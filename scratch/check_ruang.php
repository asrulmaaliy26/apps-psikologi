<?php
include("../psychoApps/contentsConAdm.php");
$q = mysqli_query($con, "SELECT id, id_ruang, nm FROM dt_ruang LIMIT 10");
while($d = mysqli_fetch_assoc($q)) {
    echo "ID: " . $d['id'] . " | ID_RUANG: " . $d['id_ruang'] . " | NAME: " . $d['nm'] . "<br>";
}
?>
