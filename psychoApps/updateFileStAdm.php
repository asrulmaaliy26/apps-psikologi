<?php
   include("contentsConAdm.php");
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $deskripsi= mysqli_real_escape_string($con, addslashes($_POST['deskripsi']));
   $jenis_surat= mysqli_real_escape_string($con, $_POST['jenis_surat']);
   $tgl_upload= mysqli_real_escape_string($con, $_POST['tgl_upload']);
   $split = explode('-', $tgl_upload);
   $bln_upload= mysqli_real_escape_string($con, $split['1']);
   $thn_upload= mysqli_real_escape_string($con, $split['0']);
   $catatan= mysqli_real_escape_string($con, $_POST['catatan']);
   $editor= mysqli_real_escape_string($con, $_POST['editor']);
   $file_surat=mysqli_real_escape_string($con, $_POST['file_surat']);
    
   $jenis_berkas = $_FILES['file_surat']['type'];
   if ($jenis_berkas == "application/msword" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_berkas=="application/vnd.ms-excel" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $jenis_berkas=="application/vnd.ms-powerpoint" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.presentationml.presentation" || $jenis_berkas=="application/pdf" || $jenis_berkas=="application/vnd.rar" || $jenis_berkas=="application/zip" || $jenis_berkas=="application/x-7z-compressed" || $jenis_berkas=="image/jpeg" || $jenis_berkas=="application/rtf") {
   $myquery = "SELECT * FROM sending_surat WHERE id='$id'";
   $r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
   $dt = mysqli_fetch_assoc( $r );
   $id_berkas=$dt['id'];
   $date=$dt['tbt'];
   $namafolder = "file_surat_kirim/";
   $temp = explode(".", $_FILES["file_surat"]["name"]);
   $nama_baru = "ST_".$id_berkas .uniqid().$date. '.' . end($temp);
   $file_surat = $namafolder . $nama_baru;
   move_uploaded_file($_FILES['file_surat']['tmp_name'], $namafolder . '/' . $nama_baru);
  
   $res = mysqli_query($con, "SELECT file_surat FROM sending_surat where id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['file_surat'])>3)
    {
      if (file_exists($d['file_surat'])) unlink($d['file_surat']);
    }
   mysqli_query($con, "UPDATE sending_surat SET file_surat='$file_surat' WHERE id='$id' LIMIT 1");
    } else {
    header("location:rekapKirimSuratTugasAdm.php?page=$page&message=notifGagal");
    }
    $myqry="UPDATE sending_surat SET deskripsi='$deskripsi',tgl_upload='$tgl_upload',bln_upload='$bln_upload',thn_upload='$thn_upload',catatan='$catatan',editor='$editor' WHERE id='$id' LIMIT 1";
    mysqli_query($con, $myqry) or die(mysqli_error($con));
    header("location:rekapKirimSuratTugasAdm.php?page=$page&message=notifEdit");
    exit;
    ?>