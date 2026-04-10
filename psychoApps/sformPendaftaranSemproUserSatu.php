<?php
include("contentsConAdm.php");

// Pastikan request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   die("Akses ditolak.");
}

$id_sempro = mysqli_real_escape_string($con, $_POST['id_sempro']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$angkatan = mysqli_real_escape_string($con, $_POST['angkatan']);
$judul_prop = mysqli_real_escape_string($con, $_POST['judul_prop']);
$pembimbing1 = mysqli_real_escape_string($con, $_POST['pembimbing1']);
$pembimbing2 = mysqli_real_escape_string($con, $_POST['pembimbing2']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan = mysqli_real_escape_string($con, $split['2'] ?? date('Y'));
$val_adm = mysqli_real_escape_string($con, $_POST['val_adm']);
$statusform = mysqli_real_escape_string($con, $_POST['statusform']);

// 1. Cek Duplikasi (Server-side defense against double-click/race condition)
$cek = mysqli_query($con, "SELECT id FROM peserta_sempro WHERE nim='$nim' AND id_sempro='$id_sempro' LIMIT 1");
if (mysqli_num_rows($cek) > 0) {
   // Jika sudah ada, langsung redirect ke halaman riwayat/pre-pendaftaran
   header("location:prePendaftaranSemproUser.php?nim=$nim&message=notifInput");
   exit;
}

// 2. Gunakan Transaksi untuk menjaga integritas data
mysqli_begin_transaction($con);

try {
   // Insert ke peserta_sempro
   $q1 = "INSERT INTO peserta_sempro(id_sempro,nim,angkatan,judul_prop,pembimbing1,pembimbing2,tgl_pengajuan,thn_pengajuan,val_adm,statusform)
           VALUES('$id_sempro','$nim','$angkatan','$judul_prop','$pembimbing1','$pembimbing2','$tgl_pengajuan','$thn_pengajuan','$val_adm','$statusform')";
   if (!mysqli_query($con, $q1)) throw new Exception(mysqli_error($con));

   // Ambil ID yang baru saja diinsert
   $id = mysqli_insert_id($con);
   if (!$id) throw new Exception("Gagal mendapatkan ID pendaftaran.");

   // Update id_reg
   $genId = str_pad($id, 4, '0', STR_PAD_LEFT);
   $id_reg = 'SEMPRO.' . $thn_pengajuan . '.' . $genId;
   $q2 = "UPDATE peserta_sempro SET id_reg='$id_reg' WHERE id='$id'";
   if (!mysqli_query($con, $q2)) throw new Exception(mysqli_error($con));

   // Insert ke jadwal_sempro
   $q3 = "INSERT INTO jadwal_sempro(id_sempro,id_pendaftaran,penguji1)
           VALUES('$id_sempro','$id','$pembimbing1')";
   if (!mysqli_query($con, $q3)) throw new Exception(mysqli_error($con));
   $idJdwl = mysqli_insert_id($con);

   // Update id_jdwl di peserta_sempro
   $q4 = "UPDATE peserta_sempro SET id_jdwl='$idJdwl' WHERE id='$id'";
   if (!mysqli_query($con, $q4)) throw new Exception(mysqli_error($con));

   // Insert ke nilai_sempro
   $q5 = "INSERT INTO nilai_sempro(id_sempro,nim,angkatan,id_pendaftaran,validasi)
           VALUES('$id_sempro','$nim','$angkatan','$id','1')";
   if (!mysqli_query($con, $q5)) throw new Exception(mysqli_error($con));

   // Commit transaksi
   mysqli_commit($con);

   header("location:prePendaftaranSemproUser.php?nim=$nim&id=$id&message=notifInput");
} catch (Exception $e) {
   // Rollback jika ada yang gagal
   mysqli_rollback($con);
   die("Terjadi kesalahan sistem: " . $e->getMessage());
}
