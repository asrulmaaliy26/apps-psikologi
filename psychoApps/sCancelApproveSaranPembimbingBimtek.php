<?php
include("contentsConAdm.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$nim = mysqli_real_escape_string($con, $_POST['nim']);

// Cari periode yang aktif untuk menentukan record mana yang dihapus
$q_per = mysqli_query($con, "SELECT id FROM pengajuan_dospem WHERE status='1' ORDER BY id DESC LIMIT 1");
$d_per = mysqli_fetch_assoc($q_per);

if (!$d_per) {
    echo json_encode(['status' => 'error', 'message' => 'Tidak ada periode aktif.']);
    exit();
}

$id_periode = $d_per['id'];

// Hapus dari pengelompokan_dospem_skripsi hanya jika status masih 2 (Approved) atau 1 (Pending)
// Jika status sudah 3 (Selesai), jangan izinkan hapus dari sini karena data sudah diproses lebih lanjut
$sql = "DELETE FROM pengelompokan_dospem_skripsi WHERE nim='$nim' AND id_periode='$id_periode' AND status='2'";

if (mysqli_query($con, $sql)) {
    if (mysqli_affected_rows($con) > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Persetujuan berhasil dibatalkan. Mahasiswa sekarang dapat dikelola kembali.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal membatalkan. Data mungkin sudah diproses lebih lanjut atau tidak ditemukan pada periode aktif ini.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . mysqli_error($con)]);
}
?>
