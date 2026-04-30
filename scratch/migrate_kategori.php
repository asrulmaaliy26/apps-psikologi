<?php
include("../psychoApps/contentsConAdm.php");

// Add kategori_peserta to lab_booking_data
$sql = "ALTER TABLE lab_booking_data ADD COLUMN kategori_peserta VARCHAR(50) DEFAULT NULL AFTER kelas";
if (mysqli_query($con, $sql)) {
    echo "Column 'kategori_peserta' added successfully to 'lab_booking_data'.<br>";
} else {
    echo "Error adding column: " . mysqli_error($con) . "<br>";
}
?>
