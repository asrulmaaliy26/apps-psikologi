<?php
  include "contentsConAdm.php";
  
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $cekjudul = mysqli_real_escape_string($con, $_POST['cekjudul']);
  $tgl_cekjudul = date('d-m-Y');

  $qry = "UPDATE mag_pengelompokan_dospem_tesis SET cekjudul='$cekjudul' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  
  header("location:verPengDospemPerId.php?id=$id&page=$page&message=notifEdit");
?>
