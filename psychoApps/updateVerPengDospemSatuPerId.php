<?php
  include "contentsConAdm.php";
  
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $id_periode=mysqli_real_escape_string($con, $_POST['id_periode']);
  $nim=mysqli_real_escape_string($con, $_POST['nim']);
  $dospem_tesis1=mysqli_real_escape_string($con, $_POST['dospem_tesis1']);
  $cek1=mysqli_real_escape_string($con, $_POST['cek1']);
  $tgl_mulai=date('d-m-Y');
  $thn_mulai=date('Y');
  
  if($cek1==1 || $cek1==3) {
  $qcek = "SELECT * FROM mag_peserta_sempro WHERE nim='$nim' AND cek='2'";
  $row = mysqli_query($con, $qcek);
  $dcek = mysqli_num_rows($row);
  if($dcek > 0) {
  header ("location:verPengDospemPerId.php?id=$id&page=$page&message=notifGagalSempro");
  }  
  else {
  $qry="UPDATE mag_pengelompokan_dospem_tesis SET cek1='$cek1',tgl_mulai='',thn_mulai='' WHERE id='$id'";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  header ("location:verPengDospemPerId.php?id=$id&page=$page&message=notifEdit");} 
  }

  else if($cek1==2) {  
  $qry1 = "SELECT COUNT(dospem_tesis1) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]' AND cek1='1'";
  $res1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
  $data1 = mysqli_fetch_assoc($res1) or die(mysqli_error($con));
  
  $qry2 = "SELECT COUNT(dospem_tesis1) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]' AND cek1='2'";
  $res2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
  $data2 = mysqli_fetch_assoc($res2) or die(mysqli_error($con));

  $qry3 = "SELECT COUNT(dospem_tesis1) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]' AND cek1='3'";
  $res3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
  $data3 = mysqli_fetch_assoc($res3) or die(mysqli_error($con));
  
  $jumData=$data1['jumData'] + $data2['jumData'] + $data3['jumData'];
  $q = "SELECT kuota1 FROM mag_dospem_tesis WHERE id='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]'";
  $r =  mysqli_query($con, $q) or die(mysqli_error($con));
  $d = mysqli_fetch_assoc($r) or die(mysqli_error($con));
  
  if($jumData < $d['kuota1']) {
  $qry="UPDATE mag_pengelompokan_dospem_tesis SET cek1='$cek1',tgl_mulai='$tgl_mulai',thn_mulai='$thn_mulai' WHERE id='$id'";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  header ("location:verPengDospemPerId.php?id=$id&page=$page&message=notifEdit");
  }
  else if($jumData >= $d['kuota1']) {
  header ("location:verPengDospemPerId.php?id=$id&page=$page&message=notifGagalDisetujui");
  }
  }
  ?>