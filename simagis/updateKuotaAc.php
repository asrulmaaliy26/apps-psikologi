<?php
   include( "koneksiAdm.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
   $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
   $kuota=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kuota']);
   
   $qry="UPDATE mag_dosen_wali SET kuota='$kuota' WHERE id='$id' LIMIT 1";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
   header ("location:acPerPeriode.php?id=$id_periode&message=notifEdit");
   ?>