<?php
   include( "koneksiAdm.php" );
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
   $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id_periode']);
   $myquery =  "delete from mag_dospem_tesis where id='$id' limit 1";
   $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
   header ("location:ptPerPeriode.php?id=$id_periode&message=notifDelete");
   ?>