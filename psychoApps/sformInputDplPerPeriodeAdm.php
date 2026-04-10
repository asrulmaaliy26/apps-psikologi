<?php
   include("contentsConAdm.php");
      
   $id=mysqli_real_escape_string($con,  $_POST['id']);
   $page=mysqli_real_escape_string($con,  $_POST['page']);
   $nip=mysqli_real_escape_string($con,  $_POST['nip']);
   $lokasi=mysqli_real_escape_string($con,  $_POST['lokasi']);
   $kuota=mysqli_real_escape_string($con,  $_POST['kuota']);
   
   /* Script sebelumnya 
   $cekdata="SELECT nip FROM dpl_pkl WHERE nip='$nip' AND id_pkl='$id'";
   $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));

   if(mysqli_num_rows($ada)>0)
   { header("location:dplPerPeriodeAdm.php?id=$id&page=$page&message=notifSama"); }

   else  {
   $query = mysqli_query($con, "INSERT INTO dpl_pkl(id_pkl,nip,lokasi,kuota)" .
   "VALUES('$id','$nip','$lokasi','$kuota')") or DIE(mysqli_error($con));
   if ($query) {
   header("location:dplPerPeriodeAdm.php?id=$id&page=$page&message=notifInput");
     }
   }
   */
   $query = mysqli_query($con, "INSERT INTO dpl_pkl(id_pkl,nip,lokasi,kuota)" .
   "VALUES('$id','$nip','$lokasi','$kuota')") or DIE(mysqli_error($con));
   if ($query) {
   header("location:dplPerPeriodeAdm.php?id=$id&page=$page&message=notifInput");
     }
   ?>