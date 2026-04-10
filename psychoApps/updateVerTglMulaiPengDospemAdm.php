<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $tgl_mulai = mysqli_real_escape_string($con, $_POST['tgl_mulai']);
  $explode_tgl_mulai = explode('-', $tgl_mulai);
  $thn_mulai  = $explode_tgl_mulai[0];
  $status = "2";
  
  $qcek1 = "SELECT cek1 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $rcek1 = mysqli_query($con,  $qcek1 )or die( mysqli_error($con) );
  $dcek1 = mysqli_fetch_assoc( $rcek1 );
  
  $qcek2 = "SELECT cek2 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $rcek2 = mysqli_query($con,  $qcek2 )or die( mysqli_error($con) );
  $dcek2 = mysqli_fetch_assoc( $rcek2 );
  
  $qcekjudul = "SELECT cekjudul FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $rcekjudul = mysqli_query($con,  $qcekjudul )or die( mysqli_error($con) );
  $dcekjudul = mysqli_fetch_assoc( $rcekjudul );
  
  if($dcek1['cek1'] == '1' || $dcek2['cek2'] == '1' || $dcekjudul['cekjudul'] == '1') {
  header("location:verifikasiPengDospemAdm.php?id=$id&page=$page&message=notifBelum");}
  
  else if($dcek1['cek1'] == '4' || $dcek2['cek2'] == '4' || $dcekjudul['cekjudul'] == '4') {
  header("location:verifikasiPengDospemAdm.php?id=$id&page=$page&message=notifTolak");}
  
  else {
  $myqry="UPDATE pengelompokan_dospem_skripsi SET tgl_mulai='$tgl_mulai',thn_mulai='$thn_mulai',status='$status' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  header("location:verifikasiPengDospemAdm.php?id=$id&page=$page&message=notifEdit");}
  ?>