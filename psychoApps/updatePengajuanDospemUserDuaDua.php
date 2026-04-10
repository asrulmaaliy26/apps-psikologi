<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_transkrip = mysqli_real_escape_string($con, $_POST['file_transkrip']);
$j_fppd = $_FILES['file_transkrip']['type'];

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

   if($file_transkrip == $dt['file_transkrip']) {
   header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {   
   if ($j_fppd != "application/pdf") {
      header("location:editPengajuanDospemUserDuaDua.php?id=$id&message=notifGagalUpload");}
   else {
   $namafppd = "file_transkrip_pengajuan_dospem/";
   $temp_transkrip = explode(".", $_FILES["file_transkrip"]["name"]);
   $nama_file_transkrip = $nama . '-'. $nim . '-' . $id_periode . '_transkrip-dospem_'. $date . '.' . end($temp_transkrip);
   $file_transkrip = $namafppd . $nama_file_transkrip;
   move_uploaded_file($_FILES['file_transkrip']['tmp_name'], $namafppd . '/' . $nama_file_transkrip);

   $res = mysqli_query($con, "SELECT file_transkrip FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_transkrip'])>3)
     {
   if (file_exists($d['file_transkrip'])) unlink($d['file_transkrip']);
   if ($dt['cekberkas2'] == 4) {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_transkrip='$file_transkrip',cekberkas2='1',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   else {
      mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_transkrip='$file_transkrip',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
      header("location:riwayatPengajuanDospemUser.php?id=$id&message=notifEdit");}
   }}}
?>