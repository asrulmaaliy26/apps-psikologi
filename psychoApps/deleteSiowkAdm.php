<?php include( "contentsConAdm.php" );

   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   $date=mysqli_real_escape_string($con, $_GET['date']);

   $myquery =  "DELETE FROM siow_kelompok WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   $myquery =  "DELETE FROM anggota_siowk WHERE id_siowk='$id'";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   header ("location:rekapSiowKelompokAdm.php?date=$date&page=$page&message=notifDelete");
   ?>