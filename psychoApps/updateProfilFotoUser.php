<?php include( "contentsConAdm.php" );
  $nim=mysqli_real_escape_string($con, $_POST['nim']);
  $photo=mysqli_real_escape_string($con, $_POST['photo']);

$jenis_berkas = $_FILES['photo']['type'];
  if ($jenis_berkas == "image/jpg" || $jenis_berkas == "image/jpeg" || $jenis_berkas == "image/png") {
  $date=strtotime('now');
  $namafolder = "photo_mhssw/";
    $temp = explode(".", $_FILES["photo"]["name"]);
    $nama_baru = $nim.'-'.$date.'.'. end($temp);
    $photo = $namafolder . $nama_baru;
    move_uploaded_file($_FILES['photo']['tmp_name'], $namafolder . '/' . $nama_baru);
  
      $res = mysqli_query($con, "SELECT photo FROM dt_mhssw where nim='$nim' LIMIT 1");
      $d=mysqli_fetch_assoc($res);
       if (strlen($d['photo'])>3)
       {
        if (file_exists($d['photo'])) unlink($d['photo']);
       }
       mysqli_query($con, "UPDATE dt_mhssw SET photo='$photo' WHERE nim='$nim' LIMIT 1");
       header("location:profilFotoUser.php?message=notifEdit");
  } else {
    header("location:profilFotoUser.php?message=notifGagal");
  }
?>