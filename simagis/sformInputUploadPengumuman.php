<?php
  include( "koneksiAdm.php" );  
  $tbt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tbt']);
  $judul=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul']);
  $isi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['isi']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_upload_pengumuman(tbt,judul,isi)".
  "VALUES('$tbt','$judul','$isi')")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {     
  header("location:rekapPengumuman.php?message=notifInput");
  }
  ?>