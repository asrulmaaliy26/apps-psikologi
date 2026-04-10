<?php
   include "koneksiAdm.php";

   $id_pendaftaran=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_pendaftaran']);
   $id_ujtes=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_ujtes']);
   $nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
   $page=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['page']);
   $validasi=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['validasi']);
   $tgl_selesai=date('d-m-Y');
   $thn_selesai=date('Y');
   $tgl_akhir=date('d-m-Y');
   $thn_akhir=date('Y');

   if($_POST['validasi']==1) {
   $qry="UPDATE mag_nilai_ujtes SET validasi='$validasi' WHERE id_pendaftaran='$id_pendaftaran'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $qry="UPDATE mag_pengelompokan_dosen_wali SET tgl_selesai='',thn_selesai='',status='1' WHERE nim='$nim'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $qry="UPDATE mag_pengelompokan_dospem_tesis SET tgl_akhir='',thn_akhir='',status='1' WHERE nim='$nim'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   header ("location:formPenilaianUjtesPerPeriode.php?id=$id_ujtes&page=$page&message=notifEdit");
   }
   else if($_POST['validasi']==2) {
   $qry="UPDATE mag_nilai_ujtes SET validasi='$validasi' WHERE id_pendaftaran='$id_pendaftaran'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $qry="UPDATE mag_pengelompokan_dosen_wali SET tgl_selesai='$tgl_selesai',thn_selesai='$thn_selesai',status='2' WHERE nim='$nim'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $qry="UPDATE mag_pengelompokan_dospem_tesis SET tgl_akhir='$tgl_akhir',thn_akhir='$thn_akhir',status='2' WHERE nim='$nim'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   header ("location:formPenilaianUjtesPerPeriode.php?id=$id_ujtes&page=$page&message=notifEdit");
   }
   ?>