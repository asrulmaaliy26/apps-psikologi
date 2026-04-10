<?php
  include ("contentsConAdm.php");
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page_a= mysqli_real_escape_string($con, $_POST['page_a']);
  $tahun= mysqli_real_escape_string($con, $_POST['tahun']);
  $page= mysqli_real_escape_string($con, $_POST['page']);
  $catatan = mysqli_real_escape_string($con, $_POST['catatan']);
  
  $myqry="UPDATE siow_individu SET catatan='$catatan' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  header("location:dataIowiPertahunAdm.php?page_a=$page_a&tahun=$tahun&page=$page&message=notifCatatan");
  ?>