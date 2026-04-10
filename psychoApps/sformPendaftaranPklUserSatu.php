<?php
include("contentsConAdm.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   header("location:prePendaftaranPklUser.php");
   exit;
}

$id_pkl = mysqli_real_escape_string($con, $_POST['id_pkl']);
$jenis_pkl = mysqli_real_escape_string($con, $_POST['jenis_pkl']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$angkatan = mysqli_real_escape_string($con, $_POST['angkatan']);
$tempat_lahir = mysqli_real_escape_string($con, $_POST['tempat_lahir']);
$tanggal_lahir = mysqli_real_escape_string($con, $_POST['tanggal_lahir']);
$jenis_kelamin = mysqli_real_escape_string($con, $_POST['jenis_kelamin']);
$alamat_ktp = mysqli_real_escape_string($con, $_POST['alamat_ktp']);
$alamat_malang = mysqli_real_escape_string($con, $_POST['alamat_malang']);
$kntk = mysqli_real_escape_string($con, $_POST['kntk']);
$dosen_wali = mysqli_real_escape_string($con, $_POST['dosen_wali']);
$sks_lalu = intval($_POST['sks_lalu'] ?? 0);
$sks_smt_berjalan = intval($_POST['sks_smt_berjalan'] ?? 0);
$sks_diambil = $sks_lalu + $sks_smt_berjalan;
$riwayat_penyakit = mysqli_real_escape_string($con, $_POST['riwayat_penyakit']);
$kontak_lain = mysqli_real_escape_string($con, $_POST['kontak_lain']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan = mysqli_real_escape_string($con, $split['2'] ?? date('Y'));
$val_adm = mysqli_real_escape_string($con, $_POST['val_adm']);
$statusform = mysqli_real_escape_string($con, $_POST['statusform']);

// Cek Duplikasi
$cek = mysqli_query($con, "SELECT id FROM peserta_pkl WHERE nim='$nim' AND id_pkl='$id_pkl' LIMIT 1");
if (mysqli_num_rows($cek) > 0) {
   header("location:prePendaftaranPklUser.php?nim=$nim&message=notifInput");
   exit;
}

mysqli_begin_transaction($con);
try {
   $q1 = "INSERT INTO peserta_pkl(id_pkl,nim,angkatan,riwayat_penyakit,sks_diambil,jenis_pkl,kontak_lain,tgl_pengajuan,thn_pengajuan,val_adm,statusform)
           VALUES('$id_pkl','$nim','$angkatan','$riwayat_penyakit','$sks_diambil','$jenis_pkl','$kontak_lain','$tgl_pengajuan','$thn_pengajuan','$val_adm','$statusform')";
   if (!mysqli_query($con, $q1)) throw new Exception(mysqli_error($con));

   $id = mysqli_insert_id($con);
   $genId = str_pad($id, 4, '0', STR_PAD_LEFT);
   $id_reg = 'PKL.' . $thn_pengajuan . '.' . $genId;

   $q2 = "UPDATE peserta_pkl SET id_reg='$id_reg' WHERE id='$id' LIMIT 1";
   if (!mysqli_query($con, $q2)) throw new Exception(mysqli_error($con));

   $sql = "UPDATE dt_mhssw SET tempat_lahir='$tempat_lahir',tanggal_lahir='$tanggal_lahir',jenis_kelamin='$jenis_kelamin',alamat_ktp='$alamat_ktp',alamat_malang='$alamat_malang',kntk='$kntk',dosen_wali='$dosen_wali' WHERE nim='$nim' LIMIT 1";
   if (!mysqli_query($con, $sql)) throw new Exception(mysqli_error($con));

   mysqli_commit($con);
   header("location:prePendaftaranPklUser.php?nim=$nim&id=$id&message=notifInput");
} catch (Exception $e) {
   mysqli_rollback($con);
   die($e->getMessage());
}
