<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  
  $qac = "SELECT * FROM mag_dosen_wali WHERE id='$id'";
  $rac = mysqli_query($GLOBALS["___mysqli_ston"], $qac)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dac = mysqli_fetch_assoc($rac);
  
  $qnac = "SELECT * FROM dt_pegawai WHERE id='$dac[nip]'";
  $rnac = mysqli_query($GLOBALS["___mysqli_ston"], $qnac)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dnac = mysqli_fetch_assoc($rnac);
  ?>
<div class="panel panel-default">
  <div class="panel-heading"><?php echo $dnac['nama'].' | '.$dnac['id'];?></div>
  <div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px; font-size:13px;">
      <thead>
        <tr>
          <th width="4%" class="text-center">No.</th>
          <th width="72%" class="text-center">Nama | NIM</th>
          <th width="14%" class="text-center">Tgl. Verifikasi</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $qdw = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$id' AND cek='2' AND status='1' ORDER BY tgl_cek ASC";
          $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          while($ddw = mysqli_fetch_assoc($rdw)) {
          $no++;
          
          $qm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddw[nim]'";
          $rm = mysqli_query($GLOBALS["___mysqli_ston"], $qm)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dm = mysqli_fetch_assoc($rm);
          ?>
        <tr>
          <td class="text-center"><?php echo $no;?></td>
          <td class="text-left"><?php echo $dm['nama'].' | '.$dm['nim'];?></td>
          <td class="text-center"><?php echo $ddw['tgl_cek'];?></td>
        </tr>
        <?php };?>
      </tbody>
    </table>
  </div>
</div>