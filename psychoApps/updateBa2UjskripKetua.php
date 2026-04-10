<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$id=mysqli_real_escape_string($con, $_POST['id']);
$id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
$page=mysqli_real_escape_string($con, $_POST['page']);
$ketua2=mysqli_real_escape_string($con, $_POST['ketua2']);

$sql="UPDATE nilai_ujskrip SET ketua2='$ketua2' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$qmean = "select * from nilai_ujskrip WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$rmean = mysqli_query($con, $qmean)or die( mysqli_error($con));
$dmean = mysqli_fetch_assoc($rmean);

$nilai_ketua=$dmean['ketua1'] + $dmean['ketua2'] + $dmean['ketua3'] + $dmean['ketua4'] + $dmean['ketua5'] + $dmean['ketua6'] + $dmean['ketua7'] + $dmean['ketua8'] + $dmean['ketua9'] + $dmean['ketua10'];

$sql="UPDATE nilai_ujskrip SET nilai_ketua='$nilai_ketua' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
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

header("location:baUjskripKetua.php?page=$page&id=$id_pendaftaran");
?>