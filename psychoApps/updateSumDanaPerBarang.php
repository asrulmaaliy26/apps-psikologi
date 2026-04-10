<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $nm=mysqli_real_escape_string($con, $_POST['nm']);

   $qry3="UPDATE opsi_sumber_dana_perolehan_barang SET nm='$nm' WHERE id='$id'";
   mysqli_query($con, $qry3) or die(mysqli_error($con));
   header ("location:opsiSumDanaPerBarang.php?page=$page&message=notifEdit");
   ?>