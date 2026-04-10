<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $nim = mysqli_real_escape_string($con, $_POST['nim']);
  $id_periode = mysqli_real_escape_string($con, $_POST['id_periode']);
  $digit_ipk1 = mysqli_real_escape_string($con, $_POST['digit_ipk1']);
  $digit_ipk2 = mysqli_real_escape_string($con, $_POST['digit_ipk2']);
  $ipk = $digit_ipk1.','.$digit_ipk2;
  $sks_ditempuh = mysqli_real_escape_string($con, $_POST['sks_ditempuh']);
  $judul_skripsi = mysqli_real_escape_string($con, $_POST['judul_skripsi']);
  $jenis_skripsi = mysqli_real_escape_string($con, $_POST['jenis_skripsi']);
  $bidang_skripsi = mysqli_real_escape_string($con, $_POST['bidang_skripsi']);
  $metode_riset = mysqli_real_escape_string($con, $_POST['metode_riset']);
  $var_1 = mysqli_real_escape_string($con, $_POST['var_1']);
  $var_2 = mysqli_real_escape_string($con, $_POST['var_2']);
  $var_3 = mysqli_real_escape_string($con, $_POST['var_3']);
  $dospem_skripsi1 = mysqli_real_escape_string($con, $_POST['dospem_skripsi1']);
  $dospem_skripsi2 = mysqli_real_escape_string($con, $_POST['dospem_skripsi2']);
  $tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $split = explode('-', $tgl_pengajuan);
  $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);

  $query1 = "SELECT dospem_skripsi1 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $has1 = mysqli_query($con,  $query1) or die(mysqli_error($con));
  $dt1 = mysqli_fetch_array($has1);
  $dospem1 = $dt1['dospem_skripsi1'];
  
  $query2 = "SELECT dospem_skripsi2 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $has2 = mysqli_query($con,  $query2) or die(mysqli_error($con));
  $dt2 = mysqli_fetch_array($has2);
  $dospem2 = $dt2['dospem_skripsi2'];

  $qry1 = "SELECT COUNT(dospem_skripsi1) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dospem_skripsi1' AND id_periode='$id_periode' AND status='1'";
  $res1 = mysqli_query($con, $qry1) or die(mysqli_error($con));
  $data1 = mysqli_fetch_assoc($res1) or die(mysqli_error($con));

  $qry2 = "SELECT COUNT(dospem_skripsi2) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dospem_skripsi2' AND id_periode='$id_periode' AND status='1'";
  $res2 = mysqli_query($con, $qry2) or die(mysqli_error($con));
  $data2 = mysqli_fetch_assoc($res2) or die(mysqli_error($con));

  if ($_POST['dospem_skripsi1'] == $_POST['dospem_skripsi2'])
{
    header("location:formPengajuanPt.php?message=notifGagalSama");
}
else if ($data1['jumData'] < $d1['kuota1'] && $data2['jumData'] < $d2['kuota2'])
{
    mysqli_query($con, "INSERT INTO mag_pengelompokan_dospem_tesis(nim,judul_tesis,outline_tesis,dospem_tesis1,dospem_tesis2,nip_dospem_tesis1,nip_dospem_tesis2,tgl_pengajuan,thn_pengajuan,id_periode,cek1,cek2,cekjudul,status)" . "VALUES('$nim','$judul_tesis','$outline_tesis','$dospem_tesis1','$dospem_tesis2','$nip1','$nip2','$tgl_pengajuan','$thn_pengajuan','$id_periode','$cek1','$cek2','$cekjudul','$status')") or die(mysqli_error($con));
    header("location:formPengajuanPt.php?message=notifInput");
}
else
{
    header("location:formPengajuanPt.php?message=notifGagal");
}
$query1 = "SELECT dospem_skripsi1 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
$has1 = mysqli_query($con,  $query1) or die(mysqli_error($con));
$dt1 = mysqli_fetch_assoc($has1);
$dospem1 = $dt1['dospem_skripsi1'];
  
$query2 = "SELECT dospem_skripsi2 FROM pengelompokan_dospem_skripsi WHERE id='$id'";
$has2 = mysqli_query($con,  $query2) or die(mysqli_error($con));
$dt2 = mysqli_fetch_assoc($has2);
$dospem2 = $dt2['dospem_skripsi2'];

$qry1 = "SELECT COUNT(dospem_skripsi1) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$_POST[dospem_skripsi1]' AND id_periode='$_POST[id_periode]' AND status='1'";
$res1 = mysqli_query($con, $qry1) or die(mysqli_error($con));
$data1 = mysqli_fetch_assoc($res1) or die(mysqli_error($con));

$qry2 = "SELECT COUNT(dospem_skripsi2) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$_POST[dospem_skripsi2]' AND id_periode='$_POST[id_periode]' AND status='1'";
$res2 = mysqli_query($con, $qry2) or die(mysqli_error($con));
$data2 = mysqli_fetch_assoc($res2) or die(mysqli_error($con));

$q1 = "SELECT kuota1 FROM dospem_skripsi WHERE nip='$_POST[dospem_skripsi1]' AND id_periode='$_POST[id_periode]'";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));
$d1 = mysqli_fetch_assoc($r1) or die(mysqli_error($con));

$q2 = "SELECT kuota2 FROM dospem_skripsi WHERE nip='$_POST[dospem_skripsi2]' AND id_periode='$_POST[id_periode]'";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));
$d2 = mysqli_fetch_assoc($r2) or die(mysqli_error($con));

if($data1['jumData'] >= $d1['kuota1']) {
header("location:formPengDospem.php?message=notifGagalDospem");}
else if($_POST['dospem_skripsi1'] == $_POST['dospem_skripsi2']) {
header("location:formPengDospem.php?message=notifGagalSama");}
else { if($data1['jumData'] < $d1['kuota1'] || $_POST['dospem_skripsi1'] != $_POST['dospem_skripsi2']) {
$myqry1="UPDATE pengelompokan_dospem_skripsi SET ipk='$ipk',digit_ipk1='$digit_ipk1',digit_ipk2='$digit_ipk2',sks_ditempuh='$sks_ditempuh',judul_skripsi='$judul_skripsi',jenis_skripsi='$jenis_skripsi',bidang_skripsi='$bidang_skripsi',metode_riset='$metode_riset',dospem_skripsi1='$dospem_skripsi1',var_1='$var_1',var_2='$var_2',var_3='$var_3',var_4='$var_4',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
mysqli_query($con, $myqry1) or die(mysqli_error($con));
header("location:formPengDospem.php?message=notifEdit");}}

if($data2['jumData'] >= $d2['kuota2']) {
header("location:formPengDospem.php?message=notifGagalDospem");}
else if($_POST['dospem_skripsi2'] == $_POST['dospem_skripsi1']) {
header("location:formPengDospem.php?message=notifGagalSama");}
else { if($data2['jumData'] < $d2['kuota1'] || $_POST['dospem_skripsi2'] != $_POST['dospem_skripsi1']) {
$myqry4="UPDATE pengelompokan_dospem_skripsi SET ipk='$ipk',digit_ipk1='$digit_ipk1',digit_ipk2='$digit_ipk2',sks_ditempuh='$sks_ditempuh',judul_skripsi='$judul_skripsi',jenis_skripsi='$jenis_skripsi',bidang_skripsi='$bidang_skripsi',metode_riset='$metode_riset',dospem_skripsi2='$dospem_skripsi2',var_1='$var_1',var_2='$var_2',var_3='$var_3',var_4='$var_4',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
mysqli_query($con, $myqry4) or die(mysqli_error($con));
header("location:formPengDospem.php?message=notifEdit");}}
   ?>