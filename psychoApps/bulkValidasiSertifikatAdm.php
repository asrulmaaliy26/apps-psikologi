<?php
session_start();
if (empty($_SESSION['username'])) {
  header("location:index.php");
  exit();
}
include("contentsConAdm.php");

$ids = $_POST['ids'] ?? [];
$status = mysqli_real_escape_string($con, $_POST['status'] ?? '');

if (!empty($ids) && is_array($ids) && !empty($status)) {
  // Sanitize all IDs
  $sanitized_ids = array_map(function($id) use ($con) {
    return (int)mysqli_real_escape_string($con, $id);
  }, $ids);
  
  $id_list = implode(',', $sanitized_ids);
  
  $sql = "UPDATE bimtek_pra_proposal SET 
          status_sertifikat='$status' 
          WHERE id IN ($id_list)";
          
  if (mysqli_query($con, $sql)) {
    header("location:rekapPraPropBimtekAdm.php?msg=bulk_success");
  } else {
    header("location:rekapPraPropBimtekAdm.php?msg=error");
  }
} else {
  header("location:rekapPraPropBimtekAdm.php");
}
?>
