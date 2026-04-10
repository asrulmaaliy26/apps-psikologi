<?php
   include( "contentsConAdm.php" );
   $idPersonal=mysqli_real_escape_string($con, $_POST['idPersonal']);
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $page1=mysqli_real_escape_string($con, $_POST['page1']);
   $kuota=mysqli_real_escape_string($con, $_POST['kuota']);
   
   $qry="UPDATE mag_dosen_wali SET kuota='$kuota' WHERE id='$idPersonal' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
  
   header ("location:magPersonalAcPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifEdit");
   ?>