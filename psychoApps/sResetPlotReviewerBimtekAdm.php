<?php
  include( "contentsConAdm.php" );
  $id_periode = mysqli_real_escape_string($con, $_GET['id']);
  $page = mysqli_real_escape_string($con, $_GET['page']);
  $mode = isset($_GET['mode']) ? $_GET['mode'] : 'plot';

  // Always clear student-reviewer assignments
  mysqli_query($con, "UPDATE bimtek_peserta SET id_reviewer='' WHERE id_bimtek='$id_periode'");

  // If mode=all, also clear kepakaran from reviewers (but keep kuota_tambahan)
  if($mode == 'all'){
      mysqli_query($con, "UPDATE bimtek_reviewer SET id_kepakaran='' WHERE id_periode='$id_periode'");
  }

  $notif = ($mode == 'all') ? 'notifResetAll' : 'notifReset';
  header("location:plotReviewerBimtekAdm.php?id=$id_periode&page=$page&message=$notif");
?>
