<?php

/**
 * superAdminSwitch.php — AJAX handler ganti role
 * Menerima POST: role, val
 * Return JSON: { redirect } atau { error }
 */
include 'conAdm.php';
require_once 'configSA.php';
header('Content-Type: application/json');

if (empty($_SESSION['is_superadmin'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$role = $_POST['role'] ?? '';
$val  = trim($_POST['val'] ?? '');
$roles = sa_roles();

if (!isset($roles[$role]) || $val === '') {
    echo json_encode(['error' => 'Role atau nilai tidak valid']);
    exit;
}

$cfg = $roles[$role];

// Set session vars yang dipakai target role
foreach ($cfg['session_set'] as $sKey => $sVal) {
    $_SESSION[$sKey] = str_replace('{val}', $val, $sVal);
}

// Simpan info SA (jangan hapus flag SA)
$_SESSION['is_superadmin']  = true;
$_SESSION['sa_role_active'] = $role;
$_SESSION['sa_role_label']  = $cfg['label'];

echo json_encode(['redirect' => $cfg['redirect']]);
