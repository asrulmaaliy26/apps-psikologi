<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET['id']);
  $page = mysqli_real_escape_string($con, $_GET['page']);

  mysqli_query($con, "DELETE FROM bimtek_pendaftaran WHERE id='$id'");

  header("location:pndftrnBimtekAdm.php?page=$page&message=notifDelete");
?>
