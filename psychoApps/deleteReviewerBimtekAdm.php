<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET['id']);
  $id_periode = mysqli_real_escape_string($con, $_GET['id_periode']);
  
  // Get NIP before deleting to unplot students?
  $q_nip = mysqli_query($con, "SELECT nip FROM bimtek_reviewer WHERE id='$id'");
  if($d_nip = mysqli_fetch_assoc($q_nip)){
      $nip = $d_nip['nip'];
      // Optional: Un-plot students who were assigned to this reviewer for this period
      mysqli_query($con, "UPDATE bimtek_peserta SET id_reviewer='' WHERE id_bimtek='$id_periode' AND id_reviewer='$nip'");
  }

  // Delete the reviewer
  $sql = "DELETE FROM bimtek_reviewer WHERE id='$id'";
  mysqli_query($con, $sql);

  header("location:plotReviewerBimtekAdm.php?id=$id_periode&message=notifDelete");
?>
