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
   $at=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['at']);
   $ab=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ab']);
   $bplust=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['bplust']);
   $bplusb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['bplusb']);
   $bt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['bt']);
   $bb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['bb']);
   $cplust=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['cplust']);
   $cplusb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['cplusb']);
   $ct=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ct']);
   $cb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['cb']);
   $status="2";
   
   $cekdata="SELECT id FROM mag_periode_pendaftaran_ujtes WHERE id='$id'";
   $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $cekta="SELECT status FROM mag_dt_ta WHERE status='1'";
   $aktif=mysqli_query($GLOBALS["___mysqli_ston"], $cekta) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   if(mysqli_num_rows($ada)>0)
   { header("location:rekapPendUjtesAdm.php?message=notifSama"); }
   elseif(mysqli_num_rows($aktif)==0)
   { header("location:rekapPendUjtesAdm.php?message=notifTa"); }

   else  {

   $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_periode_pendaftaran_ujtes(id,tahap,ta,start_datetime,end_datetime,status,wd1,kaprodi)" .
   "values('$id','$tahap','$ta','$start_datetime','$end_datetime','$status','$wd1','$kaprodi')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_grade_ujtes(id_ujtes,at,ab,bplust,bplusb,bt,bb,cplust,cplusb,ct,cb)" . "VALUES('$id','$at','$ab','$bplust','$bplusb','$bt','$bb','$cplust','$cplusb','$ct','$cb')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   header("location:rekapPendUjtesAdm.php?message=notifInput");
   }
   ?>