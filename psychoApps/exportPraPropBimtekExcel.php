<?php
include("contentsConAdm.php");

// Proteksi akses
if (empty($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$current_id_bimtek = isset($_GET['id_bimtek']) ? $_GET['id_bimtek'] : '';
if (empty($current_id_bimtek)) {
    // Cari id_bimtek terbaru jika tidak ada
    $qBimtek = mysqli_query($con, "SELECT id, nama_bimtek FROM bimtek_pendaftaran ORDER BY tgl_buka DESC LIMIT 1");
    if ($dBimtek = mysqli_fetch_assoc($qBimtek)) {
        $current_id_bimtek = $dBimtek['id'];
        $nama_bimtek = $dBimtek['nama_bimtek'];
    }
} else {
    $qBimtek = mysqli_query($con, "SELECT nama_bimtek FROM bimtek_pendaftaran WHERE id = '" . mysqli_real_escape_string($con, $current_id_bimtek) . "'");
    if ($dBimtek = mysqli_fetch_assoc($qBimtek)) {
        $nama_bimtek = $dBimtek['nama_bimtek'];
    }
}

// Build WHERE and ORDER BY based on GET params
$where = [];
if (!empty($current_id_bimtek)) $where[] = "bp.id_bimtek='" . mysqli_real_escape_string($con, $current_id_bimtek) . "'";
if (!empty($_GET['status'])) $where[] = "pp.status='" . mysqli_real_escape_string($con, $_GET['status']) . "'";
if (!empty($_GET['pembimbing'])) {
    if ($_GET['pembimbing'] == 'sudah') {
        $where[] = "(pp.pembimbing_saran_1 IS NOT NULL AND pp.pembimbing_saran_1 != '') OR (pp.pembimbing_saran_2 IS NOT NULL AND pp.pembimbing_saran_2 != '')";
    } else {
        $where[] = "(pp.pembimbing_saran_1 IS NULL OR pp.pembimbing_saran_1 = '') AND (pp.pembimbing_saran_2 IS NULL OR pp.pembimbing_saran_2 = '')";
    }
}

$where_sql = $where ? "WHERE " . implode(' AND ', $where) : '';

if (!empty($_GET['reviewer'])) {
    if ($_GET['reviewer'] == 'belum_diplot') {
        $where_sql .= ($where_sql ? " AND " : "WHERE ") . "(bp.id_reviewer IS NULL OR bp.id_reviewer = '')";
    } else {
        $where_sql .= ($where_sql ? " AND " : "WHERE ") . "bp.id_reviewer = '" . mysqli_real_escape_string($con, $_GET['reviewer']) . "'";
    }
}

$order_sql = "ORDER BY pp.tgl_submit DESC, bp.id DESC";
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'nim') {
        $order_sql = "ORDER BY bp.nim ASC";
    } else if ($_GET['sort'] == 'reviewer') {
        $order_sql = "ORDER BY rev_nama ASC, bp.nim ASC";
    } else if ($_GET['sort'] == 'status') {
        $order_sql = "ORDER BY pp.status ASC, bp.nim ASC";
    }
}

$q_list = mysqli_query($con, "SELECT bp.nim, bp.id_bimtek, bp.id_reviewer as bp_rev_id, m.nama as mhs_nama, b.nama_bimtek, 
        p.nama as rev_nama, o.nm as nm_pem, pp.*, pp.id as pp_id,
        d1.nama as saran1_nama, d2.nama as saran2_nama
        FROM bimtek_peserta bp
        JOIN (SELECT MAX(id) as max_id FROM bimtek_peserta GROUP BY nim, id_bimtek) latest ON bp.id = latest.max_id
        LEFT JOIN bimtek_pra_proposal pp ON bp.nim = pp.nim AND bp.id_bimtek = pp.id_bimtek
        LEFT JOIN dt_mhssw m ON bp.nim = m.nim
        LEFT JOIN bimtek_pendaftaran b ON bp.id_bimtek = b.id
        LEFT JOIN dt_pegawai p ON bp.id_reviewer = p.id
        LEFT JOIN dt_pegawai d1 ON pp.pembimbing_saran_1 = d1.id
        LEFT JOIN dt_pegawai d2 ON pp.pembimbing_saran_2 = d2.id
        LEFT JOIN opsi_bidang_skripsi o ON bp.peminatan = o.id
        $where_sql
        $order_sql");

// Setting header for Excel Export
$filename = "Rekap_Pra_Proposal_Bimtek_" . date('YmdHis') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h3>Rekap Pra Proposal Bimtek Penulisan TA</h3>
    <p>Periode: <?php echo htmlspecialchars($nama_bimtek); ?></p>
    <table border="1">
        <thead>
            <tr style="background-color: #6c757d; color: white;">
                <th>No</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Peminatan</th>
                <th>Reviewer</th>
                <th>Status</th>
                <th>Pilihan Pembimbing</th>
                <th>Sertifikat Bimtek</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($d = mysqli_fetch_assoc($q_list)) {
                $label_status = ['proses' => 'Diproses', 'revisi' => 'Revisi', 'diterima' => 'Diterima'];
                $status_txt = $d['status'] ? (isset($label_status[$d['status']]) ? $label_status[$d['status']] : $d['status']) : 'Belum Upload';
                
                $rev_nama = $d['rev_nama'] ? $d['rev_nama'] : 'Belum Diplot';
                
                $s_label = ['pending' => 'Pending', 'valid' => 'Valid', 'invalid' => 'Ditolak', 'bypassed' => 'Bypassed'];
                $cur_s_status = $d['status_sertifikat'] ?? 'pending';
                $sertifikat_txt = $d['file_sertifikat'] ? (isset($s_label[$cur_s_status]) ? $s_label[$cur_s_status] : $cur_s_status) : '-';
                
                $pembimbing_txt = "";
                if (!empty($d['saran1_nama'])) $pembimbing_txt .= "1. " . $d['saran1_nama'] . "\n";
                if (!empty($d['saran2_nama'])) $pembimbing_txt .= "2. " . $d['saran2_nama'];
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nim']; ?></td>
                <td><?php echo $d['mhs_nama']; ?></td>
                <td><?php echo $d['nm_pem']; ?></td>
                <td><?php echo $rev_nama; ?></td>
                <td><?php echo $status_txt; ?></td>
                <td><?php echo nl2br(htmlspecialchars($pembimbing_txt)); ?></td>
                <td><?php echo $sertifikat_txt; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
