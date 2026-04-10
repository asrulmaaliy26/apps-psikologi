<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_skripsi = mysqli_real_escape_string($con, $_POST['file_skripsi']);
$val_adm = '1';
$statusform = '1';

$j_ftpd = $_FILES['file_skripsi']['type'];

$myquery = "SELECT * FROM peserta_ujskrip WHERE id='$id'";
$r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
$dt = mysqli_fetch_assoc( $r );
$id_ujskrip=$dt['id_ujskrip'];
$q = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
$has = mysqli_query($con,  $q )or die( mysqli_error($con) );
$dataku = mysqli_fetch_assoc( $has );
$nim =  $dataku['nim'];
$nama = $dataku['nama'];
$date = strtotime('now');

if ($j_ftpd == "application/pdf") {
$namaftpd = "file_skripsi_ujian/";
$temp_skripsi = explode(".", $_FILES["file_skripsi"]["name"]);
$nama_file_skripsi = $nama . '-'. $nim . '-' . $id_ujskrip . '_skripsi_'. $date . '.' . end($temp_skripsi);
$file_skripsi = $namaftpd . $nama_file_skripsi;
move_uploaded_file($_FILES['file_skripsi']['tmp_name'], $namaftpd . '/' . $nama_file_skripsi);
  
$res2 = mysqli_query($con, "SELECT file_skripsi FROM peserta_ujskrip WHERE id='$id' LIMIT 1");
$d2=mysqli_fetch_assoc($res2);
if (strlen($d2['file_skripsi'])>3)
{
   if (file_exists($d2['file_skripsi'])) unlink($d2['file_skripsi']);}
   mysqli_query($con, "UPDATE peserta_ujskrip SET file_skripsi='$file_skripsi',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan',val_adm='$val_adm',statusform='$statusform' WHERE id='$id' LIMIT 1");
   header("location:detailRiwayatPendaftaranUjskripUser.php?id=$id&message=notifEdit");}
   else {
      if(mysqli_real_escape_string($con, $_POST['file_skripsi'])==$d2['file_skripsi']) {
      header("location:detailRiwayatPendaftaranUjskripUser.php?id=$id&message=notifEdit");}
      else {
      header("location:editPendaftaranUjskripUserDua.php?id=$id&message=notifGagalUpload");}}
?>