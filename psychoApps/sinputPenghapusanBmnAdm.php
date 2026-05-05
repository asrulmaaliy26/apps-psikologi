<?php
include("contentsConAdm.php");

if (isset($_POST['id_barang'])) {
    $alasan = mysqli_real_escape_string($con, $_POST['alasan']);
    $metode = mysqli_real_escape_string($con, $_POST['metode']);
    $tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $username = $_SESSION['username'];
    $ids_barang = $_POST['id_barang'];

    // Generate No Pengajuan: HPS/YYYYMMDD/RAND
    $no_pengajuan = "HPS/" . date('Ymd') . "/" . strtoupper(substr(uniqid(), -4));

    // Insert into header
    $sql_header = "INSERT INTO dt_pengajuan_penghapusan_bmn (no_pengajuan, alasan, metode, tgl_pengajuan, status, username_pengaju) 
                   VALUES ('$no_pengajuan', '$alasan', '$metode', '$tgl_pengajuan', '$status', '$username')";
    
    if (mysqli_query($con, $sql_header)) {
        $id_pengajuan = mysqli_insert_id($con);

        // Insert into details
        foreach ($ids_barang as $id_barang) {
            $id_barang = mysqli_real_escape_string($con, $id_barang);
            mysqli_query($con, "INSERT INTO dt_pengajuan_penghapusan_bmn_detail (id_pengajuan, id_barang) VALUES ('$id_pengajuan', '$id_barang')");
        }

        header("location:rekapPenghapusanBmnAdm.php?message=notifInput");
    } else {
        header("location:dtBarang.php?message=notifError");
    }
} else {
    header("location:dtBarang.php");
}
?>
