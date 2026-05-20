<?php
  include "contentsConAdm.php";
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = mysqli_real_escape_string($con, $_POST['id']);
      $page = mysqli_real_escape_string($con, $_POST['page']);
      $target = mysqli_real_escape_string($con, $_POST['target']); // 1 or 2
      $new_dospem_id = mysqli_real_escape_string($con, $_POST['new_dospem_id']);
      
      // Get NIP of the new advisor
      $q = "SELECT nip FROM mag_dospem_tesis WHERE id='$new_dospem_id'";
      $r = mysqli_query($con, $q);
      $d = mysqli_fetch_assoc($r);
      
      if ($d) {
          $new_nip = $d['nip'];
          
          if ($target == '1') {
              $qry = "UPDATE mag_pengelompokan_dospem_tesis SET dospem_tesis1='$new_dospem_id', nip_dospem_tesis1='$new_nip', cek1='1' WHERE id='$id'";
          } else {
              $qry = "UPDATE mag_pengelompokan_dospem_tesis SET dospem_tesis2='$new_dospem_id', nip_dospem_tesis2='$new_nip', cek2='1' WHERE id='$id'";
          }
          
          mysqli_query($con, $qry) or die(mysqli_error($con));
          header("location:verPengDospemPerId.php?id=$id&page=$page&message=notifEdit");
          exit();
      } else {
          header("location:verPengDospemPerId.php?id=$id&page=$page&message=notifGagal");
          exit();
      }
  } else {
      header("location:verPengDospem.php");
      exit();
  }
?>
