<?php
include("contentsConAdm.php");
$res = mysqli_query($con, "SHOW COLUMNS FROM dt_pegawai");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . "\n";
}
?>
