<?php
// Dynamic Sidebar Loader based on User Level
if (!empty($_SESSION['level'])) {
    $level = $_SESSION['level'];
    if ($level == 1) {
        include("navSideBarDosen.php");
    } else if ($level == 2) {
        include("navSideBarUserS1.php");
    } else if ($level == 3) {
        include("navSideBarAdmBakS2.php");
    } else if ($level == 4) {
        include("navSideBarAdmKepeg.php");
    } else if ($level == 5) {
        include("navSideBarAdmBmn.php");
    } else if ($level == 6) {
        include("navSideBarAdmTaper.php");
    } else if ($level == 7) {
        include("navSideBarAdmBakS1.php");
    } else if ($level == 8) {
        include("navSideBarAdmBakS2.php");
    } else if ($level == 10 || $level === 'adminutama') {
        include("navSideBarAdminUtama.php");
    } else if ($level == 11) {
        include("navSideBarKaryawan.php");
    } else {
        include("navSideBarUserS1.php");
    }
}
?>
