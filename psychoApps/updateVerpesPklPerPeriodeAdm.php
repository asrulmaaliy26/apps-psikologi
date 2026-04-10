<?php
  include ("contentsConAdm.php");
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $id_pendaftar = mysqli_real_escape_string($con, $_POST['id_pendaftar']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  $val_adm = mysqli_real_escape_string($con, $_POST['val_adm']);
  $tgl_validasi = date('Y-m-d');

  $qpeserta = "SELECT * FROM peserta_pkl WHERE id='$id_pendaftar'";
  $rpeserta = mysqli_query($con,  $qpeserta )or die( mysqli_error($con) );
  $dpeserta = mysqli_fetch_assoc( $rpeserta );

  $myqry1="UPDATE peserta_pkl SET val_adm='$val_adm',tgl_validasi='$tgl_validasi' WHERE id='$id_pendaftar' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  
  $qcekval = "SELECT val_adm FROM peserta_pkl WHERE id='$id_pendaftar'";
  $rcekval = mysqli_query($con,  $qcekval )or die( mysqli_error($con) );
  $dcekval = mysqli_fetch_assoc( $rcekval );
  
  if($dcekval['val_adm'] == '4') {
  
  $qterisi = "SELECT terisi FROM dpl_pkl WHERE id='$dpeserta[id_dpl]'";
  $rterisi = mysqli_query($con,  $qterisi )or die( mysqli_error($con) );
  $dterisi = mysqli_fetch_assoc( $rterisi );
  $terisi = $dterisi['terisi'] - 1;

  $myqry3="UPDATE dpl_pkl SET terisi='$terisi' WHERE id='$dpeserta[id_dpl]'";
  mysqli_query($con, $myqry3) or die(mysqli_error($con));

  $myqry2="UPDATE peserta_pkl SET dpl='',id_dpl='',tgl_validasi='',nilai='',statusform='1' WHERE id='$id_pendaftar' LIMIT 1";
  mysqli_query($con, $myqry2) or die(mysqli_error($con));
  }
  header("location:verpesPklPerPeriodeAdm.php?id=$id&page=$page&message=notifEdit");
  ?>