<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $tahun = mysqli_real_escape_string($con, $_POST['date']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $catatan = mysqli_real_escape_string($con, $_POST['catatan']);
  
  $myqry="UPDATE siprak_siswa SET catatan='$catatan' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  header("location:rekapSiprakSiswaKelAdm.php?id=$id&date=$tahun&message=notifCatatan");
  ?>