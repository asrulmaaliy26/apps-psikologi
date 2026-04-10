<?php
  include( "koneksiUser.php" );
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $lembaga_tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['lembaga_tujuan_surat']);
  $sebutan_pimpinan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['sebutan_pimpinan']);
  $kota_penelitian=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kota_penelitian']);
  $tempat_ow=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tempat_ow']);
  $tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tujuan_surat']);
  $matkul=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['matkul']);
  $dosen_pembimbing=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dosen_pembimbing']);
  $tgl_pengajuan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_siowi SET lembaga_tujuan_surat='$lembaga_tujuan_surat',sebutan_pimpinan='$sebutan_pimpinan',kota_penelitian='$kota_penelitian',tempat_ow='$tempat_ow',tujuan_surat='$tujuan_surat',matkul='$matkul',dosen_pembimbing='$dosen_pembimbing',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {  
  header("location:formSowam.php?message=notifEdit");
  }
  ?>