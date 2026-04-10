<?php
   include("contentsConAdm.php");
      
   $nm=mysqli_real_escape_string($con,  $_POST['nm']);
   $page=mysqli_real_escape_string($con,  $_POST['page']);
   $cekdata="SELECT nm FROM dt_pengawas_kompre WHERE nm LIKE '%$nm%'";
   $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));
   
   if(mysqli_num_rows($ada)>0)
   { header("location:rekapPengawasKompreAdm.php?page=$page&message=notifSama"); }

   else  {
   $query = mysqli_query($con, "INSERT INTO dt_pengawas_kompre(nm)" .
   "VALUES('$nm')") or DIE(mysqli_error($con));
   if ($query) {
   header("location:rekapPengawasKompreAdm.php?page=$page&message=notifInput");
     }
   }
   ?>