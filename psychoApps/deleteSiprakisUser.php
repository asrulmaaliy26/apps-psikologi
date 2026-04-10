<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $myquery =  "DELETE FROM siprak_siswa WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   header ("location:riwayatSiprakisUser.php?message=notifDelete");
   ?>