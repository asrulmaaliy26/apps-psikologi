<?php
   include("contentsConAdm.php");
   
   $jumlah = count($_POST["item"]);
   for($i=0; $i < $jumlah; $i++)
   {
   $id=$_POST["item"][$i];
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $id_barang=mysqli_real_escape_string($con, $_POST['id']);
   $peminjam=mysqli_real_escape_string($con, $_POST['peminjam']);
   $tgl_awal_pinjam=mysqli_real_escape_string($con, $_POST['tgl_awal_pinjam']);
   $tgl_akhir_pinjam=mysqli_real_escape_string($con, $_POST['tgl_akhir_pinjam']);
   $status_peminjaman='1';
      
   mysqli_query($con, "INSERT INTO dt_pinjam_barang(id_barang,peminjam,tgl_awal_pinjam,tgl_akhir_pinjam,status_peminjaman)".
   "values('$id','$peminjam','$tgl_awal_pinjam','$tgl_akhir_pinjam','$status_peminjaman')")  or die(mysqli_error($con));

   $qry="UPDATE dt_inventaris_barang SET status_peminjaman='2' WHERE id='$id'";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   }
   header ("location:dtPinjamBarang.php?page=$page&message=notifInput");
   ?>