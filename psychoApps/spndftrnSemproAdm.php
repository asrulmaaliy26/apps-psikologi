<?php include( "contentsConAdm.php" );
  $tahap=mysqli_real_escape_string($con,  $_POST['tahap']);
  $id=mysqli_real_escape_string($con, $_POST['tahap'].''.$_POST['ta']);
  $wd1=mysqli_real_escape_string($con,  $_POST['wd1']);
  $kaprodi=mysqli_real_escape_string($con,  $_POST['kaprodi']);
  $ta=mysqli_real_escape_string($con,  $_POST['ta']);
  $start_datetime=mysqli_real_escape_string($con,  $_POST['start_datetime']);
  $end_datetime=mysqli_real_escape_string($con,  $_POST['end_datetime']);
  $syarat_sks=mysqli_real_escape_string($con,  $_POST['syarat_sks']);
  $lt=mysqli_real_escape_string($con,  $_POST['lt']);
  $lb=mysqli_real_escape_string($con,  $_POST['lb']);
  $lrt=mysqli_real_escape_string($con,  $_POST['lrt']);
  $lrb=mysqli_real_escape_string($con,  $_POST['lrb']);
  $sut=mysqli_real_escape_string($con,  $_POST['sut']);
  $sub=mysqli_real_escape_string($con,  $_POST['sub']);
  $status=mysqli_real_escape_string($con,  $_POST['status']);
  
  $cekdata="SELECT id FROM pendaftaran_sempro WHERE id='$id'";
  $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));
  
  $cekta="SELECT status FROM dt_ta WHERE status='1'";
  $aktif=mysqli_query($con, $cekta) or die(mysqli_error($con));
  
  if(mysqli_num_rows($ada)>0)
  { header("location:pndftrnSemproAdm.php?message=notifSama"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:pndftrnSemproAdm.php?message=notifTa"); }
  
  else  {
  if($_POST['status']==1) {
    mysqli_query($con, "UPDATE pendaftaran_sempro SET status='2' WHERE status='1' LIMIT 1")  or die(mysqli_error($con));
    $query = mysqli_query($con, "INSERT INTO pendaftaran_sempro(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,wd1,kajur)" . "VALUES('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$wd1','$kaprodi')") or die(mysqli_error($con));
    $query = mysqli_query($con, "INSERT INTO grade_sempro(id_sempro,lt,lb,lrt,lrb,sut,sub)" . "VALUES('$id','$lt','$lb','$lrt','$lrb','$sut','$sub')") or die(mysqli_error($con));
  header("location:pndftrnSemproAdm.php?message=notifInput");
  }
  if($_POST['status']==2) {
   $query = mysqli_query($con, "INSERT INTO pendaftaran_sempro(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,wd1,kajur)" . "VALUES('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$wd1','$kaprodi')") or die(mysqli_error($con));
    $query = mysqli_query($con, "INSERT INTO grade_sempro(id_sempro,lt,lb,lrt,lrb,sut,sub)" . "VALUES('$id','$lt','$lb','$lrt','$lrb','$sut','$sub')") or die(mysqli_error($con));
  header("location:pndftrnSemproAdm.php?message=notifInput");
   }
  }
  ?>