<?php include( "contentsConAdm.php" );

   $id=mysqli_real_escape_string($con, $_GET['id']);
   $date=mysqli_real_escape_string($con, $_GET['date']);
   $page=mysqli_real_escape_string($con, $_GET['page']);

   $myquery =  "DELETE FROM prasips WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   header ("location:rekapPrasipsAdm.php?date=$date&page=$page&message=notifDelete");
   
   ?>