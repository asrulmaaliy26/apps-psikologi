<?php
include("conAdm.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    $ids = $_POST['id'];
    $dpls = $_POST['id_dpl'];
    $pengujis = $_POST['id_penguji'];

    $count = count($ids);
    for ($i = 0; $i < $count; $i++) {
        $id = mysqli_real_escape_string($con, $ids[$i]);
        $id_dpl = mysqli_real_escape_string($con, $dpls[$i]);
        $id_penguji = mysqli_real_escape_string($con, $pengujis[$i]);

        $query = "UPDATE peserta_pkl SET dpl='$id_dpl', id_penguji='$id_penguji' WHERE id='$id'";
        mysqli_query($con, $query);
    }
    $angkatan = isset($_POST['angkatan']) ? $_POST['angkatan'] : '';
    $redirect_url = "plottingPengujiPklAdm.php?message=notifUpdate";
    if (!empty($angkatan)) {
        $redirect_url .= "&angkatan=" . urlencode($angkatan);
    }
    
    header("Location: " . $redirect_url);
    exit();
}
?>
