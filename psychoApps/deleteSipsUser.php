<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $myquery =  "DELETE FROM sips WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   header ("location:riwayatSipsUser.php?message=notifDelete");
   ?>