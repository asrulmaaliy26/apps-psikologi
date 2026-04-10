<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $nm=mysqli_real_escape_string($con, $_POST['nm']);
   $alasan_pinjam=mysqli_real_escape_string($con, $_POST['alasan_pinjam']);
   $tgl_awal_pinjam=mysqli_real_escape_string($con, $_POST['tgl_awal_pinjam']);
   $tgl_akhir_pinjam=mysqli_real_escape_string($con, $_POST['tgl_akhir_pinjam']);

   $qry3="UPDATE dt_peminjam_barang SET nm='$nm',alasan_pinjam='$alasan_pinjam',tgl_awal_pinjam='$tgl_awal_pinjam',tgl_akhir_pinjam='$tgl_akhir_pinjam' WHERE id='$id'";
   mysqli_query($con, $qry3) or die(mysqli_error($con));

   $qry4="UPDATE dt_pinjam_barang SET tgl_awal_pinjam='$tgl_awal_pinjam',tgl_akhir_pinjam='$tgl_akhir_pinjam',tgl_akhir_pinjam='$tgl_akhir_pinjam' WHERE id='$id'";
   mysqli_query($con, $qry4) or die(mysqli_error($con));
   header ("location:dtPinjamBarang.php?page=$page&message=notifEdit");
   ?>