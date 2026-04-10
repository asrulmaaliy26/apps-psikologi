<?php include( "contentsConAdm.php" );

   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page_a= mysqli_real_escape_string($con, $_GET['page_a']);
   $tahun= mysqli_real_escape_string($con, $_GET['tahun']);
   $page= mysqli_real_escape_string($con, $_GET['page']);

   $myquery =  "DELETE FROM siow_individu WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   header("location:dataIowiPertahunAdm.php?page_a=$page_a&tahun=$tahun&page=$page&message=notifDelete");
   ?>