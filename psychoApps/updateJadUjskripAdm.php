<?php include( "contentsConAdm.php" );
   error_reporting(E_ALL & ~E_NOTICE);
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $id_ujskrip=mysqli_real_escape_string($con, $_POST['id_ujskrip']);
   $page = mysqli_real_escape_string($con,  $_POST[ 'page' ] );
   $tgl_ujian=mysqli_real_escape_string($con, $_POST['tgl_ujian']);
   $jam_mulai=mysqli_real_escape_string($con, $_POST['jam_mulai']);   
   $jam_selesai=mysqli_real_escape_string($con, $_POST['jam_selesai']);
   $ketua_penguji=mysqli_real_escape_string($con, $_POST['ketua_penguji']);
   $sekretaris_penguji=mysqli_real_escape_string($con, $_POST['sekretaris_penguji']);
   $penguji_utama=mysqli_real_escape_string($con, $_POST['penguji_utama']);
   $ruang=mysqli_real_escape_string($con, $_POST['ruang']);
   $statusform ="2";
   
   $myqry="UPDATE jadwal_ujskrip SET tgl_ujian='$tgl_ujian',jam_mulai='$jam_mulai',jam_selesai='$jam_selesai',ketua_penguji='$ketua_penguji',sekretaris_penguji='$sekretaris_penguji',penguji_utama='$penguji_utama',ruang='$ruang' WHERE id_pendaftaran='$id' LIMIT 1";
   mysqli_query($con, $myqry) or die(mysqli_error($con));
   
   $qry="UPDATE peserta_ujskrip SET id_jdwl='$id',pembimbing1='$sekretaris_penguji',statusform='$statusform' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   header("location:inputJadUjskripPerPeriodeAdm.php?id=$id_ujskrip&page=$page&message=notifEdit");
   
   ?>