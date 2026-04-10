<?php
   include("contentsConAdm.php");
      
   $id_kompre=mysqli_real_escape_string($con,  $_POST['id_kompre']);
   $page=mysqli_real_escape_string($con,  $_POST['page']);
   $pengawas1=mysqli_real_escape_string($con, $_POST['pengawas1']);
   $pengawas2=mysqli_real_escape_string($con, $_POST['pengawas2']);
   $ruang=mysqli_real_escape_string($con, $_POST['ruang']);
   $tgl_kompre=mysqli_real_escape_string($con, $_POST['tgl_kompre']);
   $jam_mulai=mysqli_real_escape_string($con, $_POST['jam_mulai']);
   $jam_selesai=mysqli_real_escape_string($con, $_POST['jam_selesai']);
   
   $cekdata="SELECT pengawas1,pengawas2,ruang,tgl_kompre,jam_mulai,jam_selesai FROM jadwal_kompre WHERE pengawas1='$pengawas1' AND pengawas2='$pengawas2' AND ruang='$ruang' AND tgl_kompre='$tgl_kompre' AND jam_mulai='$jam_mulai' AND jam_selesai='$jam_selesai'";
   $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));
   
   if(mysqli_num_rows($ada)>0)
   { header("location:jadKomprePerPeriodeAdm.php?id=$id_kompre&page=$page&message=notifSama"); }
      
   else  {
   $query = mysqli_query($con, "INSERT INTO jadwal_kompre(id_kompre,pengawas1,pengawas2,ruang,tgl_kompre,jam_mulai,jam_selesai)" .
   "VALUES('$id_kompre','$pengawas1','$pengawas2','$ruang','$tgl_kompre','$jam_mulai','$jam_selesai')") or DIE(mysqli_error($con));
   if ($query) {
   header("location:jadKomprePerPeriodeAdm.php?id=$id_kompre&page=$page&message=notifInput");
     }
   }
   ?>