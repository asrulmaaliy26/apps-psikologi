<?php
session_start();
if(empty($_SESSION['username'])){
  header("location:index.php");
  exit();
}
include("contentsConAdm.php");

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Get file names before deleting
    $q = mysqli_query($con, "SELECT file_proposal, file_sertifikat FROM bimtek_pra_proposal WHERE id='$id'");
    if($d = mysqli_fetch_assoc($q)){
        // Delete files from disk
        if($d['file_proposal'] && file_exists(__DIR__ . '/file_pra_proposal_bimtek/' . $d['file_proposal'])){
            unlink(__DIR__ . '/file_pra_proposal_bimtek/' . $d['file_proposal']);
        }
        if(!empty($d['file_sertifikat']) && file_exists(__DIR__ . '/file_pra_proposal_bimtek/' . $d['file_sertifikat'])){
            unlink(__DIR__ . '/file_pra_proposal_bimtek/' . $d['file_sertifikat']);
        }
        
        // Delete record from DB
        mysqli_query($con, "DELETE FROM bimtek_pra_proposal WHERE id='$id'");
        
        header("location:rekapPraPropBimtekAdm.php?msg=deleted");
    } else {
        header("location:rekapPraPropBimtekAdm.php?msg=notfound");
    }
} else {
    header("location:rekapPraPropBimtekAdm.php");
}
?>
