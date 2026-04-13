<?php
include("contentsConAdm.php");
if ($_SESSION['level'] == 2 || $_SESSION['level'] == 3) {
    header("location:index.php");
    exit();
}

$username = $_SESSION['username'];
$today = date('Y-m-d');

// Check attendance status
$qAbsen = mysqli_query($con, "SELECT * FROM peg_absensi_harian WHERE username='$username' AND tanggal='$today'");
$dAbsen = mysqli_fetch_assoc($qAbsen);

$status_absen = $dAbsen ? $dAbsen['status_absen'] : 'belum';
$can_add = ($status_absen == 'buka');
$is_locked = ($status_absen == 'tutup');

?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("navtopAdm.php");
        // Determine sidebar based on level
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
                            <h4 class="mb-0">Laporan Harian Pegawai</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <span class="badge badge-info p-2"><?php echo date('d F Y'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <!-- Statistics / Status Card -->
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5>Halo, <b><?php echo $_SESSION['nm_person']; ?></b></h5>
                                    <p class="text-muted mb-0">Silahkan kelola laporan aktivitas harian Anda di sini.</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <?php if ($status_absen == 'belum') { ?>
                                        <form action="sformLaporanHarian.php?op=buka_absen" method="POST" style="display:inline;">
                                            <button type="submit" onclick="disableOnSubmit(this); return false;" class="btn btn-success btn-lg"><i class="fas fa-sign-in-alt"></i> Buka Absen</button>
                                        </form>
                                    <?php } else if ($status_absen == 'buka') { ?>
                                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalTambah"><i class="fas fa-plus"></i> Tambah Kegiatan</button>
                                        <button type="button" class="btn btn-danger btn-lg" onclick="konfirmasiTutup(this)"><i class="fas fa-sign-out-alt"></i> Tutup Absen</button>
                                    <?php } else { ?>
                                        <button class="btn btn-secondary btn-lg" disabled><i class="fas fa-lock"></i> Absensi Ditutup</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activities Table -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h3 class="card-title"><i class="fas fa-list mr-1"></i> Daftar Kegiatan Hari Ini</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">No</th>
                                        <th>Kegiatan</th>
                                        <th>Waktu</th>
                                        <th>Keterangan</th>
                                        <th>Evidence</th>
                                        <th>Status</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qList = mysqli_query($con, "SELECT * FROM peg_laporan_harian WHERE username='$username' AND tanggal='$today' ORDER BY waktu ASC");
                                    $no = 1;
                                    if (mysqli_num_rows($qList) == 0) {
                                        echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada kegiatan yang tercatat hari ini.</td></tr>";
                                    }
                                    while ($d = mysqli_fetch_assoc($qList)) {
                                        $status_badge = 'secondary';
                                        if ($d['status_kegiatan'] == 'diterima') $status_badge = 'success';
                                        if ($d['status_kegiatan'] == 'ditolak') $status_badge = 'danger';
                                        if ($d['status_kegiatan'] == 'proses') $status_badge = 'warning';
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><b><?php echo $d['kegiatan']; ?></b></td>
                                            <td><?php echo date('H:i', strtotime($d['waktu'])); ?></td>
                                            <td><?php echo $d['keterangan']; ?></td>
                                            <td>
                                                <?php if ($d['evidence']) { ?>
                                                    <a href="file_laporan_harian/<?php echo $_SESSION['nm_person']; ?>/<?php echo $d['evidence']; ?>" target="_blank" class="btn btn-xs btn-outline-info"><i class="fas fa-file"></i> View File</a>
                                                <?php } else { echo "-"; } ?>
                                            </td>
                                            <td><span class="badge badge-<?php echo $status_badge; ?>"><?php echo strtoupper($d['status_kegiatan']); ?></span></td>
                                            <td>
                                                <?php if (!$is_locked && $d['status_kegiatan'] == 'proses' && !in_array($d['kegiatan'], ['Absensi Masuk', 'Absensi Keluar'])) { ?>
                                                    <a href="sformLaporanHarian.php?op=hapus&id=<?php echo $d['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Hapus kegiatan ini?')"><i class="fas fa-trash"></i></a>
                                                <?php } else { echo "-"; } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="sformLaporanHarian.php?op=tambah" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Kegiatan Harian</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Kegiatan</label>
                                <input type="text" name="kegiatan" class="form-control" placeholder="Contoh: Rapat Koordinasi" required>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Detail aktivitas..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Evidence (Foto/PDF)</label>
                                <input type="file" name="evidence" class="form-control-file">
                                <small class="text-muted">Maksimal 2MB</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" onclick="disableOnSubmit(this); return false;" class="btn btn-primary">Simpan Kegiatan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hidden Form for Closing Attendance -->
        <form id="formTutup" action="sformLaporanHarian.php?op=tutup_absen" method="POST" style="display:none;"></form>

        <?php include("footerAdm.php"); ?>
        <?php include("jsAdm.php"); ?>

        <script>
            function disableOnSubmit(btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mohon Tunggu...';
                btn.form.submit();
            }

            function konfirmasiTutup(btn) {
                if (confirm("Apakah Anda yakin ingin menutup absensi hari ini? Setelah ditutup, Anda tidak dapat menambah kegiatan lagi.")) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menutup...';
                    document.getElementById('formTutup').submit();
                }
            }
        </script>
    </div>
</body>
</html>
