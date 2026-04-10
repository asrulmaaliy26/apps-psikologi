<?php
include("koneksiUser.php");
$id_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_pendaftaran']);
$id_sempro = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_sempro']);
$nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
$judul_prop = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_prop']);
$file_prop = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_prop']);
$file_form_revisi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_form_revisi']);
$tgl_upload = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_upload']);
$thn_upload = date('Y');
$cek = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);

$namafolder = "file_revisi_proposal/";
$jenis_berkas = $_FILES['file_prop']['type'];
$nmfold = "file_form_revisi_sempro/";
$j_berkas = $_FILES['file_form_revisi']['type'];

if ($jenis_berkas == "application/pdf" && $j_berkas == "application/pdf") {
	
	$temp = explode(".", $_FILES["file_prop"]["name"]);
	$nama_baru = $nim . '-' . $id_sempro . '_revisi-proposal' . '.' . end($temp);
	$berkas = $namafolder . $nama_baru;
	move_uploaded_file($_FILES['file_prop']['tmp_name'], $namafolder . '/' . $nama_baru);

	$temp_form_revisi = explode(".", $_FILES["file_form_revisi"]["name"]);
	$nname = $nim . '-' . $id_sempro . '_form-revisi-sempro' . '.' . end($temp_form_revisi);
	$form_revisi = $nmfold . $nname;
	move_uploaded_file($_FILES['file_form_revisi']['tmp_name'], $nmfold . '/' . $nname);
			
	mysqli_query(
		$GLOBALS["___mysqli_ston"],
		"insert into mag_revisi_sempro(id_peserta,id_sempro,nim,judul_prop,file_prop,file_form_revisi,tgl_upload,thn_upload,cek)"
			. "values('$id_pendaftaran','$id_sempro','$nim','$judul_prop','$berkas','$form_revisi','$tgl_upload','$thn_upload','$cek')"
	) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	header("location:formRevisiSempro.php?message=notifInput");
} else {
	header("location:formRevisiSempro.php?message=notifGagal");
}
?>