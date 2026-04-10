<?php include( "contentsConAdm.php" );
  $id= mysqli_real_escape_string($con, $_GET['id']);
  $page= mysqli_real_escape_string($con, $_GET['page']);
  
  $res = mysqli_query($con, "SELECT image FROM dt_inventaris_barang WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['image'])>3)
  {
    if (file_exists($d['image'])) unlink($d['image']);
  }  

  $myquery =  "DELETE FROM dt_inventaris_barang WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

  header ("location:dtBarang.php?page=$page&message=notifDelete");
  ?>