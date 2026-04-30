<?php
include("contentsConAdm.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$nim = mysqli_real_escape_string($con, $_POST['nim']);
$saran1 = mysqli_real_escape_string($con, $_POST['saran1']);
$saran2 = mysqli_real_escape_string($con, $_POST['saran2']);
$id_bimtek = mysqli_real_escape_string($con, $_POST['id_bimtek']);

// 1. Dapatkan data mahasiswa
$q_mhs = mysqli_query($con, "SELECT angkatan FROM dt_mhssw WHERE nim='$nim'");
$d_mhs = mysqli_fetch_assoc($q_mhs);
$angkatan = $d_mhs ? $d_mhs['angkatan'] : '';

// 2. Dapatkan data Bimtek (judul & abstrak)
$q_bimtek = mysqli_query($con, "SELECT judul, abstrak FROM bimtek_pra_proposal WHERE nim='$nim' AND id_bimtek='$id_bimtek'");
$d_bimtek = mysqli_fetch_assoc($q_bimtek);
$judul = $d_bimtek ? mysqli_real_escape_string($con, $d_bimtek['judul']) : '';
$abstrak = $d_bimtek ? mysqli_real_escape_string($con, $d_bimtek['abstrak']) : '';

// 3. Dapatkan data Peminatan
$q_peserta = mysqli_query($con, "SELECT peminatan FROM bimtek_peserta WHERE nim='$nim' AND id_bimtek='$id_bimtek'");
$d_peserta = mysqli_fetch_assoc($q_peserta);
$peminatan = $d_peserta ? mysqli_real_escape_string($con, $d_peserta['peminatan']) : '';

// 4. Dapatkan periode pengajuan dospem yang aktif atau buat jika belum ada
$q_per = mysqli_query($con, "SELECT id FROM pengajuan_dospem WHERE status='1' ORDER BY id DESC LIMIT 1");
$d_per = mysqli_fetch_assoc($q_per);

if (!$d_per) {
    // Jika tidak ada yang aktif, cari periode yang sesuai dengan Tahun Akademik aktif
    $q_ta_aktif = mysqli_query($con, "SELECT id FROM dt_ta WHERE status='1' LIMIT 1");
    $d_ta_aktif = mysqli_fetch_assoc($q_ta_aktif);
    
    if ($d_ta_aktif) {
        $ta_id = $d_ta_aktif['id'];
        // Cek apakah sudah ada periode untuk TA ini (tahap 1)
        $id_auto = "1" . $ta_id;
        $q_per_cek = mysqli_query($con, "SELECT id FROM pengajuan_dospem WHERE id='$id_auto'");
        $d_per_cek = mysqli_fetch_assoc($q_per_cek);
        
        if ($d_per_cek) {
            $id_periode = $d_per_cek['id'];
        } else {
            // Buat periode baru secara otomatis (Tahap 1)
            $q_wd1 = mysqli_query($con, "SELECT id FROM dt_pegawai WHERE jabatan_instansi='2' LIMIT 1");
            $d_wd1 = mysqli_fetch_assoc($q_wd1);
            $wd1 = $d_wd1 ? $d_wd1['id'] : '';
            
            $q_kaprodi = mysqli_query($con, "SELECT id FROM dt_pegawai WHERE jabatan_instansi='47' LIMIT 1");
            $d_kaprodi = mysqli_fetch_assoc($q_kaprodi);
            $kaprodi = $d_kaprodi ? $d_kaprodi['id'] : '';
            
            $start = date('Y-m-d H:i:s');
            $end = date('Y-m-d H:i:s', strtotime('+6 months'));
            
            mysqli_query($con, "INSERT INTO pengajuan_dospem (id, tahap, ta, start_datetime, end_datetime, syarat_sks, status, wd1, kaprodi) 
                                VALUES ('$id_auto', '1', '$ta_id', '$start', '$end', '0', '1', '$wd1', '$kaprodi')");
            $id_periode = $id_auto;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tidak ada periode pengajuan aktif dan tidak ada Tahun Akademik yang aktif di sistem.']);
        exit();
    }
} else {
    $id_periode = $d_per['id'];
}

$tgl_now = date('d-m-Y');
$thn_now = date('Y');

// 5. Cek apakah sudah ada record di pengelompokan_dospem_skripsi untuk NIM dan Periode ini
$q_check = mysqli_query($con, "SELECT id FROM pengelompokan_dospem_skripsi WHERE nim='$nim' AND id_periode='$id_periode'");

if (mysqli_num_rows($q_check) > 0) {
    // Update data yang sudah ada
    $sql = "UPDATE pengelompokan_dospem_skripsi SET 
            dospem_skripsi1 = '$saran1', 
            dospem_skripsi2 = '$saran2', 
            judul_skripsi = '$judul', 
            outline_skripsi = '$abstrak',
            bidang_skripsi = '$peminatan',
            status = '2',
            cek1 = '2',
            cek2 = '2',
            cekjudul = '2',
            cekberkas1 = '2',
            cekberkas2 = '2',
            cekberkas3 = '2',
            cekberkas4 = '2',
            cekberkas5 = '2',
            catatan = 'Disetujui melalui Bimtek'
            WHERE nim='$nim' AND id_periode='$id_periode'";
} else {
    // Insert record baru dengan semua field mandatory NOT NULL
    $sql = "INSERT INTO pengelompokan_dospem_skripsi (
        nim, angkatan, ipk, digit_ipk1, digit_ipk2, sks_ditempuh, judul_skripsi, 
        jenis_skripsi, bidang_skripsi, metode_riset, var_1, var_2, var_3, var_4, 
        tgl_pengajuan, thn_pengajuan, id_periode, cek1, cek2, cekberkas1, 
        cekberkas2, cekberkas3, cekberkas4, cekberkas5, cekjudul, status, 
        outline_skripsi, dospem_skripsi1, dospem_skripsi2, 
        file_prop, file_transkrip, file_toefl_toafl, file_tashih, file_ukt, 
        tgl_cek1, tgl_cek2, tgl_cekjudul, tgl_cekberkas, tgl_mulai, thn_mulai, 
        catatan, tgl_akhir, thn_akhir
    ) VALUES (
        '$nim', '$angkatan', '', '', '', '', '$judul', 
        '', '$peminatan', '', '', '', '', '', 
        '$tgl_now', '$thn_now', '$id_periode', '2', '2', '2', 
        '2', '2', '2', '2', '2', '2', 
        '$abstrak', '$saran1', '$saran2', 
        '', '', '', '', '', 
        '$tgl_now', '$tgl_now', '$tgl_now', '$tgl_now', '$tgl_now', '$thn_now', 
        'Disetujui melalui Bimtek', '', ''
    )";
}

if (mysqli_query($con, $sql)) {
    // 6. Otomatis daftarkan dosen ke tabel kuota (dospem_skripsi) jika belum ada
    // Dan sesuaikan kuota agar selalu mencukupi jumlah bimbingan yang ada
    $dosen_roles = [
        '1' => $saran1,
        '2' => $saran2
    ];

    foreach ($dosen_roles as $role => $nip_dosen) {
        if (!empty($nip_dosen)) {
            // Cek apakah dosen sudah terdaftar di periode ini
            $q_cek_dospem = mysqli_query($con, "SELECT id, kuota1, kuota2 FROM dospem_skripsi WHERE nip='$nip_dosen' AND id_periode='$id_periode'");
            $d_dospem = mysqli_fetch_assoc($q_cek_dospem);

            // Hitung jumlah bimbingan riil saat ini (status 2=Approved, 3=Finished)
            $col_mhs = ($role == '1') ? 'dospem_skripsi1' : 'dospem_skripsi2';
            $q_count = mysqli_query($con, "SELECT COUNT(*) as total FROM pengelompokan_dospem_skripsi 
                                           WHERE $col_mhs = '$nip_dosen' AND id_periode = '$id_periode' AND status IN ('2','3')");
            $d_count = mysqli_fetch_assoc($q_count);
            $current_total = $d_count['total'];

            if (!$d_dospem) {
                // Belum terdaftar, buat baru dengan kuota minimal sama dengan jumlah bimbingan saat ini
                $k1 = ($role == '1') ? $current_total : 0;
                $k2 = ($role == '2') ? $current_total : 0;
                mysqli_query($con, "INSERT INTO dospem_skripsi (nip, id_periode, kuota1, kuota2) VALUES ('$nip_dosen', '$id_periode', '$k1', '$k2')");
            } else {
                // Sudah terdaftar, pastikan kuota mencukupi (jika bimbingan > kuota, maka kuota dinaikkan)
                $kuota_key = 'kuota' . $role;
                if ($current_total > $d_dospem[$kuota_key]) {
                    mysqli_query($con, "UPDATE dospem_skripsi SET $kuota_key = '$current_total' WHERE id = '$d_dospem[id]'");
                }
            }
        }
    }
    
    echo json_encode(['status' => 'success', 'message' => 'Saran pembimbing berhasil disetujui dan mahasiswa telah terdata di sistem Skripsi.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal memproses data: ' . mysqli_error($con)]);
}
?>
