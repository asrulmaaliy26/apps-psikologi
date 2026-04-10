<?php
   include("koneksiAdm.php");
   
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['lembaga_tujuan_surat']);
   $tempat_ow=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tempat_ow']);
   $sebutan_pimpinan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['sebutan_pimpinan']);
   $kota_penelitian=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kota_penelitian']);
   $tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tujuan_surat']);
   $matkul=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['matkul']);
   $dosen_pembimbing=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dosen_pembimbing']);
   $tgl_dikeluarkan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_dikeluarkan']);
   $tembusan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tembusan']);
   $wd1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['wd1']);
   $kp2=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kp2']);
   $statusform=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], '2');   
   
   mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_siowi SET lembaga_tujuan_surat='$lembaga_tujuan_surat',tempat_ow='$tempat_ow',sebutan_pimpinan='$sebutan_pimpinan', kota_penelitian='$kota_penelitian',tujuan_surat='$tujuan_surat',matkul='$matkul',dosen_pembimbing='$dosen_pembimbing',tgl_dikeluarkan='$tgl_dikeluarkan',wd1='$wd1',kp2='$kp2',tembusan='$tembusan',statusform='$statusform' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {  
   header("location:rekapSiowAdm.php?message=notifEdit");
   }
   ?>