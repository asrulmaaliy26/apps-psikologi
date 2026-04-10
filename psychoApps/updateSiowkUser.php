<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $anggota1=mysqli_real_escape_string($con, $_POST['anggota1']);
   $anggota2=mysqli_real_escape_string($con, $_POST['anggota2']);
   $anggota3=mysqli_real_escape_string($con, $_POST['anggota3']);
   $anggota4=mysqli_real_escape_string($con, $_POST['anggota4']);
   $anggota5=mysqli_real_escape_string($con, $_POST['anggota5']);
   $anggota6=mysqli_real_escape_string($con, $_POST['anggota6']);
   $anggota7=mysqli_real_escape_string($con, $_POST['anggota7']);
   $anggota8=mysqli_real_escape_string($con, $_POST['anggota8']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
   $tempat_ow=mysqli_real_escape_string($con, $_POST['tempat_ow']);
   $kota_penelitian=mysqli_real_escape_string($con, $_POST['kota_penelitian']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $dosen_pembimbing=mysqli_real_escape_string($con, $_POST['dosen_pembimbing']);
   $tgl_awal_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_awal_pelaksanaan']);
   $tgl_akhir_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_akhir_pelaksanaan']);
   $model_pelaksanaan=mysqli_real_escape_string($con, $_POST['model_pelaksanaan']);
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);
   $matkul=mysqli_real_escape_string($con, $_POST['matkul']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   
   mysqli_query($con, "UPDATE siow_kelompok SET lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',tempat_ow='$tempat_ow',kota_penelitian='$kota_penelitian',sebutan_pimpinan='$sebutan_pimpinan',matkul='$matkul',dosen_pembimbing='$dosen_pembimbing',tgl_awal_pelaksanaan='$tgl_awal_pelaksanaan',tgl_akhir_pelaksanaan='$tgl_akhir_pelaksanaan',model_pelaksanaan='$model_pelaksanaan',statusform='$statusform',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con)); 
   
   $sql="UPDATE anggota_siowk SET nim_anggota = '$anggota2' WHERE id_siowk = '$id' AND urutan='2'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_siowk SET nim_anggota = '$anggota3' WHERE id_siowk = '$id' AND urutan='3'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_siowk SET nim_anggota = '$anggota4' WHERE id_siowk = '$id' AND urutan='4'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_siowk SET nim_anggota = '$anggota5' WHERE id_siowk = '$id' AND urutan='5'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_siowk SET nim_anggota = '$anggota6' WHERE id_siowk = '$id' AND urutan='6'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_siowk SET nim_anggota = '$anggota7' WHERE id_siowk = '$id' AND urutan='7'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_siowk SET nim_anggota = '$anggota8' WHERE id_siowk = '$id' AND urutan='8'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   
   header("location:riwayatSiowkUser.php?message=notifEdit");
   ?>