<?php
   include("contentsConAdm.php");
      
   $id=mysqli_real_escape_string($con,  $_POST['id']);
   $page=mysqli_real_escape_string($con,  $_POST['page']);
   $nip=mysqli_real_escape_string($con,  $_POST['nip']);
   $kuota1=mysqli_real_escape_string($con,  $_POST['kuota1']);
   $kuota2=mysqli_real_escape_string($con,  $_POST['kuota2']);
   
   $cekdata="SELECT nip FROM dospem_skripsi WHERE nip='$nip' AND id_periode='$id'";
   $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));

   if(mysqli_num_rows($ada)>0)
   { header("location:dospemPerPeriodeAdm.php?id=$id&page=$page&message=notifSama"); }

   else  {
   $query = mysqli_query($con, "INSERT INTO dospem_skripsi(id_periode,nip,kuota1,kuota2)" .
   "VALUES('$id','$nip','$kuota1','$kuota2')") or DIE(mysqli_error($con));
   if ($query) {
   header("location:dospemPerPeriodeAdm.php?id=$id&page=$page&message=notifInput");
     }
   }
   ?>