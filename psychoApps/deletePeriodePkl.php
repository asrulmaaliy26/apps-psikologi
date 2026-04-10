<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $myquery1 =  "DELETE FROM pendaftaran_pkl WHERE id='$id' LIMIT 1";
   $hapus1 = mysqli_query($con, $myquery1) or DIE ("gagal menghapus");

   $myquery2 =  "DELETE FROM grade_pkl WHERE id_pkl='$id'";
   $hapus2 = mysqli_query($con, $myquery2) or DIE ("gagal menghapus");

   $myquery3 =  "DELETE FROM dpl_pkl WHERE id_pkl='$id'";
   $hapus3 = mysqli_query($con, $myquery3) or DIE ("gagal menghapus");
   header ("location:pndftrnPklAdm.php?page=$page&message=notifDelete");
   ?>