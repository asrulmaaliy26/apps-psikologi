<?php
   include( "koneksiAdm.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
   $myquery =  "DELETE FROM mag_variablexy WHERE id='$id' limit 1";
   $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
   header ("location:variabelxyAdm.php?message=notifDelete");
   ?>