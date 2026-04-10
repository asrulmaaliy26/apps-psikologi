<?php
   include("contentsConAdm.php");
   
   $jumlah = count($_POST["item"]);
   for($i=0; $i < $jumlah; $i++)
   {
   $id=$_POST["item"][$i];
   $dpl=mysqli_real_escape_string($con, $_POST['dpl']);
   $id_dpl=mysqli_real_escape_string($con, $_POST['id']);
   $id_pkl=mysqli_real_escape_string($con, $_POST['id_pkl']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
      
   $qry="UPDATE peserta_pkl SET dpl='$dpl',id_dpl='$id_dpl',statusform='2' WHERE id='$id'";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   }
   header ("location:pengelompokanPesPerDplPerPeriodeAdm.php?id=$id_pkl&page=$page&message=notifInput");
   ?>