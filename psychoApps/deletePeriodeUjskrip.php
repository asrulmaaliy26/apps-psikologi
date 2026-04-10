<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $myquery1 =  "DELETE FROM pendaftaran_skripsi WHERE id='$id' LIMIT 1";
   $hapus1 = mysqli_query($con, $myquery1) or DIE ("gagal menghapus");

   $myquery2 =  "DELETE FROM grade_ujskrip WHERE id_ujskrip='$id'";
   $hapus2 = mysqli_query($con, $myquery2) or DIE ("gagal menghapus");

   $myquery3 =  "DELETE FROM jadwal_ujskrip WHERE id_ujskrip='$id'";
   $hapus3 = mysqli_query($con, $myquery3) or DIE ("gagal menghapus");

   $myquery4 =  "DELETE FROM nilai_ujskrip WHERE id_ujskrip='$id'";
   $hapus4 = mysqli_query($con, $myquery4) or DIE ("gagal menghapus");
   header ("location:pndftrnUjskripAdm.php?page=$page&message=notifDelete");
   ?>