<?php
include("conAdm.php");

// Blok akses langsung tanpa sesi login aktif.
if (empty($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
?>