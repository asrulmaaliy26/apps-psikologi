<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("conAdm.php");

$ruangan_id = isset($_GET['ruangan_id']) ? intval($_GET['ruangan_id']) : 0;
if ($ruangan_id <= 0) {
    header("location:peminjamanRuangUmum.php");
    exit();
}

// Fetch Room details
$q_room = mysqli_query($con, "SELECT * FROM bmn_ruangan_booking WHERE id = $ruangan_id AND status_aktif = 1");
if (mysqli_num_rows($q_room) == 0) {
    header("location:peminjamanRuangUmum.php");
    exit();
}
$room = mysqli_fetch_assoc($q_room);
$imgPath = !empty($room['gambar']) ? "images/ruangan/" . $room['gambar'] : "images/no-image.png";

$hasSession = !empty($_SESSION['level']);

// Pre-populate data if logged in
$pre_name = "";
$pre_unit = "";
$pre_email = "";

if ($hasSession) {
    $level = $_SESSION['level'];
    $username = $_SESSION['username'];
    
    if ($level == 1) { // Dosen
        $q_dos = mysqli_query($con, "SELECT * FROM dt_dosen WHERE nip='$username'");
        if ($d_dos = mysqli_fetch_array($q_dos)) {
            $pre_name = $d_dos['nama'];
            $pre_unit = "Dosen / Staff Akademik";
            $pre_email = $d_dos['email'] ?? '';
        }
    } elseif ($level == 2) { // Mahasiswa S1
        $q_mhs = mysqli_query($con, "SELECT * FROM dt_mhssw WHERE nim='$username'");
        if ($d_mhs = mysqli_fetch_array($q_mhs)) {
            $pre_name = $d_mhs['nama'];
            $pre_unit = "Mahasiswa Psikologi S1 (NIM: " . $d_mhs['nim'] . ")";
            $pre_email = $d_mhs['imel'] ?? '';
        }
    } else {
        // Admin or other roles
        $q_adm = mysqli_query($con, "SELECT * FROM dt_all_adm WHERE username='$username'");
        if ($d_adm = mysqli_fetch_array($q_adm)) {
            $pre_name = $d_adm['nama'];
            $pre_unit = "Fakultas / Unit Admin";
            $pre_email = $d_adm['email'] ?? '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>
<style>
  :root {
    --primary-color: #17a2b8;
    --primary-gradient: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
  }
  .form-card {
    background: #ffffff;
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    overflow: hidden;
  }
  .form-header-premium {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #fff;
    padding: 30px;
    position: relative;
  }
  .btn-premium {
    border-radius: 10px;
    font-weight: 600;
    padding: 12px 24px;
    transition: all 0.3s;
  }
  .btn-premium-info {
    background: var(--primary-gradient);
    color: #fff;
    border: none;
  }
  .btn-premium-info:hover {
    box-shadow: 0 8px 15px rgba(23, 162, 184, 0.3);
    color: #fff;
  }
  .form-control-premium {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 12px 15px;
    height: auto;
    font-size: 0.9rem;
    transition: all 0.2s;
  }
  .form-control-premium:focus {
    border-color: #17a2b8;
    box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.15);
  }
  .room-summary-card {
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.15);
  }
  .guest-navbar {
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  }
</style>
<body class="hold-transition <?php echo $hasSession ? 'sidebar-mini layout-fixed' : ''; ?>" style="<?php echo !$hasSession ? 'background-color: #f8fafc; min-height: 100vh;' : ''; ?>">

<?php if ($hasSession) { ?>
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarDynamic.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold text-info"><i class="fas fa-calendar-plus mr-2"></i>Form Pengajuan Peminjaman</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="peminjamanRuangUmum.php">Daftar Ruang</a></li>
                <li class="breadcrumb-item active small">Form Pengajuan</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
<?php } else { ?>
  <!-- GUEST NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark guest-navbar py-3">
    <div class="container">
      <a class="navbar-brand font-weight-bold text-info d-flex align-items-center" href="peminjamanRuangUmum.php">
        <img src="images/logo_uin.png" width="30" height="35" class="d-inline-block align-top mr-2" alt="Logo UIN">
        <span>PsychoBMN <span class="text-white font-weight-light">Booking</span></span>
      </a>
      <div class="ml-auto">
        <a href="peminjamanRuangUmum.php" class="btn btn-outline-light btn-premium btn-sm px-4">
          <i class="fas fa-arrow-left mr-1"></i> Kembali ke Portal
        </a>
      </div>
    </div>
  </nav>

  <div class="container py-5">
<?php } ?>

      <div class="row justify-content-center">
        <div class="col-xl-10 col-12">
          
          <div class="form-card shadow-lg mb-5">
            <div class="form-header-premium">
              <div class="row align-items-center">
                <div class="col-md-7 mb-4 mb-md-0">
                  <span class="badge badge-info px-3 py-1 mb-2 font-weight-bold">Ruangan Terpilih</span>
                  <h2 class="font-weight-bold mb-2"><?php echo htmlspecialchars($room['nama_ruangan']); ?></h2>
                  <p class="text-white-50 small mb-0"><i class="fas fa-map-marker-alt text-info mr-1"></i> <?php echo htmlspecialchars($room['lokasi']); ?></p>
                </div>
                
                <div class="col-md-5">
                  <div class="room-summary-card p-3 d-flex align-items-center">
                    <img src="<?php echo $imgPath; ?>" style="width: 70px; height: 50px; object-fit: cover; border-radius: 8px;" class="mr-3" onError="this.onerror=null;this.src='images/cowok.png';">
                    <div class="small">
                      <div class="font-weight-bold">Detail Kapasitas:</div>
                      <div class="text-info"><?php echo $room['kapasitas']; ?> Orang Maks.</div>
                      <div class="text-white-50">Kondisi: <?php echo htmlspecialchars($room['kondisi']); ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <form action="peminjamanRuangAksi.php" method="post">
              <input type="hidden" name="ruangan_id" value="<?php echo $room['id']; ?>">
              <div class="card-body p-5">
                
                <div class="row">
                  <div class="col-12">
                    <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-4"><i class="fas fa-user-circle text-info mr-2"></i>Informasi Pengaju / Organisasi</h5>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Nama / Organisasi Pengaju <span class="text-danger">*</span></label>
                      <input type="text" name="nama_organisasi" class="form-control form-control-premium" placeholder="Contoh: BEM Psikologi / Ahmad Fauzi" value="<?php echo htmlspecialchars($pre_name); ?>" required>
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Unit / Lembaga / Status <span class="text-danger">*</span></label>
                      <input type="text" name="unit" class="form-control form-control-premium" placeholder="Contoh: Mahasiswa S1 / Dosen / Instansi Luar" value="<?php echo htmlspecialchars($pre_unit); ?>" required>
                    </div>
                  </div>
                  
                  <div class="col-md-12">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Alamat Email <span class="text-danger">*</span></label>
                      <input type="email" name="email" class="form-control form-control-premium" placeholder="Contoh: ahmad@gmail.com (Untuk notifikasi status booking)" value="<?php echo htmlspecialchars($pre_email); ?>" required>
                    </div>
                  </div>
                </div>
                
                <div class="row mt-3">
                  <div class="col-12">
                    <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-4"><i class="fas fa-calendar-alt text-info mr-2"></i>Detail Jadwal & Rincian Kegiatan</h5>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Tanggal Peminjaman <span class="text-danger">*</span></label>
                      <input type="date" name="tanggal" class="form-control form-control-premium" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Jam Mulai <span class="text-danger">*</span></label>
                      <input type="time" name="jam_mulai" class="form-control form-control-premium" required>
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Jam Selesai <span class="text-danger">*</span></label>
                      <input type="time" name="jam_selesai" class="form-control form-control-premium" required>
                    </div>
                  </div>
                  
                  <div class="col-md-8">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Nama / Judul Kegiatan <span class="text-danger">*</span></label>
                      <input type="text" name="kegiatan" class="form-control form-control-premium" placeholder="Contoh: Rapat Koordinasi Wilayah / Seminar Nasional" required>
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Perkiraan Kapasitas (Orang) <span class="text-danger">*</span></label>
                      <input type="number" name="kapasitas" class="form-control form-control-premium" min="1" max="<?php echo $room['kapasitas']; ?>" placeholder="Maks. <?php echo $room['kapasitas']; ?>" required>
                    </div>
                  </div>
                  
                  <div class="col-12">
                    <div class="form-group mb-4">
                      <label class="font-weight-bold small text-muted text-uppercase">Keterangan Kegiatan Lengkap & Fasilitas Yang Dibutuhkan</label>
                      <textarea name="keterangan" class="form-control form-control-premium" rows="4" placeholder="Tuliskan keterangan lengkap kegiatan, barang/perlengkapan tambahan yang dibutuhkan di ruangan seperti meja tambahan, sound system, dll."></textarea>
                    </div>
                  </div>
                </div>
                
                <div class="row mt-4">
                  <div class="col-12 text-right">
                    <a href="peminjamanRuangUmum.php" class="btn btn-secondary btn-premium px-4 mr-2">Batal</a>
                    <button type="submit" class="btn btn-info btn-premium btn-premium-info px-5 shadow-sm">
                      <i class="fas fa-paper-plane mr-2"></i> Ajukan Peminjaman Ruang
                    </button>
                  </div>
                </div>
                
              </div>
            </form>
          </div>
          
        </div>
      </div>

<?php if ($hasSession) { ?>
        </div>
      </section>
    </div>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
  </div>
<?php } else { ?>
  </div>
  
  <footer class="bg-dark text-white text-center py-4 mt-5 border-top border-secondary">
    <div class="container small opacity-75">
      &copy; 2026 Fakultas Psikologi UIN Maulana Malik Ibrahim Malang. All Rights Reserved.<br>
      <span class="text-info font-weight-bold">Biro Administrasi Umum dan BMN</span>
    </div>
  </footer>
  <?php include("jsAdm.php"); ?>
<?php } ?>

</body>
</html>
