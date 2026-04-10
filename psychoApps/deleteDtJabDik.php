<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
  $myquery =  "DELETE FROM opsi_jabatan WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery);

  header ("location:dtJabDik.php?message=notifDelete&page=$page");
  mysqli_close($con);
  ?>