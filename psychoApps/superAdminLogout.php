<?php

/**
 * superAdminLogout.php — Logout Super Admin
 * Bersihkan semua session SA, redirect ke login
 */
require_once 'conAdm.php';

session_destroy();
header('location:superAdminLogin.php');
exit;
