<?php
include("conAdm.php");

// Blok akses langsung tanpa sesi login aktif.
if (empty($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

// Global RBAC: Cegah Mahasiswa mengakses halaman Admin
if (isset($_SESSION['level'])) {
    $current_script = basename($_SERVER['SCRIPT_NAME']);
    $is_admin_script = stripos($current_script, 'Adm') !== false;
    $level = $_SESSION['level'];
    
    // Level 2 = Mahasiswa S1, Level 3 = Mahasiswa S2
    if (($level == '2' || $level == '3') && $is_admin_script) {
        header('Location: ../index.php?message=forbidden');
        exit;
    }
}
