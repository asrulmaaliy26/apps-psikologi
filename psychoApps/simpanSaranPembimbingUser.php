<?php
session_start();
if(empty($_SESSION['username'])){
  header("location:index.php");
  exit();
}
include("contentsConAdm.php");

$id_prop = mysqli_real_escape_string($con, $_POST['id_prop']);
$id_bimtek = mysqli_real_escape_string($con, $_POST['id_bimtek']);
$pembimbing_saran_1 = mysqli_real_escape_string($con, $_POST['pembimbing_saran_1']);
$pembimbing_saran_2 = mysqli_real_escape_string($con, $_POST['pembimbing_saran_2']);
$redirect_detail = isset($_POST['redirect_detail']) ? 1 : 0;

// Update the saran columns
$query = "UPDATE bimtek_pra_proposal SET 
          pembimbing_saran_1='$pembimbing_saran_1', 
          pembimbing_saran_2='$pembimbing_saran_2' 
          WHERE id='$id_prop'";

if(mysqli_query($con, $query)){
    if ($redirect_detail) {
        header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&msg=pembimbing_saved");
    } else {
        header("location:listPraPropBimtekUser.php?msg=pembimbing_saved");
    }
} else {
    if ($redirect_detail) {
        header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&error=db_error");
    } else {
        header("location:listPraPropBimtekUser.php?error=db_error");
    }
}
?>
