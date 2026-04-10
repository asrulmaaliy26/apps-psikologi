<?php
  include "koneksiAdm.php";
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
  $page=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['page']);
  $verifikasi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['verifikasi']);
  $tgl_cek=date('d-m-Y');
  $thn_cek=date('Y');
  
  if($verifikasi==1) {
  $query = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE id='$id'";
  $res =  mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dt = mysqli_fetch_assoc($res) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $status = $dt['status'];
  if($status==2) {
  header ("location:verifikasiPengajuanAc.php?id=$id_periode&page=$page&message=notifGagal");
  }  
  else {
  $qry="UPDATE mag_pengelompokan_dosen_wali SET cek='$verifikasi',tgl_cek='',thn_cek='' WHERE id='$id'";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$id_periode' AND cek='1'";
  $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $jumlahData1 = $dataku1['jumData'];
  if($jumlahData1==0) {
  header ("location:rekapPacAdm.php?id=$id_periode&page=$page&message=notifEdit");}
  if($jumlahData1 >0) {
  header ("location:verifikasiPengajuanAc.php?id=$id_periode&page=$page&message=notifEdit");} 
  }
  }
  else if($verifikasi==2) { 
  $qry="UPDATE mag_pengelompokan_dosen_wali SET cek='$verifikasi',tgl_cek='$tgl_cek',thn_cek='$thn_cek' WHERE id='$id'";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$id_periode' AND cek='1'";
  $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $jumlahData1 = $dataku1['jumData'];
  if($jumlahData1==0) {
  header ("location:rekapPacAdm.php?id=$id_periode&page=$page&message=notifEdit");}
  if($jumlahData1 >0) {
  header ("location:verifikasiPengajuanAc.php?id=$id_periode&page=$page&message=notifEdit");} 
  }
  ?>