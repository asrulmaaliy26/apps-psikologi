<?php include( "contentsConAdm.php" );
  
  $idPersonal=mysqli_real_escape_string($con, $_POST['idPersonal']);
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $page1=mysqli_real_escape_string($con, $_POST['page1']);
  $verifikasi_admin=mysqli_real_escape_string($con, $_POST['verifikasi_admin']);
  $tgl_mulai=date('d-m-Y');
  $thn_mulai=date('Y');
  
  $qry="UPDATE mag_pengelompokan_dospem_tesis SET verifikasi_admin='$verifikasi_admin',tgl_mulai='$tgl_mulai',thn_mulai='$thn_mulai' WHERE id='$idPersonal'";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  
  header ("location:magVerPengajuPtPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifEdit");
  ?>