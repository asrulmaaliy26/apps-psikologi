<?php
  include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_GET['id']);
  $id_pendaftar = mysqli_real_escape_string($con,  $_GET[ 'id_pendaftar' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $res1 = mysqli_query($con, "SELECT file_transkrip_nilai FROM peserta_kompre WHERE id='".mysqli_real_escape_string($con, $_GET['id_pendaftar'])."' LIMIT 1");
  $d1=mysqli_fetch_assoc($res1);
  if (strlen($d1['file_transkrip_nilai'])>3)
  {
    if (file_exists($d1['file_transkrip_nilai'])) unlink($d1['file_transkrip_nilai']);
  }
 
  $myquery =  "DELETE FROM peserta_kompre WHERE id='".mysqli_real_escape_string($con, $_GET['id_pendaftar'])."' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
  
  header("location:verpesKomprePerPeriodeAdm.php?id=$id&page=$page&message=notifDelete");
  ?>