<?php
  include( "koneksiAdm.php" );  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $nm=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nm']);
  $hp=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['hp']);
  $email=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['email']);
  $deskripsi_layanan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['deskripsi_layanan']);
    
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_kontak_layanan SET nm='$nm',hp='$hp',email='$email',deskripsi_layanan='$deskripsi_layanan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));  
  header("location:kontakLayananAdm.php?message=notifEdit");
  ?>