<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_prop = mysqli_real_escape_string($con, $_POST['file_prop']);
$file_transkrip = mysqli_real_escape_string($con, $_POST['file_transkrip']);
$file_toefl_toafl = mysqli_real_escape_string($con, $_POST['file_toefl_toafl']);
$file_tashih = mysqli_real_escape_string($con, $_POST['file_tashih']);
$file_ukt = mysqli_real_escape_string($con, $_POST['file_ukt']);
$cekberkas = mysqli_real_escape_string($con, $_POST['cekberkas']);
$j_fppd = $_FILES['file_prop']['type'];
$j_ftpd = $_FILES['file_transkrip']['type'];
$j_fttpd = $_FILES['file_toefl_toafl']['type'];
$j_ftspd = $_FILES['file_tashih']['type'];
$j_ftupd = $_FILES['file_ukt']['type'];

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

if ($j_fppd == "application/pdf") {
$namafppd = "file_proposal_pengajuan_dospem/";
$temp_prop = explode(".", $_FILES["file_prop"]["name"]);
$nama_file_prop = $nama . '-'. $nim . '-' . $id_periode . '_proposal-dospem_'. $date . '.' . end($temp_prop);
$file_prop = $namafppd . $nama_file_prop;
move_uploaded_file($_FILES['file_prop']['tmp_name'], $namafppd . '/' . $nama_file_prop);
$res1 = mysqli_query($con, "SELECT file_prop FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
$d1=mysqli_fetch_assoc($res1);
if (strlen($d1['file_prop'])>3)
{
   if (file_exists($d1['file_prop'])) unlink($d1['file_prop']);}
   mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_prop='$file_prop',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
   header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
   else {
      if(mysqli_real_escape_string($con, $_POST['file_prop'])==$d1['file_prop']) {
      header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
      else {
      header("location:editPengajuanDospemUserDua.php?id=$id&message=notifGagalUpload");}}

if ($j_ftpd == "application/pdf") {
$namaftpd = "file_transkrip_pengajuan_dospem/";
$temp_transkrip = explode(".", $_FILES["file_transkrip"]["name"]);
$nama_file_transkrip = $nama . '-'. $nim . '-' . $id_periode . '_transkrip-dospem_'. $date . '.' . end($temp_transkrip);
$file_transkrip = $namaftpd . $nama_file_transkrip;
move_uploaded_file($_FILES['file_transkrip']['tmp_name'], $namaftpd . '/' . $nama_file_transkrip);
  
$res2 = mysqli_query($con, "SELECT file_transkrip FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
$d2=mysqli_fetch_assoc($res2);
if (strlen($d2['file_transkrip'])>3)
{
   if (file_exists($d2['file_transkrip'])) unlink($d2['file_transkrip']);}
   mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_transkrip='$file_transkrip',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
   header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
   else {
      if(mysqli_real_escape_string($con, $_POST['file_transkrip'])==$d2['file_transkrip']) {
      header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
      else {
      header("location:editPengajuanDospemUserDua.php?id=$id&message=notifGagalUpload");}}

if ($j_fttpd == "application/pdf") {
$namafttpd = "file_toefl_toafl_pengajuan_dospem/";
$temp_toefl_toafl = explode(".", $_FILES["file_toefl_toafl"]["name"]);
$nama_file_toefl_toafl = $nama . '-'. $nim . '-' . $id_periode3 . '_toefl_toafl-dospem_'. $date . '.' . end($temp_toefl_toafl);
$file_toefl_toafl = $namafttpd . $nama_file_toefl_toafl;
move_uploaded_file($_FILES['file_toefl_toafl']['tmp_name'], $namafttpd . '/' . $nama_file_toefl_toafl);
  
$res3 = mysqli_query($con, "SELECT file_toefl_toafl FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
$d3=mysqli_fetch_assoc($res3);
if (strlen($d3['file_toefl_toafl'])>3)
{
   if (file_exists($d3['file_toefl_toafl'])) unlink($d3['file_toefl_toafl']);}
   mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_toefl_toafl='$file_toefl_toafl',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
   header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
   else {
      if(mysqli_real_escape_string($con, $_POST['file_toefl_toafl'])==$d3['file_toefl_toafl']) {
      header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
      else {
      header("location:editPengajuanDospemUserDua.php?id=$id&message=notifGagalUpload");}}

if ($j_ftspd == "application/pdf") {
$namaftspd = "file_tashih_pengajuan_dospem/";
$temp_tashih = explode(".", $_FILES["file_tashih"]["name"]);
$nama_file_tashih = $nama . '-'. $nim . '-' . $id_periode . '_tashih-dospem_'. $date . '.' . end($temp_tashih);
$file_tashih = $namaftspd . $nama_file_tashih;
move_uploaded_file($_FILES['file_tashih']['tmp_name'], $namaftspd . '/' . $nama_file_tashih);
  
$res4 = mysqli_query($con, "SELECT file_tashih FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
$d4=mysqli_fetch_assoc($res4);
if (strlen($d4['file_tashih'])>3)
{
   if (file_exists($d4['file_tashih'])) unlink($d4['file_tashih']);}
   mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_tashih='$file_tashih',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
   header("location:riwayatPengajuanDospemUser.php?message=notifEdit");} 
   else {
      if(mysqli_real_escape_string($con, $_POST['file_tashih'])==$d4['file_tashih']) {
      header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
      else {
      header("location:editPengajuanDospemUserDua.php?id=$id&message=notifGagalUpload");}}

if ($j_ftupd == "application/pdf") {
$namaftupd = "file_bukti_pembayaran_ukt/";
$temp_ukt = explode(".", $_FILES["file_ukt"]["name"]);
$nama_file_ukt = $nama . '-'. $nim . '-' . $id_periode . '_bukti-ukt_'. $date . '.' . end($temp_ukt);
$file_ukt = $namaftupd . $nama_file_ukt;
move_uploaded_file($_FILES['file_ukt']['tmp_name'], $namaftupd . '/' . $nama_file_ukt);
  
$res5 = mysqli_query($con, "SELECT file_ukt FROM pengelompokan_dospem_skripsi WHERE id='$id' LIMIT 1");
$d5=mysqli_fetch_assoc($res5);
if (strlen($d5['file_ukt'])>3)
{
   if (file_exists($d5['file_ukt'])) unlink($d5['file_ukt']);}
   mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET file_ukt='$file_ukt',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1");
   header("location:riwayatPengajuanDospemUser.php?message=notifEdit");} 
   else {
      if(mysqli_real_escape_string($con, $_POST['file_ukt'])==$d5['file_ukt']) {
   header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
      else {
      header("location:editPengajuanDospemUserDua.php?id=$id&message=notifGagalUpload");}}
?>