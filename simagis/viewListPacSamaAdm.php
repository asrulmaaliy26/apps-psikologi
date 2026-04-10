<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  ?>
<div class="table-responsive">
  <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px;">
    <thead>
      <tr>
        <th width="6%" class="text-center">No.</th>
        <th width="40%" class="text-center">Nama</th>
        <th width="30%" class="text-center">NIM</th>
        <th width="24%" class="text-center">Tgl. Pengajuan</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $no=0;
        $qdw = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$id' AND cek='1' ORDER BY tgl_pengajuan";
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
        <td class="text-center"><?php echo $ddw['tgl_pengajuan'];?></td>
      </tr>
      <?php };?>
    </tbody>
  </table>
</div>