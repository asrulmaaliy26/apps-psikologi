<?php include( "contentsConAdm.php" );
  $id= mysqli_real_escape_string($con, $_GET['id']);
  $page= mysqli_real_escape_string($con, $_GET['page']);
  $res = mysqli_query($con, "SELECT berkas FROM surat_keluar WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['berkas'])>3)
  {
    if (file_exists($d['berkas'])) unlink($d['berkas']);
  }  
  
  $myquery =  "DELETE FROM surat_keluar WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
  header ("location:agendaSuratKeluarAdm.php?page=$page&message=notifDelete");
  ?>