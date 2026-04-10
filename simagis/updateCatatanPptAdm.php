<?php
  include( "koneksiAdm.php" );  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $catatan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['catatan']);
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);

  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_pengelompokan_dospem_tesis SET catatan='$catatan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  {
  header("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifEdit");
  }
  ?>