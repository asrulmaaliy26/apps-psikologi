<?php include( "contentsConAdm.php" );
  $id=uniqid();
  $anggota1=mysqli_real_escape_string($con, $_POST['anggota1']);
  $anggota2=mysqli_real_escape_string($con, $_POST['anggota2']);
  $anggota3=mysqli_real_escape_string($con, $_POST['anggota3']);
  $anggota4=mysqli_real_escape_string($con, $_POST['anggota4']);
  $anggota5=mysqli_real_escape_string($con, $_POST['anggota5']);
  $anggota6=mysqli_real_escape_string($con, $_POST['anggota6']);
  $anggota7=mysqli_real_escape_string($con, $_POST['anggota7']);
  $anggota8=mysqli_real_escape_string($con, $_POST['anggota8']);
  $urutan1="1";
  $urutan2="2";
  $urutan3="3";
  $urutan4="4";
  $urutan5="5";
  $urutan6="6";
  $urutan7="7";
  $urutan8="8";
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
   
  $query=mysqli_query($con, "INSERT INTO siow_kelompok(id,nim,lembaga_tujuan_surat,alamat_lengkap_lts,tempat_ow,kota_penelitian,sebutan_pimpinan,matkul,dosen_pembimbing,tgl_awal_pelaksanaan,tgl_akhir_pelaksanaan,model_pelaksanaan,tgl_pengajuan,bln_pengajuan,thn_pengajuan,wd1,statusform)".
   "VALUES('$id','$anggota1','$lembaga_tujuan_surat','$alamat_lengkap_lts','$tempat_ow','$kota_penelitian','$sebutan_pimpinan','$matkul','$dosen_pembimbing','$tgl_awal_pelaksanaan','$tgl_akhir_pelaksanaan','$model_pelaksanaan','$tgl_pengajuan','$bln_pengajuan','$thn_pengajuan','$wd1','$statusform')")  or die(mysqli_error($con));
   
  $qry=mysqli_query($con, "SELECT id FROM siow_kelompok WHERE id='$id'");
  $ambil=mysqli_fetch_assoc($qry);
  $idAnggota=$ambil['id'];
  mysqli_query($con, "INSERT INTO anggota_siowk(id_siowk,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan1','$anggota1')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_siowk(id_siowk,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan2','$anggota2')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_siowk(id_siowk,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan3','$anggota3')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_siowk(id_siowk,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan4','$anggota4')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_siowk(id_siowk,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan5','$anggota5')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_siowk(id_siowk,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan6','$anggota6')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_siowk(id_siowk,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan7','$anggota7')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_siowk(id_siowk,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan8','$anggota8')")  or die(mysqli_error($con));
   
  header("location:riwayatSiowkUser.php?message=notifInput");
  ?>