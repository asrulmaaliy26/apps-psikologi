<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $myquery =  "DELETE FROM dt_pengawas_kompre WHERE id='$id' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or DIE ("gagal menghapus");
   header ("location:rekapPengawasKompreAdm.php?page=$page&message=notifDelete");
   ?>