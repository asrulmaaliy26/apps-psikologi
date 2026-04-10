<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $catatan_penguji1_3=mysqli_real_escape_string($con, $_POST['catatan_penguji1_3']);

  $sql="UPDATE mag_nilai_ujtes SET catatan_penguji1_3='$catatan_penguji1_3' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  header("location:ba4UjianTesisPenguji1.php?page=$page&id=$id_pendaftaran");
?>