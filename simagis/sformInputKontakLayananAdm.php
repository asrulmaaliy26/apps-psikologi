<?php
  include( "koneksiAdm.php" );  
  $nm=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nm']);
  $hp=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['hp']);
  $email=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['email']);
  $deskripsi_layanan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['deskripsi_layanan']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_kontak_layanan(nm,hp,email,deskripsi_layanan)".
  "VALUES('$nm','$hp','$email','$deskripsi_layanan')")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {     
  header("location:kontakLayananAdm.php?message=notifInput");
  }
  ?>