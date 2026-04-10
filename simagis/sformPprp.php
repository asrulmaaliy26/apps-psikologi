<?php
  include( "koneksiUser.php" );  
  $nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $angkatan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['angkatan']);
  $rumpun=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['rumpun']);
  $tgl_pengajuan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
  $ta=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['ta']);
  $wd1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['wd1']);
  $kaprodi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kaprodi']);
  $cek=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_pengelompokan_rumpun(nim,angkatan,rumpun,tgl_pengajuan,thn_pengajuan,ta,wd1,kaprodi,cek)".
  "VALUES('$nim','$angkatan','$rumpun','$tgl_pengajuan','$thn_pengajuan','$ta','$wd1','$kaprodi','$cek')")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {     
  header("location:formPengajuanPrp.php?message=notifInput");
  }
  ?>