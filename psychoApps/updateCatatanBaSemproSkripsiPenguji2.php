<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $catatan_narsum2=mysqli_real_escape_string($con, $_POST['catatan_narsum2']);

  $sql="UPDATE nilai_sempro SET catatan_narsum2='$catatan_narsum2' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  header("location:baSemproSkripsiPenguji2.php?page=$page&id=$id_pendaftaran");
?>