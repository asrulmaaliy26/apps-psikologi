<?php
include("koneksiAdm.php");

$id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
$page = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['page']);

$query = mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM mag_periode_thesis_camp WHERE id='$id'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

header("location:rekapThesisCampAdm.php?message=notifDelete&page=$page");
?>
