<?php
  include( "koneksiAdm.php" );
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
  $judul_tesis=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_tesis']);
  $outline_tesis=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['outline_tesis']);
  $verifikasi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['verifikasi']);
  $tgl_mulai=date('d-m-Y');
  $thn_mulai=date('Y');
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_pengelompokan_dospem_tesis SET judul_tesis='$judul_tesis',outline_tesis='$outline_tesis',cekjudul=$verifikasi,tgl_mulai='$tgl_mulai',thn_mulai='$thn_mulai' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {  
  header("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifEdit");
  }
  ?>