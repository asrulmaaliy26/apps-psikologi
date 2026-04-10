<?php 
  include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_POST['tahap'].''.$_POST['ta']);
  $tahap=mysqli_real_escape_string($con,  $_POST['tahap']);
  $ta=mysqli_real_escape_string($con,  $_POST['ta']);
  $start_datetime=mysqli_real_escape_string($con,  $_POST['start_datetime']);
  $end_datetime=mysqli_real_escape_string($con,  $_POST['end_datetime']);
  $syarat_sks=mysqli_real_escape_string($con,  $_POST['syarat_sks']);
  $status=mysqli_real_escape_string($con,  $_POST['status']);
  $wd1=mysqli_real_escape_string($con,  $_POST['wd1']);
  $kaprodi=mysqli_real_escape_string($con,  $_POST['kaprodi']);
  
  $cekdata="SELECT id FROM pengajuan_dospem WHERE id='$id'";
  $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));
  
  $cekta="SELECT status FROM dt_ta WHERE status='1'";
  $aktif=mysqli_query($con, $cekta) or die(mysqli_error($con));
  
  if(mysqli_num_rows($ada)>0)
  { header("location:pngjnDospemAdm.php?message=notifSama"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:pngjnDospemAdm.php?message=notifTa"); }
  
  else  {
   if($_POST['status']==1) {
     mysqli_query($con, "UPDATE pengajuan_dospem SET status='2' WHERE status='1' LIMIT 1")  or die(mysqli_error($con));
     $query = mysqli_query($con, "INSERT INTO pengajuan_dospem(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,wd1,kaprodi)" . "values('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$wd1','$kaprodi')") or die(mysqli_error($con));
   header("location:pngjnDospemAdm.php?message=notifInput");
   }
   if($_POST['status']==2) {
     $query = mysqli_query($con, "INSERT INTO pengajuan_dospem(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,wd1,kaprodi)" . "values('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$wd1','$kaprodi')") or die(mysqli_error($con));
   header("location:pngjnDospemAdm.php?message=notifInput");
    }
  }
  ?>