<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$id=mysqli_real_escape_string($con, $_POST['id']);
$id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
$page=mysqli_real_escape_string($con, $_POST['page']);
$mean_nilai_penguji4_7=mysqli_real_escape_string($con, $_POST['nilai_penguji4_7']);

$sql="UPDATE mag_nilai_ujtes SET nilai_penguji4_7='$mean_nilai_penguji4_7' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$qmean = "SELECT * FROM mag_nilai_ujtes WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$rmean = mysqli_query($con, $qmean)or die( mysqli_error($con));
$dmean = mysqli_fetch_assoc($rmean);

$mean_nilai_penguji4=($dmean['nilai_penguji4_1'] + $dmean['nilai_penguji4_2'] + $dmean['nilai_penguji4_3'] + $dmean['nilai_penguji4_4'] + $dmean['nilai_penguji4_5'] + $dmean['nilai_penguji4_6'] + $dmean['nilai_penguji4_7']) / 7;

$sql="UPDATE mag_nilai_ujtes SET mean_nilai_penguji4='$mean_nilai_penguji4' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$qpend =  "SELECT * FROM mag_nilai_ujtes WHERE id='$id' AND id_pendaftaran='$id_pendaftaran'";
$rpend = mysqli_query($con, $qpend);
$dpend = mysqli_fetch_array($rpend);

$mean_nilai_penguji3 = $dpend['mean_nilai_penguji3'];
$mean_nilai_penguji4 = $dpend['mean_nilai_penguji4'];
$mean_nilai_penguji1 = $dpend['mean_nilai_penguji1'];
$mean_nilai_penguji2 = $dpend['mean_nilai_penguji2'];

if($mean_nilai_penguji1=='0' && $mean_nilai_penguji2!='0' && $mean_nilai_penguji3!='0' && $mean_nilai_penguji4!='0') {$mean_nilai = ($mean_nilai_penguji2 + $mean_nilai_penguji3 + $mean_nilai_penguji4) / 3;}
  elseif($mean_nilai_penguji1=='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3!='0' && $mean_nilai_penguji4!='0') {
  $mean_nilai = ($mean_nilai_penguji3 + $mean_nilai_penguji4) / 2;}
  elseif($mean_nilai_penguji1=='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4!='0') {
  $mean_nilai = ($mean_nilai_penguji4) / 1;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji1) / 1;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2!='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji1 + $mean_nilai_penguji2) / 2;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2!='0' && $mean_nilai_penguji3!='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji1 + $mean_nilai_penguji2 + $mean_nilai_penguji3) / 3;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3!='0' && $mean_nilai_penguji4!='0') {
  $mean_nilai = ($mean_nilai_penguji1 + $mean_nilai_penguji3 + $mean_nilai_penguji4) / 3;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2!='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4!='0') {
  $mean_nilai = ($mean_nilai_penguji1 + $mean_nilai_penguji2 + $mean_nilai_penguji4) / 3;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4!='0') {
  $mean_nilai = ($mean_nilai_penguji1 + $mean_nilai_penguji4) / 2;}
  elseif($mean_nilai_penguji1=='0' && $mean_nilai_penguji2!='0' && $mean_nilai_penguji3!='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji2 + $mean_nilai_penguji3) / 2;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3!='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji1 + $mean_nilai_penguji3) / 2;}
  elseif($mean_nilai_penguji1=='0' && $mean_nilai_penguji2!='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4!='0') {
  $mean_nilai = ($mean_nilai_penguji2 + $mean_nilai_penguji4) / 2;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji1) / 1;}
  elseif($mean_nilai_penguji1=='0' && $mean_nilai_penguji2!='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji2) / 1;}
  elseif($mean_nilai_penguji1=='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3!='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji3) / 1;}
  elseif($mean_nilai_penguji1=='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4!='0') {
  $mean_nilai = ($mean_nilai_penguji4) / 1;}
  elseif($mean_nilai_penguji1=='0' && $mean_nilai_penguji2=='0' && $mean_nilai_penguji3=='0' && $mean_nilai_penguji4=='0') {
  $mean_nilai = ($mean_nilai_penguji1 + $mean_nilai_penguji2 + $mean_nilai_penguji3 + $mean_nilai_penguji4) / 4;}
  elseif($mean_nilai_penguji1!='0' && $mean_nilai_penguji2!='0' && $mean_nilai_penguji3!='0' && $mean_nilai_penguji4!='0') {
  $mean_nilai = ($mean_nilai_penguji1 + $mean_nilai_penguji2 + $mean_nilai_penguji3 + $mean_nilai_penguji4) / 4;}

$sql1="UPDATE mag_nilai_ujtes SET mean_nilai='$mean_nilai' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));

header("location:ba6UjianTesisPenguji4.php?page=$page&id=$id_pendaftaran");
?>