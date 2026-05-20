<?php
session_start();
if(empty($_SESSION['username'])){
  header("location:index.php");
  exit();
}
include("contentsConAdm.php");

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Clear pembimbing choices
    $sql = "UPDATE bimtek_pra_proposal SET pembimbing_saran_1=NULL, pembimbing_saran_2=NULL WHERE id='$id'";
    if(mysqli_query($con, $sql)){
        header("location:rekapPraPropBimtekAdm.php?msg=reset_pembimbing");
    } else {
        header("location:rekapPraPropBimtekAdm.php?msg=error");
    }
} else {
    header("location:rekapPraPropBimtekAdm.php");
}
?>
