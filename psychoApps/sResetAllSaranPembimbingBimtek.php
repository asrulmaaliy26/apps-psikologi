<?php
include("contentsConAdm.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$id_bimtek = mysqli_real_escape_string($con, $_POST['id_bimtek'] ?? '');

$q_active_per = mysqli_query($con, "SELECT id FROM pengajuan_dospem WHERE status='1' ORDER BY id DESC LIMIT 1");
$d_per_active = mysqli_fetch_assoc($q_active_per);

if (!$d_per_active) {
    echo json_encode(['status' => 'error', 'message' => 'Tidak ada periode dospem yang aktif.']);
    exit();
}

$id_periode = $d_per_active['id'];

// Hapus data persetujuan (yang bersumber dari Bimtek) pada periode ini
$where = "id_periode='$id_periode' AND catatan='Disetujui melalui Bimtek'";
if (!empty($id_bimtek)) {
    $where .= " AND nim IN (SELECT nim FROM bimtek_pra_proposal WHERE id_bimtek='$id_bimtek')";
}

if (mysqli_query($con, "DELETE FROM pengelompokan_dospem_skripsi WHERE $where")) {
    $affected = mysqli_affected_rows($con);
    echo json_encode(['status' => 'success', 'message' => "$affected data persetujuan berhasil dibatalkan dari sistem Skripsi."]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mereset data: ' . mysqli_error($con)]);
}
?>
