<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $nm=mysqli_real_escape_string($con, $_POST['nm']);
   $kategori=mysqli_real_escape_string($con, $_POST['kategori']);
   $model=mysqli_real_escape_string($con, $_POST['model']);
   $lokasi_kampus = isset($_POST['lokasi_kampus']) ? mysqli_real_escape_string($con, $_POST['lokasi_kampus']) : 'Kampus 1';

   $qry3="UPDATE dt_ruang SET nm='$nm',kategori='$kategori',model='$model',lokasi_kampus='$lokasi_kampus' WHERE id='$id'";
   mysqli_query($con, $qry3) or die(mysqli_error($con));
   
   if ($lokasi_kampus === 'Kampus 3') {
       header("location:dtRuangKampus3.php?page=$page&message=notifEdit");
   } else {
       header("location:dtRuang.php?page=$page&message=notifEdit");
   }
   ?>