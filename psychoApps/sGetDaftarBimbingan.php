<?php
include("contentsConAdm.php");
header('Content-Type: application/json');

$nip = mysqli_real_escape_string($con, $_GET['nip'] ?? '');

$q_active_per = mysqli_query($con, "SELECT id FROM pengajuan_dospem WHERE status='1' ORDER BY id DESC LIMIT 1");
$d_per_active = mysqli_fetch_assoc($q_active_per);
if (!$d_per_active) {
    echo json_encode(['status' => 'error', 'message' => 'Tidak ada periode aktif.']);
    exit();
}
$active_period_id = $d_per_active['id'];

$q = mysqli_query($con, "SELECT p.id, p.nim, m.nama, p.catatan, o.nm as peminatan
                         FROM pengelompokan_dospem_skripsi p 
                         LEFT JOIN dt_mhssw m ON p.nim = m.nim 
                         LEFT JOIN opsi_bidang_skripsi o ON p.bidang_skripsi = o.id
                         WHERE (p.dospem_skripsi1='$nip' OR p.dospem_skripsi2='$nip') 
                         AND p.id_periode='$active_period_id' 
                         AND p.status IN ('2','3')");

$data = [];
while ($r = mysqli_fetch_assoc($q)) {
    $data[] = $r;
}

echo json_encode(['status' => 'success', 'data' => $data]);
?>
