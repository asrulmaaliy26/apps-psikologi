<?php
  include "koneksiAdm.php";
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $angkatan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['angkatan']);
  $verifikasi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['verifikasi']);
      
  $qry="UPDATE mag_pengelompokan_rumpun SET cek='$verifikasi' WHERE id='$id'";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header ("location:pprpPerAngkatan.php?id=$id&angkatan=$angkatan&message=notifEdit");
  ?>