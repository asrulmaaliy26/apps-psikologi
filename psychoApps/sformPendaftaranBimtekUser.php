<?php include( "contentsConAdm.php" );
  $nim = mysqli_real_escape_string($con, $_POST['nim']);
  $id_bimtek = mysqli_real_escape_string($con, $_POST['id_bimtek']);
  $peminatan = mysqli_real_escape_string($con, $_POST['peminatan']);

  $nama_file = $_FILES['file_outline']['name'];
  $ukuran_file = $_FILES['file_outline']['size'];
  $tipe_file = $_FILES['file_outline']['type'];
  $tmp_file = $_FILES['file_outline']['tmp_name'];

  $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
  $nama_file_baru = $nim . "_" . time() . "." . $ext;
  $path = "file_outline_bimtek/" . $nama_file_baru;

  if(move_uploaded_file($tmp_file, $path)){
    $query = "INSERT INTO bimtek_peserta (nim, id_bimtek, peminatan, file_outline) 
              VALUES ('$nim', '$id_bimtek', '$peminatan', '$nama_file_baru')";
    
    if(mysqli_query($con, $query)){
      header("location:prePendaftaranBimtekUser.php?message=notifInput");
    } else {
      echo "Error DB: " . mysqli_error($con);
    }
  } else {
    echo "Error Upload: File failed to upload.";
  }
?>
