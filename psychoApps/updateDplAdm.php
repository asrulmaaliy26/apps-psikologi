<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $id_pkl=mysqli_real_escape_string($con, $_POST['id_pkl']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $nip=mysqli_real_escape_string($con, $_POST['nip']);
   $lokasi=mysqli_real_escape_string($con, $_POST['lokasi']);
   $kuota=mysqli_real_escape_string($con,  $_POST['kuota']);

   $cekdata="SELECT nip FROM dpl_pkl WHERE nip='$nip' AND id_pkl='$id_pkl'";
   $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));

   $qry_terisi = "SELECT * FROM dpl_pkl WHERE id='$id'";
   $res_terisi = mysqli_query($con, $qry_terisi);
   $dt_terisi = mysqli_fetch_assoc($res_terisi);

   if(mysqli_real_escape_string($con,  $_POST['kuota']) < $dt_terisi['terisi'])
   {
   header("location:dplPerPeriodeAdm.php?id=$id_pkl&page=$page&message=notifGagal"); }

   elseif(mysqli_num_rows($ada)>0)
   {
   $qry1="UPDATE dpl_pkl SET lokasi='$lokasi',kuota='$kuota' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $qry1) or die(mysqli_error($con));
   header("location:dplPerPeriodeAdm.php?id=$id_pkl&page=$page&message=notifSetengah"); }

   else  {
   $qry2="UPDATE dpl_pkl SET nip='$nip',lokasi='$lokasi',kuota='$kuota' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $qry2) or die(mysqli_error($con));

   $qry3="UPDATE peserta_pkl SET dpl='$nip' WHERE id_dpl='$id'";
   mysqli_query($con, $qry3) or die(mysqli_error($con));
   header ("location:dplPerPeriodeAdm.php?id=$id_pkl&page=$page&message=notifEdit");
   }
   ?>