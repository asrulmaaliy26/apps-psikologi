<?php
include("koneksiUser.php");
$id_sempro = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_sempro']);
$ta = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['ta']);
$nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
$angkatan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['angkatan']);
$smt_daftar = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['smt_daftar']);
$judul_prop = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_prop']);
$dospem_tesis1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem_tesis1']);
$dospem_tesis2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem_tesis2']);
$tgl_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pendaftaran']);
$thn_pendaftaran = date('Y');
$cek = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);

$namafolder = "file_proposal/";
$jenis_berkas = $_FILES['file_prop']['type'];
$nmfold = "file_turnitin_sempro/";
$j_berkas = $_FILES['file_turnitin']['type'];
$nmfolder = "file_toefl_sempro/";
$jns_berkas = $_FILES['file_toefl']['type'];
$nf_transkrip = "file_transkrip_sempro/";
$j_transkrip = $_FILES['file_transkrip']['type'];
$nf_audien = "file_audien_sempro/";
$j_audien = $_FILES['file_audien']['type'];
$nf_diseminasi = "file_diseminasi_sempro/";
$j_diseminasi = $_FILES['file_diseminasi']['type'];
$nf_publikasi = "file_publikasi_sempro/";
$j_publikasi = $_FILES['file_publikasi']['type'];
$nf_kwitansi = "file_kwitansi_sempro/";
$j_kwitansi = $_FILES['file_kwitansi']['type'];

if ($jenis_berkas == "application/pdf" && $j_berkas == "application/pdf" && $jns_berkas == "application/pdf" && $j_transkrip == "application/pdf" && $j_audien == "application/pdf" && $j_diseminasi == "application/pdf" && $j_publikasi == "application/pdf" && $j_kwitansi == "application/pdf") {
	
	$temp = explode(".", $_FILES["file_prop"]["name"]);
	$nama_baru = $nim . '-' . $id_sempro . '_proposal' . '.' . end($temp);
	$berkas = $namafolder . $nama_baru;
	move_uploaded_file($_FILES['file_prop']['tmp_name'], $namafolder . '/' . $nama_baru);

	$temp_turnitin = explode(".", $_FILES["file_turnitin"]["name"]);
	$nname = $nim . '-' . $id_sempro . '_turnitin-sempro' . '.' . end($temp_turnitin);
	$turnitin = $nmfold . $nname;
	move_uploaded_file($_FILES['file_turnitin']['tmp_name'], $nmfold . '/' . $nname);

	$temp_toefl = explode(".", $_FILES["file_toefl"]["name"]);
	$newname = $nim . '-' . $id_sempro . '_toefl-sempro' . '.' . end($temp_toefl);
	$toefl = $nmfolder . $newname;
	move_uploaded_file($_FILES['file_toefl']['tmp_name'], $nmfolder . '/' . $newname);

	$temp_audien = explode(".", $_FILES["file_audien"]["name"]);
	$newnameaudien = $nim . '-' . $id_sempro . '_audien-sempro' . '.' . end($temp_audien);
	$audien = $nf_audien . $newnameaudien;
	move_uploaded_file($_FILES['file_audien']['tmp_name'], $nf_audien . '/' . $newnameaudien);

	$temp_transkrip = explode(".", $_FILES["file_transkrip"]["name"]);
	$newnametranskrip = $nim . '-' . $id_sempro . '_transkrip-sempro' . '.' . end($temp_transkrip);
	$transkrip = $nf_transkrip . $newnametranskrip;
	move_uploaded_file($_FILES['file_transkrip']['tmp_name'], $nf_transkrip . '/' . $newnametranskrip);

	$temp_diseminasi = explode(".", $_FILES["file_diseminasi"]["name"]);
	$newnamediseminasi = $nim . '-' . $id_sempro . '_diseminasi-sempro' . '.' . end($temp_diseminasi);
	$diseminasi = $nf_diseminasi . $newnamediseminasi;
	move_uploaded_file($_FILES['file_diseminasi']['tmp_name'], $nf_diseminasi . '/' . $newnamediseminasi);

	$temp_publikasi = explode(".", $_FILES["file_publikasi"]["name"]);
	$newnamepublikasi = $nim . '-' . $id_sempro . '_publikasi-sempro' . '.' . end($temp_publikasi);
	$publikasi = $nf_publikasi . $newnamepublikasi;
	move_uploaded_file($_FILES['file_publikasi']['tmp_name'], $nf_publikasi . '/' . $newnamepublikasi);

	$temp_kwitansi = explode(".", $_FILES["file_kwitansi"]["name"]);
	$newnamekwitansi = $nim . '-' . $id_sempro . '_kwitansi-sempro' . '.' . end($temp_kwitansi);
	$kwitansi = $nf_kwitansi . $newnamekwitansi;
	move_uploaded_file($_FILES['file_kwitansi']['tmp_name'], $nf_kwitansi . '/' . $newnamekwitansi);
			
	mysqli_query(
		$GLOBALS["___mysqli_ston"],
		"insert into mag_peserta_sempro(id_sempro,ta,nim,angkatan,smt_daftar,judul_prop,file_prop,file_turnitin,file_toefl,file_transkrip,file_audien,file_diseminasi,file_publikasi,file_kwitansi,dospem_tesis1,dospem_tesis2,tgl_pendaftaran,thn_pendaftaran,cek)"
			. "values('$id_sempro','$ta','$nim','$angkatan','$smt_daftar','$judul_prop','$berkas','$turnitin','$toefl','$transkrip','$audien','$diseminasi','$publikasi','$kwitansi','$dospem_tesis1','$dospem_tesis2','$tgl_pendaftaran','$thn_pendaftaran','$cek')"
	) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$qid = "select id from mag_peserta_sempro WHERE id_sempro='$id_sempro' AND nim='$nim' LIMIT 1";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $qid) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$dId = mysqli_fetch_assoc($res);
	$id = $dId['id'];
	$genId = str_pad($id, 4, '0', STR_PAD_LEFT);
	$id_reg = 'SEMPRO' . '.' . $thn_pendaftaran . '.' . $genId;

	$qreg = "UPDATE mag_peserta_sempro SET id_reg='$id_reg' WHERE id='$id' LIMIT 1";
	$rreg = mysqli_query($GLOBALS["___mysqli_ston"], $qreg) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	mysqli_query(
		$GLOBALS["___mysqli_ston"],
		"insert into mag_jadwal_sempro(id_sempro,nim,id_pendaftaran,penguji1,penguji2)"
			. "values('$id_sempro','$nim','$id','$dospem_tesis1','$dospem_tesis2')"
	) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$qidjdwl = "select id from mag_jadwal_sempro WHERE id_sempro='$id_sempro' AND nim='$nim' LIMIT 1";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $qidjdwl) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$dIdjdwl = mysqli_fetch_assoc($res);
	$idJdwl = $dIdjdwl['id'];

	$q = "UPDATE mag_peserta_sempro SET id_jdwl='$idJdwl' WHERE id='$id' LIMIT 1";
	$r = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	mysqli_query(
		$GLOBALS["___mysqli_ston"],
		"insert into mag_nilai_sempro(id_pendaftaran,id_sempro,validasi)"
			. "values('$id','$id_sempro','1')"
	) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	header("location:formPendSempro.php?message=notifInput");
} else {
	header("location:formPendSempro.php?message=notifGagal");
}
?>