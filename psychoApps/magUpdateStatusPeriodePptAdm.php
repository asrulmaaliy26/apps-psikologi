<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $sql1="UPDATE mag_periode_pengajuan_dospem SET status='1' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $sql1) or die(mysqli_error($con));

   $sql2="UPDATE mag_periode_pengajuan_dospem SET status='2' WHERE id!='$id'";
   mysqli_query($con, $sql2) or die(mysqli_error($con));

   header ("location:magPeriodePptAdm.php?page=$page&message=notifEdit");
   ?>