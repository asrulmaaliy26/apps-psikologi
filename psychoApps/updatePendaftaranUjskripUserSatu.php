<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $nim = mysqli_real_escape_string($con, $_POST['nim']);
  $id_ujskrip = mysqli_real_escape_string($con, $_POST['id_ujskrip']);
  $judul_skripsi = mysqli_real_escape_string($con, $_POST['judul_skripsi']);
  $tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $split = explode('-', $tgl_pengajuan);
  $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
  $val_adm = '1';
  $statusform = '1';

  $myqry1="UPDATE peserta_ujskrip SET judul_skripsi='$judul_skripsi',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan',val_adm='$val_adm',statusform='$statusform' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));

  header("location:detailRiwayatPendaftaranUjskripUser.php?id=$id&message=notifEdit");
  ?>