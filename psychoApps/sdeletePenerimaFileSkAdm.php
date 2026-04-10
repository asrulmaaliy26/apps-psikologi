<?php
   include("contentsConAdm.php");
   
   $id=implode("','", $_POST['item']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $editor= mysqli_real_escape_string($con, $_POST['editor']);

   $myquery =  "DELETE FROM penerima_surat WHERE id IN ('$id')";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

   $qry="UPDATE sending_surat SET editor='$editor' WHERE id='$id_sending_surat' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));

    header ("location:rekapKirimSuratKeputusanAdm.php?page=$page&message=notifDelete");
   ?>