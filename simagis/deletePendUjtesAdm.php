<?php
  include( "koneksiAdm.php" );
  
  $id= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
  $query = "select * from mag_peserta_ujtes WHERE id='$id'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dIdUjtes = mysqli_fetch_assoc($r);
  $id_ujtes=$dIdUjtes['id_ujtes'];
  
  $res = mysqli_query($GLOBALS["___mysqli_ston"], "select file_tesis from mag_peserta_ujtes where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['file_tesis'])>3)
  {
    if (file_exists($d['file_tesis'])) unlink($d['file_tesis']);
  }  
   
  $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_turnitin from mag_peserta_ujtes where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d2=mysqli_fetch_assoc($res2);
  if (strlen($d2['file_turnitin'])>3)
  {
    if (file_exists($d2['file_turnitin'])) unlink($d2['file_turnitin']);
  }

  $res3 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_transkrip from mag_peserta_ujtes where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d3=mysqli_fetch_assoc($res3);
  if (strlen($d3['file_transkrip'])>3)
  {
    if (file_exists($d3['file_transkrip'])) unlink($d3['file_transkrip']);
  }
  
  $res5 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_jurnal from mag_peserta_ujtes where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d5=mysqli_fetch_assoc($res5);
  if (strlen($d5['file_jurnal'])>3)
  {
    if (file_exists($d5['file_jurnal'])) unlink($d5['file_jurnal']);
  }

  $res6 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_contoh_jurnal from mag_peserta_ujtes where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d6=mysqli_fetch_assoc($res6);
  if (strlen($d6['file_contoh_jurnal'])>3)
  {
    if (file_exists($d6['file_contoh_jurnal'])) unlink($d6['file_contoh_jurnal']);
  }

  $res4 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_kwitansi from mag_peserta_ujtes where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
  $d4=mysqli_fetch_assoc($res4);
  if (strlen($d4['file_kwitansi'])>3)
  {
    if (file_exists($d4['file_kwitansi'])) unlink($d4['file_kwitansi']);
  }

  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
  $myquery =  "delete from mag_peserta_ujtes where id='$id' limit 1";
  $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
  
  $qry =  "delete from mag_jadwal_ujtes where id_pendaftaran='$id' limit 1";
  $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("gagal menghapus");
  
  $q =  "delete from mag_nilai_ujtes where id_pendaftaran='$id' limit 1";
  $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die ("gagal menghapus");
  
  header ("location:pendaftarUjtesPerPeriode.php?id=$id_ujtes&message=notifDelete");
  ?>