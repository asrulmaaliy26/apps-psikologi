<?php
include("contentsConAdm.php");

$act = $_GET['act'];

if ($act == "create") {
    $nim = mysqli_real_escape_string($con, $_POST['nim']);
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $angkatan = mysqli_real_escape_string($con, $_POST['angkatan']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $md5password = md5($password);
    $level = mysqli_real_escape_string($con, $_POST['level']); // 2 for S1, 3 for S2

    $redirect = ($level == 2) ? "kelolaMahasiswaS1Adm.php" : "kelolaMahasiswaS2Adm.php";

    // Cek apakah NIM sudah ada
    $cek = mysqli_query($con, "SELECT nim FROM dt_mhssw WHERE nim='$nim'");
    if (mysqli_num_rows($cek) > 0) {
        header("location:$redirect?message=notifExist");
        exit;
    }

    if ($level == 2) {
        // S1 Logic
        $q_mhssw = "INSERT INTO dt_mhssw (
            nim, angkatan, fakultas_pertama_daftar, jurusan_pertama_daftar, nama, tempat_lahir, 
            tanggal_lahir, asal_sekolah, pend_terakhir, nama_ayah, pekerjaan_ayah, alamat_ayah, 
            telepon_ayah, nama_ibu, pekerjaan_ibu, alamat_ibu, telepon_ibu, alamat_ktp, 
            alamat_malang, jenis_kelamin, kntk, imel, facebook, twitter, instagram, web, 
            dosen_wali, thn_nonaktif, thn_pindah, thn_do, thn_lls_s1, reg_ijazah, no_ijazah, 
            status, rencana_kuliah, s2, thn_msk_s2, thn_lls_s2, judul_tesis, s3, thn_msk_s3, 
            thn_lls_s3, judul_disertasi, pekerjaan, alamat_kantor, status_perkawinan, motto, photo
        ) VALUES (
            '$nim', '$angkatan', '', '', '$nama', '', '', '', '', '', '', '', '', '', '', '', '', '', 
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', 
            '', '', '', '', '', '', ''
        )";
        $success = mysqli_query($con, $q_mhssw);
    } else {
        // S2 Logic
        $q_mag = "INSERT INTO mag_dt_mhssw_pasca (
            nim, angkatan, smt_daftar, nama, gelar_depan, gelar_belakang, status, password,
            tempat_lahir, tanggal_lahir, jenis_kelamin, alamat_ktp, alamat_malang, kntk,
            email, pekerjaan, asal_s1, pend_terakhir, nama_ibu, pekerjaan_ibu, alamat_ibu,
            telepon_ibu, nama_ayah, pekerjaan_ayah, alamat_ayah, telepon_ayah, thn_lulus,
            thn_cuti, thn_do, thn_non_aktif, photo
        ) VALUES (
            '$nim', '$angkatan', '1', '$nama', '', '', '1', '$md5password', 
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
        )";
        $success = mysqli_query($con, $q_mag);
    }

    if ($success) {
        // Insert ke dt_all_adm (for main login compatibility)
        mysqli_query($con, "INSERT INTO dt_all_adm (username, password, level, nm_person, login_terakhir, status) 
                            VALUES ('$nim', '$md5password', '$level', '$nama', '', '1')");
        header("location:$redirect?message=notifCreate");
    } else {
        header("location:$redirect?message=notifError");
    }
} elseif ($act == "delete") {
    $nim = mysqli_real_escape_string($con, $_GET['nim']);
    $level = mysqli_real_escape_string($con, $_GET['level']);
    $redirect = ($level == 2) ? "kelolaMahasiswaS1Adm.php" : "kelolaMahasiswaS2Adm.php";

    if ($level == 2) {
        mysqli_query($con, "DELETE FROM dt_mhssw WHERE nim='$nim'");
    } else {
        mysqli_query($con, "DELETE FROM mag_dt_mhssw_pasca WHERE nim='$nim'");
    }
    mysqli_query($con, "DELETE FROM dt_all_adm WHERE username='$nim'");
    header("location:$redirect?message=notifDelete");
}
?>
