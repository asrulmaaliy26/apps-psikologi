<?php
  include( "koneksiUser.php" );
  
  $nm=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nm']);
  $cek=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);
  $status=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['status']);
  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_covariable(nm,cek,status)".
  "VALUES('$nm','$cek','$status')")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {     
  header("location:covariabelUser.php?message=notifInput");
  }
  ?>