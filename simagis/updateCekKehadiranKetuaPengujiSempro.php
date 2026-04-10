<?php
  include( "koneksiAdm.php" );  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $cekhadir4=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cekhadir4']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_jadwal_sempro SET cekhadir4='$cekhadir4' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  {
  header("location:cekKehadiranPengujiSempro.php?id=$id&message=notifEdit");
  }
  ?>