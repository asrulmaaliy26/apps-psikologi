<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   
   $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['id']);
   $nip=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['nip']);
   $kuota1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['kuota1']);
   $kuota2=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['kuota2']);
   
   $cekdata="select nip FROM mag_dospem_tesis WHERE nip='$nip' AND id_periode='$id_periode'";
   $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   if(mysqli_num_rows($ada)>0)
   { header("location:ptPerPeriode.php?id=$id_periode&message=notifSama"); }

   else  {
   $query = mysqli_query($GLOBALS["___mysqli_ston"], "insert into mag_dospem_tesis(id_periode,nip,kuota1,kuota2)" .
   "values('$id_periode','$nip','$kuota1','$kuota2')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   if ($query) {
   header("location:ptPerPeriode.php?id=$id_periode&message=notifInput");
     }
   }
   ?>