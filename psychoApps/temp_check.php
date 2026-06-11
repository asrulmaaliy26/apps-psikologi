<?php
include('contentsConAdm.php');
$res = mysqli_query($con, "SELECT id, nama, nama_tg, jabatan_instansi FROM dt_pegawai WHERE nama LIKE '%Mahmudah%' OR jabatan_instansi='1' OR jabatan_instansi='2'");
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
