<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $id_pkl=mysqli_real_escape_string($con, $_GET['id_pkl']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $myquery1 =  "DELETE FROM dpl_pkl WHERE id='$id' LIMIT 1";
   $hapus1 = mysqli_query($con, $myquery1) or DIE ("gagal menghapus");

   $myquery2="UPDATE peserta_pkl SET dpl='',id_dpl='' WHERE id_dpl='$id'";
   mysqli_query($con, $myquery2) or die(mysqli_error($con));
   header ("location:dplPerPeriodeAdm.php?id=$id_pkl&page=$page&message=notifDelete");
   ?>