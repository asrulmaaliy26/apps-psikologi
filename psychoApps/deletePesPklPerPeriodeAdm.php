<?php
  ob_start();
  include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_GET['id']);
  $id_pendaftar = mysqli_real_escape_string($con,  $_GET[ 'id_pendaftar' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  // Ambil id_dpl dari peserta yang akan dihapus
  $qterpakai = "SELECT id_dpl FROM peserta_pkl WHERE id='$id_pendaftar'";
  $rterpakai = mysqli_query($con,  $qterpakai ) or die( mysqli_error($con) );
  $dterpakai = mysqli_fetch_assoc( $rterpakai );

  // Kurangi slot terisi DPL, hanya jika id_dpl tidak kosong
  if (!empty($dterpakai['id_dpl'])) {
    $qterisi = "SELECT terisi FROM dpl_pkl WHERE id='$dterpakai[id_dpl]'";
    $rterisi = mysqli_query($con, $qterisi) or die( mysqli_error($con) );
    $dterisi = mysqli_fetch_assoc($rterisi);
    if ($dterisi) {
      $terisi = max(0, (int)$dterisi['terisi'] - 1);
      $myqry3 = "UPDATE dpl_pkl SET terisi='$terisi' WHERE id='$dterpakai[id_dpl]'";
      mysqli_query($con, $myqry3) or die(mysqli_error($con));
    }
  }

  // Hapus file transkrip jika ada
  $res1 = mysqli_query($con, "SELECT file_transkrip FROM peserta_pkl WHERE id='".mysqli_real_escape_string($con, $id_pendaftar)."' LIMIT 1");
  $d1 = mysqli_fetch_assoc($res1);
  if (!empty($d1['file_transkrip']) && strlen($d1['file_transkrip']) > 3) {
    if (file_exists($d1['file_transkrip'])) unlink($d1['file_transkrip']);
  }

  // Hapus data peserta
  $myquery = "DELETE FROM peserta_pkl WHERE id='".mysqli_real_escape_string($con, $id_pendaftar)."' LIMIT 1";
  mysqli_query($con, $myquery) or die("gagal menghapus");

  ob_end_clean();
  header("location:verpesPklPerPeriodeAdm.php?id=$id&page=$page&message=notifDelete");
  exit;
  ?>