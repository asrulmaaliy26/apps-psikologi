<?php include( "contentsConAdm.php" );
  $id= mysqli_real_escape_string($con, $_GET['id']);
  $page_a=mysqli_real_escape_string($con, $_GET['page_a']);
  $tahun=mysqli_real_escape_string($con, $_GET['tahun']);
  $page= mysqli_real_escape_string($con, $_GET['page']);
  $res = mysqli_query($con, "SELECT berkas FROM surat_masuk WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['berkas'])>3)
  {
    if (file_exists($d['berkas'])) unlink($d['berkas']);
  }  
  
  $myquery =  "DELETE FROM surat_masuk WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");
  header("location:dataAsmPertahunAdm.php?page_a=$page_a&tahun=$tahun&page=$page&message=notifDelete");
  ?>