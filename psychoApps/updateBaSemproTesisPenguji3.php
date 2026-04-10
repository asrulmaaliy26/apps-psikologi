<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $nilai_penguji3=mysqli_real_escape_string($con, $_POST['nilai_penguji3']);

  $sql="UPDATE mag_nilai_sempro SET nilai_penguji3='$nilai_penguji3' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $qpend =  "SELECT * FROM mag_nilai_sempro WHERE id_pendaftaran='$id_pendaftaran'";
  $rpend = mysqli_query($con, $qpend);
  $dpend = mysqli_fetch_array($rpend);

  $nilai_penguji3 = $dpend['nilai_penguji3'];
  $nilai_penguji4 = $dpend['nilai_penguji4'];
  $nilai_penguji1 = $dpend['nilai_penguji1'];
  $nilai_penguji2 = $dpend['nilai_penguji2'];

  if($nilai_penguji1=='0' && $nilai_penguji2!='0' && $nilai_penguji3!='0' && $nilai_penguji4!='0') {$mean_nilai = ($nilai_penguji2 + $nilai_penguji3 + $nilai_penguji4) / 3;}
  elseif($nilai_penguji1=='0' && $nilai_penguji2=='0' && $nilai_penguji3!='0' && $nilai_penguji4!='0') {
  $mean_nilai = ($nilai_penguji3 + $nilai_penguji4) / 2;}
  elseif($nilai_penguji1=='0' && $nilai_penguji2=='0' && $nilai_penguji3=='0' && $nilai_penguji4!='0') {
  $mean_nilai = ($nilai_penguji4) / 1;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2=='0' && $nilai_penguji3=='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji1) / 1;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2!='0' && $nilai_penguji3=='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji1 + $nilai_penguji2) / 2;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2!='0' && $nilai_penguji3!='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji1 + $nilai_penguji2 + $nilai_penguji3) / 3;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2=='0' && $nilai_penguji3!='0' && $nilai_penguji4!='0') {
  $mean_nilai = ($nilai_penguji1 + $nilai_penguji3 + $nilai_penguji4) / 3;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2!='0' && $nilai_penguji3=='0' && $nilai_penguji4!='0') {
  $mean_nilai = ($nilai_penguji1 + $nilai_penguji2 + $nilai_penguji4) / 3;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2=='0' && $nilai_penguji3=='0' && $nilai_penguji4!='0') {
  $mean_nilai = ($nilai_penguji1 + $nilai_penguji4) / 2;}
  elseif($nilai_penguji1=='0' && $nilai_penguji2!='0' && $nilai_penguji3!='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji2 + $nilai_penguji3) / 2;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2=='0' && $nilai_penguji3!='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji1 + $nilai_penguji3) / 2;}
  elseif($nilai_penguji1=='0' && $nilai_penguji2!='0' && $nilai_penguji3=='0' && $nilai_penguji4!='0') {
  $mean_nilai = ($nilai_penguji2 + $nilai_penguji4) / 2;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2=='0' && $nilai_penguji3=='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji1) / 1;}
  elseif($nilai_penguji1=='0' && $nilai_penguji2!='0' && $nilai_penguji3=='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji2) / 1;}
  elseif($nilai_penguji1=='0' && $nilai_penguji2=='0' && $nilai_penguji3!='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji3) / 1;}
  elseif($nilai_penguji1=='0' && $nilai_penguji2=='0' && $nilai_penguji3=='0' && $nilai_penguji4!='0') {
  $mean_nilai = ($nilai_penguji4) / 1;}
  elseif($nilai_penguji1=='0' && $nilai_penguji2=='0' && $nilai_penguji3=='0' && $nilai_penguji4=='0') {
  $mean_nilai = ($nilai_penguji1 + $nilai_penguji2 + $nilai_penguji3 + $nilai_penguji4) / 4;}
  elseif($nilai_penguji1!='0' && $nilai_penguji2!='0' && $nilai_penguji3!='0' && $nilai_penguji4!='0') {
  $mean_nilai = ($nilai_penguji1 + $nilai_penguji2 + $nilai_penguji3 + $nilai_penguji4) / 4;}

$sql2="UPDATE mag_nilai_sempro SET mean_nilai='$mean_nilai' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));

header("location:baSemproTesisPenguji3.php?page=$page&id=$id_pendaftaran");
?>
