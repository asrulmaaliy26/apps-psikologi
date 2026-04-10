<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $start_datetime=mysqli_real_escape_string($con,  $_POST['start_datetime']);
   $end_datetime=mysqli_real_escape_string($con,  $_POST['end_datetime']);

   mysqli_query($con, "UPDATE mag_periode_pengajuan_ac SET start_datetime='$start_datetime',end_datetime='$end_datetime' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con));
   header ("location:magPeriodePacAdm.php?page=$page&message=notifEdit");
   ?>