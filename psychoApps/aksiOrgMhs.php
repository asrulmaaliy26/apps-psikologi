<?php
include("contentsConAdm.php");

$act = $_GET['act'];

if ($act == "addKat") {
    $nm = mysqli_real_escape_string($con, $_POST['nm']);
    mysqli_query($con, "INSERT INTO org_mhs_kat (nm) VALUES ('$nm')");
    header("location:kelolaKatOrgMhsAdm.php?message=notifAdd");
} elseif ($act == "editKat") {
    $id = $_POST['id'];
    $nm = mysqli_real_escape_string($con, $_POST['nm']);
    mysqli_query($con, "UPDATE org_mhs_kat SET nm='$nm' WHERE id='$id'");
    header("location:kelolaKatOrgMhsAdm.php?message=notifEdit");
} elseif ($act == "delKat") {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM org_mhs_kat WHERE id='$id'");
    header("location:kelolaKatOrgMhsAdm.php?message=notifDel");
} elseif ($act == "addRole") {
    $nm = mysqli_real_escape_string($con, $_POST['nm']);
    mysqli_query($con, "INSERT INTO org_mhs_role (nm) VALUES ('$nm')");
    header("location:kelolaRoleOrgMhsAdm.php?message=notifAdd");
} elseif ($act == "editRole") {
    $id = $_POST['id'];
    $nm = mysqli_real_escape_string($con, $_POST['nm']);
    mysqli_query($con, "UPDATE org_mhs_role SET nm='$nm' WHERE id='$id'");
    header("location:kelolaRoleOrgMhsAdm.php?message=notifEdit");
} elseif ($act == "delRole") {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM org_mhs_role WHERE id='$id'");
    header("location:kelolaRoleOrgMhsAdm.php?message=notifDel");
} elseif ($act == "addPers") {
    $nim = mysqli_real_escape_string($con, $_POST['nim']);
    $kat_id = $_POST['kat_id'];
    $role_id = $_POST['role_id'];
    mysqli_query($con, "INSERT INTO org_mhs_personalia (nim, kat_id, role_id) VALUES ('$nim', '$kat_id', '$role_id')");
    header("location:kelolaPersonaliaOrgMhsAdm.php?message=notifAdd");
} elseif ($act == "editPers") {
    $id = $_POST['id'];
    $nim = mysqli_real_escape_string($con, $_POST['nim']);
    $kat_id = $_POST['kat_id'];
    $role_id = $_POST['role_id'];
    mysqli_query($con, "UPDATE org_mhs_personalia SET nim='$nim', kat_id='$kat_id', role_id='$role_id' WHERE id='$id'");
    header("location:kelolaPersonaliaOrgMhsAdm.php?message=notifEdit");
} elseif ($act == "delPers") {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM org_mhs_personalia WHERE id='$id'");
    header("location:kelolaPersonaliaOrgMhsAdm.php?message=notifDel");
}
?>
