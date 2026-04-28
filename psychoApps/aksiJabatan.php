<?php
include("contentsConAdm.php");

$act = $_GET['act'];

if ($act == "add") {
    $nm = mysqli_real_escape_string($con, $_POST['nm']);
    mysqli_query($con, "INSERT INTO opsi_jabatan_instansi (nm) VALUES ('$nm')");
    header("location:kelolaJabatanAdm.php?message=notifAdd");
} elseif ($act == "edit") {
    $id = $_POST['id'];
    $nm = mysqli_real_escape_string($con, $_POST['nm']);
    mysqli_query($con, "UPDATE opsi_jabatan_instansi SET nm='$nm' WHERE id='$id'");
    header("location:kelolaJabatanAdm.php?message=notifEdit");
} elseif ($act == "del") {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM opsi_jabatan_instansi WHERE id='$id'");
    header("location:kelolaJabatanAdm.php?message=notifDel");
}
