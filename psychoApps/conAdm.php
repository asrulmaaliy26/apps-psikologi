<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once __DIR__ . '/db_env.php';
list($dbserver, $dbusername, $dbpassword, $dbname) = psycho_db_config('db_apps-psi');
error_reporting(E_ALL ^ E_DEPRECATED);
($con = mysqli_connect($dbserver, $dbusername, $dbpassword))  or die(mysqli_error($con));
mysqli_select_db($con, $dbname) or die  (mysqli_error($con));
?>