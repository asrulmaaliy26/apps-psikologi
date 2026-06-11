<?php
include("contentsConAdm.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$id = mysqli_real_escape_string($con, $_POST['id'] ?? '');

if (empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid.']);
    exit();
}

if (mysqli_query($con, "DELETE FROM pengelompokan_dospem_skripsi WHERE id='$id'")) {
    echo json_encode(['status' => 'success', 'message' => 'Data bimbingan berhasil dihapus dari sistem Skripsi.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data: ' . mysqli_error($con)]);
}
?>
