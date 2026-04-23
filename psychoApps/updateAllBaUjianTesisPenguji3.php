<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$id = mysqli_real_escape_string($con, $_POST['id']);
$id_pendaftaran = mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
$page = mysqli_real_escape_string($con, $_POST['page']);

// Get all scores and notes
$n1 = mysqli_real_escape_string($con, $_POST['nilai_penguji3_1']);
$n2 = mysqli_real_escape_string($con, $_POST['nilai_penguji3_2']);
$n3 = mysqli_real_escape_string($con, $_POST['nilai_penguji3_3']);
$n4 = mysqli_real_escape_string($con, $_POST['nilai_penguji3_4']);
$n5 = mysqli_real_escape_string($con, $_POST['nilai_penguji3_5']);
$n6 = mysqli_real_escape_string($con, $_POST['nilai_penguji3_6']);
$n7 = mysqli_real_escape_string($con, $_POST['nilai_penguji3_7']);

$c1 = mysqli_real_escape_string($con, $_POST['catatan_penguji3_1']);
$c2 = mysqli_real_escape_string($con, $_POST['catatan_penguji3_2']);
$c3 = mysqli_real_escape_string($con, $_POST['catatan_penguji3_3']);
$c4 = mysqli_real_escape_string($con, $_POST['catatan_penguji3_4']);
$c5 = mysqli_real_escape_string($con, $_POST['catatan_penguji3_5']);
$c6 = mysqli_real_escape_string($con, $_POST['catatan_penguji3_6']);
$c7 = mysqli_real_escape_string($con, $_POST['catatan_penguji3_7']);

// Update all fields for Penguji 3
$sql = "UPDATE mag_nilai_ujtes SET 
    nilai_penguji3_1='$n1', 
    nilai_penguji3_2='$n2', 
    nilai_penguji3_3='$n3', 
    nilai_penguji3_4='$n4', 
    nilai_penguji3_5='$n5', 
    nilai_penguji3_6='$n6', 
    nilai_penguji3_7='$n7',
    catatan_penguji3_1='$c1',
    catatan_penguji3_2='$c2',
    catatan_penguji3_3='$c3',
    catatan_penguji3_4='$c4',
    catatan_penguji3_5='$c5',
    catatan_penguji3_6='$c6',
    catatan_penguji3_7='$c7'
    WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
mysqli_query($con, $sql) or die(mysqli_error($con));

// Calculate mean for Penguji 3
$mean_nilai_penguji3 = ($n1 + $n2 + $n3 + $n4 + $n5 + $n6 + $n7) / 7;
$sql_mean3 = "UPDATE mag_nilai_ujtes SET mean_nilai_penguji3='$mean_nilai_penguji3' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
mysqli_query($con, $sql_mean3) or die(mysqli_error($con));

// Recalculate overall mean
$qpend = "SELECT * FROM mag_nilai_ujtes WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$rpend = mysqli_query($con, $qpend);
$dpend = mysqli_fetch_array($rpend);

$m1 = $dpend['mean_nilai_penguji1'];
$m2 = $dpend['mean_nilai_penguji2'];
$m3 = $dpend['mean_nilai_penguji3'];
$m4 = $dpend['mean_nilai_penguji4'];

$total_mean = 0;
$count_penguji = 0;

if ($m1 != 0) { $total_mean += $m1; $count_penguji++; }
if ($m2 != 0) { $total_mean += $m2; $count_penguji++; }
if ($m3 != 0) { $total_mean += $m3; $count_penguji++; }
if ($m4 != 0) { $total_mean += $m4; $count_penguji++; }

$mean_nilai = ($count_penguji > 0) ? ($total_mean / $count_penguji) : 0;

$sql_final = "UPDATE mag_nilai_ujtes SET mean_nilai='$mean_nilai' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
mysqli_query($con, $sql_final) or die(mysqli_error($con));

header("location:ba1UjianTesisPenguji3.php?page=$page&id=$id_pendaftaran");
?>
