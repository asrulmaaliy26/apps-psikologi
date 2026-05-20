<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php");
    exit();
}
include("contentsConAdm.php");

$id = mysqli_real_escape_string($con, $_POST['id'] ?? '');
$statusform = mysqli_real_escape_string($con, $_POST['statusform'] ?? '');
$nim = mysqli_real_escape_string($con, $_POST['nim'] ?? '');
$angkatan = mysqli_real_escape_string($con, $_POST['angkatan'] ?? '');
$page = mysqli_real_escape_string($con, $_POST['page'] ?? '1');

$tgl_validasi = date("Y-m-d");

if (!empty($id) && !empty($statusform)) {
    $sql = "UPDATE skkm SET statusform = '$statusform', tgl_validasi = '$tgl_validasi' WHERE id = '$id' LIMIT 1";
    if (mysqli_query($con, $sql)) {
        header("location:detailSkkmMhsAdm.php?nim=$nim&angkatan=$angkatan&page=$page&msg=success");
    } else {
        header("location:detailSkkmMhsAdm.php?nim=$nim&angkatan=$angkatan&page=$page&msg=error");
    }
} else {
    header("location:detailSkkmMhsAdm.php?nim=$nim&angkatan=$angkatan&page=$page");
}
?>
