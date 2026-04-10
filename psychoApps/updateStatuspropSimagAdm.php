<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $validasi_proposal = mysqli_real_escape_string($con, $_POST['validasi_proposal']);

  $myqry1="UPDATE magang SET validasi_proposal='$validasi_proposal' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  header("location:verPropMagang.php?page=$page&message=notifEdit");
  ?>