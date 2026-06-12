<?php
include("contentsConAdm.php");

// Proteksi level (hanya Admin Utama)
if (empty($_SESSION['level']) || $_SESSION['level'] !== 'adminutama') {
    header("Location: ../index.php");
    exit();
}

$judul = "";
$url = "";

// Fetch data from DB
$qJudul = mysqli_query($con, "SELECT nilai FROM pengaturan_informasi WHERE kunci='kalender_akademik_judul' LIMIT 1");
if ($rJudul = mysqli_fetch_assoc($qJudul)) {
    $judul = $rJudul['nilai'];
}

$qUrl = mysqli_query($con, "SELECT nilai FROM pengaturan_informasi WHERE kunci='kalender_akademik_url' LIMIT 1");
if ($rUrl = mysqli_fetch_assoc($qUrl)) {
    $url = $rUrl['nilai'];
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarAdminUtama.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold text-dark"><i class="fas fa-cogs mr-2 text-info"></i>Pengaturan Informasi</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_SESSION['msg_pengaturan'])) { ?>
            <div class="alert alert-<?php echo $_SESSION['msg_pengaturan']['type']; ?> alert-dismissible fade show" role="alert">
              <strong><?php echo $_SESSION['msg_pengaturan']['title']; ?></strong> <?php echo $_SESSION['msg_pengaturan']['text']; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php unset($_SESSION['msg_pengaturan']); } ?>

          <div class="row">
            <div class="col-md-6">
              <div class="card card-outline card-info shadow">
                <div class="card-header bg-white">
                  <h3 class="card-title text-muted font-weight-bold"><i class="fas fa-calendar-alt mr-2 text-secondary"></i>Kalender Akademik</h3>
                </div>
                <form action="aksiPengaturanSistem.php" method="POST">
                  <div class="card-body">
                    <p class="text-muted mb-4">
                      Atur judul dan link URL untuk file PDF Kalender Akademik yang akan ditampilkan pada seluruh Dashboard pengguna (Mahasiswa, Admin, dll).
                    </p>
                    <div class="form-group">
                      <label for="judul">Judul Kalender Akademik</label>
                      <input type="text" class="form-control" id="judul" name="kalender_akademik_judul" value="<?php echo htmlspecialchars($judul); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="url">URL / Link File PDF</label>
                      <input type="url" class="form-control" id="url" name="kalender_akademik_url" value="<?php echo htmlspecialchars($url); ?>" required>
                      <small class="form-text text-muted">Contoh: https://pasca.uin-malang.ac.id/.../Kalender.pdf</small>
                    </div>
                  </div>
                  <div class="card-footer bg-white text-right">
                    <button type="submit" class="btn btn-info font-weight-bold shadow-sm"><i class="fas fa-save mr-1"></i> Simpan Pengaturan</button>
                  </div>
                </form>
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
