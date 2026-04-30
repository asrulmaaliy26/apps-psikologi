<?php
include("contentsConAdm.php");

$nip = mysqli_real_escape_string($con, $_GET['nip']);
$id_per = mysqli_real_escape_string($con, $_GET['id_per']);
$page = mysqli_real_escape_string($con, $_GET['page']);

// Cek apakah sudah ada (mencegah duplikasi)
$cek = mysqli_query($con, "SELECT id FROM dospem_skripsi WHERE nip='$nip' AND id_periode='$id_per'");
if (mysqli_num_rows($cek) == 0) {
    mysqli_query($con, "INSERT INTO dospem_skripsi (nip, id_periode, kuota1, kuota2) VALUES ('$nip', '$id_per', '0', '0')");
    $new_id = mysqli_insert_id($con);
} else {
    $d = mysqli_fetch_assoc($cek);
    $new_id = $d['id'];
}

// Redirect ke halaman edit agar user bisa langsung isi kuotanya
header("location:editKuotaDospemKaprodi.php?id=$new_id&id_per=$id_per&page=$page");
?>
