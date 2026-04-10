<?php
include("contentsConAdm.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   header("location:prePendaftaranUjianKompreUser.php");
   exit;
}

$id_kompre = mysqli_real_escape_string($con, $_POST['id_kompre']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$angkatan = mysqli_real_escape_string($con, $_POST['angkatan']);
$sks_ditempuh = mysqli_real_escape_string($con, $_POST['sks_ditempuh']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$tgl = mysqli_real_escape_string($con, $split['0']);
$bln = mysqli_real_escape_string($con, $split['1']);
$thn = mysqli_real_escape_string($con, $split['2']);
$val_adm = mysqli_real_escape_string($con, $_POST['val_adm']);
$statusform = mysqli_real_escape_string($con, $_POST['statusform']);

// Cek Duplikasi
$cek = mysqli_query($con, "SELECT id FROM peserta_kompre WHERE nim='$nim' AND id_kompre='$id_kompre' LIMIT 1");
if (mysqli_num_rows($cek) > 0) {
   header("location:prePendaftaranUjianKompreUser.php?nim=$nim&message=notifInput");
   exit;
}

mysqli_begin_transaction($con);
try {
   $q1 = "INSERT INTO peserta_kompre(id_kompre,nim,angkatan,sks_ditempuh,tgl_pengajuan,tgl,bln,thn,val_adm,statusform)
           VALUES('$id_kompre','$nim','$angkatan','$sks_ditempuh','$tgl_pengajuan','$tgl','$bln','$thn','$val_adm','$statusform')";
   if (!mysqli_query($con, $q1)) throw new Exception(mysqli_error($con));

   $id = mysqli_insert_id($con);
   $genId = str_pad($id, 4, '0', STR_PAD_LEFT);
   $id_reg = 'KOMPRE.' . $thn . '.' . $genId;

   $q2 = "UPDATE peserta_kompre SET id_reg='$id_reg' WHERE id='$id' LIMIT 1";
   if (!mysqli_query($con, $q2)) throw new Exception(mysqli_error($con));

   mysqli_commit($con);
   header("location:prePendaftaranUjianKompreUser.php?nim=$nim&id=$id&message=notifInput");
} catch (Exception $e) {
   mysqli_rollback($con);
   die($e->getMessage());
}
