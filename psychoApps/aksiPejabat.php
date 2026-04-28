<?php
include("contentsConAdm.php");

$act = $_GET['act'];

if ($act == "assign") {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $jabatan_id = mysqli_real_escape_string($con, $_POST['jabatan_id']);

    mysqli_query($con, "UPDATE dt_pegawai SET jabatan_instansi='$jabatan_id' WHERE id='$user_id'");
    header("location:kelolaPejabatAdm.php?message=notifAssign");
} elseif ($act == "reset") {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    mysqli_query($con, "UPDATE dt_pegawai SET jabatan_instansi=NULL WHERE id='$id'");
    header("location:kelolaPejabatAdm.php?message=notifReset");
} elseif ($act == "create") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $md5password = md5($password);
    $level = mysqli_real_escape_string($con, $_POST['level']);
    $jabatan_id = mysqli_real_escape_string($con, $_POST['jabatan_id']);

    // Cek apakah username sudah ada
    $cek = mysqli_query($con, "SELECT id FROM dt_pegawai WHERE id='$username'");
    if (mysqli_num_rows($cek) > 0) {
        header("location:kelolaPejabatAdm.php?message=notifExist");
        exit;
    }

    // Insert ke dt_pegawai (minimal required fields)
    $q_pegawai = "INSERT INTO dt_pegawai (
        id, kat_pegawai, tgl_cpns, tmt, jenis_pegawai, pangkat, jabatan, jabatan_instansi, 
        kepakaran_minor, kepakaran_mayor, trend_riset, profil_riset_terkini, mengajar_pasca, 
        menguji_sempro_tesis, menguji_ujian_tesis, status, nama, nama_tg, tempat_lahir, 
        tanggal_lahir, alamat_ktp, alamat_rumah, jenis_kelamin, kntk1, kntk2, email1, 
        email2, photo, sma, th_sma, strata1, th_s1, strata2, th_s2, strata3, th_s3, 
        guru_bsr, th_gb, tgl_2a, tgl_2b, tgl_2c, tgl_2d, tgl_3a, tgl_3b, tgl_3c, tgl_3d, 
        tgl_4a, tgl_4b, tgl_4c, tgl_4d, tgl_4e, password
    ) VALUES (
        '$username', '', '0000-00-00', '0000-00-00', '2', '', '', '$jabatan_id', 
        '', '', '', '', '', '', '', '1', '$nama', '$nama', '', '0000-00-00', 
        '', '', '', '', '', '', '', '', '', '0000-00-00', '', '0000-00-00', 
        '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '0000-00-00', 
        '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 
        '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 
        '0000-00-00', '0000-00-00', '$md5password'
    )";

    if (mysqli_query($con, $q_pegawai)) {
        // Insert ke dt_all_adm
        mysqli_query($con, "INSERT INTO dt_all_adm (username, password, level, nm_person, login_terakhir, status) 
                            VALUES ('$username', '$md5password', '$level', '$nama', '', '1')");
        header("location:kelolaPejabatAdm.php?message=notifCreate");
    } else {
        header("location:kelolaPejabatAdm.php?message=notifError");
    }
}
