<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $myquery =  "DELETE FROM skkb WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

   header ("location:riwayatSkkbUser.php?message=notifDelete");
   ?>