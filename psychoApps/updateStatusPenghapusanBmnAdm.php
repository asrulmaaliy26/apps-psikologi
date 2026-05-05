<?php
include("contentsConAdm.php");

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $keterangan_admin = mysqli_real_escape_string($con, $_POST['keterangan_admin']);

    $sql = "UPDATE dt_pengajuan_penghapusan_bmn SET 
            status = '$status', 
            keterangan_admin = '$keterangan_admin' 
            WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        // Jika status Selesai, mungkin ada logika tambahan untuk mengubah status barang di dt_inventaris_barang?
        // Untuk saat ini kita simpan statusnya saja.
        header("location:rekapPenghapusanBmnAdm.php?message=notifUpdate");
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
} else {
    header("location:rekapPenghapusanBmnAdm.php");
}
?>
