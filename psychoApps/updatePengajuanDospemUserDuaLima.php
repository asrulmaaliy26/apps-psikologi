<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_ukt = mysqli_real_escape_string($con, $_POST['file_ukt']);
$j_fppd = $_FILES['file_ukt']['type'];

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

   if($file_ukt == $dt['file_ukt']) {
   header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {   
   if ($j_fppd != "application/pdf") {
      header("location:editPengajuanDospemUserDuaLima.php?id=$id&message=notifGagalUpload");}
   else {
   $namafppd = "file_bukti_pembayaran_ukt/";
   $temp_ukt = explode(".", $_FILES["file_ukt"]["name"]);
   $nama_file_ukt = $nama . '-'. $nim . '-' . $id_periode . '_bukti-ukt-dospem_'. $date . '.' . end($temp_ukt);
   $file_ukt = $namafppd . $nama_file_ukt;
   move_uploaded_file($_FILES['file_ukt']['tmp_name'], $namafppd . '/' . $nama_file_ukt);

   $res = mysqli_query($con, "SELECT file_ukt FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_ukt'])>3)
     {
   if (file_exists($d['file_ukt'])) unlink($d['file_ukt']);
   if ($dt['cekberkas5'] == 4) {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_ukt='$file_ukt',cekberkas5='1',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_ukt='$file_ukt',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   }}}
?>