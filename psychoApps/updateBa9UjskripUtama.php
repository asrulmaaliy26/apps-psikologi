<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$id=mysqli_real_escape_string($con, $_POST['id']);
$id_pendaftaran=mysqli_real_escape_string($con, $_POST['id_pendaftaran']);
$page=mysqli_real_escape_string($con, $_POST['page']);
$utama9=mysqli_real_escape_string($con, $_POST['utama9']);

$sql="UPDATE nilai_ujskrip SET utama9='$utama9' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$qmean = "select * from nilai_ujskrip WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
$rmean = mysqli_query($con, $qmean)or die( mysqli_error($con));
$dmean = mysqli_fetch_assoc($rmean);

$nilai_utama=$dmean['utama1'] + $dmean['utama2'] + $dmean['utama3'] + $dmean['utama4'] + $dmean['utama5'] + $dmean['utama6'] + $dmean['utama7'] + $dmean['utama8'] + $dmean['utama9'] + $dmean['utama10'];

$sql="UPDATE nilai_ujskrip SET nilai_utama='$nilai_utama' WHERE id='$id' AND id_pendaftaran='$id_pendaftaran' LIMIT 1";
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

header("location:baUjskripUtama.php?page=$page&id=$id_pendaftaran");
?>