<?php
if(!isset($_SESSION)) { session_start(); }
require_once "conAdm.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_lembaga'])) {
    $id_lembaga = intval($_POST['id_lembaga']);
    $tgl_mulai = mysqli_real_escape_string($con, $_POST['tgl_mulai']);
    $tgl_selesai = mysqli_real_escape_string($con, $_POST['tgl_selesai']);

    $q = "UPDATE pkl_lembaga SET tgl_mulai='$tgl_mulai', tgl_selesai='$tgl_selesai' WHERE id_lembaga='$id_lembaga'";
    if(mysqli_query($con, $q)) {
        $_SESSION['msg'] = "Durasi PKL Tim berhasil diperbarui.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['msg'] = "Gagal memperbarui durasi: " . mysqli_error($con);
        $_SESSION['msg_type'] = "danger";
    }
    
    header("Location: plotLembagaPklUser.php");
    exit();
}
?>
