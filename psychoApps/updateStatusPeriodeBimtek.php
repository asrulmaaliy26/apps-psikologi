<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET['id']);
  $page = mysqli_real_escape_string($con, $_GET['page']);

  // Deactivate all others first
  mysqli_query($con, "UPDATE bimtek_pendaftaran SET status='2'");
  
  // Activate selected one
  mysqli_query($con, "UPDATE bimtek_pendaftaran SET status='1' WHERE id='$id'");

  header("location:pndftrnBimtekAdm.php?page=$page&message=notifUpdateStatus");
?>
