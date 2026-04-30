<?php
include("contentsConAdm.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
    exit();
}

$nim = isset($_POST['nim']) ? mysqli_real_escape_string($con, $_POST['nim']) : '';
$id_bimtek = isset($_POST['id_bimtek']) ? mysqli_real_escape_string($con, $_POST['id_bimtek']) : '';

if (!$nim || !$id_bimtek) {
    echo json_encode(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);
    exit();
}

// 1. Ambil nama file untuk dihapus secara fisik jika perlu
$q_file = mysqli_query($con, "SELECT file_outline, file_absensi_1, file_absensi_2, file_absensi_3 FROM bimtek_peserta WHERE nim='$nim' AND id_bimtek='$id_bimtek'");
$d_file = mysqli_fetch_assoc($q_file);

if ($d_file) {
    // Hapus pendaftar
    $sql = "DELETE FROM bimtek_peserta WHERE nim='$nim' AND id_bimtek='$id_bimtek'";
    if (mysqli_query($con, $sql)) {
        // Hapus juga dari bimtek_pra_proposal jika ada (opsional, tergantung kebijakan)
        // mysqli_query($con, "DELETE FROM bimtek_pra_proposal WHERE nim='$nim' AND id_bimtek='$id_bimtek'");
        
        // Hapus file fisik (opsional)
        /*
        if ($d_file['file_outline'] && file_exists("file_outline_bimtek/".$d_file['file_outline'])) unlink("file_outline_bimtek/".$d_file['file_outline']);
        for($i=1; $i<=3; $i++) {
            $f = $d_file['file_absensi_'.$i];
            if ($f && file_exists("file_absensi_bimtek/".$f)) unlink("file_absensi_bimtek/".$f);
        }
        */
        
        echo json_encode(['status' => 'success', 'message' => 'Pendaftar berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus pendaftar: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
}
?>
