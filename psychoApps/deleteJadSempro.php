<?php
   include( "contentsConAdm.php" );
   error_reporting(E_ALL & ~E_NOTICE);
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $id_sempro=mysqli_real_escape_string($con, $_GET['id_sempro']);
   $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );

   $qry1="UPDATE jadwal_sempro SET penguji2='',tgl_seminar='',jam_mulai='',jam_selesai='',ruang='' WHERE id_pendaftaran='$id' LIMIT 1";
   mysqli_query($con, $qry1) or die(mysqli_error($con));

   $qry2="UPDATE peserta_sempro SET statusform='1' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $qry2) or die(mysqli_error($con));
   header("location:inputJadSemproPerPeriodeAdm.php?id=$id_sempro&page=$page&message=notifDelete");
   ?>