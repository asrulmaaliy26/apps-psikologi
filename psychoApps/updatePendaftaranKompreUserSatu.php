<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $nim = mysqli_real_escape_string($con, $_POST['nim']);
  $id_kompre = mysqli_real_escape_string($con, $_POST['id_kompre']);
  $sks_ditempuh = mysqli_real_escape_string($con, $_POST['sks_ditempuh']);
  $tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $split = explode('-', $tgl_pengajuan);
  $tgl= mysqli_real_escape_string($con, $split['0']);
  $bln= mysqli_real_escape_string($con, $split['1']);
  $thn= mysqli_real_escape_string($con, $split['2']);
  $val_adm = '1';
  $statusform = '1';

  $myqry1="UPDATE peserta_kompre SET sks_ditempuh='$sks_ditempuh',tgl_pengajuan='$tgl_pengajuan',tgl='$tgl',bln='$bln',thn='$thn',val_adm='$val_adm',statusform='$statusform' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));

  header("location:detailRiwayatPendaftaranKompreUser.php?id=$id&message=notifEdit");
  ?>