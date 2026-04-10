<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$newDate = date("d-m-Y", strtotime($data['tgl_ujian']));

function bulanIndo($tanggal)
{
$bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
'September','Oktober','Nopember','Desember');
$split = explode('-', $tanggal);
return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
}
?>