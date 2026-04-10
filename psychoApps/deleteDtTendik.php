<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
  $qry = mysqli_query($con, "SELECT photo FROM dt_pegawai WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($qry);
  if (strlen($d['photo'])>3)
  {
    if (file_exists($d['photo'])) unlink($d['photo']);
  }  

  $myquery =  "DELETE FROM dt_pegawai WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery);

  header ("location:dtTendik.php?message=notifDelete&page=$page");
  mysqli_close($con);
  ?>