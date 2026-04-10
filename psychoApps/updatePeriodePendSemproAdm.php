<?php
  include("contentsConAdm.php");
  $id=mysqli_real_escape_string($con,  $_POST['id']);
  $page=mysqli_real_escape_string($con,  $_POST['page']);
  $tahap=mysqli_real_escape_string($con,  $_POST['tahap']);
  $ta=mysqli_real_escape_string($con,  $_POST['ta']);
  $id_periode=mysqli_real_escape_string($con, $_POST['tahap'].''.$_POST['ta']);
  $start_datetime=mysqli_real_escape_string($con,  $_POST['start_datetime']);
  $end_datetime=mysqli_real_escape_string($con,  $_POST['end_datetime']);
  $syarat_sks=mysqli_real_escape_string($con,  $_POST['syarat_sks']);
  $lt=mysqli_real_escape_string($con,  $_POST['lt']);
  $lb=mysqli_real_escape_string($con,  $_POST['lb']);
  $lrt=mysqli_real_escape_string($con,  $_POST['lrt']);
  $lrb=mysqli_real_escape_string($con,  $_POST['lrb']);
  $sut=mysqli_real_escape_string($con,  $_POST['sut']);
  $sub=mysqli_real_escape_string($con,  $_POST['sub']);

  $cekdata="SELECT tahap FROM pendaftaran_sempro WHERE tahap='$tahap' AND ta='$ta'";
  $ada=mysqli_query($con, $cekdata) or DIE(mysqli_error($con));
  
  $cekta="SELECT status FROM dt_ta WHERE id='$ta'";
  $aktif=mysqli_query($con, $cekta) or DIE(mysqli_error($con));
  
  if(mysqli_num_rows($ada)>0)
  { 
  mysqli_query($con, "UPDATE pendaftaran_sempro SET syarat_sks='$syarat_sks',start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id' LIMIT 1")  or DIE(mysqli_error($con));
   mysqli_query($con, "UPDATE grade_sempro SET lt='$lt', lb='$lb', lrt='$lrt', lrb='$lrb', sut='$sut', sub='$sub' WHERE id_sempro='$id' LIMIT 1")  or DIE(mysqli_error($con));
  header("location:pndftrnSemproAdm.php?page=$page&message=notifSetengah"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:pndftrnSemproAdm.php?page=$page&message=notifTa"); }
  else  {
  mysqli_query($con, "UPDATE peserta_sempro SET id_sempro='$id_periode' WHERE id_sempro='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE grade_sempro SET id_sempro='$id_periode' WHERE id_sempro='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE jadwal_sempro SET id_sempro='$id_periode' WHERE id_sempro='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE nilai_sempro SET id_sempro='$id_periode' WHERE id_sempro='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE pendaftaran_sempro SET id='$id_periode',tahap='$tahap',ta='$ta',syarat_sks='$syarat_sks',start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE grade_sempro SET lt='$lt', lb='$lb', lrt='$lrt', lrb='$lrb', sut='$sut', sub='$sub' WHERE id_sempro='$id_periode' LIMIT 1")  or DIE(mysqli_error($con));
  header("location:pndftrnSemproAdm.php?page=$page&message=notifEdit");
  }
  ?>