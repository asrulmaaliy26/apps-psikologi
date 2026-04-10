<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $myquery1 =  "DELETE FROM pendaftaran_sempro WHERE id='$id' LIMIT 1";
   $hapus1 = mysqli_query($con, $myquery1) or DIE ("gagal menghapus");

   $myquery2 =  "DELETE FROM grade_sempro WHERE id_sempro='$id'";
   $hapus2 = mysqli_query($con, $myquery2) or DIE ("gagal menghapus");

   $myquery3 =  "DELETE FROM jadwal_sempro WHERE id_sempro='$id'";
   $hapus3 = mysqli_query($con, $myquery3) or DIE ("gagal menghapus");

   $myquery4 =  "DELETE FROM nilai_sempro WHERE id_sempro='$id'";
   $hapus4 = mysqli_query($con, $myquery4) or DIE ("gagal menghapus");
   header ("location:pndftrnSemproAdm.php?page=$page&message=notifDelete");
   ?>