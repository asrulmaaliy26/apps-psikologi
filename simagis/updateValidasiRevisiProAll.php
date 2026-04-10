<?php
   include "koneksiAdm.php";

   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
   $page=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['page']);
   $cek=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);
   $tgl_cek=date('d-m-Y');    
   
   if($cek==1) {
   $qry="UPDATE mag_revisi_sempro SET cek='$cek',tgl_cek='' WHERE id='$id'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   header ("location:rekapAllRevisiProAdm.php?page=$page&message=notifEdit");   
   }
   else {
   $qry="UPDATE mag_revisi_sempro SET cek='$cek',tgl_cek='$tgl_cek' WHERE id='$id'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   header ("location:rekapAllRevisiProAdm.php?page=$page&message=notifEdit");
   }
?>