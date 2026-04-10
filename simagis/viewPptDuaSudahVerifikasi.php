<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  ?>
  <div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px; font-size:13px;">
      <thead>
        <tr>
          <th width="4%" class="text-center">No.</th>
          <th width="44%" class="text-center">Nama | NIM</th>
          <th width="38%" class="text-center">Nama Dosen yang Diajukan</th>
          <th width="14%" class="text-center">Tgl. Pengajuan</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $qdw = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$id' AND cek2='2' ORDER BY tgl_pengajuan ASC";
          $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          while($ddw = mysqli_fetch_assoc($rdw)) {
          $no++;
          
          $qm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddw[nim]'";
          $rm = mysqli_query($GLOBALS["___mysqli_ston"], $qm)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dm = mysqli_fetch_assoc($rm);
		  
		  $qpt = "SELECT * FROM mag_dospem_tesis WHERE id='$ddw[dospem_tesis2]'";
		  $rpt = mysqli_query($GLOBALS["___mysqli_ston"], $qpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
		  $dpt = mysqli_fetch_assoc($rpt);
		  
		  $qnpt = "SELECT * FROM dt_pegawai WHERE id='$dpt[nip]'";
		  $rnpt = mysqli_query($GLOBALS["___mysqli_ston"], $qnpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
		  $dnpt = mysqli_fetch_assoc($rnpt);		  
          ?>
        <tr>
          <td class="text-center"><?php echo $no;?></td>
          <td><?php echo $dm['nama'].' | '.$dm['nim'];?></td>
          <td><?php echo $dnpt['nama'];?></td>
          <td class="text-center"><?php echo $ddw['tgl_pengajuan'];?></td>
        </tr>
        <?php };?>
      </tbody>
    </table>
  </div>