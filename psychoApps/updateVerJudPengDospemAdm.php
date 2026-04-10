<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $cekjudul = mysqli_real_escape_string($con, $_POST['cekjudul']);
  $tgl_cekjudul = date('Y-m-d');

  $myqry1="UPDATE pengelompokan_dospem_skripsi SET cekjudul='$cekjudul',tgl_cekjudul='$tgl_cekjudul' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  
  $qcekjudul = "SELECT cekjudul FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $rcekjudul = mysqli_query($con,  $qcekjudul )or die( mysqli_error($con) );
  $dcekjudul = mysqli_fetch_assoc( $rcekjudul );
  
  if($dcekjudul['cekjudul'] == '1' || $dcekjudul['cekjudul'] == '4') {
  $myqry2="UPDATE pengelompokan_dospem_skripsi SET tgl_cekjudul='', tgl_mulai='',thn_mulai='',status='1' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry2) or die(mysqli_error($con));}
  header("location:verifikasiPengDospemAdm.php?id=$id&page=$page&message=notifEdit");
  ?>