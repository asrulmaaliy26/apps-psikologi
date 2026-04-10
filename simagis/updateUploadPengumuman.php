<?php
  include( "koneksiAdm.php" );  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $tbt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tbt']);
  $judul=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul']);
  $isi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['isi']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_upload_pengumuman SET tbt='$tbt',judul='$judul',isi='$isi' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {  
  header("location:rekapPengumuman.php?message=notifEdit");
  }
  ?>