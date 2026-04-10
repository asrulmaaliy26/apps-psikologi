<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   
   $res = mysqli_query($con, "SELECT proposal FROM magang WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['proposal'])>3)
   {
     if (file_exists($d['proposal'])) unlink($d['proposal']);
   }

   $myquery =  "DELETE FROM magang WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

   $myquery =  "DELETE FROM anggota_magang WHERE id_magang='$id'";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

   header ("location:riwayatSimagkUser.php?message=notifDelete");
   ?>