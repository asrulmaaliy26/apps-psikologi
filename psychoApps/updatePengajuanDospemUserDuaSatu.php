<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_prop = mysqli_real_escape_string($con, $_POST['file_prop']);
$j_fppd = $_FILES['file_prop']['type'];

$myquery = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id='$id'";
$r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
$dt = mysqli_fetch_assoc( $r );
$id_periode=$dt['id_periode'];
$q = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
$has = mysqli_query($con,  $q )or die( mysqli_error($con) );
$dataku = mysqli_fetch_assoc( $has );
$nim =  $dataku['nim'];
$nama = $dataku['nama'];
$date = strtotime('now');

   if($file_prop == $dt['file_prop']) {
   header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {   
   if ($j_fppd != "application/pdf") {
      header("location:editPengajuanDospemUserDuaSatu.php?id=$id&message=notifGagalUpload");}
   else {
   $namafppd = "file_proposal_pengajuan_dospem/";
   $temp_prop = explode(".", $_FILES["file_prop"]["name"]);
   $nama_file_prop = $nama . '-'. $nim . '-' . $id_periode . '_proposal-dospem_'. $date . '.' . end($temp_prop);
   $file_prop = $namafppd . $nama_file_prop;
   move_uploaded_file($_FILES['file_prop']['tmp_name'], $namafppd . '/' . $nama_file_prop);

   $res = mysqli_query($con, "SELECT file_prop FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_prop'])>3)
     {
   if (file_exists($d['file_prop'])) unlink($d['file_prop']);
   if ($dt['cekberkas1'] == 4) {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_prop='$file_prop',cekberkas1='1',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_prop='$file_prop',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   }}}
?>