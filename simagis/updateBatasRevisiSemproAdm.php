<?php
include("koneksiAdm.php");
$id_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_pendaftaran']);
$batas_revisi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['batas_revisi']);

if(!empty($batas_revisi) && !empty($id_pendaftaran)) {
    // Ensure date format is Y-m-d
    $formatted_date = date('Y-m-d', strtotime($batas_revisi));
    $query = "UPDATE mag_jadwal_sempro SET batas_revisi='$formatted_date' WHERE id_pendaftaran='$id_pendaftaran' LIMIT 1";
    mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    
    // Redirect back to the Semua Data tab
    header("location:rekapPendSemproAdm.php?message=notifEdit");
} else {
    header("location:rekapPendSemproAdm.php?message=notifGagal");
}
?>
