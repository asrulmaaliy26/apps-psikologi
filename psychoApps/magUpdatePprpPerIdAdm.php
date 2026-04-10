<?php
  include( "contentsConAdm.php" );  
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $angkatan=mysqli_real_escape_string($con, $_POST['angkatan']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $page1=mysqli_real_escape_string($con, $_POST['page1']);
  $rumpun=mysqli_real_escape_string($con, $_POST['rumpun']);
  $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
  
  mysqli_query($con, "UPDATE mag_pengelompokan_rumpun SET rumpun='$rumpun',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con)); {  
  header("location:magEditPprpPerAngkatanAdm.php?id=$angkatan&page=$page&page1=$page1&message=notifEdit");
  }
  ?>