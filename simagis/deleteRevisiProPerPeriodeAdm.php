<?php
  include( "koneksiAdm.php" );
  
  $id= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
  $query = "SELECT * FROM mag_revisi_sempro WHERE id='$id'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dIdSempro = mysqli_fetch_assoc($r);
  $id_sempro=$dIdSempro['id_sempro'];
  
  $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT file_prop FROM mag_revisi_sempro WHERE id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['file_prop'])>3)
  {
    if (file_exists($d['file_prop'])) unlink($d['file_prop']);
  }  
  
  $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT file_form_revisi FROM mag_revisi_sempro WHERE id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d2=mysqli_fetch_assoc($res2);
  if (strlen($d2['file_form_revisi'])>3)
  {
    if (file_exists($d2['file_form_revisi'])) unlink($d2['file_form_revisi']);
  }  
  
  $myquery =  "DELETE FROM mag_revisi_sempro WHERE id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1";
  $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
  
  header ("location:detailRekapRevisiProPerPeriode.php?id_sempro=$id_sempro&message=notifDelete");
  ?>