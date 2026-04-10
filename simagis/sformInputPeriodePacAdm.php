<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   
   $ta=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ta']);
   $start_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['start_datetime']);
   $end_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['end_datetime']);
   $status="2";
   $wd1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['wd1']);
   $kaprodi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['kaprodi']);
   
   $cekdata="select id from mag_periode_pengajuan_ac where ta='$ta'";
   $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $cekta="select status from mag_dt_ta where status='1'";
   $aktif=mysqli_query($GLOBALS["___mysqli_ston"], $cekta) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   if(mysqli_num_rows($ada)>0)
   { header("location:rekapPacAdm.php?message=notifSama"); }
   elseif(mysqli_num_rows($aktif)==0)
   { header("location:rekapPacAdm.php?message=notifTa"); }

   else  {
   $query = mysqli_query($GLOBALS["___mysqli_ston"], "insert into mag_periode_pengajuan_ac(ta,start_datetime,end_datetime,status,wd1,kaprodi)" .
   "values('$ta','$start_datetime','$end_datetime','$status','$wd1','$kaprodi')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   if ($query) {
   header("location:rekapPacAdm.php?message=notifInput");
     }
   }
   ?>