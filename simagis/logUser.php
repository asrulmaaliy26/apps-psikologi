<?php
include "koneksiUser.php";

function antiinjection($data){
 
$filter_sql = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
 
return $filter_sql;}

$username=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], antiinjection($_POST['username']));
$password=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], antiinjection($_POST['password']));
$password=antiinjection(md5($password));

$op = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['op']);
if($op=="in"){
    $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$username' AND password='$password' LIMIT 1");
    if(mysqli_num_rows($cek)==1){
        $c = mysqli_fetch_array($cek);
        $_SESSION['nim'] = $c['nim'];
		$_SESSION['status'] = $c['status'];
		if($c['status']=="1"){
            header("location:dashboardUser.php");
        } else if($c['status']=="2"){
            header("location:http://psikologi.uin-malang.ac.id/ikapsi/index_alumni.php");
        }
	}
	else{
         die(header("location:index.php?message=notifLogin"));
    }
}
?>