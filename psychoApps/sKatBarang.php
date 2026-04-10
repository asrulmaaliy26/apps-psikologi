<?php include( "contentsConAdm.php" );
   $nm=mysqli_real_escape_string($con, $_POST['nm']);

   mysqli_query($con, "INSERT INTO opsi_kat_barang(nm)".
   "values('$nm')")  or die(mysqli_error($con));

   header("location:opsiKatBarang.php?message=notifInput");
   ?>