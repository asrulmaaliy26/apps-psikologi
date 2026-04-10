<?php include( "contentsConAdm.php" );
  $id= mysqli_real_escape_string($con, $_GET['id']);
  $page= mysqli_real_escape_string($con, $_GET['page']);
  
  $myquery =  "DELETE FROM opsi_kat_barang WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

  header ("location:opsiKatBarang.php?page=$page&message=notifDelete");
  ?>