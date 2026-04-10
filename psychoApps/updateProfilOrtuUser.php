<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $nim=mysqli_real_escape_string($con, $_POST['nim']);
  $nama_ayah=mysqli_real_escape_string($con, $_POST['nama_ayah']);
  $pekerjaan_ayah=mysqli_real_escape_string($con, $_POST['pekerjaan_ayah']);
  $alamat_ayah=mysqli_real_escape_string($con, $_POST['alamat_ayah']);
  $telepon_ayah=mysqli_real_escape_string($con, $_POST['telepon_ayah']);
  $nama_ibu=mysqli_real_escape_string($con, $_POST['nama_ibu']);
  $pekerjaan_ibu=mysqli_real_escape_string($con, $_POST['pekerjaan_ibu']);
  $alamat_ibu=mysqli_real_escape_string($con, $_POST['alamat_ibu']);
  $telepon_ibu=mysqli_real_escape_string($con, $_POST['telepon_ibu']);

  $myqry="UPDATE dt_mhssw SET nama_ayah='$nama_ayah',pekerjaan_ayah='$pekerjaan_ayah',alamat_ayah='$alamat_ayah',telepon_ayah='$telepon_ayah',nama_ibu='$nama_ibu',pekerjaan_ibu='$pekerjaan_ibu',alamat_ibu='$alamat_ibu',telepon_ibu='$telepon_ibu' WHERE nim='$nim' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));

  header("location:profilOrtuUser.php?message=notifEdit");
?>