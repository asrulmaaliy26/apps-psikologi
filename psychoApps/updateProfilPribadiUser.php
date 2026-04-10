<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $nim=mysqli_real_escape_string($con, $_POST['nim']);
  $tempat_lahir=mysqli_real_escape_string($con, $_POST['tempat_lahir']);
  $tanggal_lahir=mysqli_real_escape_string($con, $_POST['tanggal_lahir']);
  $newDate = date("Y-m-d", strtotime($tanggal_lahir));
  $alamat_ktp=mysqli_real_escape_string($con, $_POST['alamat_ktp']);
  $alamat_malang=mysqli_real_escape_string($con, $_POST['alamat_malang']);
  $jenis_kelamin=mysqli_real_escape_string($con, $_POST['jenis_kelamin']);
  $kntk=mysqli_real_escape_string($con, $_POST['kntk']);
  $imel=mysqli_real_escape_string($con, $_POST['imel']);

  $myqry="UPDATE dt_mhssw SET tempat_lahir='$tempat_lahir',tanggal_lahir='$newDate',alamat_ktp='$alamat_ktp',alamat_malang='$alamat_malang',jenis_kelamin='$jenis_kelamin',kntk='$kntk',imel='$imel' WHERE nim='$nim' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));

  header("location:profilPribadiUser.php?message=notifEdit");
?>