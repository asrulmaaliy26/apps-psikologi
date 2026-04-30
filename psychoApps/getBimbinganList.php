<?php
include("contentsConAdm.php");

$nip = mysqli_real_escape_string($con, $_GET['nip']);
$id_per = mysqli_real_escape_string($con, $_GET['id_per']);

$sql = "SELECT p.nim, m.nama, p.judul_skripsi, p.status, p.dospem_skripsi1, p.dospem_skripsi2
        FROM pengelompokan_dospem_skripsi p
        INNER JOIN dt_mhssw m ON p.nim = m.nim
        WHERE (p.dospem_skripsi1 = '$nip' OR p.dospem_skripsi2 = '$nip')
        AND p.id_periode = '$id_per'
        AND p.status IN ('2', '3')
        ORDER BY m.nama ASC";

$res = mysqli_query($con, $sql);
$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $role = ($row['dospem_skripsi1'] == $nip) ? 'Pembimbing I' : 'Pembimbing II';
    $status_text = ($row['status'] == '3') ? '<span class="badge badge-success">Selesai</span>' : '<span class="badge badge-primary">Proses</span>';
    
    $data[] = [
        'nim' => $row['nim'],
        'nama' => $row['nama'],
        'judul' => $row['judul_skripsi'],
        'role' => $role,
        'status' => $status_text
    ];
}

header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'data' => $data]);
?>
