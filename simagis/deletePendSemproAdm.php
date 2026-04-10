<?php
  include( "koneksiAdm.php" );
  
  $id= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
  $query = "select * from mag_peserta_sempro WHERE id='$id'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dIdSempro = mysqli_fetch_assoc($r);
  $id_sempro=$dIdSempro['id_sempro'];
  
  $res = mysqli_query($GLOBALS["___mysqli_ston"], "select file_prop from mag_peserta_sempro where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['file_prop'])>3)
  {
    if (file_exists($d['file_prop'])) unlink($d['file_prop']);
  }  
  
  $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_toefl from mag_peserta_sempro where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d2=mysqli_fetch_assoc($res2);
  if (strlen($d2['file_toefl'])>3)
  {
    if (file_exists($d2['file_toefl'])) unlink($d2['file_toefl']);
  }  
  
  $res3 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_turnitin from mag_peserta_sempro where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d3=mysqli_fetch_assoc($res3);
  if (strlen($d3['file_turnitin'])>3)
  {
    if (file_exists($d3['file_turnitin'])) unlink($d3['file_turnitin']);
  } 
  
  $res4 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_transkrip from mag_peserta_sempro where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d4=mysqli_fetch_assoc($res4);
  if (strlen($d4['file_transkrip'])>3)
  {
    if (file_exists($d4['file_transkrip'])) unlink($d4['file_transkrip']);
  }

  $res5 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_audien from mag_peserta_sempro where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d5=mysqli_fetch_assoc($res5);
  if (strlen($d5['file_audien'])>3)
  {
    if (file_exists($d5['file_audien'])) unlink($d5['file_audien']);
  }

  $res6 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_diseminasi from mag_peserta_sempro where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d6=mysqli_fetch_assoc($res6);
  if (strlen($d6['file_diseminasi'])>3)
  {
    if (file_exists($d6['file_diseminasi'])) unlink($d6['file_diseminasi']);
  }

  $res7 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_publikasi from mag_peserta_sempro where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d7=mysqli_fetch_assoc($res7);
  if (strlen($d7['file_publikasi'])>3)
  {
    if (file_exists($d7['file_publikasi'])) unlink($d7['file_publikasi']);
  }

  $res8 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_kwitansi from mag_peserta_sempro where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d8=mysqli_fetch_assoc($res8);
  if (strlen($d8['file_kwitansi'])>3)
  {
    if (file_exists($d8['file_kwitansi'])) unlink($d8['file_kwitansi']);
  }
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
  $myquery =  "delete from mag_peserta_sempro where id='$id' limit 1";
  $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
  
  $qry =  "delete from mag_jadwal_sempro where id_pendaftaran='$id' limit 1";
  $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("gagal menghapus");
  
  $q =  "delete from mag_nilai_sempro where id_pendaftaran='$id' limit 1";
  $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die ("gagal menghapus");
  
  header ("location:pendaftarSemproPerPeriode.php?id=$id_sempro&message=notifDelete");
  ?>