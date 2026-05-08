<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   
   $ta=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ta']);
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], 'TC'.$_POST['ta']);
   $start_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['start_datetime']);
   $end_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['end_datetime']);
   $status="2";
   
   $cekdata="select id from mag_periode_thesis_camp where id='$id'";
   $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $cekta="select status from mag_dt_ta where status='1'";
   $aktif=mysqli_query($GLOBALS["___mysqli_ston"], $cekta) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   if(mysqli_num_rows($ada)>0)
   { header("location:rekapThesisCampAdm.php?message=notifSama"); }
   elseif(mysqli_num_rows($aktif)==0)
   { header("location:rekapThesisCampAdm.php?message=notifTa"); }

   else  {
   $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_periode_thesis_camp(id,ta,start_datetime,end_datetime,status)" .
   "values('$id','$ta','$start_datetime','$end_datetime','$status')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   header("location:rekapThesisCampAdm.php?message=notifInput");
   }
?>
