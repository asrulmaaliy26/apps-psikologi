<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_tashih = mysqli_real_escape_string($con, $_POST['file_tashih']);
$j_fppd = $_FILES['file_tashih']['type'];

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

   if($file_tashih == $dt['file_tashih']) {
   header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {   
   if ($j_fppd != "application/pdf") {
      header("location:editPengajuanDospemUserDuaEmpat.php?id=$id&message=notifGagalUpload");}
   else {
   $namafppd = "file_tashih_pengajuan_dospem/";
   $temp_tashih = explode(".", $_FILES["file_tashih"]["name"]);
   $nama_file_tashih = $nama . '-'. $nim . '-' . $id_periode . '_tashih-dospem_'. $date . '.' . end($temp_tashih);
   $file_tashih = $namafppd . $nama_file_tashih;
   move_uploaded_file($_FILES['file_tashih']['tmp_name'], $namafppd . '/' . $nama_file_tashih);

   $res = mysqli_query($con, "SELECT file_tashih FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_tashih'])>3)
     {
   if (file_exists($d['file_tashih'])) unlink($d['file_tashih']);
   if ($dt['cekberkas4'] == 4) {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_tashih='$file_tashih',cekberkas4='1',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_tashih='$file_tashih',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   }}}
?>