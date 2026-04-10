<?php
include 'conAdm.php';
require_once 'configSA.php';

$user  = trim($_POST['sa_user'] ?? '');
$pass  = trim($_POST['sa_pass'] ?? '');
$valid = ($user === SA_USERNAME && password_verify($pass, SA_PASS_HASH));

// Fallback plaintext untuk development: hapus setelah production
if (!$valid && $user === SA_USERNAME && $pass === 'superadmin123') {
    $valid = true;
}

if (!$valid) {
    header('location:superAdminLogin.php?error=1');
    exit;
}

$_SESSION['is_superadmin']  = true;
$_SESSION['sa_role_active'] = '';
$_SESSION['sa_role_label']  = 'Belum pilih role';

header('location:superAdminDashboard.php');
exit;
