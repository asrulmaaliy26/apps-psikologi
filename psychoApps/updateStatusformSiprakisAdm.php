<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $date = mysqli_real_escape_string($con, $_POST['date']);
  $statusform = mysqli_real_escape_string($con, $_POST['statusform']);
  $tgl_proses = date('d-m-Y');
  $tgl_selesai = date('d-m-Y');
  $tgl_dikeluarkan = date('Y-m-d');

  if(mysqli_real_escape_string($con, $_POST['statusform'])=='1' OR mysqli_real_escape_string($con, $_POST['statusform'])=='4') {
  $myqry1="UPDATE siprak_siswa SET statusform='$statusform',tgl_proses='' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  }
  elseif(mysqli_real_escape_string($con, $_POST['statusform'])=='2') {
  $myqry1="UPDATE siprak_siswa SET statusform='$statusform',tgl_proses='$tgl_proses',tgl_dikeluarkan='$tgl_dikeluarkan' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  }
  elseif(mysqli_real_escape_string($con, $_POST['statusform'])=='3') {
  $myqry1="UPDATE siprak_siswa SET statusform='$statusform',tgl_dikeluarkan='$tgl_dikeluarkan',tgl_selesai='$tgl_selesai' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  }
  else {
  $myqry1="UPDATE siprak_siswa SET statusform='$statusform' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  }
  header("location:rekapSiprakSiswaIndAdm.php?date=$tahun&page=$page&message=notifEdit");
  ?>