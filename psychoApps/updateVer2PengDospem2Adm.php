<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $cek2 = mysqli_real_escape_string($con, $_POST['cek2']);
  $tgl_cek2 = date('Y-m-d');

  $myqry1="UPDATE pengelompokan_dospem_skripsi SET cek2='$cek2',tgl_cek2='$tgl_cek2' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  
  $qcekjudul = "SELECT cek2 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $rcekjudul = mysqli_query($con,  $qcekjudul )or die( mysqli_error($con) );
  $dcekjudul = mysqli_fetch_assoc( $rcekjudul );
  
  if($dcekjudul['cek2'] == '1' || $dcekjudul['cek2'] == '4') {
  $myqry2="UPDATE pengelompokan_dospem_skripsi SET tgl_cek2='', tgl_mulai='',thn_mulai='',status='1' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry2) or die(mysqli_error($con));}
  header("location:verifikasiPengDospemAdm.php?id=$id&page=$page&message=notifEdit");
  ?>