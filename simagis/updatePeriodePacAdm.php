<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['id']);
  $start_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['start_datetime']);
  $end_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['end_datetime']);
   
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_pengajuan_ac SET start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:rekapPacAdm.php?message=notifEdit");
  ?>