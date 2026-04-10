<?php
  include( "koneksiAdm.php" );  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $dosen_wali=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dosen_wali']);
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
  $tgl_pengajuan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
  
  $qNip = "SELECT nip FROM mag_dosen_wali WHERE id='$_POST[dosen_wali]' AND id_periode='$_POST[id_periode]'";
  $rNip = mysqli_query($GLOBALS["___mysqli_ston"], $qNip) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dNip = mysqli_fetch_assoc($rNip) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $nip = $dNip['nip'];

  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_pengelompokan_dosen_wali SET dosen_wali='$dosen_wali',nip_dosen_wali='$nip',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));  
  header("location:verifikasiPengajuanAc.php?id=$id_periode&message=notifEdit");
  ?>