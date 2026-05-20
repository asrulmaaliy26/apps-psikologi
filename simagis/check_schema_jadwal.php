<?php
include("koneksiUser.php");
$res = mysqli_query($GLOBALS["___mysqli_ston"], "DESCRIBE mag_jadwal_sempro");
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
