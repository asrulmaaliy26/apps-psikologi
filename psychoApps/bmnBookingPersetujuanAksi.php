<?php
include("contentsConAdm.php");

// Proteksi Level: Hanya Admin BMN (5) dan Admin Utama (10)
if ($_SESSION['level'] != '5' && $_SESSION['level'] != '10') {
    header("location:dashboardAdm.php");
    exit();
}

$act = isset($_GET['act']) ? $_GET['act'] : '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    header("location:bmnBookingPersetujuan.php");
    exit();
}

if ($act == 'approve') {
    $admin_comment = mysqli_real_escape_string($con, $_POST['admin_comment']);
    
    $query = "UPDATE bmn_peminjaman_ruangan SET 
              status = 'approved', 
              admin_comment = '$admin_comment' 
              WHERE id = $id";
              
    if (mysqli_query($con, $query)) {
        header("location:bmnBookingPersetujuan.php?message=notifApprove");
    } else {
        header("location:bmnBookingPersetujuan.php?message=notifGagal");
    }
    exit();
}

elseif ($act == 'reject') {
    $admin_comment = mysqli_real_escape_string($con, $_POST['admin_comment']);
    
    if (empty($admin_comment)) {
        header("location:bmnBookingPersetujuan.php?message=notifGagal");
        exit();
    }
    
    $query = "UPDATE bmn_peminjaman_ruangan SET 
              status = 'rejected', 
              admin_comment = '$admin_comment' 
              WHERE id = $id";
              
    if (mysqli_query($con, $query)) {
        header("location:bmnBookingPersetujuan.php?message=notifReject");
    } else {
        header("location:bmnBookingPersetujuan.php?message=notifGagal");
    }
    exit();
}

elseif ($act == 'propose') {
    $new_ruangan_id = intval($_POST['ruangan_id']);
    $new_tanggal = mysqli_real_escape_string($con, $_POST['tanggal']);
    $new_jam_mulai = mysqli_real_escape_string($con, $_POST['jam_mulai']) . ":00";
    $new_jam_selesai = mysqli_real_escape_string($con, $_POST['jam_selesai']) . ":00";
    $admin_comment = mysqli_real_escape_string($con, $_POST['admin_comment']);
    
    if (empty($admin_comment)) {
        header("location:bmnBookingPersetujuan.php?message=notifGagal");
        exit();
    }
    
    // Ambil data asli dari DB
    $q_orig = mysqli_query($con, "SELECT p.*, r.nama_ruangan FROM bmn_peminjaman_ruangan p JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id WHERE p.id = $id");
    if (mysqli_num_rows($q_orig) == 0) {
        header("location:bmnBookingPersetujuan.php?message=notifGagal");
        exit();
    }
    $d_orig = mysqli_fetch_assoc($q_orig);
    
    $orig_ruangan_id = $d_orig['ruangan_id'];
    $orig_ruangan_nama = $d_orig['nama_ruangan'];
    $orig_tanggal = $d_orig['tanggal'];
    $orig_jam_mulai = $d_orig['jam_mulai'];
    $orig_jam_selesai = $d_orig['jam_selesai'];
    
    // Tentukan detail perubahan
    $changes = array();
    
    // Jika ruangan berubah
    if ($new_ruangan_id != $orig_ruangan_id) {
        // Ambil nama ruangan baru
        $q_new_room = mysqli_query($con, "SELECT nama_ruangan FROM bmn_ruangan_booking WHERE id = $new_ruangan_id");
        $d_new_room = mysqli_fetch_assoc($q_new_room);
        $new_ruangan_nama = $d_new_room['nama_ruangan'];
        $changes[] = "Ruangan diubah dari <strong>" . htmlspecialchars($orig_ruangan_nama) . "</strong> menjadi <strong>" . htmlspecialchars($new_ruangan_nama) . "</strong>";
    }
    
    // Jika tanggal berubah
    if ($new_tanggal != $orig_tanggal) {
        $changes[] = "Tanggal diubah dari <strong>" . date('d-m-Y', strtotime($orig_tanggal)) . "</strong> menjadi <strong>" . date('d-m-Y', strtotime($new_tanggal)) . "</strong>";
    }
    
    // Jika jam berubah
    $fmt_orig_mulai = substr($orig_jam_mulai, 0, 5);
    $fmt_orig_selesai = substr($orig_jam_selesai, 0, 5);
    $fmt_new_mulai = substr($new_jam_mulai, 0, 5);
    $fmt_new_selesai = substr($new_jam_selesai, 0, 5);
    
    if ($fmt_new_mulai != $fmt_orig_mulai || $fmt_new_selesai != $fmt_orig_selesai) {
        $changes[] = "Waktu diubah dari <strong>" . $fmt_orig_mulai . " - " . $fmt_orig_selesai . "</strong> menjadi <strong>" . $fmt_new_mulai . " - " . $fmt_new_selesai . "</strong>";
    }
    
    // Jika tidak ada perubahan sama sekali tapi admin mengajukan, maka tetap di-handle sebagai perubahan biasa
    if (empty($changes)) {
        $changes[] = "Jam/Ruangan/Tanggal disesuaikan oleh Admin.";
    }
    
    $changes_detail = implode("<br>", $changes);
    
    // Simpan data asli ke kolom original_*, dan update kolom utama dengan data usulan baru
    $query = "UPDATE bmn_peminjaman_ruangan SET 
              status = 'proposed', 
              ruangan_id = $new_ruangan_id, 
              tanggal = '$new_tanggal', 
              jam_mulai = '$new_jam_mulai', 
              jam_selesai = '$new_jam_selesai', 
              original_ruangan_id = $orig_ruangan_id, 
              original_tanggal = '$orig_tanggal', 
              original_jam_mulai = '$orig_jam_mulai', 
              original_jam_selesai = '$orig_jam_selesai', 
              has_changes = 1, 
              changes_detail = '$changes_detail', 
              admin_comment = '$admin_comment' 
              WHERE id = $id";
              
    if (mysqli_query($con, $query)) {
        header("location:bmnBookingPersetujuan.php?message=notifPropose");
    } else {
        header("location:bmnBookingPersetujuan.php?message=notifGagal");
    }
    exit();
}

else {
    header("location:bmnBookingPersetujuan.php");
    exit();
}
?>
