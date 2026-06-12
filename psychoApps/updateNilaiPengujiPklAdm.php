<?php
include("conAdm.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id_peserta_pkl']);

    // Build the query dynamically
    $fields = [];
    $peng_lap_labels = 6;
    $peng_pres_labels = 6;

    for($i=1; $i<=$peng_lap_labels; $i++) {
        $f = 'penguji_laporan_'.$i;
        $val = !empty($_POST[$f]) ? "'" . mysqli_real_escape_string($con, $_POST[$f]) . "'" : "NULL";
        $fields[] = "$f = $val";
    }
    for($i=1; $i<=$peng_pres_labels; $i++) {
        $f = 'penguji_presentasi_'.$i;
        $val = !empty($_POST[$f]) ? "'" . mysqli_real_escape_string($con, $_POST[$f]) . "'" : "NULL";
        $fields[] = "$f = $val";
    }

    $cek = mysqli_query($con, "SELECT id FROM penilaian_pkl_detail WHERE id_peserta_pkl='$id'");
    if (mysqli_num_rows($cek) > 0) {
        $query = "UPDATE penilaian_pkl_detail SET " . implode(", ", $fields) . " WHERE id_peserta_pkl='$id'";
    } else {
        $query = "INSERT INTO penilaian_pkl_detail SET id_peserta_pkl='$id', " . implode(", ", $fields);
    }
    mysqli_query($con, $query) or die(mysqli_error($con));
    
    // Call calculation script
    include("calculateTotalPkl.php");
    calculateTotalPkl($con, $id);

    header("Location: formNilaiPengujiPklAdm.php?id_peserta=$id&message=notifUpdate");
    exit();
}
?>
