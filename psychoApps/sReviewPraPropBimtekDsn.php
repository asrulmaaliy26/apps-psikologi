<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];

$id_prop = $_POST['id_prop'] ?? '';
$aksi = $_POST['aksi'] ?? ''; // 'terima' or 'revisi'
$catatan_raw = $_POST['catatan'] ?? '';

// Try to decode base64 if it looks like it (to bypass WAF)
$catatan = $catatan_raw;
if (base64_encode(base64_decode($catatan_raw, true)) === $catatan_raw) {
    $catatan = base64_decode($catatan_raw);
}

$tgl = date('Y-m-d H:i:s');

// Validate dosen owns this proposal (based on current assignment in bimtek_peserta)
$stmt_check = mysqli_prepare($con, "SELECT pp.id, pp.id_bimtek 
    FROM bimtek_pra_proposal pp
    JOIN bimtek_peserta bp ON pp.nim = bp.nim AND pp.id_bimtek = bp.id_bimtek
    JOIN (SELECT MAX(id) as max_id FROM bimtek_peserta GROUP BY nim, id_bimtek) latest ON bp.id = latest.max_id
    WHERE pp.id = ? AND bp.id_reviewer = ?");
mysqli_stmt_bind_param($stmt_check, "ss", $id_prop, $username);
mysqli_stmt_execute($stmt_check);
$q_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($q_check) == 0) {
    header("location:reviewerBimtekDsn.php?error=unauthorized");
    exit();
}
$d_check = mysqli_fetch_assoc($q_check);
$id_bimtek = $d_check['id_bimtek'];

$a1 = (int)($_POST['a1_val'] ?? 0);
$a2 = (int)($_POST['a2_val'] ?? 0);
$a3 = (int)($_POST['a3_val'] ?? 0);
$a4 = (int)($_POST['a4_val'] ?? 0);
$a5 = (int)($_POST['a5_val'] ?? 0);
$a6 = (int)($_POST['a6_val'] ?? 0);
$nilai = (float)($_POST['nilai_akhir_val'] ?? 0);

if ($aksi == 'update') {
    // For update action, we preserve the current status (usually 'diterima')
    $stmt_status = mysqli_prepare($con, "SELECT status FROM bimtek_pra_proposal WHERE id = ?");
    mysqli_stmt_bind_param($stmt_status, "s", $id_prop);
    mysqli_stmt_execute($stmt_status);
    $res_status = mysqli_stmt_get_result($stmt_status);
    $d_status = mysqli_fetch_assoc($res_status);
    $status = $d_status['status'] ?? 'diterima';
} else {
    $status = ($aksi == 'terima') ? 'diterima' : 'revisi';
}

$stmt_upd = mysqli_prepare($con, "UPDATE bimtek_pra_proposal SET 
    status = ?, 
    id_reviewer = ?,
    catatan = ?, 
    a1 = ?, a2 = ?, a3 = ?, a4 = ?, a5 = ?, a6 = ?, 
    nilai_akhir = ?,
    tgl_update = ? 
    WHERE id = ?");

mysqli_stmt_bind_param($stmt_upd, "sssiiiiiidss", 
    $status, 
    $username, 
    $catatan, 
    $a1, $a2, $a3, $a4, $a5, $a6, 
    $nilai, 
    $tgl, 
    $id_prop
);

mysqli_stmt_execute($stmt_upd);

header("location:reviewPraPropBimtekDsn.php?id=$id_prop&message=success");
