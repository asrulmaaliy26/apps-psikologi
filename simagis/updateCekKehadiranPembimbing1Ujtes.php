<?php
  include( "koneksiAdm.php" );  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $cekhadir1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cekhadir1']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_jadwal_ujtes SET cekhadir1='$cekhadir1' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  {
  header("location:cekKehadiranPengujiUjtes.php?id=$id&message=notifEdit");
  }
  ?>