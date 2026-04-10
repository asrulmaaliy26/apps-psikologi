<?php include( "contentsConAdm.php" );
  $nim=mysqli_real_escape_string($con, $_POST['nim']);
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
  $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $split = explode('-', $tgl_pengajuan);
  $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
  $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
  $wd1=mysqli_real_escape_string($con, $_POST['wd1']);
  $statusform=mysqli_real_escape_string($con, $_POST['statusform']);
  
  mysqli_query($con, "INSERT INTO siow_individu(nim,lembaga_tujuan_surat,alamat_lengkap_lts,tempat_ow,kota_penelitian,sebutan_pimpinan,matkul,dosen_pembimbing,tgl_awal_pelaksanaan,tgl_akhir_pelaksanaan,model_pelaksanaan,tgl_pengajuan,bln_pengajuan,thn_pengajuan,wd1,statusform)".
  "VALUES('$nim','$lembaga_tujuan_surat','$alamat_lengkap_lts','$tempat_ow','$kota_penelitian','$sebutan_pimpinan','$matkul','$dosen_pembimbing','$tgl_awal_pelaksanaan','$tgl_akhir_pelaksanaan','$model_pelaksanaan','$tgl_pengajuan','$bln_pengajuan','$thn_pengajuan','$wd1','$statusform')")  or die(mysqli_error($con)); {     
  header("location:riwayatSiowiUser.php?message=notifInput");
  }
  ?>