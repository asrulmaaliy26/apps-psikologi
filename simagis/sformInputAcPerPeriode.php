<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   
   $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['id']);
   $nip=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['nip']);
   $kuota=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['kuota']);
   
   $cekdata="select nip FROM mag_dosen_wali WHERE nip='$nip' AND id_periode='$id_periode'";
   $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   if(mysqli_num_rows($ada)>0)
   { header("location:acPerPeriode.php?id=$id_periode&message=notifSama"); }

   else  {
   $query = mysqli_query($GLOBALS["___mysqli_ston"], "insert into mag_dosen_wali(id_periode,nip,kuota)" .
   "values('$id_periode','$nip','$kuota')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   if ($query) {
   header("location:acPerPeriode.php?id=$id_periode&message=notifInput");
     }
   }
   ?>