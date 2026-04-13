<?php
include("contentsConAdm.php");
if ($_SESSION['level'] == 2 || $_SESSION['level'] == 3) {
    header("location:index.php");
    exit();
}

$username = $_SESSION['username'];
$today = date('Y-m-d');
$now = date('Y-m-d H:i:s');
$op = $_GET['op'];

if ($op == "buka_absen") {
    // Check if already opened today
    $qCheckAbs = mysqli_query($con, "SELECT id FROM peg_absensi_harian WHERE username='$username' AND tanggal='$today'");
    if (mysqli_num_rows($qCheckAbs) == 0) {
        // Insert into absensi
        mysqli_query($con, "INSERT INTO peg_absensi_harian (username, tanggal, waktu_buka, status_absen) VALUES ('$username', '$today', '$now', 'buka')");
        
        // Insert initial activity
        mysqli_query($con, "INSERT INTO peg_laporan_harian (username, tanggal, kegiatan, keterangan, waktu, status_kegiatan) 
                            VALUES ('$username', '$today', 'Absensi Masuk', 'Absen dibuka', '$now', 'proses')");
    }
    header("location:laporanHarian.php");
}

else if ($op == "tambah") {
    $kegiatan = mysqli_real_escape_string($con, $_POST['kegiatan']);
    $keterangan = mysqli_real_escape_string($con, $_POST['keterangan']);
    
    // Check attendance status
    $qCheck = mysqli_query($con, "SELECT * FROM peg_absensi_harian WHERE username='$username' AND tanggal='$today' AND status_absen='buka'");
    if (mysqli_num_rows($qCheck) > 0) {
        // Prevent duplicate spamming (same activity within 30 seconds for same user)
        $qDup = mysqli_query($con, "SELECT id FROM peg_laporan_harian 
                                    WHERE username='$username' AND tanggal='$today' AND kegiatan='$kegiatan' 
                                    AND keterangan='$keterangan' AND waktu >= DATE_SUB('$now', INTERVAL 30 SECOND)");
        if (mysqli_num_rows($qDup) == 0) {
            $evidence_name = "";
            if (!empty($_FILES['evidence']['name'])) {
                $emp_name = $_SESSION['nm_person'];
                $target_dir = "file_laporan_harian/" . $emp_name . "/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $ext = pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION);
                $evidence_name = "EV_" . $username . "_" . time() . "." . $ext;
                move_uploaded_file($_FILES['evidence']['tmp_name'], $target_dir . $evidence_name);
            }
            
            mysqli_query($con, "INSERT INTO peg_laporan_harian (username, tanggal, kegiatan, keterangan, evidence, waktu, status_kegiatan) 
                                VALUES ('$username', '$today', '$kegiatan', '$keterangan', '$evidence_name', '$now', 'proses')");
        }
    }
    header("location:laporanHarian.php");
}

else if ($op == "tutup_absen") {
     // Check if currently open
     $qCheckAbs = mysqli_query($con, "SELECT id FROM peg_absensi_harian WHERE username='$username' AND tanggal='$today' AND status_absen='buka'");
     if (mysqli_num_rows($qCheckAbs) > 0) {
         // Update absensi
         mysqli_query($con, "UPDATE peg_absensi_harian SET waktu_tutup='$now', status_absen='tutup' 
                             WHERE username='$username' AND tanggal='$today'");
         
         // Insert final activity
         mysqli_query($con, "INSERT INTO peg_laporan_harian (username, tanggal, kegiatan, keterangan, waktu, status_kegiatan) 
                             VALUES ('$username', '$today', 'Absensi Keluar', 'Absen ditutup', '$now', 'proses')");
     }
     header("location:laporanHarian.php");
}

else if ($op == "hapus") {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Only allow deletion if status is 'proses' and not a locked system activity
    $qCheck = mysqli_query($con, "SELECT * FROM peg_laporan_harian WHERE id='$id' AND username='$username' 
                                  AND status_kegiatan='proses' AND kegiatan NOT IN ('Absensi Masuk', 'Absensi Keluar')");
    if (mysqli_num_rows($qCheck) > 0) {
        $d = mysqli_fetch_array($qCheck);
        if ($d['evidence']) {
            $emp_name = $_SESSION['nm_person'];
            unlink("file_laporan_harian/" . $emp_name . "/" . $d['evidence']);
        }
        mysqli_query($con, "DELETE FROM peg_laporan_harian WHERE id='$id'");
    }
    header("location:laporanHarian.php");
}
?>
