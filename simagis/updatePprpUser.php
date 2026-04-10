<?php
  include( "koneksiUser.php" );  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $rumpun=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['rumpun']);
  $tgl_pengajuan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_pengelompokan_rumpun SET rumpun='$rumpun',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {  
  header("location:formPengajuanPrp.php?message=notifEdit");
  }
  ?>