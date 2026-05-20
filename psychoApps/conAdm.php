<?php
date_default_timezone_set('Asia/Jakarta');
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/db_env.php';
list($dbserver, $dbusername, $dbpassword, $dbname) = psycho_db_config('db_apps-psi');
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED);
($con = mysqli_connect($dbserver, $dbusername, $dbpassword))  or die(mysqli_error($con));
mysqli_select_db($con, $dbname) or die(mysqli_error($con));

// Session Recovery for Super Admin Switcher / Inconsistent Sessions
if (isset($_SESSION['username']) && (isset($_SESSION['is_superadmin']) || !isset($_SESSION['level']) || !isset($_SESSION['nm_person']))) {
    $us_recover = mysqli_real_escape_string($con, $_SESSION['username']);
    $q_recover = mysqli_query($con, "SELECT level, nm_person FROM dt_all_adm WHERE username='$us_recover' LIMIT 1");
    if ($d_recover = mysqli_fetch_array($q_recover)) {
        $_SESSION['level'] = $d_recover['level'];
        $_SESSION['nm_person'] = $d_recover['nm_person'];
    }
}

if (!function_exists('isFeatureEnabled')) {
    function isFeatureEnabled(string $featureName): bool {
        global $con;
        static $featuresCache = null;
        
        if ($featuresCache === null) {
            $featuresCache = [];
            $q = mysqli_query($con, "SELECT nama_fitur, status FROM pengaturan_fitur");
            if ($q) {
                while ($row = mysqli_fetch_assoc($q)) {
                    $featuresCache[$row['nama_fitur']] = (intval($row['status']) === 1);
                }
            }
        }
        
        return isset($featuresCache[$featureName]) ? $featuresCache[$featureName] : true;
    }
}

