<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
  $id_sempro=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['id_sempro']);
  $tahap=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['tahap']);
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tahap'].''.$_POST['ta']);
  $ta=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ta']);
  $start_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['start_datetime']);
  $end_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['end_datetime']);
  $lt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['lt']);
  $lb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['lb']);
  $lrt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['lrt']);
  $lrb=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['lrb']);
  $sut=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['sut']);
  $sub=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['sub']);

  $cekdata="SELECT tahap FROM mag_periode_pendaftaran_sempro WHERE tahap='$tahap' AND ta='$ta'";
  $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or DIE(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $cekta="SELECT status FROM dt_ta WHERE id='$ta'";
  $aktif=mysqli_query($GLOBALS["___mysqli_ston"], $cekta) or DIE(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  if(mysqli_num_rows($ada)>0)
  { 
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_pendaftaran_sempro SET start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id_sempro' LIMIT 1")  or DIE(mysqli_error($GLOBALS["___mysqli_ston"]));
   mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_grade_sempro SET lt='$lt', lb='$lb', lrt='$lrt', lrb='$lrb', sut='$sut', sub='$sub' WHERE id_sempro='$id_sempro' LIMIT 1")  or DIE(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:rekapPendSemproAdm.php?page=$page&message=notifSetengah"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:rekapPendSemproAdm.php?page=$page&message=notifTa"); }
  else  {
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET id_sempro='$id' WHERE id_sempro='$id_sempro'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_grade_sempro SET id_sempro='$id' WHERE id_sempro='$id_sempro'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_jadwal_sempro SET id_sempro='$id' WHERE id_sempro='$id_sempro'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_nilai_sempro SET id_sempro='$id' WHERE id_sempro='$id_sempro'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_pendaftaran_sempro SET id='$id',tahap='$tahap',ta='$ta',start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id_sempro' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_grade_sempro SET id_sempro='$id',lt='$lt', lb='$lb', lrt='$lrt', lrb='$lrb', sut='$sut', sub='$sub' WHERE id_sempro='$id' LIMIT 1")  or DIE(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:rekapPendSemproAdm.php?page=$page&message=notifEdit");
  }
  ?>