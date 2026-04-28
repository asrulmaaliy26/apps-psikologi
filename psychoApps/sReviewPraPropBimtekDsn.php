<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];

$id_prop = mysqli_real_escape_string($con, $_POST['id_prop']);
$aksi = mysqli_real_escape_string($con, $_POST['aksi']); // 'terima' or 'revisi'
$catatan = mysqli_real_escape_string($con, $_POST['catatan']);
$tgl = date('Y-m-d H:i:s');

// Validate dosen owns this proposal
$q_check = mysqli_query($con, "SELECT id, id_bimtek FROM bimtek_pra_proposal WHERE id='$id_prop' AND id_reviewer='$username'");
if(mysqli_num_rows($q_check) == 0){
    header("location:reviewerBimtekDsn.php?error=unauthorized");
    exit();
}
$d_check = mysqli_fetch_assoc($q_check);
$id_bimtek = $d_check['id_bimtek'];

$a1 = (int)($_POST['a1_val'] ?? 0);
$a2 = (int)($_POST['a2_val'] ?? 0);
$a3 = (int)($_POST['a3_val'] ?? 0);
$a4 = (int)($_POST['a4_val'] ?? 0);
$a5 = (int)($_POST['a5_val'] ?? 0);
$a6 = (int)($_POST['a6_val'] ?? 0);
$nilai = (float)($_POST['nilai_akhir_val'] ?? 0);

if($aksi == 'terima'){
    mysqli_query($con, "UPDATE bimtek_pra_proposal SET 
        status='diterima', 
        catatan='', 
        a1='$a1', a2='$a2', a3='$a3', a4='$a4', a5='$a5', a6='$a6', 
        nilai_akhir='$nilai',
        tgl_update='$tgl' 
        WHERE id='$id_prop'");
} elseif($aksi == 'revisi'){
    mysqli_query($con, "UPDATE bimtek_pra_proposal SET 
        status='revisi', 
        catatan='$catatan', 
        a1='$a1', a2='$a2', a3='$a3', a4='$a4', a5='$a5', a6='$a6', 
        nilai_akhir='$nilai',
        tgl_update='$tgl' 
        WHERE id='$id_prop'");
}

header("location:reviewPraPropBimtekDsn.php?id=$id_prop&message=success");
?>
