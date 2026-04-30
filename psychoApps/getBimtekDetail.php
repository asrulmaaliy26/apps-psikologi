<?php
include("contentsConAdm.php");
header('Content-Type: application/json');

if (!isset($_GET['nim']) || !isset($_GET['id_bimtek'])) {
    echo json_encode(['status' => 'error', 'message' => 'NIM atau ID Bimtek tidak ditemukan.']);
    exit();
}

$nim = mysqli_real_escape_string($con, $_GET['nim']);
$id_bimtek = mysqli_real_escape_string($con, $_GET['id_bimtek']);

// Ambil detail Bimtek
$q = mysqli_query($con, "SELECT pp.*, d.nama as reviewer_nama, d1.nama as saran1_nama, d2.nama as saran2_nama
        FROM bimtek_pra_proposal pp
        LEFT JOIN dt_pegawai d ON pp.id_reviewer = d.id
        LEFT JOIN dt_pegawai d1 ON pp.pembimbing_saran_1 = d1.id
        LEFT JOIN dt_pegawai d2 ON pp.pembimbing_saran_2 = d2.id
        WHERE pp.nim='$nim' AND pp.id_bimtek='$id_bimtek'");
$d = mysqli_fetch_assoc($q);

if (!$d) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
    exit();
}

// Pastikan nilai tidak null untuk tampilan
$fields = ['a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'nilai_akhir'];
foreach ($fields as $f) {
    if ($d[$f] === null) $d[$f] = '0';
}

// Ambil ID periode pengajuan dospem yang aktif untuk kuota
$q_per_active = mysqli_query($con, "SELECT id FROM pengajuan_dospem WHERE status='1' ORDER BY id DESC LIMIT 1");
$d_per_active = mysqli_fetch_assoc($q_per_active);
$id_periode_aktif = $d_per_active ? $d_per_active['id'] : '';

// Ambil daftar SELURUH dospem (Tenaga Pendidik) yang terdaftar di sistem beserta kuotanya
$advisors = [];
$q_adv = mysqli_query($con, "SELECT p.id as nip, p.nama, k.kuota1, k.kuota2 
        FROM dt_pegawai p
        LEFT JOIN dospem_skripsi k ON p.id = k.nip AND k.id_periode = '$id_periode_aktif'
        WHERE p.id != '' AND p.jenis_pegawai = '1' AND p.nama NOT LIKE '%Admin%' 
        ORDER BY p.nama ASC");
while($row = mysqli_fetch_assoc($q_adv)) {
    $nip = $row['nip'];
    // Hitung realisasi bimbingan saat ini
    $real = 0;
    if ($id_periode_aktif) {
        $q_count = mysqli_query($con, "SELECT COUNT(*) as total FROM pengelompokan_dospem_skripsi 
                                       WHERE (dospem_skripsi1 = '$nip' OR dospem_skripsi2 = '$nip') 
                                       AND id_periode = '$id_periode_aktif' AND status IN ('2','3')");
        $dr = mysqli_fetch_assoc($q_count);
        $real = (int)$dr['total'];
    }
    
    $row['kuota1'] = (int)$row['kuota1'];
    $row['kuota2'] = (int)$row['kuota2'];
    $row['real'] = $real;
    $advisors[] = $row;
}

echo json_encode([
    'status' => 'success',
    'data' => $d,
    'advisors' => $advisors,
    'id_periode' => $id_periode_aktif
]);
?>
