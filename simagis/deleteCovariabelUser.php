<?php
   include( "koneksiUser.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
   $myquery =  "DELETE FROM mag_covariable WHERE id='$id' limit 1";
   $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
   header ("location:covariabelUser.php?message=notifDelete");
   ?>