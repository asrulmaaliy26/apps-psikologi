<?php include( "contentsConAdm.php" );
$id = mysqli_real_escape_string($con, $_POST['id']);
$id_sempro = mysqli_real_escape_string($con, $_POST['id_sempro']);
$file_prop = mysqli_real_escape_string($con, $_POST['file_prop']);

$j_ftpd = $_FILES['file_prop']['type'];

$myquery = "SELECT * FROM peserta_sempro WHERE id='$id'";
$r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
$dt = mysqli_fetch_assoc( $r );
$q = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
$has = mysqli_query($con,  $q )or die( mysqli_error($con) );
$dataku = mysqli_fetch_assoc( $has );
$nim =  $dataku['nim'];
$nama = $dataku['nama'];
$date = strtotime('now');

if ($j_ftpd == "application/pdf") {
$namaftpd = "file_proposal/";
$temp_prop = explode(".", $_FILES["file_prop"]["name"]);
$nama_file_prop = $nama . '-'. $nim . '-' . $id_sempro . '_proposal_'. $date . '.' . end($temp_prop);
$file_prop = $namaftpd . $nama_file_prop;
move_uploaded_file($_FILES['file_prop']['tmp_name'], $namaftpd . '/' . $nama_file_prop);
  
$res2 = mysqli_query($con, "SELECT file_prop FROM peserta_sempro WHERE id='$id' LIMIT 1");
$d2=mysqli_fetch_assoc($res2);
if (strlen($d2['file_prop'])>3)
{
   if (file_exists($d2['file_prop'])) unlink($d2['file_prop']);}
   mysqli_query($con, "UPDATE peserta_sempro SET file_prop='$file_prop' WHERE id='$id' LIMIT 1");
   header("location:prePendaftaranSemproUser.php?id=$id&message=notifInput");}
   else {
   header("location:prePendaftaranSemproUser.php?id=$id&message=notifGagalUpload");}
   ?>