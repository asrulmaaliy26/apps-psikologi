<?php
include("contentsConAdm.php");

$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$link_output = mysqli_real_escape_string($con, $_POST['link_output']);

$q = "SELECT * FROM dt_mhssw WHERE nim='$nim'";
$has = mysqli_query($con,  $q) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($has);
$nama = $dataku['nama'];
$date = strtotime('now');

$q_pkl = "SELECT * FROM peserta_pkl WHERE id='$id'";
$has_pkl = mysqli_query($con, $q_pkl) or die(mysqli_error($con));
$dt_pkl = mysqli_fetch_assoc($has_pkl);
$id_pkl = $dt_pkl['id_pkl'];

$update_query = "UPDATE peserta_pkl SET link_output='$link_output'";

// Handle file_laporan_akademik
if (isset($_FILES['file_laporan_akademik']) && $_FILES['file_laporan_akademik']['error'] === UPLOAD_ERR_OK) {
    if ($_FILES['file_laporan_akademik']['type'] == "application/pdf") {
        $namaftpd = "file_laporan_akademik/";
        if (!file_exists($namaftpd)) mkdir($namaftpd, 0777, true);
        
        $temp = explode(".", $_FILES["file_laporan_akademik"]["name"]);
        $nama_file = $nama . '-' . $nim . '-' . $id_pkl . '_laporan-akademik_' . $date . '.' . end($temp);
        $file_path = $namaftpd . $nama_file;
        
        if (move_uploaded_file($_FILES['file_laporan_akademik']['tmp_name'], $file_path)) {
            if (strlen($dt_pkl['file_laporan_akademik']) > 3 && file_exists($dt_pkl['file_laporan_akademik'])) {
                unlink($dt_pkl['file_laporan_akademik']);
            }
            $update_query .= ", file_laporan_akademik='$file_path'";
        }
    }
}

// Handle file_laporan_output
if (isset($_FILES['file_laporan_output']) && $_FILES['file_laporan_output']['error'] === UPLOAD_ERR_OK) {
    if ($_FILES['file_laporan_output']['type'] == "application/pdf") {
        $namaftpd = "file_laporan_output/";
        if (!file_exists($namaftpd)) mkdir($namaftpd, 0777, true);
        
        $temp = explode(".", $_FILES["file_laporan_output"]["name"]);
        $nama_file = $nama . '-' . $nim . '-' . $id_pkl . '_laporan-output_' . $date . '.' . end($temp);
        $file_path = $namaftpd . $nama_file;
        
        if (move_uploaded_file($_FILES['file_laporan_output']['tmp_name'], $file_path)) {
            if (strlen($dt_pkl['file_laporan_output']) > 3 && file_exists($dt_pkl['file_laporan_output'])) {
                unlink($dt_pkl['file_laporan_output']);
            }
            $update_query .= ", file_laporan_output='$file_path'";
        }
    }
}

$update_query .= " WHERE id='$id' LIMIT 1";

if (mysqli_query($con, $update_query)) {
    header("location:prePendaftaranPklUser.php?message=notifEdit");
} else {
    header("location:prePendaftaranPklUser.php?message=notifGagalUpload");
}
?>
