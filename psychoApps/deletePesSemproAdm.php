<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id_pendaftar']);
   $id_sempro=mysqli_real_escape_string($con, $_GET['id']);
   $nim=mysqli_real_escape_string($con, $_GET['nim']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $res = mysqli_query($con, "SELECT file_prop FROM peserta_sempro WHERE id='".mysqli_real_escape_string($con, $_GET['id_pendaftar'])."' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_prop'])>3)
   {
     if (file_exists($d['file_prop'])) unlink($d['file_prop']);
   }  
  
   $res2 = mysqli_query($con, "SELECT file_skkm FROM peserta_sempro WHERE id='".mysqli_real_escape_string($con, $_GET['id_pendaftar'])."' LIMIT 1");
   $d2=mysqli_fetch_assoc($res2);
   if (strlen($d2['file_skkm'])>3)
   {
     if (file_exists($d2['file_skkm'])) unlink($d2['file_skkm']);
   }

   $myquery =  "DELETE FROM peserta_sempro WHERE id='$id' LIMIT 1";
   $hapus1 = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $qry =  "DELETE FROM jadwal_sempro WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus2 = mysqli_query($con, $qry) or die ("gagal menghapus");

   $q =  "DELETE FROM nilai_sempro WHERE id_pendaftaran='$id' LIMIT 1";
   $hapus3 = mysqli_query($con, $q) or die ("gagal menghapus");

   header ("location:verPndftrSemproPerPeriodeAdm.php?id=$id_sempro&message=notifDelete");
   ?>