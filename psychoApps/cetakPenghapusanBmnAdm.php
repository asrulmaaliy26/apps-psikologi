<?php
include("contentsConAdm.php");

if (!isset($_GET['id'])) {
    header("location:rekapPenghapusanBmnAdm.php");
    exit;
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$q = mysqli_query($con, "SELECT * FROM dt_pengajuan_penghapusan_bmn WHERE id='$id'");
$d = mysqli_fetch_assoc($q);

if (!$d) {
    echo "Data pengajuan tidak ditemukan.";
    exit;
}

$tahun = date('Y', strtotime($d['tgl_pengajuan']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Penghapusan Barang Milik Negara</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .text-center {
            text-align: center;
        }
        .title-doc {
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            vertical-align: top;
        }
        th {
            text-align: center;
        }
        .img-barang {
            max-width: 80px;
            max-height: 80px;
            object-fit: cover;
        }
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <?php include("kopPotret.php"); ?>
        
        <div class="title-doc">
            DAFTAR BARANG MILIK NEGARA <br>
            FAKULTAS PSIKOLOGI UIN MAULANA MALIK IBRAHIM MALANG <br>
            YANG RUSAK DAN DI HAPUS TAHUN <?php echo $tahun; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" width="3%">No</th>
                    <th rowspan="2" width="15%">Nama Barang</th>
                    <th colspan="3">Identitas Barang</th>
                    <th rowspan="2" width="8%">Jumlah Barang</th>
                    <th rowspan="2" width="15%">Penguasaan / kondisi</th>
                    <th rowspan="2" width="10%">Gambar</th>
                    <th rowspan="2" width="15%">Ket.</th>
                </tr>
                <tr>
                    <th width="10%">Merk/Type</th>
                    <th width="12%">KD. Barang</th>
                    <th width="8%">Tahun Perolehan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $qd = mysqli_query($con, "SELECT b.*, omb.nm as nama_merk, okob.nm as nama_kondisi, r.nm as nama_ruang 
                                          FROM dt_pengajuan_penghapusan_bmn_detail d
                                          JOIN dt_inventaris_barang b ON d.id_barang = b.id
                                          LEFT JOIN opsi_merk_barang omb ON b.merk = omb.id
                                          LEFT JOIN opsi_kondisi_barang okob ON b.kondisi = okob.id
                                          LEFT JOIN dt_ruang r ON b.letak = r.id
                                          WHERE d.id_pengajuan = '$id'");
                
                if(mysqli_num_rows($qd) == 0){
                    echo "<tr><td colspan='9' class='text-center'>Tidak ada data barang</td></tr>";
                }
                
                while ($dd = mysqli_fetch_array($qd)) {
                    $img_src = (!empty($dd['image'])) ? $dd['image'] : 'images/image_none.jpg';
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?>.</td>
                    <td><?php echo $dd['nm']; ?></td>
                    <td><?php echo $dd['nama_merk']; ?></td>
                    <td class="text-center"><?php echo $dd['id_inventaris']; ?></td>
                    <td class="text-center"><?php echo $dd['thn_perolehan']; ?></td>
                    <td class="text-center">1</td>
                    <td>Milik Sendiri / <?php echo $dd['nama_kondisi']; ?></td>
                    <td class="text-center"><img src="<?php echo $img_src; ?>" class="img-barang" alt="Gambar Barang"></td>
                    <td><?php echo $dd['nama_ruang']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
