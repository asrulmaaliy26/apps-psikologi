<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("conAdm.php");

// Helper untuk generate 16 karakter token unik
function generateUniqueToken($con) {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $tokenLength = 13; // BMN + 13 chars = 16 chars
    
    while (true) {
        $randStr = "";
        for ($i = 0; $i < $tokenLength; $i++) {
            $randStr .= $chars[rand(0, strlen($chars) - 1)];
        }
        $token = "BMN" . $randStr;
        
        // Cek keunikan di DB
        $q_chk = mysqli_query($con, "SELECT id FROM bmn_peminjaman_ruangan WHERE booking_token = '$token'");
        if (mysqli_num_rows($q_chk) == 0) {
            return $token;
        }
    }
}

// Ambil data POST
$ruangan_id = isset($_POST['ruangan_id']) ? intval($_POST['ruangan_id']) : 0;
$nama_organisasi = mysqli_real_escape_string($con, $_POST['nama_organisasi']);
$unit = mysqli_real_escape_string($con, $_POST['unit']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$tanggal = mysqli_real_escape_string($con, $_POST['tanggal']);
$jam_mulai = mysqli_real_escape_string($con, $_POST['jam_mulai']) . ":00";
$jam_selesai = mysqli_real_escape_string($con, $_POST['jam_selesai']) . ":00";
$kegiatan = mysqli_real_escape_string($con, $_POST['kegiatan']);
$kapasitas = intval($_POST['kapasitas']);
$keterangan = mysqli_real_escape_string($con, $_POST['keterangan']);

if ($ruangan_id <= 0 || empty($nama_organisasi) || empty($unit) || empty($email) || empty($tanggal_mulai) || empty($tanggal_akhir) || empty($jam_mulai) || empty($jam_selesai) || empty($kegiatan) || $kapasitas <= 0) {
    header("location:peminjamanRuangUmum.php");
    exit();
}

if (strtotime($tanggal_akhir) < strtotime($tanggal_mulai)) {
    header("location:peminjamanRuangUmum.php");
    exit();
}

// Ambil kapasitas ruangan untuk proteksi server-side
$q_room = mysqli_query($con, "SELECT kapasitas FROM bmn_ruangan_booking WHERE id = $ruangan_id");
if ($room = mysqli_fetch_assoc($q_room)) {
    if ($kapasitas > $room['kapasitas']) {
        // Kapasitas terlampaui
        header("location:peminjamanRuangUmum.php");
        exit();
    }
} else {
    header("location:peminjamanRuangUmum.php");
    exit();
}

// Generate token
$booking_token = generateUniqueToken($con);

// Masukkan data ke DB
$query = "INSERT INTO bmn_peminjaman_ruangan (
            ruangan_id, nama_organisasi, unit, email, tanggal, tanggal_akhir, jam_mulai, jam_selesai, kegiatan, kapasitas, keterangan, status, booking_token
          ) VALUES (
            $ruangan_id, '$nama_organisasi', '$unit', '$email', '$tanggal_mulai', '$tanggal_akhir', '$jam_mulai', '$jam_selesai', '$kegiatan', $kapasitas, '$keterangan', 'pending', '$booking_token'
          )";

if (mysqli_query($con, $query)) {
    // Berhasil, arahkan ke detail peminjaman dengan token
    header("location:peminjamanRuangDetail.php?token=" . $booking_token . "&new=true");
} else {
    // Gagal
    header("location:peminjamanRuangUmum.php");
}
exit();
?>
