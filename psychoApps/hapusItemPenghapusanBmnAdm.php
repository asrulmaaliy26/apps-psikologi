<?php
include("contentsConAdm.php");

if (isset($_GET['id_pengajuan']) && isset($_GET['id_barang'])) {
    $id_pengajuan = mysqli_real_escape_string($con, $_GET['id_pengajuan']);
    $id_barang = mysqli_real_escape_string($con, $_GET['id_barang']);
    
    // Cek apakah pengajuan masih dalam status Draft atau Diajukan
    $q_cek = mysqli_query($con, "SELECT * FROM dt_pengajuan_penghapusan_bmn WHERE id='$id_pengajuan' AND status IN ('Draft', 'Diajukan')");
    
    if (mysqli_num_rows($q_cek) > 0) {
        // Hapus dari detail
        mysqli_query($con, "DELETE FROM dt_pengajuan_penghapusan_bmn_detail WHERE id_pengajuan='$id_pengajuan' AND id_barang='$id_barang'");
        
        // Opsional: Cek apakah detail kosong setelah dihapus. Jika kosong, hapus header sekalian
        $q_count = mysqli_query($con, "SELECT COUNT(*) as jum FROM dt_pengajuan_penghapusan_bmn_detail WHERE id_pengajuan='$id_pengajuan'");
        $d_count = mysqli_fetch_assoc($q_count);
        
        if ($d_count['jum'] == 0) {
            mysqli_query($con, "DELETE FROM dt_pengajuan_penghapusan_bmn WHERE id='$id_pengajuan'");
            header("location:rekapPenghapusanBmnAdm.php?message=notifDelete");
        } else {
            header("location:detailPenghapusanBmnAdm.php?id=$id_pengajuan&message=notifDelete");
        }
    } else {
        header("location:detailPenghapusanBmnAdm.php?id=$id_pengajuan");
    }
} else {
    header("location:rekapPenghapusanBmnAdm.php");
}
?>
