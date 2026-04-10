<?php
  if(!isset($_SESSION)) 
     { 
         session_start(); 
     } 
  require_once dirname(__DIR__) . '/psychoApps/db_env.php';
  list($dbserver, $dbusername, $dbpassword, $dbname) = psycho_db_config('db_apps-psi');
  
  error_reporting(E_ALL ^ E_DEPRECATED);
  ($GLOBALS["___mysqli_ston"] = mysqli_connect($dbserver, $dbusername, $dbpassword))  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_select_db($GLOBALS["___mysqli_ston"], $dbname) or die  (mysqli_error($GLOBALS["___mysqli_ston"]));
  
  if(!isset($_SESSION['nim'])) {
     header("location:index.php");
  }
  if($_SESSION['status']!="1"){
     header("location:index.php");
  }
  ?>