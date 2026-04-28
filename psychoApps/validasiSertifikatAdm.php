<?php
session_start();
if(empty($_SESSION['username'])){
  header("location:index.php");
  exit();
}
include("contentsConAdm.php");

$id = mysqli_real_escape_string($con, $_REQUEST['id'] ?? '');
$status = mysqli_real_escape_string($con, $_REQUEST['status'] ?? '');
$catatan = mysqli_real_escape_string($con, $_POST['catatan'] ?? '');

if($id && $status){
    mysqli_query($con, "UPDATE bimtek_pra_proposal SET 
        status_sertifikat='$status', 
        catatan_sertifikat='$catatan' 
        WHERE id='$id'");
    
    $msg = ($status == 'valid') ? 'approved' : 'rejected';
    header("location:rekapPraPropBimtekAdm.php?msg=$msg");
} else {
    header("location:rekapPraPropBimtekAdm.php");
}
?>
