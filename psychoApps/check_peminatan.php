<?php
include("contentsConAdm.php");
$res = mysqli_query($con, "SELECT DISTINCT kepakaran_mayor FROM dt_pegawai");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['kepakaran_mayor'] . "\n";
}
echo "----\n";
$res2 = mysqli_query($con, "SELECT id, nm FROM opsi_bidang_skripsi");
while($row = mysqli_fetch_assoc($res2)) {
    echo $row['id'] . ": " . $row['nm'] . "\n";
}
?>
