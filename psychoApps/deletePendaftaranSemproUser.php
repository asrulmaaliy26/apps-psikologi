<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);

   $res = mysqli_query($con, "SELECT file_prop FROM peserta_sempro WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_prop'])>3)
   {
     if (file_exists($d['file_prop'])) unlink($d['file_prop']);
   }  
  
   $myquery =  "DELETE FROM peserta_sempro WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $qry =  "DELETE FROM jadwal_sempro WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus = mysqli_query($con, $qry) or die ("gagal menghapus");

   $q =  "DELETE FROM nilai_sempro WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus = mysqli_query($con, $q) or die ("gagal menghapus");

   header ("location:riwayatPendaftaranSemproUser.php?message=notifDelete");
   ?>