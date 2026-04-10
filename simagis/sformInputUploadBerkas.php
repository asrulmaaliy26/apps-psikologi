<?php
   include "koneksiAdm.php";
   
     $tbt= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tbt']); 	
     $split = explode('-', $tbt);
     $tgl= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $split['0']);
     $bln= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $split['1']);
     $tahun= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $split['2']);
     $deskripsi= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['deskripsi']);
     $kategori= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kategori']);
   
        if (!empty($_FILES["berkas"]["tmp_name"]))
        {
          $namafolder="upload_berkas/";
          $jenis_berkas=$_FILES['berkas']['type'];
          if($jenis_berkas=="application/msword" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_berkas=="application/vnd.ms-excel" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $jenis_berkas=="application/vnd.ms-powerpoint" || $jenis_berkas=="application/vnd.openxmlformats-officedocument.presentationml.presentation" || $jenis_berkas=="application/pdf" || $jenis_berkas=="application/vnd.rar" || $jenis_berkas=="application/zip" || $jenis_berkas=="application/x-7z-compressed" || $jenis_berkas=="image/jpeg" || $jenis_berkas=="application/rtf")
          {          
        $berkas = $namafolder .uniqid(). basename($_FILES['berkas']['name']);
        if (!move_uploaded_file($_FILES['berkas']['tmp_name'],$berkas))
        { die("Berkas gagal terupload"); }
          } else  { die("File tidak diizinkan!"); }
        } 
   
   mysqli_query($GLOBALS["___mysqli_ston"], "insert  into mag_upload_berkas(tbt,tgl,bln,tahun,deskripsi,kategori,berkas)" .
    "values('$tbt','$tgl','$bln','$tahun','$deskripsi','$kategori','$berkas')")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {
    header("location:rekapUpload.php?message=notifInput");
        }
    ?>