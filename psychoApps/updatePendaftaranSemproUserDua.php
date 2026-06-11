<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_prop = mysqli_real_escape_string($con, $_POST['file_prop']);
$val_adm = '1';
$statusform = '1';

$j_ftpd = $_FILES['file_prop']['type'];

$myquery = "SELECT * FROM peserta_sempro WHERE id='$id'";
$r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
$dt = mysqli_fetch_assoc( $r );
$id_sempro=$dt['id_sempro'];
$q = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
$has = mysqli_query($con,  $q )or die( mysqli_error($con) );
$dataku = mysqli_fetch_assoc( $has );
$nim =  $dataku['nim'];
$nama = $dataku['nama'];
$date = strtotime('now');

// Validasi file upload error
$upload_error = $_FILES['file_prop']['error'] ?? UPLOAD_ERR_NO_FILE;
if ($upload_error !== UPLOAD_ERR_OK) {
    header("location:editPendaftaranSemproUserDua.php?id=$id&message=notifGagalUpload");
    exit;
}

// Validasi ukuran file (maksimal 2MB = 2097152 bytes)
$max_file_size = 2097152; // 2MB
$file_size = $_FILES['file_prop']['size'] ?? 0;
if ($file_size > $max_file_size) {
    header("location:editPendaftaranSemproUserDua.php?id=$id&message=notifGagalUpload");
    exit;
}

if ($j_ftpd == "application/pdf") {
$namaftpd = "file_proposal/";
$temp_prop = explode(".", $_FILES["file_prop"]["name"]);
$nama_file_prop = $nama . '-'. $nim . '-' . $id_sempro . '_proposal_'. $date . '.' . end($temp_prop);
$file_prop = $namaftpd . $nama_file_prop;
if (!move_uploaded_file($_FILES['file_prop']['tmp_name'], $namaftpd . '/' . $nama_file_prop)) {
    header("location:editPendaftaranSemproUserDua.php?id=$id&message=notifGagalUpload");
    exit;
}
  
$res2 = mysqli_query($con, "SELECT file_prop FROM peserta_sempro WHERE id='$id' LIMIT 1");
$d2=mysqli_fetch_assoc($res2);
if (strlen($d2['file_prop'])>3)
{
   if (file_exists($d2['file_prop'])) unlink($d2['file_prop']);}
   mysqli_query($con, "UPDATE peserta_sempro SET file_prop='$file_prop',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan',val_adm='$val_adm',statusform='$statusform' WHERE id='$id' LIMIT 1");
   header("location:detailRiwayatPendaftaranSemproUser.php?id=$id&message=notifEdit");}
   else {
      if(mysqli_real_escape_string($con, $_POST['file_prop'])==$d2['file_prop']) {
      header("location:detailRiwayatPendaftaranSemproUser.php?id=$id&message=notifEdit");}
      else {
      header("location:editPendaftaranSemproUserDua.php?id=$id&message=notifGagalUpload");}}
?>