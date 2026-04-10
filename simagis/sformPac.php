<?php
  include( "koneksiUser.php" );
  $nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $dosen_wali=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dosen_wali']);
  $tgl_pengajuan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
  $cek=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);
  $status=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['status']);
  
  $qNip = "SELECT nip FROM mag_dosen_wali WHERE id='$_POST[dosen_wali]' AND id_periode='$_POST[id_periode]'";
  $rNip = mysqli_query($GLOBALS["___mysqli_ston"], $qNip) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dNip = mysqli_fetch_assoc($rNip) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $nip = $dNip['nip'];

  $qry = "SELECT COUNT(dosen_wali) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$dosen_wali' AND id_periode='$id_periode' AND status='1'";
  $res =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $data = mysqli_fetch_assoc($res) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      
  $q = "SELECT kuota FROM mag_dosen_wali WHERE id='$dosen_wali' AND id_periode='$id_periode'";
  $r =  mysqli_query($GLOBALS["___mysqli_ston"], $q) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $d = mysqli_fetch_assoc($r) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

  if($data['jumData'] < $d['kuota'])
  { 
  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_pengelompokan_dosen_wali(nim,dosen_wali,nip_dosen_wali,tgl_pengajuan,thn_pengajuan,id_periode,cek,status) VALUES ('$nim','$dosen_wali','$nip','$tgl_pengajuan','$thn_pengajuan','$id_periode','$cek','$status')")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:formPengajuanAc.php?message=notifInput");
  }
  else  {  
  header("location:formPengajuanAc.php?message=notifGagal");
  }
  ?>

