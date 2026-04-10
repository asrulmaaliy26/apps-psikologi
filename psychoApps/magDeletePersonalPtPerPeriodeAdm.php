<?php
   include( "contentsConAdm.php" );
   $idPersonal=mysqli_real_escape_string($con, $_GET['idPersonal']);
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   $page1=mysqli_real_escape_string($con, $_GET['page1']);

   $myquery =  "DELETE FROM mag_dospem_tesis WHERE id='$idPersonal' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
   header ("location:magPersonalPtPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifDelete");
   ?>