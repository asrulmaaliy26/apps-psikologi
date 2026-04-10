<?php include( "contentsConAdm.php" );
$id = mysqli_real_escape_string($con, $_POST['id']);
$id_periode = mysqli_real_escape_string($con, $_POST['id_periode']);
$dospem_skripsi1 = mysqli_real_escape_string($con, $_POST['dospem_skripsi1']);
$dospem_skripsi2 = mysqli_real_escape_string($con, $_POST['dospem_skripsi2']);

$query1 = "SELECT dospem_skripsi1 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
$has1 = mysqli_query($con,  $query1) or die(mysqli_error($con));
$dt1 = mysqli_fetch_assoc($has1);
$dospem1 = $dt1['dospem_skripsi1'];
  
$query2 = "SELECT dospem_skripsi2 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
$has2 = mysqli_query($con,  $query2) or die(mysqli_error($con));
$dt2 = mysqli_fetch_assoc($has2);
$dospem2 = $dt2['dospem_skripsi2'];

$qry1 = "SELECT COUNT(dospem_skripsi1) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$_POST[dospem_skripsi1]' AND id_periode='$_POST[id_periode]' AND status='1'";
$res1 = mysqli_query($con, $qry1) or die(mysqli_error($con));
$data1 = mysqli_fetch_assoc($res1) or die(mysqli_error($con));

$qry2 = "SELECT COUNT(dospem_skripsi2) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$_POST[dospem_skripsi2]' AND id_periode='$_POST[id_periode]' AND status='1'";
$res2 = mysqli_query($con, $qry2) or die(mysqli_error($con));
$data2 = mysqli_fetch_assoc($res2) or die(mysqli_error($con));

$q1 = "SELECT kuota1 FROM dospem_skripsi WHERE nip='$_POST[dospem_skripsi1]' AND id_periode='$id_periode'";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));
$d1 = mysqli_fetch_assoc($r1) or die(mysqli_error($con));

$q2 = "SELECT kuota2 FROM dospem_skripsi WHERE nip='$_POST[dospem_skripsi2]' AND id_periode='$id_periode'";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));
$d2 = mysqli_fetch_assoc($r2) or die(mysqli_error($con));

if($data1['jumData'] >= $d1['kuota1']) {
header("location:prePengajuanDospemUser.php?message=notifGagalDospem1");}

else if($data2['jumData'] >= $d2['kuota2']) {
header("location:prePengajuanDospemUser.php?message=notifGagalDospem2");}

else if($data1['jumData'] >= $d1['kuota1'] && $data2['jumData'] >= $d2['kuota2']) {
header("location:prePengajuanDospemUser.php?message=notifGagalDospem12");}

else if($_POST['dospem_skripsi1'] == $_POST['dospem_skripsi2']) {
header("location:prePengajuanDospemUser.php?message=notifGagalSama");}

else {

$myqry1="UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi1='$dospem_skripsi1',dospem_skripsi2='$dospem_skripsi2' WHERE id='$id' LIMIT 1";
mysqli_query($con, $myqry1) or die(mysqli_error($con));
header("location:prePengajuanDospemUser.php?message=notifEdit");}
   ?>