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
  $status=mysqli_real_escape_string($con,  $_POST['status']);

  $cekdata="SELECT tahap FROM pengajuan_dospem WHERE tahap='$tahap' AND ta='$ta'";
  $ada=mysqli_query($con, $cekdata) or DIE(mysqli_error($con));
  
  $cekta="SELECT status FROM dt_ta WHERE id='$ta'";
  $aktif=mysqli_query($con, $cekta) or DIE(mysqli_error($con));
  
  if(mysqli_num_rows($ada)>0)
  { 
  mysqli_query($con, "UPDATE pengajuan_dospem SET syarat_sks='$syarat_sks',start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id' LIMIT 1")  or DIE(mysqli_error($con));
  header("location:pngjnDospemAdm.php?page=$page&message=notifSetengah"); }
  elseif(mysqli_num_rows($aktif)==0)
  { header("location:pngjnDospemAdm.php?page=$page&message=notifTa"); }
  else  {
  mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET id_periode='$id_periode' WHERE id_periode='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE dospem_skripsi SET id_periode='$id_periode' WHERE id_periode='$id'")  or die(mysqli_error($con));
  mysqli_query($con, "UPDATE pengajuan_dospem SET id='$id_periode',tahap='$tahap',ta='$ta',syarat_sks='$syarat_sks',start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con));
  header("location:pngjnDospemAdm.php?page=$page&message=notifEdit");
  }
  ?>