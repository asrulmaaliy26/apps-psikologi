<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
  $id_ujtes=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['id_ujtes']);
  $tahap=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['tahap']);
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tahap'].''.$_POST['ta']);
  $ta=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ta']);
  $start_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['start_datetime']);
  $end_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['end_datetime']);
  $at=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['at']);
  $ab=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ab']);
  $bplust=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['bplust']);
  $bplusb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['bplusb']);
  $bt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['bt']);
  $bb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['bb']);
  $cplust=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['cplust']);
  $cplusb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['cplusb']);
  $ct=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ct']);
  $cb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['cb']);

  $cekdata="select tahap from mag_periode_pendaftaran_ujtes where tahap='$tahap' AND ta='$ta'";
  $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $cekta="select status from mag_dt_ta where id='$ta'";
  $aktif=mysqli_query($GLOBALS["___mysqli_ston"], $cekta) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  if(mysqli_num_rows($ada)>0)
  { 
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_pendaftaran_ujtes SET start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id_ujtes' LIMIT 1")  or DIE(mysqli_error($GLOBALS["___mysqli_ston"]));
   mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_grade_ujtes SET at='$at', ab='$ab', bplust='$bplust', bplusb='$bplusb', bt='$bt', bb='$bb', cplust='$cplust', cplusb='$cplusb', ct='$ct', cb='$cb' WHERE id_ujtes='$id_ujtes' LIMIT 1")  or DIE(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:rekapPendUjtesAdm.php?page=$page&message=notifSetengah"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:rekapPendUjtesAdm.php?page=$page&message=notifTa"); }
  else  {
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_ujtes SET id_ujtes='$id' WHERE id_ujtes='$id_ujtes'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_grade_ujtes SET id_ujtes='$id' WHERE id_ujtes='$id_ujtes'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_jadwal_ujtes SET id_ujtes='$id' WHERE id_ujtes='$id_ujtes'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_nilai_ujtes SET id_ujtes='$id' WHERE id_ujtes='$id_ujtes'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_pendaftaran_ujtes SET id='$id',tahap='$tahap',ta='$ta',start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id_ujtes' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_grade_ujtes SET id_ujtes='$id',at='$at', ab='$ab', bplust='$bplust', bplusb='$bplusb', bt='$bt', bb='$bb', cplust='$cplust', cplusb='$cplusb', ct='$ct', cb='$cb' WHERE id_ujtes='$id' LIMIT 1")  or DIE(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:rekapPendUjtesAdm.php?page=$page&message=notifEdit");
  }
  ?>