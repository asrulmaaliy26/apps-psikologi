<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $image=mysqli_real_escape_string($con, $_POST['image']);

   $jenis_image = $_FILES['image']['type'];
   if ($jenis_image == "image/jpeg" || $jenis_image=="image/jpg" || $jenis_image=="image/png") {
   $myquery = "SELECT * FROM dt_inventaris_barang WHERE id='$id'";
   $r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
   $dt = mysqli_fetch_assoc( $r );
   $id_image=$dt['id'];
   $foldername = "image_barang/";
   $temp = explode(".", $_FILES["image"]["name"]);
   $newname = "image_".$id_image .uniqid(). '.' . end($temp);
   $image = $foldername . $newname;
   move_uploaded_file($_FILES['image']['tmp_name'], $foldername . '/' . $newname);
  
   $res = mysqli_query($con, "SELECT image FROM dt_inventaris_barang where id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['image'])>3)
    {
      if (file_exists($d['image'])) unlink($d['image']);
    }
   mysqli_query($con, "UPDATE dt_inventaris_barang SET image='$image' WHERE id='$id' LIMIT 1");
   header("location:dtBarang.php?page=$page&message=notifEdit");
    } else {
    header("location:dtBarang.php?page=$page&message=notifGagalImage");
    }
   ?>