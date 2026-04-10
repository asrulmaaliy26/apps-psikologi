<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $catatan = mysqli_real_escape_string($con, $_POST['catatan']);
  
  $myqry="UPDATE pengelompokan_dospem_skripsi SET catatan='$catatan' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  header("location:verifikasiPengDospemAdm.php?id=$id&page=$page&message=notifEdit");
  ?>