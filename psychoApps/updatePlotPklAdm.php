<?php
if(!isset($_SESSION)) { session_start(); }
require_once "conAdm.php";

if (isset($_GET['act'])) {
    $act = $_GET['act'];

    if ($act == 'open_periode' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        mysqli_query($con, "UPDATE pkl_plot_periode SET status='Tutup'"); // Tutup semua yang lain
        mysqli_query($con, "UPDATE pkl_plot_periode SET status='Buka' WHERE id_periode='$id'");
        $_SESSION['msg'] = "Periode berhasil dibuka.";
        header("Location: plotLembagaPklAdm.php");
        exit();
    }
    elseif ($act == 'close_periode' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        mysqli_query($con, "UPDATE pkl_plot_periode SET status='Tutup' WHERE id_periode='$id'");
        $_SESSION['msg'] = "Periode berhasil ditutup.";
        header("Location: plotLembagaPklAdm.php");
        exit();
    }
    elseif ($act == 'delete_penjurusan' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        if(mysqli_query($con, "DELETE FROM pkl_penjurusan WHERE id_penjurusan='$id'")){
           $_SESSION['msg'] = "Penjurusan berhasil dihapus.";
        } else {
           $_SESSION['msg'] = "Gagal hapus, mungkin data sedang digunakan di tabel lembaga.";
        }
        header("Location: plotLembagaPklAdm.php");
        exit();
    }
    elseif ($act == 'delete_lembaga' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        // Delete file first if exists
        $qF = mysqli_query($con, "SELECT file_surat FROM pkl_lembaga WHERE id_lembaga='$id'");
        if($dF = mysqli_fetch_assoc($qF)) {
            if($dF['file_surat'] && file_exists("file_surat_lembaga_pkl/".$dF['file_surat'])) {
                unlink("file_surat_lembaga_pkl/".$dF['file_surat']);
            }
        }
        mysqli_query($con, "DELETE FROM pkl_lembaga WHERE id_lembaga='$id'");
        $_SESSION['msg'] = "Lembaga berhasil dihapus.";
        header("Location: plotLembagaPklAdm.php");
        exit();
    }
    elseif ($act == 'del_plot' && isset($_GET['id']) && isset($_GET['lid'])) {
        $id = intval($_GET['id']);
        $lid = intval($_GET['lid']);
        mysqli_query($con, "DELETE FROM pkl_plot_pendaftar WHERE id_plot='$id'");
        $_SESSION['msg'] = "Plot pendaftar berhasil dicabut.";
        header("Location: plotLembagaPklAdm.php?lembaga_id=".$lid);
        exit();
    }
    elseif ($act == 'add_plot_manual' && isset($_POST['id_lembaga'])) {
        $lid = intval($_POST['id_lembaga']);
        $nim = mysqli_real_escape_string($con, $_POST['nim']);
        // bypass overbooking logic here because manual admin force insert
        mysqli_query($con, "INSERT INTO pkl_plot_pendaftar (nim, id_lembaga) VALUES ('$nim', '$lid')");
        $_SESSION['msg'] = "Mahasiswa $nim berhasil ditambahkan ke plot secara manual.";
        header("Location: plotLembagaPklAdm.php?lembaga_id=".$lid);
        exit();
    }
    elseif ($act == 'update_kuota' && isset($_POST['id_lembaga'])) {
        $lid = intval($_POST['id_lembaga']);
        $kuota = intval($_POST['kuota']);
        mysqli_query($con, "UPDATE pkl_lembaga SET kuota='$kuota' WHERE id_lembaga='$lid'");
        $_SESSION['msg'] = "Kuota lembaga berhasil diperbarui.";
        header("Location: plotLembagaPklAdm.php?lembaga_id=".$lid);
        exit();
    }
}

header("Location: plotLembagaPklAdm.php");
?>
