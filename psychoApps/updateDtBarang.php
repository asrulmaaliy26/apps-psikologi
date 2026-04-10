<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $nm=mysqli_real_escape_string($con, $_POST['nm']);
   $merk=mysqli_real_escape_string($con, $_POST['merk']);
   $tgl_perolehan=mysqli_real_escape_string($con, $_POST['tgl_perolehan']);
   $split = explode('-', $tgl_perolehan);
   $thn_perolehan= mysqli_real_escape_string($con, $split['0']);
   $sumber_dana=mysqli_real_escape_string($con, $_POST['sumber_dana']);
   $kategori=mysqli_real_escape_string($con, $_POST['kategori']);
   $sub_kategori=mysqli_real_escape_string($con, $_POST['sub_kategori']);
   $kondisi=mysqli_real_escape_string($con, $_POST['kondisi']);
   $id_inventaris_pusat=mysqli_real_escape_string($con, $_POST['id_inventaris_pusat']);

   $id_inventaris=mysqli_real_escape_string($con, $_POST['kategori']).''.mysqli_real_escape_string($con, $_POST['sub_kategori']).''.mysqli_real_escape_string($con, $_POST['merk']).''.mysqli_real_escape_string($con, $split['0']).''.mysqli_real_escape_string($con, $_POST['sumber_dana']).''.mysqli_real_escape_string($con, $_POST['id']);

   $qry3="UPDATE dt_inventaris_barang SET id_inventaris='$id_inventaris',nm='$nm',merk='$merk',tgl_perolehan='$tgl_perolehan',thn_perolehan='$thn_perolehan',sumber_dana='$sumber_dana',kategori='$kategori',sub_kategori='$sub_kategori',kondisi='$kondisi',id_inventaris_pusat='$id_inventaris_pusat' WHERE id='$id'";
   mysqli_query($con, $qry3) or die(mysqli_error($con));
   header ("location:dtBarang.php?page=$page&message=notifEdit");
   ?>