<?php include( "contentsConAdm.php" );
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
   $jenis_magang="2";
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
   $nama_obyek=mysqli_real_escape_string($con, $_POST['nama_obyek']);
   $tgl_awal_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_awal_pelaksanaan']);
   $tgl_akhir_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_akhir_pelaksanaan']);
   $kota_lts=mysqli_real_escape_string($con, $_POST['kota_lts']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   $wd1=mysqli_real_escape_string($con, $_POST['wd1']);
   $validasi_proposal=mysqli_real_escape_string($con, $_POST['validasi_proposal']);
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);
   $proposal=mysqli_real_escape_string($con, $_POST['proposal']);

   $namafolder = "file_proposal_magang/";
   $jenis_berkas = $_FILES['proposal']['type'];

   if ($proposal='' || $jenis_berkas != "application/pdf") {
   header("location:riwayatSimagkUser.php?message=notifGagalUpload");} 
   else {
   $temp = explode(".", $_FILES["proposal"]["name"]);
   $nama_baru = $nim . '_proposal_magang' . '.' . end($temp);
   $berkas = $namafolder . $nama_baru;
   move_uploaded_file($_FILES['proposal']['tmp_name'], $namafolder . '/' . $nama_baru);

   mysqli_query($con, "INSERT INTO magang(nim,jenis_magang,lembaga_tujuan_surat,alamat_lengkap_lts,nama_obyek,tgl_awal_pelaksanaan,tgl_akhir_pelaksanaan,kota_lts,sebutan_pimpinan,proposal,tgl_pengajuan,bln_pengajuan,thn_pengajuan,wd1,validasi_proposal,statusform)".
   "values('$anggota1','$jenis_magang','$lembaga_tujuan_surat','$alamat_lengkap_lts','$nama_obyek','$tgl_awal_pelaksanaan','$tgl_akhir_pelaksanaan','$kota_lts','$sebutan_pimpinan','$berkas','$tgl_pengajuan','$bln_pengajuan','$thn_pengajuan','$wd1','$validasi_proposal','$statusform')")  or die(mysqli_error($con));

   $qry=mysqli_query($con, "SELECT id FROM magang ORDER BY id DESC");
   $ambil=mysqli_fetch_assoc($qry);
   $idAnggota=$ambil['id'];

   mysqli_query($con, "INSERT INTO anggota_magang(id_magang,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan1','$anggota1')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_magang(id_magang,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan2','$anggota2')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_magang(id_magang,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan3','$anggota3')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_magang(id_magang,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan4','$anggota4')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_magang(id_magang,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan5','$anggota5')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_magang(id_magang,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan6','$anggota6')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_magang(id_magang,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan7','$anggota7')")  or die(mysqli_error($con));
  mysqli_query($con, "INSERT INTO anggota_magang(id_magang,urutan,nim_anggota)".
   "VALUES('$idAnggota','$urutan8','$anggota8')")  or die(mysqli_error($con));

   header("location:riwayatSimagkUser.php?message=notifInput");
}
   ?>