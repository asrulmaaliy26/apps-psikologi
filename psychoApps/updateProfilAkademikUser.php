<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $nim=mysqli_real_escape_string($con, $_POST['nim']);
  $fakultas_pertama_daftar=mysqli_real_escape_string($con, $_POST['fakultas_pertama_daftar']);
  $jurusan_pertama_daftar=mysqli_real_escape_string($con, $_POST['jurusan_pertama_daftar']);
  $asal_sekolah=mysqli_real_escape_string($con, $_POST['asal_sekolah']);
  $pend_terakhir=mysqli_real_escape_string($con, $_POST['pend_terakhir']);
  $dosen_wali=mysqli_real_escape_string($con, $_POST['dosen_wali']);

  $myqry="UPDATE dt_mhssw SET fakultas_pertama_daftar='$fakultas_pertama_daftar',jurusan_pertama_daftar='$jurusan_pertama_daftar',asal_sekolah='$asal_sekolah',pend_terakhir='$pend_terakhir',dosen_wali='$dosen_wali' WHERE nim='$nim' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));

  header("location:profilAkademikUser.php?message=notifEdit");
?>