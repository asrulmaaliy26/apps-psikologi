<?php include( "contentsConAdm.php" );
$id = mysqli_real_escape_string($con, $_POST['id']);
$id_pkl = mysqli_real_escape_string($con, $_POST['id_pkl']);
$file_transkrip = mysqli_real_escape_string($con, $_POST['file_transkrip']);

$j_ftpd = $_FILES['file_transkrip']['type'];

$myquery = "SELECT * FROM peserta_pkl WHERE id='$id'";
$r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
$dt = mysqli_fetch_assoc( $r );
$q = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
$has = mysqli_query($con,  $q )or die( mysqli_error($con) );
$dataku = mysqli_fetch_assoc( $has );
$nim =  $dataku['nim'];
$nama = $dataku['nama'];
$date = strtotime('now');

if ($j_ftpd == "application/pdf") {
$namaftpd = "file_transkrip_pkl/";
$temp_transkrip = explode(".", $_FILES["file_transkrip"]["name"]);
$nama_file_transkrip = $nama . '-'. $nim . '-' . $id_pkl . '_transkrip-pkl_'. $date . '.' . end($temp_transkrip);
$file_transkrip = $namaftpd . $nama_file_transkrip;
move_uploaded_file($_FILES['file_transkrip']['tmp_name'], $namaftpd . '/' . $nama_file_transkrip);
  
$res2 = mysqli_query($con, "SELECT file_transkrip FROM peserta_pkl WHERE id='$id' LIMIT 1");
$d2=mysqli_fetch_assoc($res2);
if (strlen($d2['file_transkrip'])>3)
{
   if (file_exists($d2['file_transkrip'])) unlink($d2['file_transkrip']);}
   mysqli_query($con, "UPDATE peserta_pkl SET file_transkrip='$file_transkrip' WHERE id='$id' LIMIT 1");
   header("location:prePendaftaranPklUser.php?id=$id&message=notifInput");}
   else {
   header("location:prePendaftaranPklUser.php?id=$id&message=notifGagalUpload");}
   ?>