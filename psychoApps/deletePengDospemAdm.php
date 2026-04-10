<?php
  include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_GET['id']);
  $id_periode = mysqli_real_escape_string($con,  $_GET[ 'id_periode' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $res1 = mysqli_query($con, "SELECT file_prop FROM pengelompokan_dospem_skripsi WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d1=mysqli_fetch_assoc($res1);
  if (strlen($d1['file_prop'])>3)
  {
    if (file_exists($d1['file_prop'])) unlink($d1['file_prop']);
  }  
  
  $res2 = mysqli_query($con, "SELECT file_transkrip FROM pengelompokan_dospem_skripsi WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d2=mysqli_fetch_assoc($res2);
  if (strlen($d2['file_transkrip'])>3)
  {
    if (file_exists($d2['file_transkrip'])) unlink($d2['file_transkrip']);
  }
  
  $res3 = mysqli_query($con, "SELECT file_toefl_toafl FROM pengelompokan_dospem_skripsi WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d3=mysqli_fetch_assoc($res3);
  if (strlen($d3['file_toefl_toafl'])>3)
  {
    if (file_exists($d3['file_toefl_toafl'])) unlink($d3['file_toefl_toafl']);
  }
  
  $res4 = mysqli_query($con, "SELECT file_tashih FROM pengelompokan_dospem_skripsi WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d4=mysqli_fetch_assoc($res4);
  if (strlen($d4['file_tashih'])>3)
  {
    if (file_exists($d4['file_tashih'])) unlink($d4['file_tashih']);
  }
  
  $myquery =  "DELETE FROM pengelompokan_dospem_skripsi WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
  
  header("location:pngjnDospemPerPeriodeAdm.php?id=$id_periode&page=$page&message=notifDelete");
  ?>