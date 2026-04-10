<?php include( "contentsConAdm.php" );
  $tahap=mysqli_real_escape_string($con,  $_POST['tahap']);
  $id=mysqli_real_escape_string($con, $_POST['tahap'].''.$_POST['ta']);
  $ketua=mysqli_real_escape_string($con,  $_POST['ketua']);
  $wd1=mysqli_real_escape_string($con,  $_POST['wd1']);
  $kaprodi=mysqli_real_escape_string($con,  $_POST['kaprodi']);
  $ta=mysqli_real_escape_string($con,  $_POST['ta']);
  $start_datetime=mysqli_real_escape_string($con,  $_POST['start_datetime']);
  $end_datetime=mysqli_real_escape_string($con,  $_POST['end_datetime']);
  $syarat_sks=mysqli_real_escape_string($con,  $_POST['syarat_sks']);
  $at=mysqli_real_escape_string($con,  $_POST['at']);
  $ab=mysqli_real_escape_string($con,  $_POST['ab']);
  $bplust=mysqli_real_escape_string($con,  $_POST['bplust']);
  $bplusb=mysqli_real_escape_string($con,  $_POST['bplusb']);
  $bt=mysqli_real_escape_string($con,  $_POST['bt']);
  $bb=mysqli_real_escape_string($con,  $_POST['bb']);
  $cplust=mysqli_real_escape_string($con,  $_POST['cplust']);
  $cplusb=mysqli_real_escape_string($con,  $_POST['cplusb']);
  $ct=mysqli_real_escape_string($con,  $_POST['ct']);
  $cb=mysqli_real_escape_string($con,  $_POST['cb']);
  $dt=mysqli_real_escape_string($con,  $_POST['dt']);
  $db=mysqli_real_escape_string($con,  $_POST['db']);
  $status=mysqli_real_escape_string($con,  $_POST['status']);
  
  $cekdata="SELECT id FROM pendaftaran_pkl WHERE id='$id'";
  $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));
  
  $cekta="SELECT status FROM dt_ta WHERE status='1'";
  $aktif=mysqli_query($con, $cekta) or die(mysqli_error($con));
  
  if(mysqli_num_rows($ada)>0)
  { header("location:pndftrnPklAdm.php?message=notifSama"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:pndftrnPklAdm.php?message=notifTa"); }
  
  else  {
  if($_POST['status']==1) {
    mysqli_query($con, "UPDATE pendaftaran_pkl SET status='2' WHERE status='1' LIMIT 1")  or die(mysqli_error($con));
    $query = mysqli_query($con, "INSERT INTO pendaftaran_pkl(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,ketua,wd1,kajur)" . "VALUES('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$ketua','$wd1','$kaprodi')") or die(mysqli_error($con));
    $query = mysqli_query($con, "INSERT INTO grade_pkl(id_pkl,at,ab,bplust,bplusb,bt,bb,cplust,cplusb,ct,cb,dt,db)" . "VALUES('$id','$at','$ab','$bplust','$bplusb','$bt','$bb','$cplust','$cplusb','$ct','$cb','$dt','$db')") or die(mysqli_error($con));
  header("location:pndftrnPklAdm.php?message=notifInput");
  }
  if($_POST['status']==2) {
   $query = mysqli_query($con, "INSERT INTO pendaftaran_pkl(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,ketua,wd1,kajur)" . "VALUES('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$ketua','$wd1','$kaprodi')") or die(mysqli_error($con));
    $query = mysqli_query($con, "INSERT INTO grade_pkl(id_pkl,at,ab,bplust,bplusb,bt,bb,cplust,cplusb,ct,cb,dt,db)" . "VALUES('$id','$at','$ab','$bplust','$bplusb','$bt','$bb','$cplust','$cplusb','$ct','$cb','$dt','$db')") or die(mysqli_error($con));
  header("location:pndftrnPklAdm.php?message=notifInput");
   }
  }
  ?>