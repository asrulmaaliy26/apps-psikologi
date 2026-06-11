<?php
// Cek session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("conAdm.php"); // Gunakan conAdm.php untuk koneksi DB

$hasSession = !empty($_SESSION['level']);
$userEmail = '';
if ($hasSession && !empty($_SESSION['username'])) {
    $session_username = mysqli_real_escape_string($con, $_SESSION['username']);
    $session_level = $_SESSION['level'];
    
    if ($session_level == 1) {
        // Dosen / Pegawai
        $q_dos = mysqli_query($con, "SELECT email1, email2 FROM dt_pegawai WHERE id = '$session_username'");
        if ($q_dos && $d_dos = mysqli_fetch_assoc($q_dos)) {
            $userEmail = !empty($d_dos['email1']) ? $d_dos['email1'] : $d_dos['email2'];
        }
    } elseif ($session_level == 2 || $session_level == 3) {
        // Mahasiswa S1 / S2
        $q_mhs = mysqli_query($con, "SELECT imel FROM dt_mhssw WHERE nim = '$session_username'");
        if ($q_mhs && $d_mhs = mysqli_fetch_assoc($q_mhs)) {
            $userEmail = $d_mhs['imel'];
        }
    }
    
    if (empty($userEmail)) {
        if (strpos($session_username, '@') !== false) {
            $userEmail = $session_username;
        } else {
            $q_peg = mysqli_query($con, "SELECT email1, email2 FROM dt_pegawai WHERE id = '$session_username'");
            if ($q_peg && $d_peg = mysqli_fetch_assoc($q_peg)) {
                $userEmail = !empty($d_peg['email1']) ? $d_peg['email1'] : $d_peg['email2'];
            } else {
                $userEmail = $session_username;
            }
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
    --bg-dark-accent: #1e293b;
  }
  .banner-premium {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #fff;
    border-radius: 20px;
    padding: 50px 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
  }
  .banner-premium::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(23,162,184,0.15) 0%, transparent 70%);
    border-radius: 50%;
  }
  .room-card {
    border-radius: 16px;
    border: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #ffffff;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  .room-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  }
  .room-img-container {
    height: 200px;
    position: relative;
    overflow: hidden;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    background: #f1f5f9;
  }
  .room-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
  }
  .room-card:hover .room-img {
    transform: scale(1.08);
  }
  .room-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    color: #fff;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 0.75rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  .btn-premium {
    border-radius: 10px;
    font-weight: 600;
    padding: 10px 20px;
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
  .track-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
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
              <h1 class="m-0 font-weight-bold text-info"><i class="fas fa-calendar-alt mr-2"></i>Peminjaman Ruangan</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="dashboardAdm.php">Dashboard</a></li>
                <li class="breadcrumb-item active small">Peminjaman Ruang</li>
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
      <a class="navbar-brand font-weight-bold text-info d-flex align-items-center" href="#">
        <img src="images/logo_uin.png" width="30" height="35" class="d-inline-block align-top mr-2" alt="Logo UIN">
        <span>PsychoBMN <span class="text-white font-weight-light">Booking</span></span>
      </a>
      <div class="ml-auto">
        <a href="../login.php" class="btn btn-outline-info btn-premium btn-sm px-4">
          <i class="fas fa-sign-in-alt mr-1"></i> Login Admin / Mahasiswa
        </a>
      </div>
    </div>
  </nav>

  <div class="container py-5">
<?php } ?>

      <!-- BANNER & INFO -->
      <div class="row mb-5">
        <div class="col-lg-8 mb-4 mb-lg-0">
          <div class="banner-premium">
            <h1 class="font-weight-bold mb-2">Peminjaman Ruangan Psikologi</h1>
            <p class="lead font-weight-light mb-4">Sistem booking mandiri ruangan BMN untuk civitas akademika Fakultas Psikologi UIN Malang dan pihak eksternal.</p>
            <div class="d-flex flex-wrap gap-3">
              <div class="bg-white-50 px-3 py-2 rounded-lg mr-3 mb-2" style="background: rgba(255,255,255,0.08); border-radius: 10px;">
                <h4 class="font-weight-bold mb-0 text-info">Prosedur Mudah</h4>
                <span class="small text-muted text-white-50">Pilih Ruang &rarr; Isi Formulir &rarr; Review BMN &rarr; Booking Selesai</span>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4">
          <div class="track-card p-4 h-100 d-flex flex-column justify-content-start">
            <?php if ($hasSession && !empty($userEmail)) { 
                $q_my_bookings = mysqli_query($con, "
                    SELECT p.*, r.nama_ruangan 
                    FROM bmn_peminjaman_ruangan p 
                    JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id 
                    WHERE p.email = '$userEmail' 
                    ORDER BY p.tgl_input DESC 
                    LIMIT 5
                ");
            ?>
              <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-history text-info mr-2"></i>Booking Saya</h5>
              <p class="small text-muted mb-3">Daftar peminjaman terbaru Anda dengan email <strong><?php echo htmlspecialchars($userEmail); ?></strong>:</p>
              
              <div style="max-height: 250px; overflow-y: auto; margin-bottom: 15px;" class="pr-1">
                <?php if (mysqli_num_rows($q_my_bookings) == 0) { ?>
                  <div class="text-center py-4 text-muted border rounded bg-light">
                    <i class="far fa-calendar-times fa-2x mb-2 text-secondary" style="opacity:0.5;"></i>
                    <p class="small mb-0">Belum ada riwayat booking menggunakan email Anda.</p>
                  </div>
                <?php } else { ?>
                  <div class="list-group">
                    <?php while ($mb = mysqli_fetch_assoc($q_my_bookings)) { 
                      $mb_status = $mb['status'];
                      $mb_badge = '';
                      if ($mb_status == 'pending') {
                          $mb_badge = '<span class="badge badge-warning">Diproses</span>';
                      } elseif ($mb_status == 'approved') {
                          $mb_badge = '<span class="badge badge-success">Disetujui</span>';
                      } elseif ($mb_status == 'rejected') {
                          $mb_badge = '<span class="badge badge-danger">Ditolak</span>';
                      } elseif ($mb_status == 'proposed') {
                          $mb_badge = '<span class="badge badge-info">Usulan Baru</span>';
                      } elseif ($mb_status == 'accepted_change') {
                          $mb_badge = '<span class="badge badge-success">Disetujui</span>';
                      } elseif ($mb_status == 'declined_change') {
                          $mb_badge = '<span class="badge badge-danger">Dibatalkan</span>';
                      }
                    ?>
                      <a href="peminjamanRuangDetail.php?token=<?php echo $mb['booking_token']; ?>" class="list-group-item list-group-item-action p-2 border-0 mb-2 bg-light rounded shadow-xs" style="transition:all 0.2s;">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                          <span class="font-weight-bold text-dark small"><?php echo htmlspecialchars($mb['nama_ruangan']); ?></span>
                          <?php echo $mb_badge; ?>
                        </div>
                        <p class="mb-1 text-muted font-italic" style="font-size: 0.75rem;">"<?php echo htmlspecialchars($mb['kegiatan']); ?>"</p>
                        <small class="text-info font-weight-bold" style="font-size: 0.7rem;">
                          <?php
                            $bookingDate = !empty($mb['tanggal_akhir']) && $mb['tanggal_akhir'] !== '0000-00-00' && $mb['tanggal_akhir'] !== $mb['tanggal']
                                ? date('d/m/y', strtotime($mb['tanggal'])) . ' s.d. ' . date('d/m/y', strtotime($mb['tanggal_akhir']))
                                : date('d/m/y', strtotime($mb['tanggal']));
                          ?>
                          <i class="far fa-calendar-alt mr-1"></i><?php echo $bookingDate; ?> &bull; 
                          <i class="far fa-clock mr-1"></i><?php echo substr($mb['jam_mulai'], 0, 5); ?>
                        </small>
                      </a>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
              
              <div class="mt-auto border-top pt-2">
                <p class="small text-muted mb-1 text-center font-weight-bold">- ATAU CARI DENGAN TOKEN -</p>
                <form action="peminjamanRuangDetail.php" method="get">
                  <div class="input-group input-group-sm mb-2" style="border-radius: 8px; overflow: hidden; border: 1px solid #ced4da;">
                    <input type="text" name="token" class="form-control border-0" placeholder="Token Peminjaman..." required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-info border-0"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            <?php } else { ?>
              <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-search-location text-info mr-2"></i>Lacak Peminjaman</h5>
              <p class="small text-muted mb-4">Masukkan 16 karakter token peminjaman Anda untuk melihat status persetujuan, mengonfirmasi usulan jadwal baru dari admin, atau mengunduh bukti booking.</p>
              <form action="peminjamanRuangDetail.php" method="get">
                <div class="form-group mb-3">
                  <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white border-right-0"><i class="fas fa-ticket-alt text-info"></i></span>
                    </div>
                    <input type="text" name="token" class="form-control border-left-0" placeholder="Contoh: BMN1234567890ABC" style="height: 48px;" required>
                  </div>
                </div>
                <button type="submit" class="btn btn-info btn-block btn-premium shadow-sm py-2">
                  <i class="fas fa-search mr-1"></i> Cari & Lacak Status
                </button>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- MAIN CONTENT: ROOM LIST -->
      <div class="row mb-4">
        <div class="col-12">
          <h3 class="font-weight-bold text-dark mb-1"><i class="fas fa-home text-info mr-2"></i>Pilihan Ruangan yang Tersedia</h3>
          <p class="text-muted">Daftar ruangan aktif yang dapat Anda pinjam untuk keperluan akademik, organisasi, maupun kegiatan eksternal.</p>
        </div>
      </div>

      <div class="row">
        <?php
        $q_ruang = mysqli_query($con, "SELECT * FROM bmn_ruangan_booking WHERE status_aktif = 1 ORDER BY nama_ruangan ASC");
        if (mysqli_num_rows($q_ruang) == 0) {
            echo '<div class="col-12"><div class="card p-5 text-center text-muted border-0 shadow-sm" style="border-radius: 16px;"><i class="fas fa-building fa-4x text-info-light mb-3"></i><h5>Mohon maaf, belum ada ruangan aktif yang dimasukkan oleh Admin BMN.</h5></div></div>';
        }
        while ($d = mysqli_fetch_array($q_ruang)) {
            $imgPath = !empty($d['gambar']) ? "images/ruangan/" . $d['gambar'] : "images/no-image.png";
        ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="room-card">
              <div class="room-img-container">
                <img src="<?php echo $imgPath; ?>" class="room-img" onError="this.onerror=null;this.src='images/cowok.png';">
                <div class="room-badge">
                  <i class="fas fa-users mr-1"></i> Kapasitas: <?php echo $d['kapasitas']; ?>
                </div>
              </div>
              <div class="card-body p-4 d-flex flex-column" style="flex-grow: 1;">
                <h5 class="font-weight-bold text-dark mb-2"><?php echo htmlspecialchars($d['nama_ruangan']); ?></h5>
                <div class="d-flex align-items-center mb-2 text-muted small">
                  <i class="fas fa-map-marker-alt text-info mr-2" style="width: 14px;"></i>
                  <span><?php echo htmlspecialchars($d['lokasi']); ?></span>
                </div>
                <div class="d-flex align-items-center mb-3 text-muted small">
                  <i class="fas fa-shield-alt text-info mr-2" style="width: 14px;"></i>
                  <span>Kondisi: <strong><?php echo htmlspecialchars($d['kondisi']); ?></strong></span>
                </div>
                <p class="text-muted small mb-4" style="flex-grow: 1; line-height: 1.5;">
                  <?php echo !empty($d['keterangan']) ? htmlspecialchars($d['keterangan']) : "Fasilitas lengkap untuk menunjang kelancaran kegiatan Anda."; ?>
                </p>

                <!-- Jadwal & Peminjam Collapsible -->
                <?php
                $ruang_id = $d['id'];
                $q_sched = mysqli_query($con, "
                    SELECT nama_organisasi, unit, tanggal, tanggal_akhir, jam_mulai, jam_selesai, status, kegiatan 
                    FROM bmn_peminjaman_ruangan 
                    WHERE ruangan_id = $ruang_id 
                      AND status IN ('pending', 'approved', 'accepted_change', 'proposed') 
                      AND (
                          tanggal >= CURDATE()
                          OR tanggal_akhir >= CURDATE()
                          OR (tanggal <= CURDATE() AND tanggal_akhir >= CURDATE())
                      )
                    ORDER BY tanggal ASC, jam_mulai ASC
                ");
                $sched_count = mysqli_num_rows($q_sched);
                ?>
                <button class="btn btn-outline-info btn-block btn-sm mb-3 btn-premium font-weight-bold" type="button" data-toggle="collapse" data-target="#schedCollapse<?php echo $ruang_id; ?>" aria-expanded="false" style="border-width: 2px;">
                    <i class="far fa-calendar-alt mr-1"></i> Lihat Jadwal & Peminjam (<?php echo $sched_count; ?>)
                </button>
                <div class="collapse mb-3" id="schedCollapse<?php echo $ruang_id; ?>">
                    <div class="p-3 bg-light rounded border text-left" style="max-height: 200px; overflow-y: auto; font-size: 0.8rem;">
                        <?php if ($sched_count == 0) { ?>
                            <div class="text-muted text-center py-2"><i class="fas fa-calendar-check mr-1 text-success"></i>Belum ada jadwal peminjaman aktif.</div>
                        <?php } else { ?>
                            <ul class="list-unstyled mb-0">
                                <?php 
                                while ($s = mysqli_fetch_assoc($q_sched)) {
                                    $s_status = $s['status'];
                                    $status_badge = '';
                                    if ($s_status == 'pending') {
                                        $status_badge = '<span class="badge badge-warning float-right px-2 py-1">Diproses</span>';
                                    } else {
                                        $status_badge = '<span class="badge badge-success float-right px-2 py-1">Disetujui</span>';
                                    }
                                    
                                    if (!empty($s['tanggal_akhir']) && $s['tanggal_akhir'] !== '0000-00-00' && $s['tanggal_akhir'] !== $s['tanggal']) {
                                        $date_formatted = date('d M Y', strtotime($s['tanggal'])) . ' s.d. ' . date('d M Y', strtotime($s['tanggal_akhir']));
                                    } else {
                                        $date_formatted = date('d M Y', strtotime($s['tanggal']));
                                    }
                                    $time_formatted = substr($s['jam_mulai'], 0, 5) . ' - ' . substr($s['jam_selesai'], 0, 5);
                                ?>
                                    <li class="border-bottom pb-2 mb-2">
                                        <?php echo $status_badge; ?>
                                        <div class="font-weight-bold text-dark mb-1" style="max-width: 70%;"><?php echo htmlspecialchars($s['nama_organisasi']); ?></div>
                                        <div class="text-muted small">
                                            <i class="far fa-calendar-alt mr-1"></i><?php echo $date_formatted; ?><br>
                                            <i class="far fa-clock mr-1"></i><?php echo $time_formatted; ?>
                                        </div>
                                        <div class="text-info mt-1 font-italic small" style="font-size: 0.75rem;">
                                            "<?php echo htmlspecialchars($s['kegiatan']); ?>"
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>

                <a href="peminjamanRuangForm.php?ruangan_id=<?php echo $d['id']; ?>" class="btn btn-info btn-block btn-premium btn-premium-info py-2 shadow-sm">
                  <i class="fas fa-calendar-plus mr-1"></i> Ajukan Peminjaman
                </a>
              </div>
            </div>
          </div>
        <?php } ?>
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
