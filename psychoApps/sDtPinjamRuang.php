<?php include( "contentsConAdm.php" );
   $nm=mysqli_real_escape_string($con, $_POST['nm']);
   $alasan_pinjam=mysqli_real_escape_string($con, $_POST['alasan_pinjam']);
   $tgl_awal_pinjam=mysqli_real_escape_string($con, $_POST['tgl_awal_pinjam']);
   $tgl_akhir_pinjam=mysqli_real_escape_string($con, $_POST['tgl_akhir_pinjam']);

   mysqli_query($con, "INSERT INTO dt_peminjam_ruang(nm,alasan_pinjam,tgl_awal_pinjam,tgl_akhir_pinjam)".
   "values('$nm','$alasan_pinjam','$tgl_awal_pinjam','$tgl_akhir_pinjam')")  or die(mysqli_error($con));

   header("location:dtPinjamRuang.php?message=notifInput");
   ?>