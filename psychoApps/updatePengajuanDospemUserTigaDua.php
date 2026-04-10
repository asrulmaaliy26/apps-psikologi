<?php include( "contentsConAdm.php" );
$id = mysqli_real_escape_string($con, $_POST['id']);
$id_periode = mysqli_real_escape_string($con, $_POST['id_periode']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$dospem_skripsi2 = mysqli_real_escape_string($con, $_POST['dospem_skripsi2']);
$cek2 = mysqli_real_escape_string($con, $_POST['cek2']);

$query1 = "SELECT dospem_skripsi1 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
$has1 = mysqli_query($con,  $query1) or die(mysqli_error($con));
$dt1 = mysqli_fetch_assoc($has1);
$dospem1 = $dt1['dospem_skripsi1'];
  
$query2 = "SELECT dospem_skripsi2 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
$has2 = mysqli_query($con,  $query2) or die(mysqli_error($con));
$dt2 = mysqli_fetch_assoc($has2);
$dospem2 = $dt2['dospem_skripsi2'];

$qry1 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$_POST[dospem_skripsi2]' AND id_periode='$_POST[id_periode]'";
$res1 = mysqli_query($con, $qry1) or die(mysqli_error($con));
$data1 = mysqli_fetch_assoc($res1) or die(mysqli_error($con));

$q1 = "SELECT kuota2 FROM dospem_skripsi WHERE nip='$_POST[dospem_skripsi2]' AND id_periode='$id_periode'";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));
$d1 = mysqli_fetch_assoc($r1) or die(mysqli_error($con));

if($_POST['dospem_skripsi2'] != $dospem2 && $data1['jumData'] >= $d1['kuota2']) {
  header("location:editPengajuanDospemUserTigaDua.php?id=$id&message=notifGagalDospem2");}

else if($_POST['dospem_skripsi2'] == $dospem1) {
  header("location:editPengajuanDospemUserTigaDua.php?id=$id&message=notifGagalSama");}

else {
  if($cek2 == 4 && $_POST['dospem_skripsi2'] != $dospem2) {
  $myqry1="UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi2='$dospem_skripsi2',cek2='1',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
  else {
  $myqry2="UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi2='$dospem_skripsi2',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
mysqli_query($con, $myqry2) or die(mysqli_error($con));
header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}

  }

   ?>