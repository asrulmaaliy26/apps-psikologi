<?php
   include "koneksiAdm.php";
   
   $id= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
   $res = mysqli_query($GLOBALS["___mysqli_ston"], "select berkas from mag_upload_berkas where id='".mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id'])."' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['berkas'])>3)
   {
     if (file_exists($d['berkas'])) unlink($d['berkas']);
   }  
   
   $myquery =  "delete from mag_upload_berkas where id='$id' limit 1";
   $hapus = mysqli_query($GLOBALS["___mysqli_ston"], $myquery) or die ("gagal menghapus");
   header ("location:rekapUpload.php?message=notifDelete");
   ?>