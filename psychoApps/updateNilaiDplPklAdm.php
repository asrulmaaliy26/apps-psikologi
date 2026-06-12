<?php
include("conAdm.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id_peserta_pkl']);
    $id_dpl = mysqli_real_escape_string($con, $_POST['id_dpl'] ?? '');
    $id_pkl = mysqli_real_escape_string($con, $_POST['id_pkl'] ?? '');
    $page = mysqli_real_escape_string($con, $_POST['page'] ?? '');
    $source = mysqli_real_escape_string($con, $_POST['source'] ?? '');

    // Build the query dynamically
    $fields = [];
    $super_labels = 12;
    $dpl_pel_labels = 8;
    $dpl_lap_labels = 6;
    $dpl_pres_labels = 6;

    for($i=1; $i<=$super_labels; $i++) {
        $f = 'super_pelaksanaan_'.$i;
        $val = !empty($_POST[$f]) ? "'" . mysqli_real_escape_string($con, $_POST[$f]) . "'" : "NULL";
        $fields[] = "$f = $val";
    }
    for($i=1; $i<=$dpl_pel_labels; $i++) {
        $f = 'dpl_pelaksanaan_'.$i;
        $val = !empty($_POST[$f]) ? "'" . mysqli_real_escape_string($con, $_POST[$f]) . "'" : "NULL";
        $fields[] = "$f = $val";
    }
    for($i=1; $i<=$dpl_lap_labels; $i++) {
        $f = 'dpl_laporan_'.$i;
        $val = !empty($_POST[$f]) ? "'" . mysqli_real_escape_string($con, $_POST[$f]) . "'" : "NULL";
        $fields[] = "$f = $val";
    }
    for($i=1; $i<=$dpl_pres_labels; $i++) {
        $f = 'dpl_presentasi_'.$i;
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

    header("Location: formNilaiDplPklAdm.php?id_peserta=$id&id_dpl=$id_dpl&id_pkl=$id_pkl&page=$page&source=$source&message=notifUpdate");
    exit();
}
?>
