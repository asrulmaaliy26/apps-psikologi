<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $myquery =  "DELETE FROM siow_kelompok WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $myquery =  "DELETE FROM anggota_siowk WHERE id_siowk='$id'";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   header ("location:riwayatSiowkUser.php?message=notifDelete");
   ?>