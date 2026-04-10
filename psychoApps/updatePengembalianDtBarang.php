<?php
   include("contentsConAdm.php");
   
   $jumlah = count($_POST["item"]);
   for($i=0; $i < $jumlah; $i++)
   {
   $id=$_POST["item"][$i];
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $tgl_kembali=date('Y-m-d');

   $qry_inv = "SELECT id_barang FROM dt_pinjam_barang WHERE id='$id'";
   $r_inv = mysqli_query($con, $qry_inv);
   $d_inv = mysqli_fetch_assoc($r_inv);

   $qry="UPDATE dt_pinjam_barang SET status_peminjaman='2',tgl_kembali='$tgl_kembali' WHERE id='$id'";
   mysqli_query($con, $qry) or die(mysqli_error($con));
  
   $qry1="UPDATE dt_inventaris_barang SET status_peminjaman='1' WHERE id='$d_inv[id_barang]'";
   mysqli_query($con, $qry1) or die(mysqli_error($con));
    }
   header ("location:dtPinjamBarang.php?page=$page&message=notifKembali");
   ?>