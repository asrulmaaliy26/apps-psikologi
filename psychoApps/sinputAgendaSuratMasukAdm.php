<?php include( "contentsConAdm.php" );
  $page= mysqli_real_escape_string($con, $_POST['page']);
  $tgl_terima= mysqli_real_escape_string($con, $_POST['tgl_terima']);
  $no_berkas= mysqli_real_escape_string($con, $_POST['no_berkas']);
  $pengirim= mysqli_real_escape_string($con, addslashes($_POST['pengirim']));
  $tgl_surat= mysqli_real_escape_string($con, $_POST['tgl_surat']);
  $split = explode('-', $tgl_surat);
  $bln_surat= mysqli_real_escape_string($con, $split['1']);
  $tahun= mysqli_real_escape_string($con, $split['2']);
  $no_surat= mysqli_real_escape_string($con, $_POST['no_surat']);
  $jml_berkas= mysqli_real_escape_string($con, $_POST['jml_berkas']);
  $perihal= mysqli_real_escape_string($con, addslashes($_POST['perihal']));
  $ordner= mysqli_real_escape_string($con, $_POST['ordner']);
  $executor= mysqli_real_escape_string($con, $_POST['executor']);
    mysqli_query(
    $con,
    "INSERT into surat_masuk(tgl_terima,no_berkas,pengirim,tgl_surat,bulan,tahun,no_surat,jml_berkas,perihal,ordner,executor) values ('$tgl_terima','$no_berkas','$pengirim','$tgl_surat','$bln_surat','$tahun','$no_surat','$jml_berkas','$perihal','$ordner','$executor')") or die(mysqli_error($con));
    header("location:agendaSuratMasukAdm.php?page=$page&message=notifInput");
 ?>