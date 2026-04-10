<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $nm=mysqli_real_escape_string($con, $_POST['nm']);
   $kategori=mysqli_real_escape_string($con, $_POST['kategori']);
   $model=mysqli_real_escape_string($con, $_POST['model']);


   $qry3="UPDATE dt_ruang SET nm='$nm',kategori='$kategori',model='$model' WHERE id='$id'";
   mysqli_query($con, $qry3) or die(mysqli_error($con));
   header ("location:dtRuang.php?page=$page&message=notifEdit");
   ?>