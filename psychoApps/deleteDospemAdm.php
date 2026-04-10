<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   $id_periode=mysqli_real_escape_string($con, $_GET['id_periode']);
   $page=mysqli_real_escape_string($con, $_GET['page']);
   
   $myquery =  "DELETE FROM dospem_skripsi WHERE nip='$id' AND id_periode='$id_periode' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or DIE ("gagal menghapus");
   header ("location:dospemPerPeriodeAdm.php?id=$id_periode&page=$page&message=notifDelete");
   ?>