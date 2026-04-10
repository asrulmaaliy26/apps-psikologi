<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $nm=mysqli_real_escape_string($con, $_POST['nm']);

   $qry3="UPDATE opsi_merk_barang SET nm='$nm' WHERE id='$id'";
   mysqli_query($con, $qry3) or die(mysqli_error($con));
   header ("location:opsiMerkBarang.php?page=$page&message=notifEdit");
   ?>