<?php
   include( "contentsConAdm.php" );
   error_reporting(E_ALL & ~E_NOTICE);
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $id_ujskrip=mysqli_real_escape_string($con, $_GET['id_ujskrip']);
   $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );

   $qry1="UPDATE jadwal_ujskrip SET ketua_penguji='',penguji_utama='',tgl_ujian='',jam_mulai='',jam_selesai='',ruang='' WHERE id_pendaftaran='$id' LIMIT 1";
   mysqli_query($con, $qry1) or die(mysqli_error($con));

   $qry2="UPDATE peserta_ujskrip SET statusform='1' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $qry2) or die(mysqli_error($con));
   header("location:inputJadUjskripPerPeriodeAdm.php?id=$id_ujskrip&page=$page&message=notifDelete");
   ?>