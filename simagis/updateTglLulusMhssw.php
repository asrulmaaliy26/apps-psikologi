<?php
  include( "koneksiAdm.php" );  
  $nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $angkatan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['angkatan']);
  $thn_lulus=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['thn_lulus']);
  $page=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['page']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_dt_mhssw_pasca SET thn_lulus='$thn_lulus' WHERE nim='$nim' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:editMhsswPerAngkatan.php?angkatan=$angkatan&page=$page&message=notifEdit");
  ?>