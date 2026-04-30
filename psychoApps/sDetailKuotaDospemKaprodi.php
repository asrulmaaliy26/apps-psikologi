<?php
include("contentsConAdm.php");

$nip = mysqli_real_escape_string($con, $_POST['nip']);
$id_per = mysqli_real_escape_string($con, $_POST['id_per']);
$kuota1 = mysqli_real_escape_string($con, $_POST['kuota1']);
$kuota2 = mysqli_real_escape_string($con, $_POST['kuota2']);
$page = mysqli_real_escape_string($con, $_POST['page']);

// Cek apakah sudah ada
$q_cek = mysqli_query($con, "SELECT id FROM dospem_skripsi WHERE nip='$nip' AND id_periode='$id_per'");
if (mysqli_num_rows($q_cek) > 0) {
    header("location:detailKuotaDospemKaprodi.php?id=$id_per&page=$page&message=notifSama");
} else {
    $sql = "INSERT INTO dospem_skripsi (nip, id_periode, kuota1, kuota2) VALUES ('$nip', '$id_per', '$kuota1', '$kuota2')";
    if (mysqli_query($con, $sql)) {
        header("location:detailKuotaDospemKaprodi.php?id=$id_per&page=$page&message=notifInput");
    } else {
        echo mysqli_error($con);
    }
}
?>
