<?php include( "contentsConAdm.php" );
  $id_peserta = mysqli_real_escape_string($con, $_POST['id_peserta']);
  $slot = mysqli_real_escape_string($con, $_POST['slot']);
  $now = date('Y-m-d H:i:s');

  if(isset($_FILES['file_absensi']) && $_FILES['file_absensi']['error'] == 0){
    $target_dir = "file_absensi_bimtek/";
    $file_extension = pathinfo($_FILES["file_absensi"]["name"], PATHINFO_EXTENSION);
    $new_filename = "absensi_slot" . $slot . "_" . $id_peserta . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    if(move_uploaded_file($_FILES["file_absensi"]["tmp_name"], $target_file)){
      $col_file = "file_absensi_" . $slot;
      $col_tgl = "tgl_absensi_" . $slot;
      
      $query = "UPDATE bimtek_peserta SET 
                $col_file = '$new_filename', 
                $col_tgl = '$now' 
                WHERE id = '$id_peserta'";
      
      if(mysqli_query($con, $query)){
        header("location:prePendaftaranBimtekUser.php?message=notifAbsensi");
      } else {
        echo "Error: " . mysqli_error($con);
      }
    } else {
      echo "Error uploading file.";
    }
  } else {
    echo "No file uploaded or error in file.";
  }
?>

