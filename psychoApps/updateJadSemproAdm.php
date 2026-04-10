<?php include( "contentsConAdm.php" );
   error_reporting(E_ALL & ~E_NOTICE);
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $id_sempro=mysqli_real_escape_string($con, $_POST['id_sempro']);
   $page = mysqli_real_escape_string($con,  $_POST[ 'page' ] );
   $tgl_seminar=mysqli_real_escape_string($con, $_POST['tgl_seminar']);
   $jam_mulai=mysqli_real_escape_string($con, $_POST['jam_mulai']);   
   $jam_selesai=mysqli_real_escape_string($con, $_POST['jam_selesai']);
   $penguji1=mysqli_real_escape_string($con, $_POST['penguji1']);
   $penguji2=mysqli_real_escape_string($con, $_POST['penguji2']);
   $ruang=mysqli_real_escape_string($con, $_POST['ruang']);
   $statusform ="2";
   
   $myqry="UPDATE jadwal_sempro SET tgl_seminar='$tgl_seminar',jam_mulai='$jam_mulai',jam_selesai='$jam_selesai',penguji1='$penguji1',penguji2='$penguji2',ruang='$ruang' WHERE id_pendaftaran='$id' LIMIT 1";
   mysqli_query($con, $myqry) or die(mysqli_error($con));
   
   $qry="UPDATE peserta_sempro SET id_jdwl='$id',pembimbing1='$penguji1',statusform='$statusform' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   header("location:inputJadSemproPerPeriodeAdm.php?id=$id_sempro&page=$page&message=notifEdit");
   
   ?>