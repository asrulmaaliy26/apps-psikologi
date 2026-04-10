<?php
  include "koneksiAdm.php";
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
  $dospem_tesis1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem_tesis1']);
  $nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $verifikasi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['verifikasi']);
  $tgl_mulai=date('d-m-Y');
  $thn_mulai=date('Y');
  
  if($verifikasi==1 || $verifikasi==3) {
  $qcek = "SELECT * FROM mag_peserta_sempro WHERE nim='$nim' AND cek='2'";
  $row = mysqli_query($GLOBALS["___mysqli_ston"], $qcek);
  $dcek = mysqli_num_rows($row);
  if($dcek > 0) {
  header ("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifGagal");
  }  
  else {
  $qry="UPDATE mag_pengelompokan_dospem_tesis SET cek1='$verifikasi',tgl_mulai='',thn_mulai='' WHERE id='$id'";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header ("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifEdit");} 
  }
  else if($verifikasi==2) {  
  $qry1 = "SELECT COUNT(dospem_tesis1) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]' AND cek1='1'";
  $res1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $data1 = mysqli_fetch_assoc($res1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $qry2 = "SELECT COUNT(dospem_tesis1) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]' AND cek1='2'";
  $res2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $data2 = mysqli_fetch_assoc($res2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $jumData=$data1['jumData'] + $data2['jumData'];
  $q = "SELECT kuota1 FROM mag_dospem_tesis WHERE id='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]'";
  $r =  mysqli_query($GLOBALS["___mysqli_ston"], $q) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $d = mysqli_fetch_assoc($r) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $qcek3 = "SELECT cek1 FROM mag_pengelompokan_dospem_tesis WHERE id='$id'";
  $rcek3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qcek3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dcek3 = mysqli_fetch_assoc($rcek3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  if($data1['jumData'] && $data2['jumData'] < $d['kuota1']) {
  $qry="UPDATE mag_pengelompokan_dospem_tesis SET cek1='$verifikasi',tgl_mulai='$tgl_mulai',thn_mulai='$thn_mulai' WHERE id='$id'";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header ("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifEdit");
  }
  else if($jumData >= $d['kuota1']) {
  header ("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifGagalDisetujui");
  }
  }
  ?>