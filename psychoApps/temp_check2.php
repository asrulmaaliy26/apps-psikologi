<?php
include("conAdm.php");
// Disable strict mode for this session
mysqli_query($con, "SET sql_mode = ''");

mysqli_query($con, "UPDATE pendaftaran_pkl SET start_kegiatan = '2000-01-01' WHERE start_kegiatan = '0000-00-00'");
mysqli_query($con, "UPDATE pendaftaran_pkl SET end_kegiatan = '2000-01-01' WHERE end_kegiatan = '0000-00-00'");

$res1 = mysqli_query($con, "ALTER TABLE pendaftaran_pkl MODIFY start_kegiatan date DEFAULT NULL, MODIFY end_kegiatan date DEFAULT NULL, MODIFY passing_grade int DEFAULT 0");
if(!$res1) echo "Error PKL: " . mysqli_error($con) . "\n";
else echo "Success PKL\n";

$res2 = mysqli_query($con, "ALTER TABLE pendaftaran_kompre MODIFY passing_grade int DEFAULT 0");
if(!$res2) echo "Error Kompre: " . mysqli_error($con) . "\n";
else echo "Success Kompre\n";
?>
