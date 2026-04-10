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

  $cekdata="SELECT tahap FROM pendaftaran_skripsi WHERE tahap='$tahap' AND ta='$ta'";
  $ada=mysqli_query($con, $cekdata) or DIE(mysqli_error($con));
  
  $cekta="SELECT status FROM dt_ta WHERE id='$ta'";
  $aktif=mysqli_query($con, $cekta) or DIE(mysqli_error($con));
  
  if(mysqli_num_rows($ada)>0)
  { 
  mysqli_query($con, "UPDATE pendaftaran_skripsi SET syarat_sks='$syarat_sks',start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id' LIMIT 1")  or DIE(mysqli_error($con));
   mysqli_query($con, "UPDATE grade_ujskrip SET at='$at', ab='$ab', bplust='$bplust', bplusb='$bplusb', bt='$bt', bb='$bb', cplust='$cplust', cplusb='$cplusb', ct='$ct', cb='$cb', dt='$dt', db='$db' WHERE id_ujskrip='$id' LIMIT 1")  or DIE(mysqli_error($con));
  header("location:pndftrnUjskripAdm.php?page=$page&message=notifSetengah"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:pndftrnUjskripAdm.php?page=$page&message=notifTa"); }
  else  {
  mysqli_query($con, "UPDATE peserta_ujskrip SET id_ujskrip='$id_periode' WHERE id_ujskrip='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE grade_ujskrip SET id_ujskrip='$id_periode' WHERE id_ujskrip='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE jadwal_ujskrip SET id_ujskrip='$id_periode' WHERE id_ujskrip='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE nilai_ujskrip SET id_ujskrip='$id_periode' WHERE id_ujskrip='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE pendaftaran_skripsi SET id='$id_periode',tahap='$tahap',ta='$ta',syarat_sks='$syarat_sks',start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE grade_ujskrip SET at='$at', ab='$ab', bplust='$bplust', bplusb='$bplusb', bt='$bt', bb='$bb', cplust='$cplust', cplusb='$cplusb', ct='$ct', cb='$cb', dt='$dt', db='$db' WHERE id_ujskrip='$id_periode' LIMIT 1")  or DIE(mysqli_error($con));
  header("location:pndftrnUjskripAdm.php?page=$page&message=notifEdit");
  }
  ?>