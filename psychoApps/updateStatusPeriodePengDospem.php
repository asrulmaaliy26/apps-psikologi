<?php
  include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_GET['id']);
  $page=mysqli_real_escape_string($con, $_GET['page']);
  
  $sql1="UPDATE pengajuan_dospem SET status='1' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $sql1) or die(mysqli_error($con));
  
  $sql2="UPDATE pengajuan_dospem SET status='2' WHERE id!='$id'";
  mysqli_query($con, $sql2) or die(mysqli_error($con));
  
  header ("location:pngjnDospemAdm.php?message=notifUpdateStatus&page=$page");
  ?>