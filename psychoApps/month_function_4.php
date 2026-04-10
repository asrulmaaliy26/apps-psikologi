<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$newDate = date("d-m-Y", strtotime($data['tgl_kirim']));

function tglIndo($tanggal) {
$tanggal_baru = date('d-m-Y', strtotime($tanggal));
return $tanggal_baru;
}
?>