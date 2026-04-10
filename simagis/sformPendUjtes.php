<?php
include("koneksiUser.php");
$id_ujtes = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_ujtes']);
$ta = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['ta']);
$nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
$angkatan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['angkatan']);
$smt_daftar = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['smt_daftar']);
$judul_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_tesis']);
$dospem_tesis1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem_tesis1']);
$dospem_tesis2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['dospem_tesis2']);
$tgl_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pendaftaran']);
$thn_pendaftaran = date('Y');
$cek = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);

$myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
$dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
$dataku = mysqli_fetch_assoc($dmhssw);
$nmmhsw = $dataku['nama'];

$namafolder = "file_tesis/";
$jenis_berkas = $_FILES['file_tesis']['type'];
$nmfold = "file_turnitin_tesis/";
$j_berkas = $_FILES['file_turnitin']['type'];
$nf_transkrip = "file_transkrip_tesis/";
$j_transkrip = $_FILES['file_transkrip']['type'];
$nf_jurnal = "file_jurnal_tesis/";
$j_jurnal = $_FILES['file_jurnal']['type'];
$nf_template_jurnal = "file_contoh_template_jurnal_tesis/";
$j_template_jurnal = $_FILES['file_contoh_jurnal']['type'];
$nf_kwitansi = "file_kwitansi_ujian_tesis/";
$j_kwitansi = $_FILES['file_kwitansi']['type'];

if ($jenis_berkas == "application/pdf" && $j_berkas == "application/pdf" && $j_transkrip == "application/pdf" && $j_jurnal == "application/pdf" && $j_template_jurnal == "application/pdf" && $j_kwitansi == "application/pdf") {
	$temp = explode(".", $_FILES["file_tesis"]["name"]);
	$nama_baru = $nim . '-' . $nmmhsw . '-' . $id_ujtes . '_tesis' . '.' . end($temp);
	$berkas = $namafolder . $nama_baru;
	move_uploaded_file($_FILES['file_tesis']['tmp_name'], $namafolder . '/' . $nama_baru);

	$temp_turnitin = explode(".", $_FILES["file_turnitin"]["name"]);
	$nname = $nim . '-' . $id_ujtes . '_turnitin-tesis' . '.' . end($temp_turnitin);
	$turnitin = $nmfold . $nname;
	move_uploaded_file($_FILES['file_turnitin']['tmp_name'], $nmfold . '/' . $nname);

	$temp_transkrip = explode(".", $_FILES["file_transkrip"]["name"]);
	$newnametranskrip = $nim . '-' . $id_ujtes . '_transkrip-tesis' . '.' . end($temp_transkrip);
	$transkrip = $nf_transkrip . $newnametranskrip;
	move_uploaded_file($_FILES['file_transkrip']['tmp_name'], $nf_transkrip . '/' . $newnametranskrip);

	$temp_jurnal = explode(".", $_FILES["file_jurnal"]["name"]);
	$newnamejurnal = $nim . '-' . $id_ujtes . '_jurnal-tesis' . '.' . end($temp_jurnal);
	$jurnal = $nf_jurnal . $newnamejurnal;
	move_uploaded_file($_FILES['file_jurnal']['tmp_name'], $nf_jurnal . '/' . $newnamejurnal);

	$temp_template_jurnal = explode(".", $_FILES["file_contoh_jurnal"]["name"]);
	$newnametemplatejurnal = $nim . '-' . $id_ujtes . '_template_jurnal-tesis' . '.' . end($temp_template_jurnal);
	$template_jurnal = $nf_template_jurnal . $newnametemplatejurnal;
	move_uploaded_file($_FILES['file_contoh_jurnal']['tmp_name'], $nf_template_jurnal . '/' . $newnametemplatejurnal);

	$temp_kwitansi = explode(".", $_FILES["file_kwitansi"]["name"]);
	$newnamekwitansi = $nim . '-' . $id_ujtes . '_kwitansi-ujtes' . '.' . end($temp_kwitansi);
	$kwitansi = $nf_kwitansi . $newnamekwitansi;
	move_uploaded_file($_FILES['file_kwitansi']['tmp_name'], $nf_kwitansi . '/' . $newnamekwitansi);

	mysqli_query(
	$GLOBALS["___mysqli_ston"],
	"insert into mag_peserta_ujtes(id_ujtes,ta,nim,angkatan,smt_daftar,judul_tesis,file_tesis,file_turnitin,file_transkrip,file_jurnal,file_contoh_jurnal,file_kwitansi,dospem_tesis1,dospem_tesis2,tgl_pendaftaran,thn_pendaftaran,cek)"
			. "values('$id_ujtes','$ta','$nim','$angkatan','$smt_daftar','$judul_tesis','$berkas','$turnitin','$transkrip','$jurnal','$template_jurnal','$kwitansi','$dospem_tesis1','$dospem_tesis2','$tgl_pendaftaran','$thn_pendaftaran','$cek')"
	) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$qid = "select id from mag_peserta_ujtes WHERE id_ujtes='$id_ujtes' AND nim='$nim' LIMIT 1";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $qid) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$dId = mysqli_fetch_assoc($res);
	$id = $dId['id'];
	$genId = str_pad($id, 4, '0', STR_PAD_LEFT);
	$id_reg = 'UJTES' . '.' . $thn_pendaftaran . '.' . $genId;

	$qreg = "UPDATE mag_peserta_ujtes SET id_reg='$id_reg' WHERE id='$id' LIMIT 1";
	$rreg = mysqli_query($GLOBALS["___mysqli_ston"], $qreg) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	mysqli_query(
		$GLOBALS["___mysqli_ston"],
		"insert into mag_jadwal_ujtes(id_ujtes,nim,id_pendaftaran,penguji1,penguji2)"
			. "values('$id_ujtes','$nim','$id','$dospem_tesis1','$dospem_tesis2')"
	) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$qidjdwl = "select id from mag_jadwal_ujtes WHERE id_ujtes='$id_ujtes' AND nim='$nim' LIMIT 1";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $qidjdwl) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$dIdjdwl = mysqli_fetch_assoc($res);
	$idJdwl = $dIdjdwl['id'];

	$q = "UPDATE mag_peserta_ujtes SET id_jdwl='$idJdwl' WHERE id='$id' LIMIT 1";
	$r = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	mysqli_query(
		$GLOBALS["___mysqli_ston"],
		"insert into mag_nilai_ujtes(id_pendaftaran,id_ujtes,validasi)"
			. "values('$id','$id_ujtes','1')"
	) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	header("location:formPendUjTes.php?message=notifInput");
} else {
	header("location:formPendUjTes.php?message=notifGagal");
}
?>