<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $catatan_sekretaris=mysqli_real_escape_string($con, $_POST['catatan_sekretaris']);

  $sql="UPDATE nilai_ujskrip SET catatan_sekretaris='$catatan_sekretaris' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  header("location:baUjskripSekretaris.php?page=$page&id=$id_pendaftaran");
?>