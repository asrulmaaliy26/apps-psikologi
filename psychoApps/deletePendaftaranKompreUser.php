<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);

   $res = mysqli_query($con, "SELECT file_transkrip_nilai FROM peserta_kompre WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_transkrip_nilai'])>3)
   {
     if (file_exists($d['file_transkrip_nilai'])) unlink($d['file_transkrip_nilai']);
   }  
  
   $myquery =  "DELETE FROM peserta_kompre WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $qry =  "DELETE FROM jadwal_kompre WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus = mysqli_query($con, $qry) or die ("gagal menghapus");

   header ("location:riwayatPendaftaranKompreUser.php?message=notifDelete");
   ?>