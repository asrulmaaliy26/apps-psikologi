<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include( "contentsConAdm.php" );
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
   
   $namafolder = "file_persetujuan_pkl/";
   
   // Pastikan folder ada atau buat baru jika tidak ada
   if (!is_dir($namafolder)) {
       if (!mkdir($namafolder, 0755, true)) {
           die("Error: Gagal membuat folder penyimpanan '$namafolder'. Silakan buat folder tersebut secara manual di server atau cek permission.");
       }
   }

   // Pastikan folder bisa ditulisi (writable)
   if (!is_writable($namafolder)) {
       die("Error: Folder '$namafolder' tidak memiliki izin tulis (not writable). Silakan lakukan chmod 755 atau 777 pada folder tersebut di VPS.");
   }

   if (!isset($_FILES['file_persetujuan'])) {
       die("Error: Form tidak mengirimkan file_persetujuan_pkl. Cek post_max_size di php.ini atau pastikan form menggunakan enctype='multipart/form-data'.");
   }

   $file_error = $_FILES['file_persetujuan']['error'];
   if ($file_error !== UPLOAD_ERR_OK) {
       $error_msg = "Gagal upload (Error Code: $file_error). ";
       switch($file_error) {
           case 1: $error_msg .= "Ukuran file melampaui 'upload_max_filesize' di php.ini server."; break;
           case 2: $error_msg .= "Ukuran file melampaui batas MAX_FILE_SIZE yang ditentukan di form HTML."; break;
           case 3: $error_msg .= "File hanya terupload sebagian."; break;
           case 4: $error_msg .= "Tidak ada file yang dipilih untuk diupload."; break;
           case 6: $error_msg .= "Folder penyimpanan sementara (tmp) tidak ditemukan di server."; break;
           case 7: $error_msg .= "Gagal menulis file ke disk server."; break;
           case 8: $error_msg .= "Upload dihentikan oleh ekstensi PHP."; break;
           default: $error_msg .= "Terjadi error yang tidak diketahui."; break;
       }
       die($error_msg);
   }

   $jenis_berkas = $_FILES['file_persetujuan']['type'];

   if ($jenis_berkas != "application/pdf") {
       die("Gagal upload: Jenis file harus PDF. File yang Anda kirim bertipe: " . htmlspecialchars($jenis_berkas));
   } 
   else {
   $temp = explode(".", $_FILES["file_persetujuan"]["name"]);
   $nama_baru = $nim . '_persetujuan_kriscen_' . time() . '.' . end($temp);
   $berkas = $namafolder . $nama_baru;
   
   if (!move_uploaded_file($_FILES['file_persetujuan']['tmp_name'], $namafolder . $nama_baru)) {
       die("Gagal memindahkan file dari folder sementara ke '$namafolder$nama_baru'. Cek permission folder atau kuota disk VPS.");
   }

   $query=mysqli_query($con, "INSERT INTO sitp(no_agenda_surat,nim,lembaga_tujuan_surat,alamat_lengkap_lts,kota_lts,sebutan_pimpinan,tgl_pengajuan,bln_pengajuan,jenis_pkl,thn_pengajuan,wd1,statusform,tgl_proses,tgl_selesai,tgl_dikeluarkan,tembusan,catatan,executor,editor,file_persetujuan)".
   "VALUES('','$nim','$lembaga_tujuan_surat','$alamat_lengkap_lts','$kota_lts','$sebutan_pimpinan','$tgl_pengajuan','$bln_pengajuan','$jenis_pkl','$thn_pengajuan','$wd1','$statusform','','',NULL,'','','','','$berkas')")  or die(mysqli_error($con));

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
   }
   ?>