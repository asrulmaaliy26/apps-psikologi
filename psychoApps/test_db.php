<?php
session_start();
$_SESSION['username'] = 'admin';
include("contentsConAdm.php");

$q = mysqli_query($con, "SELECT nim, id_bimtek FROM bimtek_pra_proposal WHERE status='proses' LIMIT 1");
$r = mysqli_fetch_assoc($q);
if ($r) {
    $_GET['nim'] = $r['nim'];
    $_GET['id_bimtek'] = $r['id_bimtek'];
    include("getBimtekDetail.php");
} else {
    echo "No proses data found.";
}
?>
