<?php include( "contentsConAdm.php" );
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
   $status_peminjaman='1';

   mysqli_query($con, "INSERT INTO dt_inventaris_barang(nm,merk,tgl_perolehan,thn_perolehan,sumber_dana,kategori,sub_kategori,kondisi,id_inventaris_pusat,status_peminjaman)".
   "values('$nm','$merk','$tgl_perolehan','$thn_perolehan','$sumber_dana','$kategori','$sub_kategori','$kondisi','$id_inventaris_pusat','$status_peminjaman')")  or die(mysqli_error($con));

   $qry_dbr = "SELECT * FROM dt_inventaris_barang ORDER BY id DESC LIMIT 1";
   $r_dbr = mysqli_query($con, $qry_dbr);
   $d_dbr = mysqli_fetch_assoc($r_dbr);
   $id = $d_dbr['id'];
   $id_inventaris=$d_dbr['kategori'].''.$d_dbr['sub_kategori'].''.$d_dbr['merk'].''.$d_dbr['thn_perolehan'].''.$d_dbr['sumber_dana'].''.$d_dbr['id'];

   $qry3="UPDATE dt_inventaris_barang SET id_inventaris='$id_inventaris' WHERE id='$id'";
   mysqli_query($con, $qry3) or die(mysqli_error($con));

   header("location:dtBarang.php?message=notifInput");
   ?>