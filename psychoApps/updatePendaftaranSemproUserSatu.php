<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $nim = mysqli_real_escape_string($con, $_POST['nim']);
  $id_sempro = mysqli_real_escape_string($con, $_POST['id_sempro']);
  $judul_prop = mysqli_real_escape_string($con, $_POST['judul_prop']);
  $tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $split = explode('-', $tgl_pengajuan);
  $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
  $val_adm = '1';
  $statusform = '1';

  $myqry1="UPDATE peserta_sempro SET judul_prop='$judul_prop',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan',val_adm='$val_adm',statusform='$statusform' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));

  header("location:detailRiwayatPendaftaranSemproUser.php?id=$id&message=notifEdit");
  ?>