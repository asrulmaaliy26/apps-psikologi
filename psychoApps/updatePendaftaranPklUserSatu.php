<?php
include("contentsConAdm.php");

$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$id_pkl = mysqli_real_escape_string($con, $_POST['id_pkl']);
$jenis_pkl = mysqli_real_escape_string($con, $_POST['jenis_pkl']);
$peminatan = mysqli_real_escape_string($con, $_POST['peminatan']);
$nama_instansi = mysqli_real_escape_string($con, $_POST['nama_instansi']);
$alamat_instansi = mysqli_real_escape_string($con, $_POST['alamat_instansi']);
$id_dpl = intval($_POST['id_dpl']);
$sks_diambil = mysqli_real_escape_string($con, $_POST['sks_diambil']);

$tgl_pengajuan = date("d-m-Y");
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan = mysqli_real_escape_string($con, $split['2']);
$val_adm = '2';
$statusform = '1';

// Get DPL Name
$dpl_name = '';
$q_dpl = mysqli_query($con, "SELECT nama FROM dt_pegawai WHERE id='$id_dpl' LIMIT 1");
if ($row_dpl = mysqli_fetch_assoc($q_dpl)) {
   $dpl_name = mysqli_real_escape_string($con, $row_dpl['nama']);
}

mysqli_begin_transaction($con);
try {
   $myqry1 = "UPDATE peserta_pkl SET jenis_pkl='$jenis_pkl', peminatan='$peminatan', nama_instansi='$nama_instansi', alamat_instansi='$alamat_instansi', sks_diambil='$sks_diambil', tgl_pengajuan='$tgl_pengajuan', thn_pengajuan='$thn_pengajuan', val_adm='$val_adm', statusform='$statusform', dpl='$dpl_name', id_dpl='$id_dpl' WHERE id='$id' LIMIT 1";
   if (!mysqli_query($con, $myqry1)) throw new Exception(mysqli_error($con));

   mysqli_commit($con);
   header("location:detailRiwayatPendaftaranPklUser.php?id=$id&message=notifEdit");
} catch (Exception $e) {
   mysqli_rollback($con);
   die($e->getMessage());
}
