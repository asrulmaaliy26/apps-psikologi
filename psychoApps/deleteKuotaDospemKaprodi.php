<?php
include("contentsConAdm.php");

$id = mysqli_real_escape_string($con, $_GET['id']);
$id_per = mysqli_real_escape_string($con, $_GET['id_per']);
$page = mysqli_real_escape_string($con, $_GET['page']);

$sql = "DELETE FROM dospem_skripsi WHERE id='$id'";
if (mysqli_query($con, $sql)) {
    header("location:detailKuotaDospemKaprodi.php?id=$id_per&page=$page&message=notifDelete");
} else {
    echo mysqli_error($con);
}
?>
