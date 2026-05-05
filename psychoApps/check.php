<?php
require 'contentsConAdm.php';
$q = mysqli_query($con, "SELECT id, username, level FROM dt_all_adm");
while($r = mysqli_fetch_assoc($q)) {
    print_r($r);
}
?>
