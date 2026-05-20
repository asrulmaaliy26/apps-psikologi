<?php
include("contentsConAdm.php");

// Proteksi Level: Hanya Admin BMN (5) dan Admin Utama (10)
if ($_SESSION['level'] != '5' && $_SESSION['level'] != '10') {
    header("location:dashboardAdm.php");
    exit();
}

$act = isset($_GET['act']) ? $_GET['act'] : '';
if (empty($act)) {
    $act = isset($_POST['id']) ? 'edit' : '';
}
if (empty($act) && isset($_GET['id']) && isset($_GET['act']) && $_GET['act'] == 'del') {
    $act = 'del';
}

// Pastikan direktori gambar ruangan ada
$targetDir = "images/ruangan/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if ($act == 'add') {
    $nama_ruangan = mysqli_real_escape_string($con, $_POST['nama_ruangan']);
    $kondisi = mysqli_real_escape_string($con, $_POST['kondisi']);
    $lokasi = mysqli_real_escape_string($con, $_POST['lokasi']);
    $kapasitas = intval($_POST['kapasitas']);
    $status_aktif = intval($_POST['status_aktif']);
    $keterangan = mysqli_real_escape_string($con, $_POST['keterangan']);
    
    $gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $fileSize = $_FILES['gambar']['size'];
        $fileTmp = $_FILES['gambar']['tmp_name'];
        $fileName = $_FILES['gambar']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = array('jpg', 'jpeg', 'png');
        
        if (in_array($fileExt, $allowed) && $fileSize <= 2097152) { // 2MB
            $newFileName = "ruang_" . time() . "_" . rand(100, 999) . "." . $fileExt;
            if (move_uploaded_file($fileTmp, $targetDir . $newFileName)) {
                $gambar = $newFileName;
            }
        }
    }
    
    // Jika upload gambar wajib pada add, tapi tidak berhasil
    if (empty($gambar)) {
        header("location:bmnBookingRuangan.php?message=notifGagal");
        exit();
    }
    
    $query = "INSERT INTO bmn_ruangan_booking (nama_ruangan, gambar, kondisi, lokasi, kapasitas, keterangan, status_aktif) 
              VALUES ('$nama_ruangan', '$gambar', '$kondisi', '$lokasi', $kapasitas, '$keterangan', $status_aktif)";
              
    if (mysqli_query($con, $query)) {
        header("location:bmnBookingRuangan.php?message=notifAdd");
    } else {
        header("location:bmnBookingRuangan.php?message=notifGagal");
    }
    exit();
}

elseif ($act == 'edit') {
    $id = intval($_POST['id']);
    $nama_ruangan = mysqli_real_escape_string($con, $_POST['nama_ruangan']);
    $kondisi = mysqli_real_escape_string($con, $_POST['kondisi']);
    $lokasi = mysqli_real_escape_string($con, $_POST['lokasi']);
    $kapasitas = intval($_POST['kapasitas']);
    $status_aktif = intval($_POST['status_aktif']);
    $keterangan = mysqli_real_escape_string($con, $_POST['keterangan']);
    
    // Ambil gambar lama
    $q_old = mysqli_query($con, "SELECT gambar FROM bmn_ruangan_booking WHERE id = $id");
    $d_old = mysqli_fetch_assoc($q_old);
    $gambar = $d_old['gambar'];
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $fileSize = $_FILES['gambar']['size'];
        $fileTmp = $_FILES['gambar']['tmp_name'];
        $fileName = $_FILES['gambar']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = array('jpg', 'jpeg', 'png');
        
        if (in_array($fileExt, $allowed) && $fileSize <= 2097152) { // 2MB
            $newFileName = "ruang_" . time() . "_" . rand(100, 999) . "." . $fileExt;
            if (move_uploaded_file($fileTmp, $targetDir . $newFileName)) {
                // Hapus gambar lama jika ada
                if (!empty($gambar) && file_exists($targetDir . $gambar)) {
                    unlink($targetDir . $gambar);
                }
                $gambar = $newFileName;
            } else {
                header("location:bmnBookingRuangan.php?message=notifGagal");
                exit();
            }
        } else {
            header("location:bmnBookingRuangan.php?message=notifGagal");
            exit();
        }
    }
    
    $query = "UPDATE bmn_ruangan_booking SET 
              nama_ruangan = '$nama_ruangan', 
              gambar = '$gambar', 
              kondisi = '$kondisi', 
              lokasi = '$lokasi', 
              kapasitas = $kapasitas, 
              keterangan = '$keterangan', 
              status_aktif = $status_aktif 
              WHERE id = $id";
              
    if (mysqli_query($con, $query)) {
        header("location:bmnBookingRuangan.php?message=notifEdit");
    } else {
        header("location:bmnBookingRuangan.php?message=notifGagal");
    }
    exit();
}

elseif ($act == 'del') {
    $id = intval($_GET['id']);
    
    // Ambil gambar untuk dihapus fisiknya
    $q_old = mysqli_query($con, "SELECT gambar FROM bmn_ruangan_booking WHERE id = $id");
    if ($d_old = mysqli_fetch_assoc($q_old)) {
        $gambar = $d_old['gambar'];
        if (!empty($gambar) && file_exists($targetDir . $gambar)) {
            unlink($targetDir . $gambar);
        }
    }
    
    $query = "DELETE FROM bmn_ruangan_booking WHERE id = $id";
    if (mysqli_query($con, $query)) {
        header("location:bmnBookingRuangan.php?message=notifDel");
    } else {
        header("location:bmnBookingRuangan.php?message=notifGagal");
    }
    exit();
}

else {
    header("location:bmnBookingRuangan.php");
    exit();
}
?>
