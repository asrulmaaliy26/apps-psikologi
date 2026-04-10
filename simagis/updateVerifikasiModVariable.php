<?php
   include "koneksiAdm.php";

   $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
   $cek=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);
   $page=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['page']);
   
   $qry="UPDATE mag_moderatorvariable SET cek='$cek' WHERE id='$id'";
   mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   header ("location:variabelmoderatorAdm.php?page=$page&message=notifEdit");
?>