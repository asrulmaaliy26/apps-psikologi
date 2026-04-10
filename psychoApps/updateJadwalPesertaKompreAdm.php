<?php
   include("contentsConAdm.php");
   
   $jumlah = count($_POST["item"]);
   for($i=0; $i < $jumlah; $i++)
   {
   $id=$_POST["item"][$i];
   $id_jdwl=mysqli_real_escape_string($con, $_POST['id']);
   $id_kompre=mysqli_real_escape_string($con, $_POST['id_kompre']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
      
   $qry="UPDATE peserta_kompre SET id_jdwl='$id_jdwl',statusform='2' WHERE id='$id'";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   }
   header ("location:jadKomprePerPeriodeAdm.php?id=$id_kompre&page=$page&message=notifInput");
   ?>