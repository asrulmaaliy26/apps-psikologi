<?php
include("contentsConAdm.php");

// Proteksi level (hanya Admin Utama)
if (empty($_SESSION['level']) || $_SESSION['level'] !== 'adminutama') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($con, $_POST['kalender_akademik_judul']);
    $url = mysqli_real_escape_string($con, $_POST['kalender_akademik_url']);

    // Update judul
    $q1 = "UPDATE pengaturan_informasi SET nilai='$judul' WHERE kunci='kalender_akademik_judul'";
    mysqli_query($con, $q1);

    // Update url
    $q2 = "UPDATE pengaturan_informasi SET nilai='$url' WHERE kunci='kalender_akademik_url'";
    mysqli_query($con, $q2);

    $_SESSION['msg_pengaturan'] = [
        'type' => 'success',
        'title' => 'Berhasil!',
        'text' => 'Pengaturan informasi Kalender Akademik telah diperbarui.'
    ];

    header("Location: pengaturanSistemAdm.php");
    exit();
}

header("Location: pengaturanSistemAdm.php");
exit();
