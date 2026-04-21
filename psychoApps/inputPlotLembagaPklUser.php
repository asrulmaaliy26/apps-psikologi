<?php
if(!isset($_SESSION)) { session_start(); }
require_once "conAdm.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_lembaga'])) {
    $nim = $_SESSION['username'];
    $id_lembaga = intval($_POST['id_lembaga']);
    
    // Validasi apakah sisa kuota masih ada (Atomic check trick or normal select inside transaction to prevent race)
    // Walau tidak ada strict transaction mechanism di MyISAM/simpel, minimal kita cek
    mysqli_autocommit($con, FALSE);
    
    $qCek = mysqli_query($con, "SELECT kuota FROM pkl_lembaga WHERE id_lembaga='$id_lembaga' FOR UPDATE");
    $dCek = mysqli_fetch_assoc($qCek);
    $kuota = $dCek['kuota'];
    
    $qHitung = mysqli_query($con, "SELECT count(id_plot) as c FROM pkl_plot_pendaftar WHERE id_lembaga='$id_lembaga'");
    $dHitung = mysqli_fetch_assoc($qHitung);
    $terisi = $dHitung['c'];
    
    if ($terisi < $kuota) {
        $qIns = mysqli_query($con, "INSERT INTO pkl_plot_pendaftar (nim, id_lembaga) VALUES ('$nim', '$id_lembaga')");
        if($qIns) {
            mysqli_commit($con);
            $_SESSION['msg'] = "Selamat, Anda berhasil mendapatkan slot lembaga ini!";
            $_SESSION['msg_type'] = "success";
        } else {
            mysqli_rollback($con);
            $_SESSION['msg'] = "Terjadi kesalahan sistem.";
            $_SESSION['msg_type'] = "danger";
        }
    } else {
        mysqli_rollback($con);
        $_SESSION['msg'] = "Maaf, kuota sudah habis saat Anda mencoba mendaftar. Silakan negosiasi dengan admin BAAK S1 secara offline.";
        $_SESSION['msg_type'] = "warning";
    }
    mysqli_autocommit($con, TRUE);
    
    header("Location: plotLembagaPklUser.php");
    exit();
}
?>
