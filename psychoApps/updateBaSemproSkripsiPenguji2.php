<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $nilai_narsum2=mysqli_real_escape_string($con, $_POST['nilai_narsum2']);

  $sql="UPDATE nilai_sempro SET nilai_narsum2='$nilai_narsum2' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $qpend =  "SELECT * FROM nilai_sempro WHERE id_pendaftaran='$id_pendaftaran'";
  $rpend = mysqli_query($con, $qpend);
  $dpend = mysqli_fetch_array($rpend);

  $nilai_narsum1 = $dpend['nilai_narsum1'];
  $nilai_narsum2 = $dpend['nilai_narsum2'];

  if($nilai_narsum1=='0' && $nilai_narsum2!='0') {
  $mean_nilai = $nilai_narsum2 / 1;}
  elseif($nilai_narsum1!='0' && $nilai_narsum2=='0') {
  $mean_nilai = $nilai_narsum1 / 1;}
  elseif($nilai_narsum1=='0' && $nilai_narsum2=='0') {
  $mean_nilai = ($nilai_narsum1 + $nilai_narsum2) / 2;}
  elseif($nilai_narsum1!='0' && $nilai_narsum2!='0') {
  $mean_nilai = ($nilai_narsum1 + $nilai_narsum2) / 2;}

$sql2="UPDATE nilai_sempro SET mean_nilai='$mean_nilai' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));

header("location:baSemproSkripsiPenguji2.php?page=$page&id=$id_pendaftaran");
?>
