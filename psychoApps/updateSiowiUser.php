<?php include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
  $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
  $tempat_ow=mysqli_real_escape_string($con, $_POST['tempat_ow']);
  $kota_penelitian=mysqli_real_escape_string($con, $_POST['kota_penelitian']);
  $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
  $matkul=mysqli_real_escape_string($con, $_POST['matkul']);
  $dosen_pembimbing=mysqli_real_escape_string($con, $_POST['dosen_pembimbing']);
  $tgl_awal_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_awal_pelaksanaan']);
  $tgl_akhir_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_akhir_pelaksanaan']);
  $model_pelaksanaan=mysqli_real_escape_string($con, $_POST['model_pelaksanaan']);
  $statusform=mysqli_real_escape_string($con, $_POST['statusform']);
  $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $split = explode('-', $tgl_pengajuan);
  $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
  $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
  
  mysqli_query($con, "UPDATE siow_individu SET lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',tempat_ow='$tempat_ow',kota_penelitian='$kota_penelitian',sebutan_pimpinan='$sebutan_pimpinan',matkul='$matkul',dosen_pembimbing='$dosen_pembimbing',tgl_awal_pelaksanaan='$tgl_awal_pelaksanaan',tgl_akhir_pelaksanaan='$tgl_akhir_pelaksanaan',model_pelaksanaan='$model_pelaksanaan',statusform='$statusform',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con)); {  
  header("location:riwayatSiowiUser.php?message=notifEdit");
  }
  ?>