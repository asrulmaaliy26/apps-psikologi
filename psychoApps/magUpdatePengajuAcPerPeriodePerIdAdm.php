<?php
  include( "contentsConAdm.php" );  
  $idPersonal=mysqli_real_escape_string($con, $_POST['idPersonal']);
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $page1=mysqli_real_escape_string($con, $_POST['page1']);
  $dosen_wali=mysqli_real_escape_string($con, $_POST['dosen_wali']);
  $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $thn_pengajuan=date('Y');
  
  $qdw = "SELECT * FROM mag_dosen_wali WHERE id='$dosen_wali'";
  $res = mysqli_query($con, $qdw);
  $ddw = mysqli_fetch_assoc($res);
  $nip_dosen_wali = $ddw['nip'];
  
  mysqli_query($con, "UPDATE mag_pengelompokan_dosen_wali SET dosen_wali='$dosen_wali',nip_dosen_wali='$nip_dosen_wali',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$idPersonal' LIMIT 1")  or die(mysqli_error($con));  
  header("location:magEditPengajuAcPerPeriodeAdm.php?id=$id&page=$page&page1=$page1&message=notifEdit");
  ?>