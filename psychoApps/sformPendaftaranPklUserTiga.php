<?php include( "contentsConAdm.php" );
$id = mysqli_real_escape_string($con, $_POST['id']);
$id_pkl = mysqli_real_escape_string($con, $_POST['id_pkl']);
$id_dpl = mysqli_real_escape_string($con, $_POST['id_dpl']);

$qryCount = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE id_pkl='$id_pkl' AND id_dpl='$id_dpl'";
$rCount = mysqli_query($con,  $qryCount )or DIE( mysqli_error($con) );
$dCount = mysqli_fetch_array( $rCount );
$jumData = $dCount['jumData'];

$qryKuota = "SELECT * FROM dpl_pkl WHERE id_pkl='$id_pkl' AND id='$id_dpl'";
$rKuota = mysqli_query($con,  $qryKuota )or DIE( mysqli_error($con) );
$dKuota = mysqli_fetch_array( $rKuota );
$kuota = $dKuota['kuota'];

$qNip = "SELECT * FROM dt_pegawai WHERE id='$dKuota[nip]'";
$rNip = mysqli_query($con,  $qNip )or DIE( mysqli_error($con) );
$dNip = mysqli_fetch_array( $rNip );
$nip = $dKuota['nip'];

if($jumData >= $kuota) {
   header("location:prePendaftaranPklUser.php?message=notifGagalKuota");}

else {

$myqry="UPDATE peserta_pkl SET dpl='$nip',id_dpl='$id_dpl' WHERE id='$id' LIMIT 1";
mysqli_query($con, $myqry) or die(mysqli_error($con));

$sqlTerisi="UPDATE dpl_pkl SET terisi=(SELECT COUNT(*) FROM peserta_pkl WHERE id_pkl='$id_pkl' AND id_dpl='$id_dpl') WHERE id_pkl='$id_pkl' AND id='$id_dpl' LIMIT 1";
$rTerisi = mysqli_query($con, $sqlTerisi) or die(mysqli_error($con));
header("location:prePendaftaranPklUser.php?message=notifEdit");}
   ?>