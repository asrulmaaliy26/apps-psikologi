<?php
  include( "koneksiUser.php" );  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $dosen_wali=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dosen_wali']);
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
  $tgl_pengajuan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
    
  $qNip = "SELECT nip FROM mag_dosen_wali WHERE id='$_POST[dosen_wali]' AND id_periode='$_POST[id_periode]'";
  $rNip = mysqli_query($GLOBALS["___mysqli_ston"], $qNip) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dNip = mysqli_fetch_assoc($rNip) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $nip = $dNip['nip'];

  $qry = "SELECT COUNT(dosen_wali) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$dosen_wali' AND id_periode='$id_periode'";
  $res =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $data = mysqli_fetch_assoc($res) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      
  $q = "SELECT kuota FROM mag_dosen_wali WHERE id='$dosen_wali' AND id_periode='$id_periode'";
  $r =  mysqli_query($GLOBALS["___mysqli_ston"], $q) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $d = mysqli_fetch_assoc($r) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
  $qmpdw = "SELECT dosen_wali FROM mag_pengelompokan_dosen_wali WHERE id='$id'";
  $rmpdw =  mysqli_query($GLOBALS["___mysqli_ston"], $qmpdw) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dmpdw = mysqli_fetch_assoc($rmpdw) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  if($data['jumData'] < $d[kuota])
  { 
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_pengelompokan_dosen_wali SET dosen_wali='$dosen_wali',nip_dosen_wali='$nip',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));  
  header("location:formPengajuanAc.php?message=notifEdit");
  }
  else if($_POST['dosen_wali']==$dmpdw['dosen_wali'])
  {
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_pengelompokan_dosen_wali SET tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));  
  header("location:formPengajuanAc.php?message=notifEdit");
  }
  else  { 
  header("location:formPengajuanAc.php?message=notifGagal");
  }
  ?>