<?php
   include "koneksiAdm.php";

   $id_pendaftaran=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_pendaftaran']);
   $id_sempro=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_sempro']);
   $page=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['page']);
   $validasi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['validasi']);
       
   $qry="UPDATE mag_nilai_sempro SET validasi='$validasi' WHERE id_pendaftaran='$id_pendaftaran'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 
   header ("location:formPenilaianSemproPerPeriode.php?id=$id_sempro&page=$page&message=notifEdit");
   ?>