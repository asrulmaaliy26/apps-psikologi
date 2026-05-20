<?php
include("contentsConAdm.php");
if ($_SESSION['level'] != 11) {
    header("location:index.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch from dt_pegawai
$qPeg = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
$dPeg = mysqli_fetch_assoc($qPeg);

// If not found in dt_pegawai, handle gracefully
if (!$dPeg) {
    $dPeg = [
        'id' => $username,
        'nama' => $_SESSION['nm_person'],
        'nama_tg' => $_SESSION['nm_person'],
        'status' => '1',
        'jenis_pegawai' => '2'
    ];
}

$message = '';
$msg_type = 'success';

if (isset($_POST['update_profile'])) {
    $alamat_ktp = mysqli_real_escape_string($con, $_POST['alamat_ktp']);
    $alamat_rumah = mysqli_real_escape_string($con, $_POST['alamat_rumah']);
    $kntk1 = mysqli_real_escape_string($con, $_POST['kntk1']);
    $kntk2 = mysqli_real_escape_string($con, $_POST['kntk2']);
    $email1 = mysqli_real_escape_string($con, $_POST['email1']);
    $email2 = mysqli_real_escape_string($con, $_POST['email2']);
    
    // Check if record exists in dt_pegawai
    $qCheck = mysqli_query($con, "SELECT id FROM dt_pegawai WHERE id='$username'");
    if (mysqli_num_rows($qCheck) > 0) {
        $qUpdate = mysqli_query($con, "UPDATE dt_pegawai SET 
            alamat_ktp = '$alamat_ktp',
            alamat_rumah = '$alamat_rumah',
            kntk1 = '$kntk1',
            kntk2 = '$kntk2',
            email1 = '$email1',
            email2 = '$email2'
            WHERE id = '$username'");
    } else {
        // Insert fallback
        $qUpdate = mysqli_query($con, "INSERT INTO dt_pegawai (id, jenis_pegawai, nama, nama_tg, status, alamat_ktp, alamat_rumah, kntk1, kntk2, email1, email2) 
            VALUES ('$username', '2', '{$_SESSION['nm_person']}', '{$_SESSION['nm_person']}', '1', '$alamat_ktp', '$alamat_rumah', '$kntk1', '$kntk2', '$email1', '$email2')");
    }
    
    if ($qUpdate) {
        $message = 'Profil berhasil diperbarui!';
        $msg_type = 'success';
        // Refresh local data
        $qPeg = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
        $dPeg = mysqli_fetch_assoc($qPeg);
    } else {
        $message = 'Gagal memperbarui profil: ' . mysqli_error($con);
        $msg_type = 'danger';
    }
}

if (isset($_POST['change_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    
    if ($new_pass !== $confirm_pass) {
        $message = 'Konfirmasi password baru tidak cocok!';
        $msg_type = 'danger';
    } else {
        $md5_current = md5($current_pass);
        $qCheckPass = mysqli_query($con, "SELECT password FROM dt_all_adm WHERE username='$username' AND password='$md5_current'");
        if (mysqli_num_rows($qCheckPass) == 0) {
            $message = 'Password saat ini salah!';
            $msg_type = 'danger';
        } else {
            $md5_new = md5($new_pass);
            $qUpdatePass = mysqli_query($con, "UPDATE dt_all_adm SET password='$md5_new' WHERE username='$username'");
            if ($qUpdatePass) {
                $message = 'Password berhasil diubah!';
                $msg_type = 'success';
            } else {
                $message = 'Gagal mengubah password: ' . mysqli_error($con);
                $msg_type = 'danger';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("navtopAdm.php");
        include("navSideBarKaryawan.php");
        ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="mb-0">Profil Karyawan</h4>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    
                    <?php if ($message) { ?>
                        <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                            <i class="fas <?php echo ($msg_type == 'success') ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> mr-1"></i>
                            <?php echo $message; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <!-- Left Column: Profile Card -->
                        <div class="col-md-4">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" 
                                             src="images/cowok.png" 
                                             onError="this.onerror=null;this.src='<?php echo ($dPeg['jenis_kelamin'] == '2') ? 'images/cewek.png' : 'images/cowok.png'; ?>';" 
                                             alt="User profile picture" 
                                             style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>

                                    <h3 class="profile-username text-center mt-3 text-md font-weight-bold"><?php echo htmlspecialchars($dPeg['nama_tg']); ?></h3>
                                    <p class="text-muted text-center mb-2"><?php echo htmlspecialchars($dPeg['id']); ?></p>

                                    <ul class="list-group list-group-unbordered mb-3 text-sm">
                                        <li class="list-group-item">
                                            <b>Kategori Pegawai</b> <span class="float-right badge badge-info">Tendik</span>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Status</b> 
                                            <span class="float-right badge badge-<?php echo ($dPeg['status'] == '1') ? 'success' : 'secondary'; ?>">
                                                <?php echo ($dPeg['status'] == '1') ? 'Aktif' : 'Tidak Aktif'; ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Jabatan</b> <span class="float-right text-muted"><?php echo htmlspecialchars($dPeg['jabatan_instansi'] ?: 'Staf Kependidikan'); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Detail Tabs -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills text-sm">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#info" data-toggle="tab"><i class="fas fa-id-card mr-1"></i> Data Kepegawaian</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#edit" data-toggle="tab"><i class="fas fa-edit mr-1"></i> Edit Kontak & Alamat</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#security" data-toggle="tab"><i class="fas fa-key mr-1"></i> Ganti Password</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body text-sm">
                                    <div class="tab-content">
                                        
                                        <!-- Tab 1: Info -->
                                        <div class="active tab-pane" id="info">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted mb-1">Tanggal CPNS</label>
                                                    <p class="font-weight-bold border-bottom pb-1"><?php echo htmlspecialchars($dPeg['tgl_cpns'] ?: '-'); ?></p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted mb-1">TMT (Terhitung Mulai Tanggal)</label>
                                                    <p class="font-weight-bold border-bottom pb-1"><?php echo htmlspecialchars($dPeg['tmt'] ?: '-'); ?></p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted mb-1">Pangkat / Golongan</label>
                                                    <p class="font-weight-bold border-bottom pb-1"><?php echo htmlspecialchars($dPeg['pangkat'] ?: '-'); ?></p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted mb-1">Tempat & Tanggal Lahir</label>
                                                    <p class="font-weight-bold border-bottom pb-1">
                                                        <?php echo htmlspecialchars(($dPeg['tempat_lahir'] ? $dPeg['tempat_lahir'] . ', ' : '') . ($dPeg['tanggal_lahir'] ?: '-')); ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <h5 class="text-primary border-bottom pb-1 mt-3 mb-3 font-weight-bold"><i class="fas fa-graduation-cap mr-1"></i> Riwayat Pendidikan</h5>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="text-muted mb-1">Strata 1 (S1)</label>
                                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars($dPeg['strata1'] ?: '-'); ?></p>
                                                    <small class="text-muted">Tahun: <?php echo htmlspecialchars($dPeg['th_s1'] ?: '-'); ?></small>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="text-muted mb-1">Strata 2 (S2)</label>
                                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars($dPeg['strata2'] ?: '-'); ?></p>
                                                    <small class="text-muted">Tahun: <?php echo htmlspecialchars($dPeg['th_s2'] ?: '-'); ?></small>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="text-muted mb-1">Strata 3 (S3)</label>
                                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars($dPeg['strata3'] ?: '-'); ?></p>
                                                    <small class="text-muted">Tahun: <?php echo htmlspecialchars($dPeg['th_s3'] ?: '-'); ?></small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab 2: Edit -->
                                        <div class="tab-pane" id="edit">
                                            <form action="" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label>No. HP / Kontak 1</label>
                                                        <input type="text" name="kntk1" class="form-control form-control-sm" value="<?php echo htmlspecialchars($dPeg['kntk1']); ?>" placeholder="08xxxxxxxx">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>No. HP / Kontak 2 (Opsional)</label>
                                                        <input type="text" name="kntk2" class="form-control form-control-sm" value="<?php echo htmlspecialchars($dPeg['kntk2']); ?>" placeholder="08xxxxxxxx">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Email Utama</label>
                                                        <input type="email" name="email1" class="form-control form-control-sm" value="<?php echo htmlspecialchars($dPeg['email1']); ?>" placeholder="nama@domain.com">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Email Alternatif (Opsional)</label>
                                                        <input type="email" name="email2" class="form-control form-control-sm" value="<?php echo htmlspecialchars($dPeg['email2']); ?>" placeholder="nama@domain.com">
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Alamat KTP</label>
                                                        <textarea name="alamat_ktp" class="form-control form-control-sm" rows="2" placeholder="Alamat lengkap sesuai KTP..."><?php echo htmlspecialchars($dPeg['alamat_ktp']); ?></textarea>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Alamat Rumah Tinggal</label>
                                                        <textarea name="alamat_rumah" class="form-control form-control-sm" rows="2" placeholder="Alamat tinggal saat ini..."><?php echo htmlspecialchars($dPeg['alamat_rumah']); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" name="update_profile" class="btn btn-sm btn-primary mt-2">
                                                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Tab 3: Security -->
                                        <div class="tab-pane" id="security">
                                            <form action="" method="POST">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Password Saat Ini</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" name="current_password" class="form-control form-control-sm" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Password Baru</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" name="new_password" class="form-control form-control-sm" required minlength="4">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Konfirmasi Password Baru</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" name="confirm_password" class="form-control form-control-sm" required minlength="4">
                                                    </div>
                                                </div>
                                                <div class="text-right mt-3">
                                                    <button type="submit" name="change_password" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-key mr-1"></i> Ubah Password
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
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
