<?php
  include( "koneksiAdm.php" );
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  
  $q = "SELECT * FROM mag_dt_ta WHERE status='1'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $d = mysqli_fetch_assoc($r);
  ?>
<div class="panel panel-default">
  <div class="panel-heading">Pendaftar yang Belum Terjadwal</div>
  <div class="table-responsive">
    <table class="table table-condensed table-bordered custom" style="margin-bottom:0px;">
      <thead>
        <tr>
          <th width="6%" class="text-left">No.</th>
          <th width="40%" class="text-left">Nama</th>
          <th width="30%" class="text-center">NIM</th>
          <th width="24%" class="text-center">Tgl. pendaftaran</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $qdw = "SELECT * FROM mag_peserta_sempro WHERE id_sempro='$id' AND cek='1' ORDER BY tgl_pendaftaran ASC";
          $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          while($ddw = mysqli_fetch_assoc($rdw)) {
          $no++;
          $qm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddw[nim]'";
          $rm = mysqli_query($GLOBALS["___mysqli_ston"], $qm)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dm = mysqli_fetch_assoc($rm);
          ?>
        <tr>
          <td class="text-center"><?php echo $no;?></td>
          <td class="text-left"><?php echo $dm['nama'];?></td>
          <td class="text-center"><?php echo $dm['nim'];?></td>
          <td class="text-center"><?php echo $ddw['tgl_pendaftaran'];?></td>
        </tr>
        <?php };?>
      </tbody>
    </table>
  </div>
</div>