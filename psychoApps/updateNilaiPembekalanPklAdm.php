<?php
include("conAdm.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    $ids = $_POST['id_peserta_pkl'];
    $n1s = $_POST['n1'];
    $n2s = $_POST['n2'];
    $n3s = $_POST['n3'];

    $count = count($ids);
    for ($i = 0; $i < $count; $i++) {
        $id = mysqli_real_escape_string($con, $ids[$i]);
        
        // Handle empty values as NULL
        $n1 = !empty($n1s[$i]) ? "'" . mysqli_real_escape_string($con, $n1s[$i]) . "'" : "NULL";
        $n2 = !empty($n2s[$i]) ? "'" . mysqli_real_escape_string($con, $n2s[$i]) . "'" : "NULL";
        $n3 = !empty($n3s[$i]) ? "'" . mysqli_real_escape_string($con, $n3s[$i]) . "'" : "NULL";

        // Cek apakah data sudah ada di tabel
        $cek = mysqli_query($con, "SELECT id FROM penilaian_pkl_detail WHERE id_peserta_pkl='$id'");
        if (mysqli_num_rows($cek) > 0) {
            $query = "UPDATE penilaian_pkl_detail SET 
                      panitia_pembekalan_1=$n1, 
                      panitia_pembekalan_2=$n2, 
                      panitia_pembekalan_3=$n3 
                      WHERE id_peserta_pkl='$id'";
        } else {
            $query = "INSERT INTO penilaian_pkl_detail (id_peserta_pkl, panitia_pembekalan_1, panitia_pembekalan_2, panitia_pembekalan_3) 
                      VALUES ('$id', $n1, $n2, $n3)";
        }
        mysqli_query($con, $query) or die(mysqli_error($con));
    }
    
    // Call calculation script
    include("calculateTotalPkl.php");
    calculateTotalPkl($con, $id);
    $angkatan = isset($_POST['angkatan']) ? $_POST['angkatan'] : '';
    $periode = isset($_POST['periode']) ? $_POST['periode'] : '';
    $redirect_url = "nilaiPembekalanPklAdm.php?message=notifUpdate";
    
    if (!empty($periode)) {
        $redirect_url .= "&periode=" . urlencode($periode);
    }
    if (!empty($angkatan)) {
        $redirect_url .= "&angkatan=" . urlencode($angkatan);
    }

    header("Location: " . $redirect_url);
    exit();
}
?>
