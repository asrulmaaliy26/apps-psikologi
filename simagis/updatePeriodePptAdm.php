<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['id']);
  $tahap=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['tahap']);
  $ta=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['ta']);
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tahap'].''.$_POST['ta']);
  $start_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['start_datetime']);
  $end_datetime=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['end_datetime']);
  $syarat_sks=mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_POST['syarat_sks']);
   
  $cekdata="SELECT tahap FROM mag_periode_pengajuan_dospem WHERE tahap='$tahap' AND ta='$ta'";
  $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $cekta="SELECT status FROM mag_dt_ta WHERE id='$ta'";
  $aktif=mysqli_query($GLOBALS["___mysqli_ston"], $cekta) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  if(mysqli_num_rows($ada)>0)
  { 
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_pengajuan_dospem SET start_datetime='$start_datetime',end_datetime='$end_datetime',syarat_sks='$syarat_sks' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:rekapPptAdm.php?message=notifSetengah"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:rekapPptAdm.php?message=notifTa"); }
  
  else  {
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_dospem_tesis SET id_periode='$id_periode' WHERE id_periode='$id'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_pengelompokan_dospem_tesis SET id_periode='$id_periode' WHERE id_periode='$id'")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_periode_pengajuan_dospem SET id='$id_periode',tahap='$tahap',ta='$ta',start_datetime='$start_datetime',end_datetime='$end_datetime',syarat_sks='$syarat_sks' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:rekapPptAdm.php?message=notifEdit");
  }
  ?>