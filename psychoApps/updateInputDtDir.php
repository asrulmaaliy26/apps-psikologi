<?php
   include("contentsConAdm.php");
   
   $jumlah = count($_POST["item"]);
   for($i=0; $i < $jumlah; $i++)
   {
   $id=$_POST["item"][$i];
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $page0=mysqli_real_escape_string($con, $_POST['page0']);
   $id_barang=mysqli_real_escape_string($con, $_POST['id']);   
      
   $qry="UPDATE dt_inventaris_barang SET letak='$id_barang' WHERE id='$id'";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   }
   header ("location:dtDir.php?page=$page&message=notifInput");
   ?>