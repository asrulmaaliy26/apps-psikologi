<?php
  include("contentsConAdm.php");
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $id_kompre=mysqli_real_escape_string($con, $_POST['id_kompre']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $pengawas1=mysqli_real_escape_string($con, $_POST['pengawas1']);
  $pengawas2=mysqli_real_escape_string($con, $_POST['pengawas2']);
  $ruang=mysqli_real_escape_string($con, $_POST['ruang']);
  $tgl_kompre=mysqli_real_escape_string($con, $_POST['tgl_kompre']);
  $jam_mulai=mysqli_real_escape_string($con, $_POST['jam_mulai']);
  $jam_selesai=mysqli_real_escape_string($con, $_POST['jam_selesai']);
   
  $qupdate="UPDATE jadwal_kompre SET pengawas1='$pengawas1',pengawas2='$pengawas2',ruang='$ruang',tgl_kompre='$tgl_kompre',jam_mulai='$jam_mulai',jam_selesai='$jam_selesai' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $qupdate) or die(mysqli_error($con));
   
  header("location:jadKomprePerPeriodeAdm.php?id=$id_kompre&page=$page&message=notifEdit");
  ?>