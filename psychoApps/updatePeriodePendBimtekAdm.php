<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $nama_bimtek = mysqli_real_escape_string($con, $_POST['nama_bimtek']);
  $start_datetime = mysqli_real_escape_string($con, $_POST['start_datetime']);
  $end_datetime = mysqli_real_escape_string($con, $_POST['end_datetime']);
  $status = mysqli_real_escape_string($con, $_POST['status']);

  $pemateri = mysqli_real_escape_string($con, $_POST['pemateri']);
  $tempat_offline = mysqli_real_escape_string($con, $_POST['tempat_offline']);
  $waktu_offline = mysqli_real_escape_string($con, $_POST['waktu_offline']);
  $waktu_online = mysqli_real_escape_string($con, $_POST['waktu_online']);
  $link_online = mysqli_real_escape_string($con, $_POST['link_online']);
  $tgl_tampil_pengumuman = mysqli_real_escape_string($con, $_POST['tgl_tampil_pengumuman']);
  $tgl_buka_praprop  = mysqli_real_escape_string($con, $_POST['tgl_buka_praprop'] ?? '');
  $tgl_tutup_praprop = mysqli_real_escape_string($con, $_POST['tgl_tutup_praprop'] ?? '');
  $bypass_sertifikat = isset($_POST['bypass_sertifikat']) ? (int)$_POST['bypass_sertifikat'] : 0;

  if($status == 1){
    mysqli_query($con, "UPDATE bimtek_pendaftaran SET status='2'");
  }

  // Handle File Upload
  $file_sql = "";
  if(isset($_FILES['file_pengumuman']) && $_FILES['file_pengumuman']['error'] == 0){
    // Delete old file
    $q_old = mysqli_query($con, "SELECT file_pengumuman FROM bimtek_pendaftaran WHERE id='$id'");
    $d_old = mysqli_fetch_assoc($q_old);
    if($d_old['file_pengumuman'] && file_exists("file_pengumuman_bimtek/" . $d_old['file_pengumuman'])){
      unlink("file_pengumuman_bimtek/" . $d_old['file_pengumuman']);
    }

    $target_dir = "file_pengumuman_bimtek/";
    $file_extension = pathinfo($_FILES["file_pengumuman"]["name"], PATHINFO_EXTENSION);
    $new_filename = "pengumuman_bimtek_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    if(move_uploaded_file($_FILES["file_pengumuman"]["tmp_name"], $target_file)){
      $file_sql = ", file_pengumuman='$new_filename'";
    }
  }

  $query = "UPDATE bimtek_pendaftaran SET 
            nama_bimtek='$nama_bimtek', 
            start_datetime='$start_datetime', 
            end_datetime='$end_datetime', 
            status='$status',
            pemateri='$pemateri',
            tempat_offline='$tempat_offline',
            waktu_offline='$waktu_offline',
            waktu_online='$waktu_online',
            link_online='$link_online',
            tgl_tampil_pengumuman='$tgl_tampil_pengumuman',
            tgl_buka_praprop=" . ($tgl_buka_praprop ? "'$tgl_buka_praprop'" : 'NULL') . ",
            tgl_tutup_praprop=" . ($tgl_tutup_praprop ? "'$tgl_tutup_praprop'" : 'NULL') . ",
            bypass_sertifikat='$bypass_sertifikat'
            $file_sql
            WHERE id='$id'";
  
  if(mysqli_query($con, $query)){
    header("location:pndftrnBimtekAdm.php?page=$page&message=notifEdit");
  } else {
    echo "Error: " . mysqli_error($con);
  }
?>

