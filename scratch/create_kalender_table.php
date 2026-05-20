<?php
include("c:/Users/losts/Desktop/apps-psikologi/psychoApps/conAdm.php");

$sql = "CREATE TABLE IF NOT EXISTS `kalender_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `color` varchar(50) DEFAULT '#3788d8',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($con, $sql)) {
    echo "Table kalender_kegiatan created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($con);
}
?>
