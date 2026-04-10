<?php
   include( "koneksiAdm.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
   $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
   $kuota1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kuota1']);
   $kuota2=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kuota2']);
   
   $qry="UPDATE mag_dospem_tesis SET kuota1='$kuota1',kuota2='$kuota2' WHERE id='$id' LIMIT 1";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
   header ("location:ptPerPeriode.php?id=$id_periode&message=notifEdit");
   ?>