<?php
  include( "koneksiAdm.php" );
  
  $id= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
  $page= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['page']);
  $query = "SELECT * FROM mag_revisi_tesis WHERE id='$id'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dIdTesis = mysqli_fetch_assoc($r);
  
  $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT file_tesis FROM mag_revisi_tesis WHERE id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['file_tesis'])>3)
  {
    if (file_exists($d['file_tesis'])) unlink($d['file_tesis']);
  }  
  
  $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT file_form_revisi FROM mag_revisi_tesis WHERE id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d2=mysqli_fetch_assoc($res2);
  if (strlen($d2['file_form_revisi'])>3)
  {
    if (file_exists($d2['file_form_revisi'])) unlink($d2['file_form_revisi']);
  }  
  
  $myquery =  "DELETE FROM mag_revisi_tesis WHERE id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1";
  $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
  
  header ("location:rekapAllRevisiTesAdm.php?page=$page&message=notifDelete");
  ?>