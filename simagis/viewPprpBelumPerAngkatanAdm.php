<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  $angkatan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'angkatan' ] );
  ?>
  <div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px; font-size:13px;">
      <thead>
        <tr>
          <th width="4%" class="text-center">No.</th>
          <th width="82%" class="text-center">Nama | NIM</th>
          <th width="14%" class="text-center">Tgl. Pengajuan</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $qdw = "SELECT * FROM mag_pengelompokan_rumpun WHERE angkatan='$angkatan' AND cek='1' ORDER BY tgl_pengajuan ASC";
          $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          while($ddw = mysqli_fetch_assoc($rdw)) {
          $no++;
          
          $qm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddw[nim]'";
          $rm = mysqli_query($GLOBALS["___mysqli_ston"], $qm)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dm = mysqli_fetch_assoc($rm); 
          ?>
        <tr>
          <td class="text-center"><?php echo $no;?></td>
          <td><?php echo $dm['nama'].' | '.$dm['nim'];?></td>
          <td class="text-center"><?php echo $ddw['tgl_pengajuan'];?></td>
        </tr>
        <?php };?>
      </tbody>
    </table>
  </div>