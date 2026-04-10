<?php
include("contentsConAdm.php");

// Pastikan request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   die("Akses ditolak.");
}

$id_ujskrip = mysqli_real_escape_string($con, $_POST['id_ujskrip']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$angkatan = mysqli_real_escape_string($con, $_POST['angkatan']);
$judul_skripsi = mysqli_real_escape_string($con, $_POST['judul_skripsi']);
$pembimbing1 = mysqli_real_escape_string($con, $_POST['pembimbing1']);
$pembimbing2 = mysqli_real_escape_string($con, $_POST['pembimbing2']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan = mysqli_real_escape_string($con, $split['2'] ?? date('Y'));
$val_adm = mysqli_real_escape_string($con, $_POST['val_adm']);
$statusform = mysqli_real_escape_string($con, $_POST['statusform']);

// 1. Cek Duplikasi
$cek = mysqli_query($con, "SELECT id FROM peserta_ujskrip WHERE nim='$nim' AND id_ujskrip='$id_ujskrip' LIMIT 1");
if (mysqli_num_rows($cek) > 0) {
   header("location:prePendaftaranUjianskripsiUser.php?nim=$nim&message=notifInput");
   exit;
}

// 2. Transaksi
mysqli_begin_transaction($con);

try {
   // Insert ke peserta_ujskrip
   $q1 = "INSERT INTO peserta_ujskrip(id_ujskrip,nim,angkatan,judul_skripsi,pembimbing1,pembimbing2,tgl_pengajuan,thn_pengajuan,val_adm,statusform)
           VALUES('$id_ujskrip','$nim','$angkatan','$judul_skripsi','$pembimbing1','$pembimbing2','$tgl_pengajuan','$thn_pengajuan','$val_adm','$statusform')";
   if (!mysqli_query($con, $q1)) throw new Exception(mysqli_error($con));

   $id = mysqli_insert_id($con);
   if (!$id) throw new Exception("Gagal mendapatkan ID pendaftaran.");

   // Update id_reg
   $genId = str_pad($id, 4, '0', STR_PAD_LEFT);
   $id_reg = 'UJSKRIP.' . $thn_pengajuan . '.' . $genId;
   $q2 = "UPDATE peserta_ujskrip SET id_reg='$id_reg' WHERE id='$id'";
   if (!mysqli_query($con, $q2)) throw new Exception(mysqli_error($con));

   // Insert ke jadwal_ujskrip
   $q3 = "INSERT INTO jadwal_ujskrip(id_ujskrip,id_pendaftaran,sekretaris_penguji)
           VALUES('$id_ujskrip','$id','$pembimbing1')";
   if (!mysqli_query($con, $q3)) throw new Exception(mysqli_error($con));
   $idJdwl = mysqli_insert_id($con);

   // Update id_jdwl
   $q4 = "UPDATE peserta_ujskrip SET id_jdwl='$idJdwl' WHERE id='$id'";
   if (!mysqli_query($con, $q4)) throw new Exception(mysqli_error($con));

   // Insert ke nilai_ujskrip
   $q5 = "INSERT INTO nilai_ujskrip(id_ujskrip,nim,angkatan,id_pendaftaran,validasi)
           VALUES('$id_ujskrip','$nim','$angkatan','$id','1')";
   if (!mysqli_query($con, $q5)) throw new Exception(mysqli_error($con));

   mysqli_commit($con);
   header("location:prePendaftaranUjianskripsiUser.php?nim=$nim&id=$id&message=notifInput");
} catch (Exception $e) {
   mysqli_rollback($con);
   die("Terjadi kesalahan sistem: " . $e->getMessage());
}
