<?php include( "contentsConAdm.php" );
  $id_periode = mysqli_real_escape_string($con, $_POST['id_periode']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  
  $id_pesertas = $_POST['id_peserta'];
  $id_reviewers = $_POST['id_reviewer'];

  for($i = 0; $i < count($id_pesertas); $i++){
      $id_peserta = mysqli_real_escape_string($con, $id_pesertas[$i]);
      $id_reviewer = mysqli_real_escape_string($con, $id_reviewers[$i]);
      
      // Update even if id_reviewer is empty (means un-plot)
      $sql = "UPDATE bimtek_peserta SET id_reviewer='$id_reviewer' WHERE id='$id_peserta'";
      mysqli_query($con, $sql);
  }

  header("location:plotReviewerBimtekAdm.php?id=$id_periode&page=$page&message=notifPlot");
?>
