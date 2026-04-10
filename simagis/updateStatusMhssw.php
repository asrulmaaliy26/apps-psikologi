<?php
  include( "koneksiAdm.php" );  
  $nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $angkatan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['angkatan']);
  $status=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['status']);
  $page=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['page']);
  
  if($status==2){
  $q = "SELECT COUNT(nim) AS jumData FROM mag_peserta_sempro WHERE nim='$nim'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $d = mysqli_fetch_assoc($r);
  
  $qry = "SELECT COUNT(nim) AS jumData FROM mag_peserta_ujtes WHERE nim='$nim'";
  $row = mysqli_query($GLOBALS["___mysqli_ston"], $qry)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dut = mysqli_fetch_assoc($row);
  
  if($d['jumData']<1) {
  header("location:editMhsswPerAngkatan.php?angkatan=$angkatan&page=$page&message=notifGagalSempro");
  } else if($dut['jumData']<1) {
  header("location:editMhsswPerAngkatan.php?angkatan=$angkatan&page=$page&message=notifGagalUjtes");
  } else {
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_dt_mhssw_pasca SET status='$status' WHERE nim='$nim' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:editMhsswPerAngkatan.php?angkatan=$angkatan&page=$page&message=notifEdit");
  }
  } else {
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_dt_mhssw_pasca SET status='$status' WHERE nim='$nim' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:editMhsswPerAngkatan.php?angkatan=$angkatan&page=$page&message=notifEdit");
  }
  ?>