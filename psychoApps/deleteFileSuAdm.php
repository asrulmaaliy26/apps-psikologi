<?php include( "contentsConAdm.php" );
  $id= mysqli_real_escape_string($con, $_GET['id']);
  $page= mysqli_real_escape_string($con, $_GET['page']);
  
  $res = mysqli_query($con, "SELECT file_surat FROM sending_surat WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['file_surat'])>3)
  {
    if (file_exists($d['file_surat'])) unlink($d['file_surat']);
  }  
  
  $myquery =  "DELETE FROM sending_surat WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

  $qry =  "DELETE FROM penerima_surat WHERE id_sending_surat='$id'";
  $delete = mysqli_query($con, $qry) or die ("gagal menghapus");

  header ("location:rekapKirimSuratUndAdm.php?page=$page&message=notifDelete");
  ?>