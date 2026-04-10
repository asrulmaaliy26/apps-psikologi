<?php include( "contentsConAdm.php" );

   $id=mysqli_real_escape_string($con, $_GET['id']);
   $date=mysqli_real_escape_string($con, $_GET['date']);
   $page=mysqli_real_escape_string($con, $_GET['page']);

   $myquery =  "DELETE FROM siprak_siswa WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $myquery =  "DELETE FROM testee_siprak WHERE id_siprak='$id'";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

   header ("location:rekapSiprakSiswaKelAdm.php?date=$date&page=$page&message=notifDelete");
   
   ?>