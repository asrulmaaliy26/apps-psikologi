<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET['id']);
  
  // Delete details first to maintain integrity (if there are foreign keys, though usually these scripts just delete sequentially)
  mysqli_query($con, "DELETE FROM dt_pengajuan_penghapusan_bmn_detail WHERE id_pengajuan='$id'") or die ("gagal menghapus detail");
  
  // Delete the main request record
  $myquery = "DELETE FROM dt_pengajuan_penghapusan_bmn WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus pengajuan");

  header ("location:rekapPenghapusanBmnAdm.php?message=notifDelete");
?>
