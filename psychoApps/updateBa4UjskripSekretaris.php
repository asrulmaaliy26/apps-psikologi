<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$id=mysqli_real_escape_string($con, $_POST['id']);
$id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
$page=mysqli_real_escape_string($con, $_POST['page']);
$sekretaris4=mysqli_real_escape_string($con, $_POST['sekretaris4']);

$sql="UPDATE nilai_ujskrip SET sekretaris4='$sekretaris4' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$qmean = "select * from nilai_ujskrip WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$rmean = mysqli_query($con, $qmean)or die( mysqli_error($con));
$dmean = mysqli_fetch_assoc($rmean);

$nilai_sekretaris=$dmean['sekretaris1'] + $dmean['sekretaris2'] + $dmean['sekretaris3'] + $dmean['sekretaris4'] + $dmean['sekretaris5'] + $dmean['sekretaris6'] + $dmean['sekretaris7'] + $dmean['sekretaris8'] + $dmean['sekretaris9'] + $dmean['sekretaris10'];

$sql="UPDATE nilai_ujskrip SET nilai_sekretaris='$nilai_sekretaris' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$qpend =  "SELECT * FROM nilai_ujskrip WHERE id='$id' AND id_pendaftaran='$id_pendaftaran'";
$rpend = mysqli_query($con, $qpend);
$dpend = mysqli_fetch_array($rpend);

$nilai_ketua = $dpend['nilai_ketua'];
$nilai_sekretaris = $dpend['nilai_sekretaris'];
$nilai_utama = $dpend['nilai_utama'];

if($nilai_ketua=='0' && $nilai_sekretaris!='0' && $nilai_utama!='0') {$mean_nilai = ($nilai_sekretaris + $nilai_utama) / 2;}
elseif($nilai_ketua=='0' && $nilai_sekretaris=='0' && $nilai_utama!='0') {$mean_nilai = ($nilai_utama) / 1;}
elseif($nilai_ketua!='0' && $nilai_sekretaris=='0' && $nilai_utama=='0') {$mean_nilai = ($nilai_ketua) / 1;}
elseif($nilai_ketua!='0' && $nilai_sekretaris!='0' && $nilai_utama=='0') {$mean_nilai = ($nilai_ketua + $nilai_sekretaris) / 2;}
elseif($nilai_ketua!='0' && $nilai_sekretaris=='0' && $nilai_utama!='0') {$mean_nilai = ($nilai_ketua + $nilai_utama) / 2;}
elseif($nilai_ketua!='0' && $nilai_sekretaris!='0' && $nilai_utama=='0') {$mean_nilai = ($nilai_ketua + $nilai_sekretaris) / 2;}
elseif($nilai_ketua!='0' && $nilai_sekretaris=='0' && $nilai_utama=='0') {$mean_nilai = ($nilai_ketua) / 1;}
elseif($nilai_ketua=='0' && $nilai_sekretaris!='0' && $nilai_utama!='0') {$mean_nilai = ($nilai_sekretaris + $nilai_utama) / 2;}
elseif($nilai_ketua!='0' && $nilai_sekretaris=='0' && $nilai_utama!='0') {$mean_nilai = ($nilai_ketua + $nilai_utama) / 2;}
elseif($nilai_ketua=='0' && $nilai_sekretaris!='0' && $nilai_utama=='0') {$mean_nilai = ($nilai_sekretaris) / 1;}
elseif($nilai_ketua!='0' && $nilai_sekretaris=='0' && $nilai_utama=='0') {$mean_nilai = ($nilai_ketua) / 1;}
elseif($nilai_ketua=='0' && $nilai_sekretaris=='0' && $nilai_utama=='0') {$mean_nilai = ($nilai_ketua + $nilai_sekretaris + $nilai_utama) / 3;}
elseif($nilai_ketua!='0' && $nilai_sekretaris!='0' && $nilai_utama!='0') {$mean_nilai = ($nilai_ketua + $nilai_sekretaris + $nilai_utama) / 3;}

$sql1="UPDATE nilai_ujskrip SET mean_nilai='$mean_nilai' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));

header("location:baUjskripSekretaris.php?page=$page&id=$id_pendaftaran");
?>