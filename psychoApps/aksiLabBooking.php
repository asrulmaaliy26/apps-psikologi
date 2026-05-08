<?php
include("contentsConAdm.php");

$act = $_GET['act'];

if ($act == "addPeriode") {
    $tgl = $_POST['tgl'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $info_tenaga = mysqli_real_escape_string($con, $_POST['info_tenaga'] ?? '');
    $layanan = mysqli_real_escape_string($con, $_POST['layanan'] ?? '');
    $ruangan_id = $_POST['ruangan_id'];
    
    mysqli_query($con, "INSERT INTO lab_booking_periode (tgl, jam_mulai, jam_selesai, ruangan_id, info_tenaga, layanan) VALUES ('$tgl', '$jam_mulai', '$jam_selesai', '$ruangan_id', '$info_tenaga', '$layanan')");
    header("location:periodeBookingLabUser.php?message=notifAdd");
} elseif ($act == "editPeriode") {
    $id = $_POST['id'];
    $tgl = $_POST['tgl'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $info_tenaga = mysqli_real_escape_string($con, $_POST['info_tenaga'] ?? '');
    $layanan = mysqli_real_escape_string($con, $_POST['layanan'] ?? '');
    $ruangan_id = $_POST['ruangan_id'];
    $status = $_POST['status'];
    
    mysqli_query($con, "UPDATE lab_booking_periode SET tgl='$tgl', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai', ruangan_id='$ruangan_id', info_tenaga='$info_tenaga', layanan='$layanan', status='$status' WHERE id='$id'");
    header("location:periodeBookingLabUser.php?message=notifEdit");
} elseif ($act == "toggleStatus") {
    $id = $_GET['id'];
    mysqli_query($con, "UPDATE lab_booking_periode SET status = CASE WHEN status = 1 THEN 0 ELSE 1 END WHERE id = '$id'");
    header("location:periodeBookingLabUser.php");
} elseif ($act == "delPeriode") {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM lab_booking_periode WHERE id='$id'");
    header("location:periodeBookingLabUser.php?message=notifDel");
} elseif ($act == "submitBooking") {
    $periode_id = $_POST['periode_id'];
    $nim = $_POST['nim'];
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $kategori_peserta = mysqli_real_escape_string($con, $_POST['kategori_peserta']);
    $jml_orang = $_POST['jml_orang'];
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $no_wa = mysqli_real_escape_string($con, $_POST['no_wa']);
    $layanan_utama = mysqli_real_escape_string($con, $_POST['layanan_utama']);
    $keperluan_alat = mysqli_real_escape_string($con, $_POST['keperluan_alat']);
    $jenis_layanan = $_POST['jenis_layanan'];
    $tipe_alat = mysqli_real_escape_string($con, $_POST['tipe_alat'] ?? '');
    
    // Check Quota
    $q_quota = mysqli_query($con, "SELECT r.kuota FROM lab_booking_periode p 
                                   JOIN lab_booking_ruangan r ON p.ruangan_id = r.id 
                                   WHERE p.id = '$periode_id'");
    $d_quota = mysqli_fetch_array($q_quota);
    $max_quota = $d_quota['kuota'] ?? 0;

    $q_current = mysqli_query($con, "SELECT SUM(jml_orang) as total FROM lab_booking_data WHERE periode_id = '$periode_id'");
    $d_current = mysqli_fetch_array($q_current);
    $current_total = $d_current['total'] ?? 0;

    if (($current_total + $jml_orang) > $max_quota) {
        header("location:bookingLabUser.php?message=failedQuota");
        exit;
    }

    if ($kategori_peserta == 'Kelompok') {
        $check = mysqli_query($con, "SELECT id FROM lab_booking_data WHERE periode_id='$periode_id' AND kategori_peserta='Kelompok'");
        if (mysqli_num_rows($check) > 0) {
            header("location:bookingLabUser.php?message=failedBooked");
            exit;
        }
    }
    
    mysqli_query($con, "INSERT INTO lab_booking_data (periode_id, nim, nama, kategori_peserta, jml_orang, email, no_wa, layanan_utama, keperluan_alat, jenis_layanan, tipe_alat) 
                        VALUES ('$periode_id', '$nim', '$nama', '$kategori_peserta', '$jml_orang', '$email', '$no_wa', '$layanan_utama', '$keperluan_alat', '$jenis_layanan', '$tipe_alat')");
    header("location:bookingLabUser.php?message=notifAdd");
} elseif ($act == "moveBooking") {
    $booking_id = $_POST['booking_id'];
    $new_periode_id = $_POST['new_periode_id'];
    
    mysqli_query($con, "UPDATE lab_booking_data SET periode_id='$new_periode_id' WHERE id='$booking_id'");
    header("location:periodeBookingLabUser.php?message=notifMove");
} elseif ($act == "addRuangan") {
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $kuota = $_POST['kuota'];
    mysqli_query($con, "INSERT INTO lab_booking_ruangan (nama, kuota) VALUES ('$nama', '$kuota')");
    header("location:ruanganBookingLabUser.php?message=notifAdd");
} elseif ($act == "editRuangan") {
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $kuota = $_POST['kuota'];
    mysqli_query($con, "UPDATE lab_booking_ruangan SET nama='$nama', kuota='$kuota' WHERE id='$id'");
    header("location:ruanganBookingLabUser.php?message=notifEdit");
} elseif ($act == "delRuangan") {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM lab_booking_ruangan WHERE id='$id'");
    header("location:ruanganBookingLabUser.php?message=notifDel");
}
?>
