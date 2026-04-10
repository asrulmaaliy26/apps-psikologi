<?php include( "contentsConAdm.php" );
  
  $idPersonal=mysqli_real_escape_string($con, $_POST['idPersonal']);
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $page1=mysqli_real_escape_string($con, $_POST['page1']);
  $cek=mysqli_real_escape_string($con, $_POST['cek']);
  $tgl_cek=date('d-m-Y');
  $thn_cek=date('Y');
  
  if($cek==1) {
  $query = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE id='$idPersonal'";
  $res =  mysqli_query($con, $query) or die(mysqli_error($con));
  $dt = mysqli_fetch_assoc($res) or die(mysqli_error($con));
  $status = $dt['status'];
  if($status==2) {
  header ("location:magVerPengajuAcPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifGagal");
  }  
  else {
  $qry="UPDATE mag_pengelompokan_dosen_wali SET cek='$cek',tgl_cek='',thn_cek='' WHERE id='$idPersonal'";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  
  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$id' AND cek='1'";
  $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
  $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
  $jumlahData1 = $dataku1['jumData'];
  if($jumlahData1==0) {
  header ("location:magVerPengajuAcPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifEdit");}
  if($jumlahData1 >0) {
  header ("location:magVerPengajuAcPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifEdit");} 
  }
  }
  else if($cek==2) { 
  $qry="UPDATE mag_pengelompokan_dosen_wali SET cek='$cek',tgl_cek='$tgl_cek',thn_cek='$thn_cek' WHERE id='$idPersonal'";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  
  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$id' AND cek='1'";
  $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
  $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
  $jumlahData1 = $dataku1['jumData'];
  if($jumlahData1==0) {
  header ("location:magVerPengajuAcPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifEdit");}
  if($jumlahData1 >0) {
  header ("location:magVerPengajuAcPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifEdit");} 
  }
  ?>