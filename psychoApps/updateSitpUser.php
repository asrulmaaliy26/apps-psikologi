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
   $anggota9=mysqli_real_escape_string($con, $_POST['anggota9']);
   $anggota10=mysqli_real_escape_string($con, $_POST['anggota10']);
   $anggota11=mysqli_real_escape_string($con, $_POST['anggota11']);
   $anggota12=mysqli_real_escape_string($con, $_POST['anggota12']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $kota_lts=mysqli_real_escape_string($con, $_POST['kota_lts']);
   $jenis_pkl=mysqli_real_escape_string($con, $_POST['jenis_pkl']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
       
   if (empty($lembaga_tujuan_surat))
   {   
       die("Mohon Lembaga tujuan surat diisi!");
   }
   
    else
    {
    if(!empty($_FILES['file_persetujuan']['name'])) {
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

        // Cek apakah ada error upload
        $file_error = $_FILES['file_persetujuan']['error'];
        if ($file_error !== UPLOAD_ERR_OK) {
            $error_msg = "Gagal upload pada saat update (Error Code: $file_error). ";
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
            die("Gagal update file: Jenis file harus PDF. File yang Anda kirim bertipe: " . htmlspecialchars($jenis_berkas));
        } else {
            $temp = explode(".", $_FILES["file_persetujuan"]["name"]);
            $nama_baru = $anggota1 . '_persetujuan_kriscen_' . time() . '.' . end($temp);
            $berkas = $namafolder . $nama_baru;
            
            if (!move_uploaded_file($_FILES['file_persetujuan']['tmp_name'], $namafolder . $nama_baru)) {
                die("Gagal memindahkan file dari folder sementara ke '$namafolder$nama_baru'. Cek permission folder atau kuota disk VPS.");
            }
            mysqli_query($con, "UPDATE sitp SET file_persetujuan='$berkas' WHERE id='$id'");
        }
    }

   $myqry="UPDATE sitp SET lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',kota_lts='$kota_lts',sebutan_pimpinan='$sebutan_pimpinan',jenis_pkl='$jenis_pkl',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $myqry) or die(mysqli_error($con));

   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota1' WHERE id_sitp = '$id' AND urutan='1'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota2' WHERE id_sitp = '$id' AND urutan='2'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota3' WHERE id_sitp = '$id' AND urutan='3'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota4' WHERE id_sitp = '$id' AND urutan='4'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota5' WHERE id_sitp = '$id' AND urutan='5'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota6' WHERE id_sitp = '$id' AND urutan='6'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota7' WHERE id_sitp = '$id' AND urutan='7'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota8' WHERE id_sitp = '$id' AND urutan='8'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota9' WHERE id_sitp = '$id' AND urutan='9'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota10' WHERE id_sitp = '$id' AND urutan='10'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota11' WHERE id_sitp = '$id' AND urutan='11'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota12' WHERE id_sitp = '$id' AND urutan='12'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));

   header("location:riwayatSitpUser.php?message=notifEdit");
   }
   ?>