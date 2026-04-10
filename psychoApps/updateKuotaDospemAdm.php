<?php
   include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $id_periode=mysqli_real_escape_string($con, $_POST['id_periode']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $kuota1=mysqli_real_escape_string($con, $_POST['kuota1']);
   $kuota2=mysqli_real_escape_string($con, $_POST['kuota2']);
   
   $myquery = "SELECT * FROM dospem_skripsi WHERE id='$id'";
   $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
   $dataku = mysqli_fetch_assoc( $res );

   $qpengaju1 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataku[nip]' AND id_periode='$dataku[id_periode]'";
   $row1 = mysqli_query($con, $qpengaju1);
   $dpengaju1 = mysqli_fetch_array($row1);
   $jum1=$dpengaju1['jumData'];
                            
   $qpengaju2 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataku[nip]' AND id_periode='$dataku[id_periode]'";
   $row2 = mysqli_query($con, $qpengaju2);
   $dpengaju2 = mysqli_fetch_array($row2);
   $jum2=$dpengaju2['jumData'];

   if($_POST['kuota1'] < $dpengaju1['jumData'] || $_POST['kuota2'] < $dpengaju2['jumData']) {
   header ("location:editKuotaDospemAdm.php?id=$id&page=$page&message=notifGagal");}
   else {
   $qry="UPDATE dospem_skripsi SET kuota1='$kuota1',kuota2='$kuota2' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));  
   header ("location:dospemPerPeriodeAdm.php?id=$id_periode&page=$page&message=notifEdit");}
   ?>