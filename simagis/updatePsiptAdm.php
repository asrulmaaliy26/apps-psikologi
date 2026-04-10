<?php
   include("koneksiAdm.php");
   
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['lembaga_tujuan_surat']);
   $nama_obyek=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama_obyek']);
   $sebutan_pimpinan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['sebutan_pimpinan']);
   $kota_penelitian=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kota_penelitian']);
   $tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tujuan_surat']);
   $judul_tesis=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_tesis']);
   $tgl_dikeluarkan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_dikeluarkan']);
   $tembusan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tembusan']);
   $statusform=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], '2');   
   
   mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_sipt SET lembaga_tujuan_surat='$lembaga_tujuan_surat',nama_obyek='$nama_obyek',sebutan_pimpinan='$sebutan_pimpinan', kota_penelitian='$kota_penelitian',tujuan_surat='$tujuan_surat',judul_tesis='$judul_tesis',tgl_dikeluarkan='$tgl_dikeluarkan',tembusan='$tembusan',statusform='$statusform' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {  
   header("location:rekapPsiptAdm.php?message=notifEdit");
   }
   ?>