<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   
   $tahap=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['tahap']);
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tahap'].''.$_POST['ta']);
   $wd1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['wd1']);
   $kaprodi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['kaprodi']);
   $ta=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ta']);
   $start_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['start_datetime']);
   $end_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['end_datetime']);
   $lt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['lt']);
   $lb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['lb']);
   $lrt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['lrt']);
   $lrb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['lrb']);
   $sut=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['sut']);
   $sub=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['sub']);
   $status="2";
   
   $cekdata="select id from mag_periode_pendaftaran_sempro where id='$id'";
   $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $cekta="select status from mag_dt_ta where status='1'";
   $aktif=mysqli_query($GLOBALS["___mysqli_ston"], $cekta) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   if(mysqli_num_rows($ada)>0)
   { header("location:rekapPendSemproAdm.php?message=notifSama"); }
   elseif(mysqli_num_rows($aktif)==0)
   { header("location:rekapPendSemproAdm.php?message=notifTa"); }

   else  {

   $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_periode_pendaftaran_sempro(id,tahap,ta,start_datetime,end_datetime,status,wd1,kaprodi)" .
   "values('$id','$tahap','$ta','$start_datetime','$end_datetime','$status','$wd1','$kaprodi')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_grade_sempro(id_sempro,lt,lb,lrt,lrb,sut,sub)" . "VALUES('$id','$lt','$lb','$lrt','$lrb','$sut','$sub')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   header("location:rekapPendSemproAdm.php?message=notifInput");
   }
   ?>