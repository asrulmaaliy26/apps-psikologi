<?php include( "contentsConAdm.php" );
  $page= mysqli_real_escape_string($con, $_POST['page']);
  $no_berkas= mysqli_real_escape_string($con, $_POST['no_berkas']);
  $tujuan= mysqli_real_escape_string($con, addslashes($_POST['tujuan']));
  $tgl_surat= mysqli_real_escape_string($con, $_POST['tgl_surat']);
  $split = explode('-', $tgl_surat);
  $bln_surat= mysqli_real_escape_string($con, $split['1']);
  $tahun= mysqli_real_escape_string($con, $split['2']);
  $jml_berkas= mysqli_real_escape_string($con, $_POST['jml_berkas']);
  $perihal= mysqli_real_escape_string($con, addslashes($_POST['perihal']));
  $ordner= mysqli_real_escape_string($con, $_POST['ordner']);
  $executor= mysqli_real_escape_string($con, $_POST['executor']);
  
  mysqli_query(
    $con,
    "INSERT into surat_keluar(no_berkas,tujuan,tgl_surat,bulan,tahun,jml_berkas,perihal,ordner,executor) values ('$no_berkas','$tujuan','$tgl_surat','$bln_surat','$tahun','$jml_berkas','$perihal','$ordner','$executor')") or die(mysqli_error($con));
    header("location:agendaSuratKeluarAdm.php?page=$page&message=notifInput");
 ?>