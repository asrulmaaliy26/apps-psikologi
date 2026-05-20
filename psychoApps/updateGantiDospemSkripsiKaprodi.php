<?php
include "contentsConAdm.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username'];

    // Validasi Kaprodi S1
    $q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
    $dMe = mysqli_fetch_assoc($q_me);
    if ($dMe['jabatan_instansi'] != '47') {
        header("location:dashboardAdm.php");
        exit();
    }

    $angkatan = mysqli_real_escape_string($con, $_POST['angkatan']);
    $page = mysqli_real_escape_string($con, $_POST['page']);
    $id_pengajuan = mysqli_real_escape_string($con, $_POST['id_pengajuan']);
    $target = mysqli_real_escape_string($con, $_POST['target']); // 1 or 2
    $new_dospem_id = mysqli_real_escape_string($con, $_POST['new_dospem_id']);

    if (!empty($id_pengajuan) && !empty($new_dospem_id) && !empty($target)) {
        
        $q_mhs = mysqli_query($con, "SELECT nim, dospem_skripsi1, dospem_skripsi2 FROM pengelompokan_dospem_skripsi WHERE id='$id_pengajuan'");
        $d_mhs = mysqli_fetch_assoc($q_mhs);
        $nim = $d_mhs['nim'];
        $old_dospem = ($target == '1') ? $d_mhs['dospem_skripsi1'] : $d_mhs['dospem_skripsi2'];

        if ($target == '1') {
            $qry = "UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi1='$new_dospem_id', cek1='2', status = IF(status='1', '2', status) WHERE id='$id_pengajuan'";
            mysqli_query($con, $qry) or die(mysqli_error($con));
            
            // Sinkronisasi ke Sempro dan Ujian Skripsi
            mysqli_query($con, "UPDATE peserta_sempro SET pembimbing1='$new_dospem_id' WHERE nim='$nim'");
            mysqli_query($con, "UPDATE peserta_ujskrip SET pembimbing1='$new_dospem_id' WHERE nim='$nim'");
            
            // Sinkronisasi Penguji jika yang menguji adalah Dospem lama
            mysqli_query($con, "UPDATE jadwal_sempro js JOIN peserta_sempro ps ON js.id_pendaftaran = ps.id SET js.penguji1='$new_dospem_id' WHERE ps.nim='$nim' AND js.penguji1='$old_dospem'");
            mysqli_query($con, "UPDATE jadwal_ujskrip ju JOIN peserta_ujskrip pu ON ju.id_pendaftaran = pu.id SET ju.sekretaris_penguji='$new_dospem_id' WHERE pu.nim='$nim' AND ju.sekretaris_penguji='$old_dospem'");
            
        } else if ($target == '2') {
            $qry = "UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi2='$new_dospem_id', cek2='2', status = IF(status='1', '2', status) WHERE id='$id_pengajuan'";
            mysqli_query($con, $qry) or die(mysqli_error($con));
            
            // Sinkronisasi ke Sempro dan Ujian Skripsi
            mysqli_query($con, "UPDATE peserta_sempro SET pembimbing2='$new_dospem_id' WHERE nim='$nim'");
            mysqli_query($con, "UPDATE peserta_ujskrip SET pembimbing2='$new_dospem_id' WHERE nim='$nim'");
        }
        
        if (isset($qry)) {
            mysqli_query($con, $qry) or die(mysqli_error($con));
            header("location:allPembPerAngkKaprodi.php?angkatan=$angkatan&page=$page&message=notifEdit");
            exit();
        }
    }

    header("location:allPembPerAngkKaprodi.php?angkatan=$angkatan&page=$page&message=notifGagal");
    exit();
} else {
    header("location:rekapPembimbinganKaprodi.php");
    exit();
}
?>
