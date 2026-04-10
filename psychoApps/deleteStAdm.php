<?php include( "contentsConAdm.php" );
   
   $id= mysqli_real_escape_string($con, $_GET['id']);
   $page= mysqli_real_escape_string($con, $_GET['page']);
   
   $myquery =  "DELETE FROM st WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $myquery =  "DELETE FROM personil_st WHERE id_st='".mysqli_real_escape_string($con, $_GET['id'])."'";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
      
   header("location:rekapSuratTugasAdm.php?page=$page&message=notifDelete");
   ?>