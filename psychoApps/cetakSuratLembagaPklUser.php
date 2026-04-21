<?php
include("contentsConAdm.php");
if(!isset($_SESSION)) { session_start(); }
$nim = $_SESSION['username'];
$id_lembaga = isset($_GET['id_lembaga']) ? intval($_GET['id_lembaga']) : 0;

// Get lembaga and periode info
$qL = mysqli_query($con, "SELECT l.*, p.periode, p.tahun, pj.nama_penjurusan 
                          FROM pkl_lembaga l 
                          JOIN pkl_plot_periode p ON l.id_periode = p.id_periode 
                          JOIN pkl_penjurusan pj ON l.id_penjurusan = pj.id_penjurusan
                          WHERE l.id_lembaga='$id_lembaga'");
$dLem = mysqli_fetch_assoc($qL);

if(!$dLem) {
    die("Data lembaga tidak ditemukan.");
}

// Get team members
$qM = mysqli_query($con, "SELECT p.*, m.nama, m.fakultas_pertama_daftar, m.jurusan_pertama_daftar 
                          FROM pkl_plot_pendaftar p 
                          LEFT JOIN dt_mhssw m ON p.nim = m.nim 
                          WHERE p.id_lembaga='$id_lembaga'");
$tim = [];
while($dM = mysqli_fetch_assoc($qM)) {
    $tim[] = $dM;
}

// We assume there's kop surat 
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Surat Penempatan Lembaga PKL</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; padding: 20px; font-size: 14px; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        .no-border table, .no-border th, .no-border td { border: none !important; }
        .kop-surat hr { border: 2px solid black; margin-bottom: 20px;}
    </style>
</head>
<body onload="window.print()">
    <!-- Simulated Kop Surat -->
    <div class="kop-surat text-center">
        <h2>UNIVERSITAS ISLAM NEGERI MAULANA MALIK IBRAHIM MALANG</h2>
        <h3>FAKULTAS PSIKOLOGI</h3>
        <p>Jalan Gajayana 50 Malang 65144 Telepon (0341) 558933 Faksmile (0341) 558933</p>
        <p>Website: psikologi.uin-malang.ac.id | Email: psikologi@uin-malang.ac.id</p>
        <hr>
    </div>
    
    <div class="text-center bold">
        <p style="text-decoration: underline;">SURAT PENGANTAR PRAKTIK KERJA LAPANGAN (PKL)</p>
    </div>

    <div style="margin-top:20px;">
        <p>Kepada Yth. Pimpinan/Direktur</p>
        <p class="bold"><?= $dLem['nama_tempat'] ?></p>
        <p><?= $dLem['alamat_lengkap']; ?><br><?= $dLem['kota']; ?></p>
    </div>

    <div style="margin-top:20px; text-align: justify;">
        <p>Dengan hormat,</p>
        <p>Berdasarkan pemilihan dan plotting lembaga Praktik Kerja Lapangan (PKL) Fakultas Psikologi UIN Maulana Malik Ibrahim Malang Periode <b><?= $dLem['periode']." ".$dLem['tahun'] ?></b>, dengan ini kami sampaikan daftar mahasiswa yang tergabung dalam 1 tim untuk melaksanakan kegiatan PKL di institusi/lembaga yang Bapak/Ibu Pimpin.</p>
        
        <p>Adapun durasi pelaksanaan PKL direncanakan mulai tanggal <b><?= $dLem['tgl_mulai'] ? date('d-m-Y', strtotime($dLem['tgl_mulai'])) : '... ' ?></b> sampai dengan tanggal <b><?= $dLem['tgl_selesai'] ? date('d-m-Y', strtotime($dLem['tgl_selesai'])) : '... ' ?></b>.</p>

        <p>Berikut adalah nama-nama mahasiswa tersebut:</p>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%; text-align:center;">No</th>
                    <th style="width: 30%;">NIM</th>
                    <th style="width: 65%;">Nama Mahasiswa</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach($tim as $t) { 
                ?>
                <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= $t['nim'] ?></td>
                    <td><?= $t['nama'] ?? 'Data tidak tersedia' ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <p style="margin-top: 15px;">Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagaimana mestinya. Atas perhatian dan kerjasamanya kami sampaikan terima kasih.</p>
    </div>

    <div style="margin-top:50px; float: right; width: 300px; text-align: left;">
        <p>Malang, <?= date('d F Y') ?></p>
        <p>Mengetahui,</p>
        <p>Admin BAAK S1 / Dekanat</p>
        <br><br><br>
        <p>_______________________</p>
    </div>

</body>
</html>
