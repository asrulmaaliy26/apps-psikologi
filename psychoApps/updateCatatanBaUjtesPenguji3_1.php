<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $catatan_penguji3_1=mysqli_real_escape_string($con, $_POST['catatan_penguji3_1']);

  $sql="UPDATE mag_nilai_ujtes SET catatan_penguji3_1='$catatan_penguji3_1' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  header("location:ba2UjianTesisPenguji3.php?page=$page&id=$id_pendaftaran");
?>