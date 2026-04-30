<?php
include("../psychoApps/contentsConAdm.php");

$sql = "ALTER TABLE lab_booking_data DROP COLUMN kelas";
if (mysqli_query($con, $sql)) {
    echo "Column 'kelas' dropped successfully from 'lab_booking_data'.<br>";
} else {
    echo "Error dropping column: " . mysqli_error($con) . "<br>";
}
?>
