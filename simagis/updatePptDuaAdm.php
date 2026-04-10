<?php
  include( "koneksiAdm.php" );  
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $dospem_tesis2=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem_tesis2']);
  $id_periode=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_periode']);
  
  $query1 = "SELECT dospem_tesis1 FROM mag_pengelompokan_dospem_tesis WHERE id='$id'";
  $has1 = mysqli_query($GLOBALS["___mysqli_ston"],  $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dt1 = mysqli_fetch_assoc($has1);
  $dospem1 = $dt1['dospem_tesis1'];
  
  $qNip2 = "SELECT nip FROM mag_dospem_tesis WHERE id='$_POST[dospem_tesis2]'";
  $rNip2 = mysqli_query($GLOBALS["___mysqli_ston"], $qNip2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dNip2 = mysqli_fetch_assoc($rNip2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $nip2 = $dNip2['nip'];

  $query2 = "SELECT dospem_tesis2 FROM mag_pengelompokan_dospem_tesis WHERE id='$id'";
  $has2 = mysqli_query($GLOBALS["___mysqli_ston"],  $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $dt2 = mysqli_fetch_assoc($has2);
  $dospem2 = $dt2['dospem_tesis2'];  
  
  $qry = "SELECT COUNT(dospem_tesis2) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$_POST[dospem_tesis2]' AND id_periode='$_POST[id_periode]' AND (cek2='1' OR cek2='2')";
  $res =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $data = mysqli_fetch_assoc($res) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $q = "SELECT kuota2 FROM mag_dospem_tesis WHERE id='$_POST[dospem_tesis2]' AND id_periode='$_POST[id_periode]'";
  $r =  mysqli_query($GLOBALS["___mysqli_ston"], $q) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $d = mysqli_fetch_assoc($r) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    
  if($_POST['dospem_tesis2'] == $dospem1)
  {
  header("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifGagalSama");
  }
  else if($data['jumData'] >= $d['kuota2']) 
  {
  header("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifGagalDospem");
  }
  else {
   mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_pengelompokan_dospem_tesis SET dospem_tesis2='$dospem_tesis2',nip_dospem_tesis2='$nip2' WHERE id='$id' LIMIT 1") or die(mysqli_error($GLOBALS["___mysqli_ston"]));  
  header("location:verifikasiEditPpt.php?id=$id&id_periode=$id_periode&message=notifEdit");
}
  ?>