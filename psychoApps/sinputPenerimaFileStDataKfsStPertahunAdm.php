<?php
   include("contentsConAdm.php");
   
   $page_a = mysqli_real_escape_string($con,  $_POST[ 'page_a' ] );
   $thn_upload = mysqli_real_escape_string($con,  $_POST[ 'thn_upload' ] );
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $id_sending_surat=mysqli_real_escape_string($con, $_POST['id']);
   $jenis_surat_penerima=mysqli_real_escape_string($con, $_POST['jenis_surat']);
   $tgl_kirim= date('Y-m-d');
   $split = explode('-', $tgl_kirim);
   $bln_kirim= mysqli_real_escape_string($con, $split['1']);
   $thn_kirim= mysqli_real_escape_string($con, $split['0']);
   $catatan= mysqli_real_escape_string($con, $_POST['catatan']);
   $executor= mysqli_real_escape_string($con, $_POST['executor']);
   $editor= mysqli_real_escape_string($con, $_POST['editor']);

   if(isset($_POST['submit']))
   {
    $item = $_POST['item'];
    foreach($item as $items)
    {
      
      mysqli_query($con,
    "INSERT into penerima_surat(id_sending_surat,jenis_surat_penerima,penerima,tgl_kirim,bln_kirim,thn_kirim) values ('$id_sending_surat','$jenis_surat_penerima','$items','$tgl_kirim','$bln_kirim','$thn_kirim')") or die(mysqli_error($con));
    }
 }

   $qry="UPDATE sending_surat SET editor='$editor' WHERE id='$id_sending_surat' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));

   header("location:dataKfsStPertahunAdm.php?page_a=$page_a&thn_upload=$thn_upload&page=$page&message=notifInput");
   ?>