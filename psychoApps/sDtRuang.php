<?php include( "contentsConAdm.php" );
   $nm=mysqli_real_escape_string($con, $_POST['nm']);
   $kategori=mysqli_real_escape_string($con, $_POST['kategori']);
   $model=mysqli_real_escape_string($con, $_POST['model']);
   $lokasi_kampus = isset($_POST['lokasi_kampus']) ? mysqli_real_escape_string($con, $_POST['lokasi_kampus']) : 'Kampus 1';
   $status_peminjaman='1';

   mysqli_query($con, "INSERT INTO dt_ruang(id_ruang,nm,kategori,model,status_peminjaman,lokasi_kampus)".
   "values('0','$nm','$kategori','$model','$status_peminjaman','$lokasi_kampus')")  or die(mysqli_error($con));

   if ($lokasi_kampus === 'Kampus 3') {
       header("location:dtRuangKampus3.php?message=notifInput");
   } else {
       header("location:dtRuang.php?message=notifInput");
   }
   ?>