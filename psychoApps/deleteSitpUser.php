<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $myquery =  "DELETE FROM sitp WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

   $myquery =  "DELETE FROM draf_anggota_pkl WHERE id_sitp='$id'";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

   header ("location:riwayatSitpUser.php?message=notifDelete");
   ?>