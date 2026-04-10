<?php
  include "koneksiAdm.php";
  
  $idmpdt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['idmpdt']);
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $verifikasi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['verifikasi']);
  $tgl_mulai=date('d-m-Y');
  $thn_mulai=date('Y');
  
  if($verifikasi==1) {
  $qcek = "SELECT * FROM mag_peserta_sempro WHERE nim='$nim' AND cek='2'";
  $row = mysqli_query($GLOBALS["___mysqli_ston"], $qcek);
  $dcek = mysqli_num_rows($row);
  if($dcek > 0) {
  header ("location:pengajuPtPerPeriode.php?id=$id&message=notifGagal");
  }  
  else {
  $qry="UPDATE mag_pengelompokan_dospem_tesis SET status='$verifikasi',tgl_mulai='',thn_mulai='' WHERE id='$idmpdt'";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$id' AND status='1'";
  $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $jumlahData1 = $dataku1['jumData'];
  if($jumlahData1==0) {
  header ("location:rekapPptAdm.php?message=notifEdit");}
  if($jumlahData1 >0) {
  header ("location:pengajuPtPerPeriode.php?id=$id&message=notifEdit");} 
  }
  }
  else if($verifikasi==2) { 
  $qry="UPDATE mag_pengelompokan_dospem_tesis SET status='$verifikasi',tgl_mulai='$tgl_mulai',thn_mulai='$thn_mulai' WHERE id='$idmpdt'";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$id' AND status='1'";
  $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $jumlahData2 = $dataku2['jumData'];
  if($jumlahData2==0) {
  header ("location:rekapPptAdm.php?message=notifEdit");}
  if($jumlahData2 >0) {
  header ("location:pengajuPtPerPeriode.php?id=$id&message=notifEdit");} 
  }
  ?>