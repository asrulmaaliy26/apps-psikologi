<?php
  include( "contentsConAdm.php" );
  $id_peserta = mysqli_real_escape_string($con, $_GET['id_peserta']);
  $id_periode = mysqli_real_escape_string($con, $_GET['id_periode']);
  $page = mysqli_real_escape_string($con, $_GET['page']);

  mysqli_query($con, "DELETE FROM bimtek_peserta WHERE id='$id_peserta' AND id_bimtek='$id_periode'");

  header("location:plotReviewerBimtekAdm.php?id=$id_periode&page=$page&message=notifDeletePeserta");
?>
