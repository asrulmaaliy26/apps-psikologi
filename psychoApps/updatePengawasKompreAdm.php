<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $nm = mysqli_real_escape_string($con, $_POST['nm']);

  $myqry="UPDATE dt_pengawas_kompre SET nm='$nm' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  header("location:rekapPengawasKompreAdm.php?page=$page&message=notifEdit");
  ?>