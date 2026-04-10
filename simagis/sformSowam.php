<?php
  include( "koneksiUser.php" );
  
  $nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $lembaga_tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['lembaga_tujuan_surat']);
  $sebutan_pimpinan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['sebutan_pimpinan']);
  $kota_penelitian=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kota_penelitian']);
  $tempat_ow=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tempat_ow']);
  $tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tujuan_surat']);
  $matkul=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['matkul']);
  $dosen_pembimbing=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dosen_pembimbing']);
  $tgl_pengajuan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
  $wd1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['wd1']);
  $kp2=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kp2']);
  $statusform=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['statusform']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_siowi(nim,lembaga_tujuan_surat,sebutan_pimpinan,kota_penelitian,tempat_ow,tujuan_surat,matkul,dosen_pembimbing,tgl_pengajuan,thn_pengajuan,wd1,kp2,statusform)".
  "VALUES('$nim','$lembaga_tujuan_surat','$sebutan_pimpinan','$kota_penelitian','$tempat_ow','$tujuan_surat','$matkul','$dosen_pembimbing','$tgl_pengajuan','$thn_pengajuan','$wd1','$kp2','$statusform')")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {     
  header("location:formSowam.php?message=notifInput");
  }
  ?>