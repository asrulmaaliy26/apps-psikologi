<?php
include("contentsConAdm.php");

$id = mysqli_real_escape_string($con, $_POST['id']);
$id_per = mysqli_real_escape_string($con, $_POST['id_per']);
$kuota1 = mysqli_real_escape_string($con, $_POST['kuota1']);
$kuota2 = mysqli_real_escape_string($con, $_POST['kuota2']);
$page = mysqli_real_escape_string($con, $_POST['page']);

$sql = "UPDATE dospem_skripsi SET kuota1='$kuota1', kuota2='$kuota2' WHERE id='$id'";
if (mysqli_query($con, $sql)) {
    header("location:detailKuotaDospemKaprodi.php?id=$id_per&page=$page&message=notifEdit");
} else {
    echo mysqli_error($con);
}
?>
