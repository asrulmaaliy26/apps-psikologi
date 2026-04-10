<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftar = mysqli_real_escape_string($con, $_POST['id_pendaftar']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $catatan = mysqli_real_escape_string($con, $_POST['catatan']);
  
  $myqry="UPDATE peserta_kompre SET catatan='$catatan' WHERE id='$id_pendaftar' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  header("location:verpesKomprePerPeriodeAdm.php?id=$id&page=$page&message=notifCatatan");
  ?>