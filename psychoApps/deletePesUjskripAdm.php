<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id_pendaftar']);
   $id_ujskrip=mysqli_real_escape_string($con, $_GET['id']);
   $nim=mysqli_real_escape_string($con, $_GET['nim']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $res = mysqli_query($con, "SELECT file_skripsi FROM peserta_ujskrip WHERE id='".mysqli_real_escape_string($con, $_GET['id_pendaftar'])."' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_skripsi'])>3)
   {
     if (file_exists($d['file_skripsi'])) unlink($d['file_skripsi']);
   }  

   $myquery =  "DELETE FROM peserta_ujskrip WHERE id='$id' LIMIT 1";
   $hapus1 = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $qry =  "DELETE FROM jadwal_ujskrip WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus2 = mysqli_query($con, $qry) or die ("gagal menghapus");

   $q =  "DELETE FROM nilai_ujskrip WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus3 = mysqli_query($con, $q) or die ("gagal menghapus");

   header ("location:verPndftrUjskripPerPeriodeAdm.php?id=$id_ujskrip&message=notifDelete");
   ?>