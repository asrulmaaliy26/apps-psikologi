<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);

   $res = mysqli_query($con, "SELECT file_skripsi FROM peserta_ujskrip WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_skripsi'])>3)
   {
     if (file_exists($d['file_skripsi'])) unlink($d['file_skripsi']);
   }  
  
   $myquery =  "DELETE FROM peserta_ujskrip WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $qry =  "DELETE FROM jadwal_ujskrip WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus = mysqli_query($con, $qry) or die ("gagal menghapus");

   $q =  "DELETE FROM nilai_ujskrip WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus = mysqli_query($con, $q) or die ("gagal menghapus");

   header ("location:riwayatPendaftaranUjianSkripsiUser.php?message=notifDelete");
   ?>