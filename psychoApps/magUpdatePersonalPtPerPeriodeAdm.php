<?php
   include( "contentsConAdm.php" );
   $idPersonal=mysqli_real_escape_string($con, $_POST['idPersonal']);
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $page1=mysqli_real_escape_string($con, $_POST['page1']);
   $kuota1=mysqli_real_escape_string($con, $_POST['kuota1']);
   $kuota2=mysqli_real_escape_string($con, $_POST['kuota2']);
   
   $qry="UPDATE mag_dospem_tesis SET kuota1='$kuota1',kuota2='$kuota2' WHERE id='$idPersonal' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
  
   header ("location:magPersonalPtPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifEdit");
   ?>