<?php include("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $kepakaran_mayor = mysqli_real_escape_string($con, $_POST['kepakaran_mayor']);
  $kepakaran_minor = mysqli_real_escape_string($con, $_POST['kepakaran_minor']);
  $trend_riset = mysqli_real_escape_string($con, $_POST['trend_riset']);

  $query = "UPDATE dt_pegawai SET 
            kepakaran_mayor = '$kepakaran_mayor', 
            kepakaran_minor = '$kepakaran_minor', 
            trend_riset = '$trend_riset' 
            WHERE id = '$id'";

  if(mysqli_query($con, $query)){
    header("location:dataDosenKepakaranAdm.php?message=notifUpdate");
  } else {
    echo "Error: " . mysqli_error($con);
  }
?>
