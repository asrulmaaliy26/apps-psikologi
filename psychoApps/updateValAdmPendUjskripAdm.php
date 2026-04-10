<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftar = mysqli_real_escape_string($con, $_POST['id_pendaftar']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $val_adm = mysqli_real_escape_string($con, $_POST['val_adm']);
  $tgl_validasi = date('Y-m-d');

  $myqry1="UPDATE peserta_ujskrip SET val_adm='$val_adm',tgl_validasi='$tgl_validasi' WHERE id='$id_pendaftar' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  
  $qcekval = "SELECT val_adm FROM peserta_ujskrip WHERE id='$id_pendaftar'";
  $rcekval = mysqli_query($con,  $qcekval )or die( mysqli_error($con) );
  $dcekval = mysqli_fetch_assoc( $rcekval );
  
  if($dcekval['val_adm'] == '1') {
  $myqry2="UPDATE peserta_ujskrip SET id_jdwl='',tgl_validasi='',catatan='' WHERE id='$id_pendaftar' LIMIT 1";
  mysqli_query($con, $myqry2) or die(mysqli_error($con));}
  header("location:verPndftrUjskripPerPeriodeAdm.php?id=$id&page=$page&message=notifEdit");
  ?>