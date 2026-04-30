<?php
include("contentsConAdm.php");

$act = $_GET['act'];

if ($act == "addPeriode") {
    $tgl = $_POST['tgl'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $info_tenaga = mysqli_real_escape_string($con, $_POST['info_tenaga'] ?? '');
    $ruangan_id = $_POST['ruangan_id'];
    
    mysqli_query($con, "INSERT INTO lab_booking_periode (tgl, jam_mulai, jam_selesai, ruangan_id, info_tenaga) VALUES ('$tgl', '$jam_mulai', '$jam_selesai', '$ruangan_id', '$info_tenaga')");
    header("location:periodeBookingLabUser.php?message=notifAdd");
} elseif ($act == "editPeriode") {
    $id = $_POST['id'];
    $tgl = $_POST['tgl'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $info_tenaga = mysqli_real_escape_string($con, $_POST['info_tenaga'] ?? '');
    $ruangan_id = $_POST['ruangan_id'];
    $status = $_POST['status'];
    
    mysqli_query($con, "UPDATE lab_booking_periode SET tgl='$tgl', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai', ruangan_id='$ruangan_id', info_tenaga='$info_tenaga', status='$status' WHERE id='$id'");
    header("location:periodeBookingLabUser.php?message=notifEdit");
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
    $keperluan_alat = mysqli_real_escape_string($con, $_POST['keperluan_alat']);
    $jenis_layanan = $_POST['jenis_layanan'];
    $tipe_alat = mysqli_real_escape_string($con, $_POST['tipe_alat'] ?? '');
    
    // Logic: 
    // - Kelompok (Booking) only 1 per slot.
    // - Individu (Mengantri) can be multiple per slot.
    // - If Kelompok already exists, nobody else can register (or as per user: "kelompok masih bisa mengisi" implies individuals don't block groups).
    
    if ($kategori_peserta == 'Kelompok') {
        $check = mysqli_query($con, "SELECT id FROM lab_booking_data WHERE periode_id='$periode_id' AND kategori_peserta='Kelompok'");
        if (mysqli_num_rows($check) > 0) {
            header("location:bookingLabUser.php?message=failedBooked");
            exit;
        }
    }
    
    // Note: We don't block individuals from queueing even if a group exists, 
    // or we can decide based on further user input. For now, allowing multiple.
    
    mysqli_query($con, "INSERT INTO lab_booking_data (periode_id, nim, nama, kategori_peserta, jml_orang, email, keperluan_alat, jenis_layanan, tipe_alat) 
                        VALUES ('$periode_id', '$nim', '$nama', '$kategori_peserta', '$jml_orang', '$email', '$keperluan_alat', '$jenis_layanan', '$tipe_alat')");
    header("location:bookingLabUser.php?message=notifAdd");
} elseif ($act == "moveBooking") {
    $booking_id = $_POST['booking_id'];
    $new_periode_id = $_POST['new_periode_id'];
    
    mysqli_query($con, "UPDATE lab_booking_data SET periode_id='$new_periode_id' WHERE id='$booking_id'");
    header("location:periodeBookingLabUser.php?message=notifMove");
}
?>
