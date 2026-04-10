<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $myquery =  "DELETE FROM siprak_siswa WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $qry =  "DELETE FROM testee_siprak WHERE id_siprak='$id'";
   $del = mysqli_query($con, $qry) or die ("gagal menghapus");

   header ("location:riwayatSiprakksUser.php?message=notifDelete");
   ?>