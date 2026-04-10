<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $cekberkas4 = mysqli_real_escape_string($con, $_POST['cekberkas4']);
  $tgl_cekberkas = date('Y-m-d');

  $myqry1="UPDATE pengelompokan_dospem_skripsi SET cekberkas4='$cekberkas4',tgl_cekberkas='$tgl_cekberkas' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  
  $qcekberkas = "SELECT cekberkas4 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $rcekberkas = mysqli_query($con,  $qcekberkas )or die( mysqli_error($con) );
  $dcekberkas = mysqli_fetch_assoc( $rcekberkas );
  
  if($dcekberkas['cekberkas4'] == '1' || $dcekberkas['cekberkas4'] == '4') {
  $myqry2="UPDATE pengelompokan_dospem_skripsi SET tgl_cekberkas='', tgl_mulai='',thn_mulai='',status='1' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry2) or die(mysqli_error($con));}
  header("location:verifikasiPengDospemAdm.php?id=$id&page=$page&message=notifEdit");
  ?>