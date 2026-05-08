<?php
include("koneksiAdm.php");

$id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);

// Matikan semua periode dulu
$query1 = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_thesis_camp SET status='2'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

// Aktifkan yang dipilih
$query2 = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_thesis_camp SET status='1' WHERE id='$id'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

header("location:rekapThesisCampAdm.php?message=notifEdit");
?>
