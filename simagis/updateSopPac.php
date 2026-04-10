<?php
   include( "koneksiAdm.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
   $isi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['isi']);
   
   $qry="UPDATE mag_sop_pac SET isi='$isi' WHERE id='$id' LIMIT 1";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
   header ("location:sopPac.php?message=notifEdit");
   ?>