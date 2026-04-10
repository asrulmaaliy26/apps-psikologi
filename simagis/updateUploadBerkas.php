<?php
   include "koneksiAdm.php";
    
   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
   $tbt= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tbt']); 	
   $split = explode('-', $tbt);
   $tgl= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $split['0']);
   $bln= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $split['1']);
   $tahun= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $split['2']);
   $deskripsi= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['deskripsi']);
   $kategori= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kategori']);
   $berkas=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['berkas']);
    
   $jenis_berkas = $_FILES['berkas']['type'];
   if ($jenis_berkas == "application/msword" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_berkas=="application/vnd.ms-excel" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $jenis_berkas=="application/vnd.ms-powerpoint" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.presentationml.presentation" || $jenis_berkas=="application/pdf" || $jenis_berkas=="application/vnd.rar" || $jenis_berkas=="application/zip" || $jenis_berkas=="application/x-7z-compressed" || $jenis_berkas=="image/jpeg" || $jenis_berkas=="application/rtf") {
   $myquery = "select * from mag_upload_berkas WHERE id='$id'";
   $r = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dt = mysqli_fetch_assoc( $r );
   $id_berkas=$dt['id'];
   $date=$dt['tbt'];
   $namafolder = "upload_berkas/";
   $temp = explode(".", $_FILES["berkas"]["name"]);
   $nama_baru = $id_berkas .uniqid().$date. '.' . end($temp);
   $berkas = $namafolder . $nama_baru;
   move_uploaded_file($_FILES['berkas']['tmp_name'], $namafolder . '/' . $nama_baru);
  
   $res = mysqli_query($GLOBALS["___mysqli_ston"], "select berkas from mag_upload_berkas where id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['berkas'])>3)
    {
      if (file_exists($d['berkas'])) unlink($d['berkas']);
    }
   mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_upload_berkas SET berkas='$berkas' WHERE id='$id' LIMIT 1");
    } else {
    header("location:pendaftarSemproPerPeriode.php?id=$id_berkas&message=notifGagal");
    }
    $myqry="UPDATE mag_upload_berkas SET tbt='$tbt',tgl='$tgl',bln='$bln',tahun='$tahun',deskripsi='$deskripsi',".
        "kategori='$kategori' WHERE id='$id' LIMIT 1";
    mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    header("location:rekapUpload.php?message=notifEdit");
    exit;
    ?>