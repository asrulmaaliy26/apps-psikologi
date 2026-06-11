<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once dirname(__DIR__) . '/psychoApps/db_env.php';
list($dbserver, $dbusername, $dbpassword, $dbname) = psycho_db_config();
error_reporting(E_ALL ^ E_DEPRECATED);
($GLOBALS["___mysqli_ston"] = mysqli_connect($dbserver, $dbusername, $dbpassword))  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $dbname) or die  (mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_query($GLOBALS["___mysqli_ston"], "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

if(!isset($_SESSION['username'])) {
    header("location:admin.php");
}
if($_SESSION['status']!="1"){
    header("location:admin.php");
}
?>