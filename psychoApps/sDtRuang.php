<?php include( "contentsConAdm.php" );
   $nm=mysqli_real_escape_string($con, $_POST['nm']);
   $kategori=mysqli_real_escape_string($con, $_POST['kategori']);
   $model=mysqli_real_escape_string($con, $_POST['model']);
   $status_peminjaman='1';

   mysqli_query($con, "INSERT INTO dt_ruang(id_ruang,nm,kategori,model,status_peminjaman)".
   "values('$id_ruang','$nm','$kategori','$model','$status_peminjaman')")  or die(mysqli_error($con));

   header("location:dtRuang.php?message=notifInput");
   ?>