<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   
   $qterpakai = "SELECT id_dpl FROM peserta_pkl WHERE id='$id'";
   $rterpakai = mysqli_query($con,  $qterpakai )or die( mysqli_error($con) );
   $dterpakai = mysqli_fetch_assoc( $rterpakai );

   $qterisi = "SELECT terisi FROM dpl_pkl WHERE id='$dterpakai[id_dpl]'";
   $rterisi = mysqli_query($con,  $qterisi )or die( mysqli_error($con) );
   $dterisi = mysqli_fetch_assoc( $rterisi );
   $terisi = $dterisi['terisi'] - 1;

   $myqry3="UPDATE dpl_pkl SET terisi='$terisi' WHERE id='$dterpakai[id_dpl]'";
   mysqli_query($con, $myqry3) or die(mysqli_error($con));

   $res1 = mysqli_query($con, "SELECT file_transkrip FROM peserta_pkl WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1");
   $d1=mysqli_fetch_assoc($res1);
   if (strlen($d1['file_transkrip'])>3)
   {
     if (file_exists($d1['file_transkrip'])) unlink($d1['file_transkrip']);
   }  

   $myquery =  "DELETE FROM peserta_pkl WHERE id='".mysqli_real_escape_string($con, $_GET['id'])."' LIMIT 1";
   $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

   header ("location:riwayatPendaftaranPklUser.php?message=notifDelete");
   ?>