<?php
   include( "koneksiAdm.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
   $myquery =  "delete from mag_siowi where id='$id' limit 1";
   $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
   header ("location:rekapSiowAdm.php?message=notifDelete");
   ?>