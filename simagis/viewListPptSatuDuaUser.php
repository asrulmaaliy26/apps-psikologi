<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  
  $qry_moment = "SELECT * FROM mag_periode_pengajuan_dospem WHERE status='1'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_periode=$data['id'];
  $ta=$data['ta'];
  ?>
<div class="panel panel-default">
  <div class="panel-heading">Pengajuan Dosen Pembimbing I</div>
  <div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px;">
      <thead>
        <tr>
          <th width="6%" class="text-left">No.</th>
          <th width="40%" class="text-left">Nama</th>
          <th width="30%" class="text-center">NIM</th>
          <th width="24%" class="text-center">Tgl. pengajuan</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $qdw = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$id' AND id_periode='$data[id]' AND cek1='1' AND cekjudul='1' ORDER BY tgl_pengajuan";
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
</div>
<div class="panel panel-default">
  <div class="panel-heading">Pengajuan Dosen Pembimbing II</div>
  <div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px;">
      <thead>
        <tr>
          <th width="6%" class="text-left">No.</th>
          <th width="40%" class="text-left">Nama</th>
          <th width="30%" class="text-center">NIM</th>
          <th width="24%" class="text-center">Tgl. pengajuan</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $qdw = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$id' AND id_periode='$data[id]' AND cek2='1' AND cekjudul='1' ORDER BY tgl_pengajuan";
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
</div>