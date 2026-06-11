<?php
include("contentsConAdm.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$nim = mysqli_real_escape_string($con, $_POST['nim'] ?? '');
$id_bimtek = mysqli_real_escape_string($con, $_POST['id_bimtek'] ?? '');
$saran1 = mysqli_real_escape_string($con, $_POST['saran1'] ?? '');
$saran2 = mysqli_real_escape_string($con, $_POST['saran2'] ?? '');

if (!empty($saran1) && !empty($saran2) && $saran1 == $saran2) {
    echo json_encode(['status' => 'error', 'message' => 'Dosen Pembimbing 1 dan Dosen Pembimbing 2 tidak boleh sama.']);
    exit();
}

$sql = "UPDATE bimtek_pra_proposal SET 
        pembimbing_saran_1 = '$saran1', 
        pembimbing_saran_2 = '$saran2' 
        WHERE nim='$nim' AND id_bimtek='$id_bimtek'";

if (mysqli_query($con, $sql)) {
    echo json_encode(['status' => 'success', 'message' => 'Saran pembimbing berhasil diperbarui.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data: ' . mysqli_error($con)]);
}
