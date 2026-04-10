<?php
include ("koneksiUser.php");
$nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
$judul_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_tesis']);
$outline_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['outline_tesis']);
$dospem_tesis1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem_tesis1']);
$dospem_tesis2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem_tesis2']);
$tgl_pengajuan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
$thn_pengajuan = date('Y');
$id_periode = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
$cek1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek1']);
$cek2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek2']);
$cekjudul = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cekjudul']);
$status = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['status']);

$qNip1 = "SELECT nip FROM mag_dospem_tesis WHERE id='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]'";
$rNip1 = mysqli_query($GLOBALS["___mysqli_ston"], $qNip1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$dNip1 = mysqli_fetch_assoc($rNip1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$qNip2 = "SELECT nip FROM mag_dospem_tesis WHERE id='$_POST[dospem_tesis2]' AND id_periode='$_POST[id_periode]'";
$rNip2 = mysqli_query($GLOBALS["___mysqli_ston"], $qNip2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$dNip2 = mysqli_fetch_assoc($rNip2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$nip1 = $dNip1['nip'];
$nip2 = $dNip2['nip'];

$qry1 = "SELECT COUNT(dospem_tesis1) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]' AND status='1'";
$res1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$data1 = mysqli_fetch_assoc($res1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$qry2 = "SELECT COUNT(dospem_tesis2) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$_POST[dospem_tesis2]' AND id_periode='$_POST[id_periode]' AND status='1'";
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$data2 = mysqli_fetch_assoc($res2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$q1 = "SELECT kuota1 FROM mag_dospem_tesis WHERE id='$_POST[dospem_tesis1]' AND id_periode='$_POST[id_periode]'";
$r1 = mysqli_query($GLOBALS["___mysqli_ston"], $q1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$d1 = mysqli_fetch_assoc($r1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$q2 = "SELECT kuota2 FROM mag_dospem_tesis WHERE id='$_POST[dospem_tesis2]' AND id_periode='$_POST[id_periode]'";
$r2 = mysqli_query($GLOBALS["___mysqli_ston"], $q2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$d2 = mysqli_fetch_assoc($r2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

if ($_POST['dospem_tesis1'] == $_POST['dospem_tesis2'])
{
    header("location:formPengajuanPt.php?message=notifGagalSama");
}
else if ($data1['jumData'] < $d1['kuota1'] && $data2['jumData'] < $d2['kuota2'])
{
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_pengelompokan_dospem_tesis(nim,judul_tesis,outline_tesis,dospem_tesis1,dospem_tesis2,nip_dospem_tesis1,nip_dospem_tesis2,tgl_pengajuan,thn_pengajuan,id_periode,cek1,cek2,cekjudul,status)" . "VALUES('$nim','$judul_tesis','$outline_tesis','$dospem_tesis1','$dospem_tesis2','$nip1','$nip2','$tgl_pengajuan','$thn_pengajuan','$id_periode','$cek1','$cek2','$cekjudul','$status')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    header("location:formPengajuanPt.php?message=notifInput");
}
else
{
    header("location:formPengajuanPt.php?message=notifGagal");
}
?>
