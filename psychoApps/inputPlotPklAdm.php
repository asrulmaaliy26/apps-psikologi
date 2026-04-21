<?php
if(!isset($_SESSION)) { session_start(); }
require_once "conAdm.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tipe'])) {
    $tipe = $_POST['tipe'];

    if ($tipe == 'periode') {
        $periode = mysqli_real_escape_string($con, $_POST['periode']);
        $tahun = mysqli_real_escape_string($con, $_POST['tahun']);
        
        $q = "INSERT INTO pkl_plot_periode (periode, tahun, status) VALUES ('$periode', '$tahun', 'Tutup')";
        if(mysqli_query($con, $q)) {
            $_SESSION['msg'] = "Periode berhasil ditambahkan.";
        } else {
            $_SESSION['msg'] = "Gagal menambahkan periode: " . mysqli_error($con);
        }
    } 
    elseif ($tipe == 'penjurusan') {
        $nama = mysqli_real_escape_string($con, $_POST['nama_penjurusan']);
        
        $q = "INSERT INTO pkl_penjurusan (nama_penjurusan) VALUES ('$nama')";
        if(mysqli_query($con, $q)) {
            $_SESSION['msg'] = "Penjurusan berhasil ditambahkan.";
        } else {
            $_SESSION['msg'] = "Gagal menambahkan penjurusan: " . mysqli_error($con);
        }
    }
    elseif ($tipe == 'lembaga') {
        $id_periode = intval($_POST['id_periode']);
        $id_penjurusan = intval($_POST['id_penjurusan']);
        $nama_tempat = mysqli_real_escape_string($con, $_POST['nama_tempat']);
        $kota = mysqli_real_escape_string($con, $_POST['kota']);
        $alamat = mysqli_real_escape_string($con, $_POST['alamat_lengkap']);
        $kuota = intval($_POST['kuota']);
        
        $filename = "";
        if(isset($_FILES['surat']) && $_FILES['surat']['error'] == 0) {
            $ext = pathinfo($_FILES['surat']['name'], PATHINFO_EXTENSION);
            $filename = time() . "_" . mt_rand(100,999) . "." . $ext;
            $dest = "file_surat_lembaga_pkl/" . $filename;
            move_uploaded_file($_FILES['surat']['tmp_name'], $dest);
        }
        
        $q = "INSERT INTO pkl_lembaga (id_periode, id_penjurusan, nama_tempat, kota, alamat_lengkap, kuota, file_surat) 
              VALUES ('$id_periode', '$id_penjurusan', '$nama_tempat', '$kota', '$alamat', '$kuota', '$filename')";
        if(mysqli_query($con, $q)) {
            $_SESSION['msg'] = "Lembaga berhasil ditambahkan.";
        } else {
            $_SESSION['msg'] = "Gagal menambahkan lembaga: " . mysqli_error($con);
        }
    }

    header("Location: plotLembagaPklAdm.php");
    exit();
}
?>
