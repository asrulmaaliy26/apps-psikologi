<?php
include("contentsConAdm.php");
$username = $_SESSION['username'];
$idAdm = $_SESSION['username'];

// Check Monitoring Role
$qCheckMon = mysqli_query($con, "SELECT * FROM peg_monitoring_role WHERE username='$idAdm'");
if (mysqli_num_rows($qCheckMon) == 0) {
    header("location:dashboardAdm.php");
    exit();
}

$filter_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$filter_user = isset($_GET['q']) ? $_GET['q'] : '';
$filter_level = isset($_GET['level']) ? $_GET['level'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("navtopAdm.php");
        // Reuse Sidebar
        if ($_SESSION['level'] == 1) include("navSideBarDosen.php");
        else if ($_SESSION['level'] == 4) include("navSideBarAdmKepeg.php");
        else if ($_SESSION['level'] == 5) include("navSideBarAdmBmn.php");
        else if ($_SESSION['level'] == 7) include("navSideBarAdmBakS1.php");
        else if ($_SESSION['level'] == 8) include("navSideBarAdmBakS2.php");
        else include("navSideBarAdmTaper.php");
        ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="mb-0">Monitoring Laporan Harian</h4>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <!-- Filters -->
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <form action="" method="GET" class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="small">Tanggal Laporan</label>
                                        <input type="date" name="date" class="form-control" value="<?php echo $filter_date; ?>" onchange="this.form.submit()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="small">Kategori Pegawai</label>
                                        <select name="level" class="form-control" onchange="this.form.submit()">
                                            <option value="">-- Semua Kategori --</option>
                                            <?php
                                            $qLevels = mysqli_query($con, "SELECT * FROM opsi_level_admin WHERE id NOT IN (2, 3) ORDER BY nm ASC");
                                            while ($l = mysqli_fetch_assoc($qLevels)) {
                                                $sel = ($filter_level == $l['id']) ? 'selected' : '';
                                                echo "<option value='$l[id]' $sel>$l[nm]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="small">Cari Nama Pegawai (Opsional)</label>
                                        <input type="text" name="q" class="form-control" placeholder="Nama..." value="<?php echo $filter_user; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding-top: 25px;">
                                    <button type="submit" class="btn btn-info btn-block"><i class="fas fa-search"></i> Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Daftar Laporan Pegawai - <?php echo date('d F Y', strtotime($filter_date)); ?></h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-hover table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Nama Pegawai</th>
                                                <th>Waktu Absen</th>
                                                <th>Total Kegiatan</th>
                                                <th>Status Absen</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $searchQuery = $filter_user ? " AND b.nm_person LIKE '%$filter_user%'" : "";
                                            $levelQuery = $filter_level ? " AND b.level = '$filter_level'" : "";
                                            $qStaff = mysqli_query($con, "SELECT DISTINCT a.username, b.nm_person 
                                                                         FROM peg_laporan_harian a 
                                                                         JOIN dt_all_adm b ON a.username = b.username 
                                                                         WHERE a.tanggal = '$filter_date' $searchQuery $levelQuery");
                                            
                                            if (mysqli_num_rows($qStaff) == 0) {
                                                echo "<tr><td colspan='5' class='text-center text-muted p-4'>Tidak ada laporan ditemukan untuk filter ini.</td></tr>";
                                            }

                                            while ($s = mysqli_fetch_assoc($qStaff)) {
                                                $u = $s['username'];
                                                
                                                // Get Absen Status
                                                $qAb = mysqli_query($con, "SELECT * FROM peg_absensi_harian WHERE username='$u' AND tanggal='$filter_date'");
                                                $da = mysqli_fetch_assoc($qAb);
                                                $stAb = $da ? $da['status_absen'] : 'N/A';
                                                $tBuka = $da ? date('H:i', strtotime($da['waktu_buka'])) : '-';
                                                $tTutup = ($da && $da['waktu_tutup']) ? date('H:i', strtotime($da['waktu_tutup'])) : '-';
                                                
                                                // Count Activities
                                                $qCount = mysqli_query($con, "SELECT COUNT(*) as tot FROM peg_laporan_harian WHERE username='$u' AND tanggal='$filter_date'");
                                                $rc = mysqli_fetch_assoc($qCount);
                                            ?>
                                                <tr data-widget="expandable-table" aria-expanded="false">
                                                    <td>
                                                        <b><?php echo $s['nm_person']; ?></b><br>
                                                        <small class="text-muted"><?php echo $u; ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="text-success"><?php echo $tBuka; ?></span> - <span class="text-danger"><?php echo $tTutup; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-info"><?php echo $rc['tot']; ?> Kegiatan</span>
                                                    </td>
                                                    <td>
                                                        <?php if ($stAb == 'buka') { ?>
                                                            <span class="badge badge-success">AKTIF / BUKA</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-secondary">TUTUP / TERKUNCI</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</button>
                                                        <?php if ($stAb == 'tutup') { ?>
                                                            <a href="sformMonitoringLaporanHarian.php?op=reopen&target=<?php echo $u; ?>&date=<?php echo $filter_date; ?>&q=<?php echo $filter_user; ?>&level=<?php echo $filter_level; ?>" 
                                                               class="btn btn-sm btn-warning" onclick="event.stopPropagation(); return confirm('Buka kembali akses absen untuk pegawai ini?')"><i class="fas fa-unlock"></i> Re-open</a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr class="expandable-body">
                                                    <td colspan="5">
                                                        <div class="p-3">
                                                            <table class="table table-bordered table-striped mb-0 small">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th>Waktu</th>
                                                                        <th>Kegiatan</th>
                                                                        <th>Keterangan</th>
                                                                        <th>Evidence</th>
                                                                        <th>Status</th>
                                                                        <th style="width: 180px">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $qActs = mysqli_query($con, "SELECT * FROM peg_laporan_harian WHERE username='$u' AND tanggal='$filter_date' ORDER BY waktu ASC");
                                                                    while ($ac = mysqli_fetch_assoc($qActs)) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo date('H:i', strtotime($ac['waktu'])); ?></td>
                                                                            <td><b><?php echo $ac['kegiatan']; ?></b></td>
                                                                            <td><?php echo $ac['keterangan']; ?></td>
                                                                            <td>
                                                                                <?php if ($ac['evidence']) { ?>
                                                                                    <a href="file_laporan_harian/<?php echo $s['nm_person']; ?>/<?php echo $ac['evidence']; ?>" target="_blank" class="text-info"><i class="fas fa-download"></i> View File</a>
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $bStatus = 'secondary';
                                                                                if ($ac['status_kegiatan'] == 'diterima') $bStatus = 'success';
                                                                                if ($ac['status_kegiatan'] == 'ditolak') $bStatus = 'danger';
                                                                                if ($ac['status_kegiatan'] == 'proses') $bStatus = 'warning';
                                                                                ?>
                                                                                <span class="badge badge-<?php echo $bStatus; ?>"><?php echo strtoupper($ac['status_kegiatan']); ?></span>
                                                                            </td>
                                                                                <td class="text-right">
                                                                                <?php if (!in_array($ac['kegiatan'], ['Absensi Masuk', 'Absensi Keluar'])) { ?>
                                                                                    <a href="sformMonitoringLaporanHarian.php?op=verifikasi&id=<?php echo $ac['id']; ?>&status=diterima&q=<?php echo $filter_user; ?>&level=<?php echo $filter_level; ?>&date=<?php echo $filter_date; ?>" class="btn btn-xs btn-success"><i class="fas fa-check"></i> Terima</a>
                                                                                    <a href="sformMonitoringLaporanHarian.php?op=verifikasi&id=<?php echo $ac['id']; ?>&status=ditolak&q=<?php echo $filter_user; ?>&level=<?php echo $filter_level; ?>&date=<?php echo $filter_date; ?>" class="btn btn-xs btn-danger"><i class="fas fa-times"></i> Tolak</a>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include("footerAdm.php"); ?>
        <?php include("jsAdm.php"); ?>
    </div>
</body>
</html>
