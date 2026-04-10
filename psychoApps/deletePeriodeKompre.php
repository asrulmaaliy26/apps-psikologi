<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $myquery1 =  "DELETE FROM pendaftaran_kompre WHERE id='$id' LIMIT 1";
   $hapus1 = mysqli_query($con, $myquery1) or DIE ("gagal menghapus");

   $myquery2 =  "DELETE FROM grade_kompre WHERE id_kompre='$id'";
   $hapus2 = mysqli_query($con, $myquery2) or DIE ("gagal menghapus");

   $myquery3 =  "DELETE FROM jadwal_kompre WHERE id_kompre='$id'";
   $hapus3 = mysqli_query($con, $myquery3) or DIE ("gagal menghapus");
   header ("location:pndftrnKompreAdm.php?page=$page&message=notifDelete");
   ?>