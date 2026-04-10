<?php include( "contentsConAdm.php" );
  $page= mysqli_real_escape_string($con, $_POST['page']);
  $deskripsi= mysqli_real_escape_string($con, addslashes($_POST['deskripsi']));
  $jenis_surat= mysqli_real_escape_string($con, $_POST['jenis_surat']);
  $tgl_upload= mysqli_real_escape_string($con, $_POST['tgl_upload']);
  $split = explode('-', $tgl_upload);
  $bln_upload= mysqli_real_escape_string($con, $split['1']);
  $thn_upload= mysqli_real_escape_string($con, $split['0']);
  $catatan= mysqli_real_escape_string($con, $_POST['catatan']);
  $executor= mysqli_real_escape_string($con, $_POST['executor']);
  
  $namafolder = "file_surat_kirim/";
  $jenis_berkas = $_FILES['file_surat']['type'];
  
  if ($jenis_berkas == "application/msword" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_berkas=="application/vnd.ms-excel" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $jenis_berkas=="application/vnd.ms-powerpoint" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.presentationml.presentation" || $jenis_berkas=="application/pdf" || $jenis_berkas=="application/vnd.rar" || $jenis_berkas=="application/zip" || $jenis_berkas=="application/x-7z-compressed" || $jenis_berkas=="image/jpeg" || $jenis_berkas=="application/rtf") {
  
  $temp = explode(".", $_FILES["file_surat"]["name"]);
  $nama_baru = 'SU_' . uniqid() . '.' . end($temp);
  $file_surat = $namafolder . $nama_baru;
  move_uploaded_file($_FILES['file_surat']['tmp_name'], $namafolder . '/' . $nama_baru);

  mysqli_query(
    $con,
    "INSERT into sending_surat(deskripsi,jenis_surat,file_surat,tgl_upload,bln_upload,thn_upload,catatan,executor) values ('$deskripsi','$jenis_surat','$file_surat','$tgl_upload','$bln_upload','$thn_upload','$catatan','$executor')") or die(mysqli_error($con));
  header("location:rekapKirimSuratUndAdm.php?page=$page&message=notifInput");
  }
  else {
  header("location:rekapKirimSuratUndAdm.php?page=$page&message=notifGagal");
  }
 ?>