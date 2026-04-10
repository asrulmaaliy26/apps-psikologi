<?php include( "contentsConAdm.php" );

   $id=mysqli_real_escape_string($con, $_GET['id']);
   $id_kompre=mysqli_real_escape_string($con, $_GET['id_kompre']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $query =  "UPDATE peserta_kompre SET id_jdwl='' WHERE id_jdwl='$id' AND id_kompre=$id_kompre";
   $h = mysqli_query($con, $query) or die ("gagal menghapus");

   $myquery =  "DELETE FROM jadwal_kompre WHERE id='$id' limit 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   
   header ("location:jadKomprePerPeriodeAdm.php?id=$id_kompre&page=$page&message=notifDelete");
   ?>