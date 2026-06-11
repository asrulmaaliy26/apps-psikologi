<?php
include("contentsConAdm.php");

if (isset($_GET['id_barang'])) {
    $id_barang = mysqli_real_escape_string($con, $_GET['id_barang']);
    
    // Cek apakah ada pengajuan dengan status Diajukan
    $q_cek = mysqli_query($con, "SELECT id FROM dt_pengajuan_penghapusan_bmn WHERE status = 'Diajukan' ORDER BY id DESC LIMIT 1");
    if(mysqli_num_rows($q_cek) > 0) {
        $d_cek = mysqli_fetch_assoc($q_cek);
        $id_pengajuan = $d_cek['id'];
        
        // Cek agar tidak duplikat
        $q_dup = mysqli_query($con, "SELECT * FROM dt_pengajuan_penghapusan_bmn_detail WHERE id_pengajuan='$id_pengajuan' AND id_barang='$id_barang'");
        if(mysqli_num_rows($q_dup) == 0) {
            mysqli_query($con, "INSERT INTO dt_pengajuan_penghapusan_bmn_detail (id_pengajuan, id_barang) VALUES ('$id_pengajuan', '$id_barang')");
        }
        
        header("location:rekapPenghapusanBmnAdm.php?message=notifInput");
    } else {
        // Buat pengajuan baru
        $alasan = "Pengajuan penghapusan";
        $metode = "lelang";
        $tgl_pengajuan = date('Y-m-d');
        $status = "Diajukan";
        $username = $_SESSION['username'];

        // Generate No Pengajuan: HPS/YYYYMMDD/RAND
        $no_pengajuan = "HPS/" . date('Ymd') . "/" . strtoupper(substr(uniqid(), -4));

        $sql_header = "INSERT INTO dt_pengajuan_penghapusan_bmn (no_pengajuan, alasan, metode, tgl_pengajuan, status, username_pengaju) 
                       VALUES ('$no_pengajuan', '$alasan', '$metode', '$tgl_pengajuan', '$status', '$username')";
        
        if (mysqli_query($con, $sql_header)) {
            $id_pengajuan = mysqli_insert_id($con);
            mysqli_query($con, "INSERT INTO dt_pengajuan_penghapusan_bmn_detail (id_pengajuan, id_barang) VALUES ('$id_pengajuan', '$id_barang')");
            
            header("location:rekapPenghapusanBmnAdm.php?message=notifInput");
        } else {
            header("location:dtBarang.php?message=notifError");
        }
    }
} else {
    header("location:dtBarang.php");
}
?>
