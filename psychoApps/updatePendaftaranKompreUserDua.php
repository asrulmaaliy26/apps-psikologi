<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$tgl= mysqli_real_escape_string($con, $split['0']);
$bln= mysqli_real_escape_string($con, $split['1']);
$thn= mysqli_real_escape_string($con, $split['2']);
$file_transkrip_nilai = mysqli_real_escape_string($con, $_POST['file_transkrip_nilai']);
$val_adm = '1';
$statusform = '1';

$j_ftpd = $_FILES['file_transkrip_nilai']['type'];

$myquery = "SELECT * FROM peserta_kompre WHERE id='$id'";
$r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
$dt = mysqli_fetch_assoc( $r );
$id_kompre=$dt['id_kompre'];
$q = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
$has = mysqli_query($con,  $q )or die( mysqli_error($con) );
$dataku = mysqli_fetch_assoc( $has );
$nim =  $dataku['nim'];
$nama = $dataku['nama'];
$date = strtotime('now');

if ($j_ftpd == "application/pdf") {
$namaftpd = "transkrip_kompre/";
$temp_transkrip = explode(".", $_FILES["file_transkrip_nilai"]["name"]);
$nama_file_transkrip_nilai = $nama . '-'. $nim . '-' . $id_kompre . '_transkrip_'. $date . '.' . end($temp_transkrip);
$file_transkrip_nilai = $namaftpd . $nama_file_transkrip_nilai;
move_uploaded_file($_FILES['file_transkrip_nilai']['tmp_name'], $namaftpd . '/' . $nama_file_transkrip_nilai);
  
$res2 = mysqli_query($con, "SELECT file_transkrip_nilai FROM peserta_kompre WHERE id='$id' LIMIT 1");
$d2=mysqli_fetch_assoc($res2);
if (strlen($d2['file_transkrip_nilai'])>3)
{
   if (file_exists($d2['file_transkrip_nilai'])) unlink($d2['file_transkrip_nilai']);}
   mysqli_query($con, "UPDATE peserta_kompre SET file_transkrip_nilai='$file_transkrip_nilai',tgl_pengajuan='$tgl_pengajuan',tgl='$tgl',bln='$bln',thn='$thn',val_adm='$val_adm',statusform='$statusform' WHERE id='$id' LIMIT 1");
   header("location:detailRiwayatPendaftaranKompreUser.php?id=$id&message=notifEdit");}
   else {
      if(mysqli_real_escape_string($con, $_POST['file_transkrip_nilai'])==$d2['file_transkrip_nilai']) {
      header("location:detailRiwayatPendaftaranKompreUser.php?id=$id&message=notifEdit");}
      else {
      header("location:editPendaftaranKompreUserDua.php?id=$id&message=notifGagalUpload");}}
?>