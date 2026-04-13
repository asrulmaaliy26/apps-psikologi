<?php
include("contentsConAdm.php");
$idAdm = $_SESSION['username'];

// Check Monitoring Role
$qCheckMon = mysqli_query($con, "SELECT * FROM peg_monitoring_role WHERE username='$idAdm'");
if (mysqli_num_rows($qCheckMon) == 0) {
    header("location:dashboardAdm.php");
    exit();
}

$op = $_GET['op'];
$filter_date = $_GET['date'];
$q = isset($_GET['q']) ? $_GET['q'] : '';
$level = isset($_GET['level']) ? $_GET['level'] : '';

if ($op == "verifikasi") {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $status = mysqli_real_escape_string($con, $_GET['status']);

    mysqli_query($con, "UPDATE peg_laporan_harian SET status_kegiatan='$status' WHERE id='$id'");
    
    header("location:monitoringLaporanHarian.php?date=$filter_date&q=$q&level=$level");
}

else if ($op == "reopen") {
    $target = mysqli_real_escape_string($con, $_GET['target']);
    $date = mysqli_real_escape_string($con, $_GET['date']);

    // Update attendance status back to 'buka'
    mysqli_query($con, "UPDATE peg_absensi_harian SET status_absen='buka', waktu_tutup=NULL 
                        WHERE username='$target' AND tanggal='$date'");
    
    // Optional: Delete the 'Absensi Keluar' activity to avoid confusion
    mysqli_query($con, "DELETE FROM peg_laporan_harian WHERE username='$target' AND tanggal='$date' AND kegiatan='Absensi Keluar'");

    header("location:monitoringLaporanHarian.php?date=$date&q=$q&level=$level");
}
?>
