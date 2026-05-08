<?php
  include("koneksiUser.php");
  
  if(isset($_POST['submit'])) {
    $id_tc = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_tc']);
    $nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
    $topik = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['topik']);
    $dospem1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem1']);
    $dospem2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem2']);
    $tahapan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tahapan']);
    $harapan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['harapan']);
    $tgl_daftar = date("Y-m-d H:i:s");
    
    // Check if already registered for this period
    $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM mag_peserta_thesis_camp WHERE id_periode_thesis_camp='$id_tc' AND nim='$nim'");
    if(mysqli_num_rows($cek) > 0) {
      header("location:formThesisCamp.php?message=notifSama");
    } else {
      $query = "INSERT INTO mag_peserta_thesis_camp (nim, id_periode_thesis_camp, topik, dospem1, dospem2, tahapan, harapan, tgl_daftar, status) 
                VALUES ('$nim', '$id_tc', '$topik', '$dospem1', '$dospem2', '$tahapan', '$harapan', '$tgl_daftar', '1')";
      
      mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      
      header("location:formThesisCamp.php?message=notifInput");
    }
  } else {
    header("location:dashboardUser.php");
  }
?>
