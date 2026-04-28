<?php include( "contentsConAdm.php" );
  $wd1 = mysqli_real_escape_string($con, $_POST['wd1']);
  $kaprodi = mysqli_real_escape_string($con, $_POST['kaprodi']);
  $ta = mysqli_real_escape_string($con, $_POST['ta']);
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

  // File Upload
  $file_pengumuman = "";
  if(isset($_FILES['file_pengumuman']) && $_FILES['file_pengumuman']['error'] == 0){
    $target_dir = "file_pengumuman_bimtek/";
    $file_extension = pathinfo($_FILES["file_pengumuman"]["name"], PATHINFO_EXTENSION);
    $new_filename = "pengumuman_bimtek_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    if(move_uploaded_file($_FILES["file_pengumuman"]["tmp_name"], $target_file)){
      $file_pengumuman = $new_filename;
    }
  }

  // If status is 1, deactivate all other Bimtek periods
  if($status == 1){
    mysqli_query($con, "UPDATE bimtek_pendaftaran SET status='2'");
  }

  $query = "INSERT INTO bimtek_pendaftaran (
              nama_bimtek, start_datetime, end_datetime, status, ta, wd1, kaprodi, 
              pemateri, tempat_offline, waktu_offline, waktu_online, link_online, 
              file_pengumuman, tgl_tampil_pengumuman
            ) 
            VALUES (
              '$nama_bimtek', '$start_datetime', '$end_datetime', '$status', '$ta', '$wd1', '$kaprodi',
              '$pemateri', '$tempat_offline', '$waktu_offline', '$waktu_online', '$link_online',
              '$file_pengumuman', '$tgl_tampil_pengumuman'
            )";
  
  if(mysqli_query($con, $query)){
    header("location:pndftrnBimtekAdm.php?message=notifInput");
  } else {
    echo "Error: " . mysqli_error($con);
  }
?>

