<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $catatan_penguji2_6=mysqli_real_escape_string($con, $_POST['catatan_penguji2_6']);

  $sql="UPDATE mag_nilai_ujtes SET catatan_penguji2_6='$catatan_penguji2_6' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  header("location:ba7UjianTesisPenguji2.php?page=$page&id=$id_pendaftaran");
?>