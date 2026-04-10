<?php
   include( "koneksiAdm.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
   $page=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['page']);
   
   $myquery =  "delete from mag_periode_pengajuan_ac where id='$id' limit 1";
   $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
   
   header ("location:rekapPacAdm.php?page=$page&message=notifDelete");
   ?>