<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $cekberkas2 = mysqli_real_escape_string($con, $_POST['cekberkas2']);
  $tgl_cekberkas = date('Y-m-d');

  $myqry1="UPDATE pengelompokan_dospem_skripsi SET cekberkas2='$cekberkas2',tgl_cekberkas='$tgl_cekberkas' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  
  $qcekberkas = "SELECT cekberkas2 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $rcekberkas = mysqli_query($con,  $qcekberkas )or die( mysqli_error($con) );
  $dcekberkas = mysqli_fetch_assoc( $rcekberkas );
  
  if($dcekberkas['cekberkas2'] == '1' || $dcekberkas['cekberkas2'] == '4') {
  $myqry2="UPDATE pengelompokan_dospem_skripsi SET tgl_cekberkas='', tgl_mulai='',thn_mulai='',status='1' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry2) or die(mysqli_error($con));}
  header("location:verifikasiPengDospemAdm.php?id=$id&page=$page&message=notifEdit");
  ?>