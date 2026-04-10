<?php

/**
 * superAdminSearch.php — Paginated search API untuk Super Admin
 *
 * GET params:
 *   role  : key role dari configSA.php
 *   q     : query string. '*' atau '' = tampil halaman tertentu (paginated)
 *            Ada isi = search semua data (no pagination)
 *   page  : halaman (default 1, hanya berlaku jika q kosong/'*')
 *   limit : jumlah per halaman (default 15)
 *
 * Response JSON:
 *   { data: [{val, text}], total: N, page: N, pages: N, is_search: bool }
 */
include 'conAdm.php';
require_once 'configSA.php';
header('Content-Type: application/json');

if (empty($_SESSION['is_superadmin'])) {
    echo '{}';
    exit;
}

$role  = $_GET['role'] ?? '';
$rawQ  = trim($_GET['q'] ?? '');
$page  = max(1, intval($_GET['page'] ?? 1));
$limit = max(5, min(50, intval($_GET['limit'] ?? 15)));
$roles = sa_roles();

if (!isset($roles[$role])) {
    echo json_encode(['data' => [], 'total' => 0, 'page' => 1, 'pages' => 1, 'is_search' => false]);
    exit;
}

$cfg    = $roles[$role];
$table  = $cfg['db_table'];
$valCol = $cfg['db_val'];
$txtCol = $cfg['db_label'];
$search = $cfg['db_search'];
$isSearch = ($rawQ !== '' && $rawQ !== '*');

$dbWhere = isset($cfg['db_where']) ? $cfg['db_where'] : '1=1';

if ($isSearch) {
    // Mode SEARCH: query semua data yang cocok, tanpa pagination
    $esc   = '%' . mysqli_real_escape_string($con, $rawQ) . '%';
    $whereSearch = implode(' OR ', array_map(fn($c) => "`$c` LIKE '$esc'", $search));
    $sql   = "SELECT `$valCol` AS val, $txtCol AS text FROM `$table` WHERE ($whereSearch) AND ($dbWhere) ORDER BY `$valCol` DESC LIMIT 200";
    $res   = mysqli_query($con, $sql);
    $data  = [];
    while ($r = mysqli_fetch_assoc($res)) $data[] = ['val' => $r['val'], 'text' => $r['text']];
    echo json_encode(['data' => $data, 'total' => count($data), 'page' => 1, 'pages' => 1, 'is_search' => true]);
} else {
    // Mode LIST (paginated), urutan terbaru (DESC)
    $countSql = "SELECT COUNT(*) AS n FROM `$table` WHERE $dbWhere";
    $total    = (int) mysqli_fetch_assoc(mysqli_query($con, $countSql))['n'];
    $pages    = max(1, (int) ceil($total / $limit));
    $page     = min($page, $pages);
    $offset   = ($page - 1) * $limit;

    $sql  = "SELECT `$valCol` AS val, $txtCol AS text FROM `$table` WHERE $dbWhere ORDER BY `$valCol` DESC LIMIT $limit OFFSET $offset";
    $res  = mysqli_query($con, $sql);
    $data = [];
    while ($r = mysqli_fetch_assoc($res)) $data[] = ['val' => $r['val'], 'text' => $r['text']];
    echo json_encode(['data' => $data, 'total' => $total, 'page' => $page, 'pages' => $pages, 'is_search' => false]);
}
