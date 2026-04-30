<?php
include("../psychoApps/contentsConAdm.php");
$q = mysqli_query($con, "SELECT * FROM lab_booking_data");
if(mysqli_num_rows($q) == 0) {
    echo "No booking data found.";
} else {
    while($d = mysqli_fetch_assoc($q)) {
        print_r($d);
        echo "<br><br>";
    }
}
?>
