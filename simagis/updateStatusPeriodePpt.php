<?php
   include( "koneksiAdm.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
   
   $sql1="UPDATE mag_periode_pengajuan_dospem SET status='1' WHERE id='$id' LIMIT 1";
   mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $sql2="UPDATE mag_periode_pengajuan_dospem SET status='2' WHERE id!='$id'";
   mysqli_query($GLOBALS["___mysqli_ston"], $sql2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   header ("location:rekapPptAdm.php?message=notifEdit");
   ?>