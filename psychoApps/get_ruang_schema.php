<?php
require_once 'db_env.php';
list($h,$u,$p,$d) = psycho_db_config();
$con = mysqli_connect($h,$u,$p,$d);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
$res = mysqli_query($con, 'DESCRIBE dt_ruang');
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Default'] . "\n";
}
