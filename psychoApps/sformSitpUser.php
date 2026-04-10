<?php include( "contentsConAdm.php" );
   $anggota1=mysqli_real_escape_string($con, $_POST['anggota1']);
   $anggota2=mysqli_real_escape_string($con, $_POST['anggota2']);
   $anggota3=mysqli_real_escape_string($con, $_POST['anggota3']);
   $anggota4=mysqli_real_escape_string($con, $_POST['anggota4']);
   $anggota5=mysqli_real_escape_string($con, $_POST['anggota5']);
   $anggota6=mysqli_real_escape_string($con, $_POST['anggota6']);
   $anggota7=mysqli_real_escape_string($con, $_POST['anggota7']);
   $anggota8=mysqli_real_escape_string($con, $_POST['anggota8']);
   $anggota9=mysqli_real_escape_string($con, $_POST['anggota9']);
   $anggota10=mysqli_real_escape_string($con, $_POST['anggota10']);
   $anggota11=mysqli_real_escape_string($con, $_POST['anggota11']);
   $anggota12=mysqli_real_escape_string($con, $_POST['anggota12']);
   $urutan1="1";
   $urutan2="2";
   $urutan3="3";
   $urutan4="4";
   $urutan5="5";
   $urutan6="6";
   $urutan7="7";
   $urutan8="8";
   $urutan9="9";
   $urutan10="10";
   $urutan11="11";
   $urutan12="12";

   $nim=mysqli_real_escape_string($con, $_POST['nim']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $kota_lts=mysqli_real_escape_string($con, $_POST['kota_lts']);
   $jenis_pkl=mysqli_real_escape_string($con, $_POST['jenis_pkl']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   $wd1=mysqli_real_escape_string($con, $_POST['wd1']);   
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);
   
   $query=mysqli_query($con, "INSERT INTO sitp(nim,lembaga_tujuan_surat,alamat_lengkap_lts,kota_lts,sebutan_pimpinan,tgl_pengajuan,bln_pengajuan,jenis_pkl,thn_pengajuan,wd1,statusform)".
   "VALUES('$nim','$lembaga_tujuan_surat','$alamat_lengkap_lts','$kota_lts','$sebutan_pimpinan','$tgl_pengajuan','$bln_pengajuan','$jenis_pkl','$thn_pengajuan','$wd1','$statusform')")  or die(mysqli_error($con));

   $qry=mysqli_query($con, "SELECT id FROM sitp ORDER BY id DESC");
   $ambil=mysqli_fetch_assoc($qry);
   $idAnggota=$ambil['id'];

   mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan1','$anggota1')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan2','$anggota2')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan3','$anggota3')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan4','$anggota4')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan5','$anggota5')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan6','$anggota6')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan7','$anggota7')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan8','$anggota8')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan9','$anggota9')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan10','$anggota10')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan11','$anggota11')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO draf_anggota_pkl(id_sitp,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan12','$anggota12')")  or die(mysqli_error($con));

   header("location:riwayatSitpUser.php?message=notifInput");
   ?>