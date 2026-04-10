<?php include( "koneksiUser.php" );
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $lembaga_tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['lembaga_tujuan_surat']);
  $sebutan_pimpinan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['sebutan_pimpinan']);
  $kota_penelitian=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kota_penelitian']);
  $nama_obyek=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama_obyek']);
  $tujuan_surat=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tujuan_surat']);
  $judul_tesis=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_tesis']);
  $tgl_pengajuan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
      
  if (empty($nama_obyek))
  {   
      die("Mohon nama obyek diisi!");
  }
  
  else 
  {
  $myqry="UPDATE mag_sipt SET lembaga_tujuan_surat='$lembaga_tujuan_surat',sebutan_pimpinan='$sebutan_pimpinan',kota_penelitian='$kota_penelitian',nama_obyek='$nama_obyek',tujuan_surat='$tujuan_surat',judul_tesis='$judul_tesis',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
      mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      header("location:formSuratPenTes.php?message=notifEdit");
  }
  ?>