<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_toefl_toafl = mysqli_real_escape_string($con, $_POST['file_toefl_toafl']);
$j_fppd = $_FILES['file_toefl_toafl']['type'];

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

   if($file_toefl_toafl == $dt['file_toefl_toafl']) {
   header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {   
   if ($j_fppd != "application/pdf") {
      header("location:editPengajuanDospemUserDuaTiga.php?id=$id&message=notifGagalUpload");}
   else {
   $namafppd = "file_toefl_toafl_pengajuan_dospem/";
   $temp_toefl_toafl = explode(".", $_FILES["file_toefl_toafl"]["name"]);
   $nama_file_toefl_toafl = $nama . '-'. $nim . '-' . $id_periode . '_toefl-toafl-dospem_'. $date . '.' . end($temp_toefl_toafl);
   $file_toefl_toafl = $namafppd . $nama_file_toefl_toafl;
   move_uploaded_file($_FILES['file_toefl_toafl']['tmp_name'], $namafppd . '/' . $nama_file_toefl_toafl);

   $res = mysqli_query($con, "SELECT file_toefl_toafl FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_toefl_toafl'])>3)
     {
   if (file_exists($d['file_toefl_toafl'])) unlink($d['file_toefl_toafl']);
   if ($dt['cekberkas3'] == 4) {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_toefl_toafl='$file_toefl_toafl',cekberkas3='1',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_toefl_toafl='$file_toefl_toafl',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   }}}
?>