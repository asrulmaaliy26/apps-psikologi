<?php
include ("contentsConAdm.php");
$id = mysqli_real_escape_string($con, $_POST['id']);
$nim = mysqli_real_escape_string($con, $_POST['nim']);
$nama = mysqli_real_escape_string($con, $_POST['nama']);
$tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
$split = explode('-', $tgl_pengajuan);
$thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
$file_pembekalan = mysqli_real_escape_string($con, $_POST['file_pembekalan'] ?? '');
$val_adm = '2';
$statusform = '1';

$j_ftpd = $_FILES['file_pembekalan']['type'] ?? '';

$myquery = "SELECT * FROM peserta_pkl WHERE id='$id'";
$r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
$dt = mysqli_fetch_assoc( $r );
$id_pkl=$dt['id_pkl'];
$q = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
$has = mysqli_query($con,  $q )or die( mysqli_error($con) );
$dataku = mysqli_fetch_assoc( $has );
$nim =  $dataku['nim'];
$nama = $dataku['nama'];
$date = strtotime('now');

// Validasi file upload error
$upload_error = $_FILES['file_pembekalan']['error'] ?? UPLOAD_ERR_NO_FILE;
if ($upload_error !== UPLOAD_ERR_OK) {
    header("location:editPendaftaranPklUserDua.php?id=$id&message=notifGagalUpload");
    exit;
}

// Validasi ukuran file (maksimal 2MB = 2097152 bytes)
$max_file_size = 2097152; // 2MB
$file_size = $_FILES['file_pembekalan']['size'] ?? 0;
if ($file_size > $max_file_size) {
    header("location:editPendaftaranPklUserDua.php?id=$id&message=notifGagalUpload");
    exit;
}

if ($j_ftpd == "application/pdf") {
    $namaftpd = "file_pembekalan_pkl/";
    if (!file_exists($namaftpd)) {
        mkdir($namaftpd, 0777, true);
    }
    $temp_pembekalan = explode(".", $_FILES["file_pembekalan"]["name"]);
    $nama_file_pembekalan = $nama . '-'. $nim . '-' . $id_pkl . '_pembekalan-pkl_'. $date . '.' . end($temp_pembekalan);
    $file_pembekalan_path = $namaftpd . $nama_file_pembekalan;
    if (!move_uploaded_file($_FILES['file_pembekalan']['tmp_name'], $namaftpd . $nama_file_pembekalan)) {
        header("location:editPendaftaranPklUserDua.php?id=$id&message=notifGagalUpload");
        exit;
    }
  
    $res2 = mysqli_query($con, "SELECT file_pembekalan FROM peserta_pkl WHERE id='$id' LIMIT 1");
    $d2=mysqli_fetch_assoc($res2);
    if (strlen($d2['file_pembekalan'])>3) {
       if (file_exists($d2['file_pembekalan'])) unlink($d2['file_pembekalan']);
    }
    mysqli_query($con, "UPDATE peserta_pkl SET file_pembekalan='$file_pembekalan_path',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan',val_adm='$val_adm',statusform='$statusform' WHERE id='$id' LIMIT 1");
    header("location:detailRiwayatPendaftaranPklUser.php?id=$id&message=notifEdit");
} else {
    $res2 = mysqli_query($con, "SELECT file_pembekalan FROM peserta_pkl WHERE id='$id' LIMIT 1");
    $d2=mysqli_fetch_assoc($res2);
    if($file_pembekalan == $d2['file_pembekalan']) {
        header("location:detailRiwayatPendaftaranPklUser.php?id=$id&message=notifEdit");
    } else {
        header("location:editPendaftaranPklUserDua.php?id=$id&message=notifGagalUpload");
    }
}
?>