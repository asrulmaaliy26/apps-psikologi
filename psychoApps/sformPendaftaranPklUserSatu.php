<?php
include("contentsConAdm.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:prePendaftaranPklUser.php");
    exit;
}

$id_pkl = mysqli_real_escape_string($con, $_POST['id_pkl']);
$jenis_pkl = mysqli_real_escape_string($con, $_POST['jenis_pkl']);
$peminatan = mysqli_real_escape_string($con, $_POST['peminatan']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$angkatan = mysqli_real_escape_string($con, $_POST['angkatan']);
$nama_instansi = mysqli_real_escape_string($con, $_POST['nama_instansi']);
$alamat_instansi = mysqli_real_escape_string($con, $_POST['alamat_instansi']);
$id_dpl = intval($_POST['id_dpl']);

$sks_lalu = intval($_POST['sks_lalu'] ?? 0);
$sks_smt_berjalan = intval($_POST['sks_smt_berjalan'] ?? 0);
$sks_diambil = $sks_lalu + $sks_smt_berjalan;

$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan = mysqli_real_escape_string($con, $split['2'] ?? date('Y'));
$val_adm = mysqli_real_escape_string($con, $_POST['val_adm']);
$statusform = mysqli_real_escape_string($con, $_POST['statusform']);

// Get DPL NIP and Name (id_dpl here = NIP/id dari dt_pegawai)
$dpl_nip = mysqli_real_escape_string($con, $id_dpl);
$dpl_name = '';
$q_dpl = mysqli_query($con, "SELECT nama FROM dt_pegawai WHERE id='$dpl_nip' LIMIT 1");
if ($row_dpl = mysqli_fetch_assoc($q_dpl)) {
    $dpl_name = mysqli_real_escape_string($con, $row_dpl['nama']);
}

// Cek Duplikasi
$cek = mysqli_query($con, "SELECT id FROM peserta_pkl WHERE nim='$nim' AND id_pkl='$id_pkl' LIMIT 1");
if (mysqli_num_rows($cek) > 0) {
    header("location:prePendaftaranPklUser.php?nim=$nim&message=notifInput");
    exit;
}

// Get Mahasiswa name
$q_mhs = mysqli_query($con, "SELECT nama FROM dt_mhssw WHERE nim='$nim' LIMIT 1");
$mhs = mysqli_fetch_assoc($q_mhs);
$nama_mhs = $mhs['nama'];
$date = strtotime('now');

// Validasi File Pembekalan
$file_pembekalan_path = '';
$j_ftpd = $_FILES['file_pembekalan']['type'] ?? '';
$upload_error = $_FILES['file_pembekalan']['error'] ?? UPLOAD_ERR_NO_FILE;
$max_file_size = 2097152; // 2MB

if ($upload_error !== UPLOAD_ERR_OK || $_FILES['file_pembekalan']['size'] > $max_file_size || $j_ftpd !== "application/pdf") {
    header("location:prePendaftaranPklUser.php?message=notifGagalUpload");
    exit;
}

$namaftpd = "file_pembekalan_pkl/";
if (!file_exists($namaftpd)) {
    mkdir($namaftpd, 0777, true);
}
$temp_pembekalan = explode(".", $_FILES["file_pembekalan"]["name"]);
$nama_file_pembekalan = $nama_mhs . '-' . $nim . '-' . $id_pkl . '_pembekalan-pkl_' . $date . '.' . end($temp_pembekalan);
$file_pembekalan_path = $namaftpd . $nama_file_pembekalan;

if (!move_uploaded_file($_FILES['file_pembekalan']['tmp_name'], $file_pembekalan_path)) {
    header("location:prePendaftaranPklUser.php?message=notifGagalUpload");
    exit;
}

mysqli_begin_transaction($con);
try {
    $q1 = "INSERT INTO peserta_pkl(id_pkl,nim,angkatan,sks_diambil,jenis_pkl,peminatan,nama_instansi,alamat_instansi,tgl_pengajuan,thn_pengajuan,val_adm,statusform,file_pembekalan,dpl,id_dpl,tgl_validasi,catatan,nilai,id_reg,riwayat_penyakit,kontak_lain,file_transkrip)
           VALUES('$id_pkl','$nim','$angkatan','$sks_diambil','$jenis_pkl','$peminatan','$nama_instansi','$alamat_instansi','$tgl_pengajuan','$thn_pengajuan','$val_adm','$statusform','$file_pembekalan_path','$dpl_nip','0','','','0','','','','')";
    if (!mysqli_query($con, $q1)) throw new Exception(mysqli_error($con));

    $id = mysqli_insert_id($con);
    $genId = str_pad($id, 4, '0', STR_PAD_LEFT);
    $id_reg = 'PKL.' . $thn_pengajuan . '.' . $genId;

    $q2 = "UPDATE peserta_pkl SET id_reg='$id_reg' WHERE id='$id' LIMIT 1";
    if (!mysqli_query($con, $q2)) throw new Exception(mysqli_error($con));


    mysqli_commit($con);
    header("location:prePendaftaranPklUser.php?nim=$nim&id=$id&message=notifInput");
} catch (Exception $e) {
    mysqli_rollback($con);
    die($e->getMessage());
}
