<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tahap'].''.$_POST['ta']);
   $tahap=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['tahap']);
   $wd1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['wd1']);
   $kaprodi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['kaprodi']);
   $ta=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ta']);
   $start_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['start_datetime']);
   $end_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['end_datetime']);
   $syarat_sks=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['syarat_sks']);
   $status="2";
   
   $cekdata="SELECT id FROM mag_periode_pengajuan_dospem WHERE id='$id'";
   $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $cekta="SELECT status FROM mag_dt_ta WHERE status='1'";
   $aktif=mysqli_query($GLOBALS["___mysqli_ston"], $cekta) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   if(mysqli_num_rows($ada)>0)
   { header("location:rekapPptAdm.php?message=notifSama"); }
   elseif(mysqli_num_rows($aktif)==0)
   { header("location:rekapPptAdm.php?message=notifTa"); }

   else  {
   $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO mag_periode_pengajuan_dospem(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,wd1,kaprodi)" .
   "values('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$wd1','$kaprodi')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   if ($query) {
   header("location:rekapPptAdm.php?message=notifInput");
     }
   }
   ?>