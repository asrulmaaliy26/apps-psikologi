<?php include( "contentsConAdm.php" );
  
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $angkatan=mysqli_real_escape_string($con, $_POST['angkatan']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $page1=mysqli_real_escape_string($con, $_POST['page1']);
  $cek=mysqli_real_escape_string($con, $_POST['cek']);
    
  $qry="UPDATE mag_pengelompokan_rumpun SET cek='$cek' WHERE id='$id'";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  header ("location:magVerPprpPerAngkatanAdm.php?id=$angkatan&page=$page&page1=$page1&message=notifEdit");
  ?>