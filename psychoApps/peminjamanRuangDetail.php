<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("conAdm.php");

$token = isset($_GET['token']) ? mysqli_real_escape_string($con, trim($_GET['token'])) : '';
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

// Proses Aksi User Menerima atau Menolak Usulan Perubahan
$post_action_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && !empty($token)) {
    $action = $_POST['action'];
    
    // Ambil data untuk validasi status 'proposed'
    $q_chk = mysqli_query($con, "SELECT id, status FROM bmn_peminjaman_ruangan WHERE booking_token = '$token'");
    if (mysqli_num_rows($q_chk) > 0) {
        $d_chk = mysqli_fetch_assoc($q_chk);
        $booking_id = $d_chk['id'];
        $current_status = $d_chk['status'];
        
        if ($current_status == 'proposed') {
            if ($action == 'accept') {
                // User menerima perubahan -> status diubah menjadi 'accepted_change'
                $query_update = "UPDATE bmn_peminjaman_ruangan SET status = 'accepted_change' WHERE id = $booking_id";
                if (mysqli_query($con, $query_update)) {
                    $post_action_message = "success_accept";
                } else {
                    $post_action_message = "gagal";
                }
            } elseif ($action == 'decline') {
                // User menolak usulan -> status diubah menjadi 'declined_change'
                $user_reason = isset($_POST['user_reason']) ? mysqli_real_escape_string($con, $_POST['user_reason']) : '';
                $comment_update = "Usulan ditolak oleh Pengaju.";
                if (!empty($user_reason)) {
                    $comment_update .= " Alasan: " . $user_reason;
                }
                
                $query_update = "UPDATE bmn_peminjaman_ruangan SET status = 'declined_change', admin_comment = CONCAT(admin_comment, '\n\n', '$comment_update') WHERE id = $booking_id";
                if (mysqli_query($con, $query_update)) {
                    $post_action_message = "success_decline";
                } else {
                    $post_action_message = "gagal";
                }
            }
        }
    }
}

// Fetch booking data
$booking = null;
if (!empty($token)) {
    $q_book = mysqli_query($con, "
        SELECT p.*, r.nama_ruangan, r.lokasi, r.gambar, r.kondisi 
        FROM bmn_peminjaman_ruangan p 
        JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id 
        WHERE p.booking_token = '$token'
    ");
    if (mysqli_num_rows($q_book) > 0) {
        $booking = mysqli_fetch_assoc($q_book);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>
<style>
  :root {
    --primary-gradient: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
    --success-gradient: linear-gradient(135deg, #28a745 0%, #218838 100%);
    --danger-gradient: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
  }
  .detail-card {
    background: #ffffff;
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    overflow: hidden;
  }
  .detail-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #fff;
    padding: 30px 40px;
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
  .badge-status-large {
    padding: 10px 20px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 700;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    display: inline-block;
  }
  .comparison-card {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
  }
  .comparison-side {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #edf2f7;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
  }
  .highlight-change {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 2px 6px;
    border-radius: 6px;
    font-weight: 600;
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
              <h1 class="m-0 font-weight-bold text-info"><i class="fas fa-ticket-alt mr-2"></i>Status Pelacakan Peminjaman</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="peminjamanRuangUmum.php">Daftar Ruang</a></li>
                <li class="breadcrumb-item active small">Pelacakan</li>
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
        <div class="col-xl-9 col-lg-10 col-12">
          
          <?php if (!$booking) { ?>
            <!-- TOKEN NOT FOUND or LIST MY BOOKINGS -->
            <?php if ($hasSession && !empty($userEmail)) { 
                $q_my_details_bookings = mysqli_query($con, "
                    SELECT p.*, r.nama_ruangan, r.lokasi 
                    FROM bmn_peminjaman_ruangan p 
                    JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id 
                    WHERE p.email = '$userEmail' 
                    ORDER BY p.tgl_input DESC
                ");
            ?>
              <div class="card p-5 border-0 shadow-lg" style="border-radius: 20px;">
                <div class="text-center mb-4">
                  <i class="fas fa-history fa-4x text-info mb-2"></i>
                  <h3 class="font-weight-bold text-dark">Daftar Booking Saya</h3>
                  <p class="text-muted max-width-md mx-auto small">Daftar seluruh permohonan peminjaman ruangan Anda yang terhubung dengan email <strong><?php echo htmlspecialchars($userEmail); ?></strong>.</p>
                </div>
                
                <?php if (mysqli_num_rows($q_my_details_bookings) == 0) { ?>
                  <div class="text-center py-5 text-muted border rounded bg-light">
                    <i class="far fa-calendar-times fa-3x mb-3 text-secondary" style="opacity:0.5;"></i>
                    <h5>Belum ada peminjaman terdaftar</h5>
                    <p class="small mb-0">Silakan ajukan peminjaman ruangan terlebih dahulu lewat portal utama.</p>
                  </div>
                <?php } else { ?>
                  <div class="row">
                    <?php while ($mb = mysqli_fetch_assoc($q_my_details_bookings)) { 
                      $mb_status = $mb['status'];
                      $mb_badge = '';
                      $card_border = '';
                      if ($mb_status == 'pending') {
                          $mb_badge = '<span class="badge badge-warning px-3 py-2">Menunggu Review BMN</span>';
                          $card_border = 'border-left: 5px solid #ffc107;';
                      } elseif ($mb_status == 'approved') {
                          $mb_badge = '<span class="badge badge-success px-3 py-2">Disetujui</span>';
                          $card_border = 'border-left: 5px solid #28a745;';
                      } elseif ($mb_status == 'rejected') {
                          $mb_badge = '<span class="badge badge-danger px-3 py-2">Ditolak</span>';
                          $card_border = 'border-left: 5px solid #dc3545;';
                      } elseif ($mb_status == 'proposed') {
                          $mb_badge = '<span class="badge badge-info px-3 py-2">Usulan Jadwal Baru</span>';
                          $card_border = 'border-left: 5px solid #17a2b8;';
                      } elseif ($mb_status == 'accepted_change') {
                          $mb_badge = '<span class="badge badge-success px-3 py-2">Disetujui (Penyesuaian)</span>';
                          $card_border = 'border-left: 5px solid #28a745;';
                      } elseif ($mb_status == 'declined_change') {
                          $mb_badge = '<span class="badge badge-danger px-3 py-2">Dibatalkan</span>';
                          $card_border = 'border-left: 5px solid #dc3545;';
                      }
                    ?>
                      <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border" style="border-radius: 12px; overflow: hidden; <?php echo $card_border; ?>">
                          <div class="card-body p-4 d-flex flex-column text-left">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                              <span class="small font-weight-bold text-muted">Token: <code><?php echo $mb['booking_token']; ?></code></span>
                              <?php echo $mb_badge; ?>
                            </div>
                            <h5 class="font-weight-bold text-dark mb-1"><?php echo htmlspecialchars($mb['nama_ruangan']); ?></h5>
                            <p class="text-secondary small font-italic mb-3">"<?php echo htmlspecialchars($mb['kegiatan']); ?>"</p>
                            
                            <div class="small text-muted mb-4" style="line-height: 1.6;">
                              <div><i class="far fa-calendar-alt mr-2 text-info"></i><?php echo date('d-m-Y', strtotime($mb['tanggal'])); ?></div>
                              <div><i class="far fa-clock mr-2 text-info"></i><?php echo substr($mb['jam_mulai'], 0, 5) . ' - ' . substr($mb['jam_selesai'], 0, 5); ?> WIB</div>
                              <div><i class="fas fa-users mr-2 text-info"></i><?php echo htmlspecialchars($mb['nama_organisasi']); ?> &bull; Unit: <?php echo htmlspecialchars($mb['unit']); ?></div>
                            </div>
                            
                            <a href="peminjamanRuangDetail.php?token=<?php echo $mb['booking_token']; ?>" class="btn btn-info btn-block btn-sm btn-premium py-2 mt-auto">
                              <i class="fas fa-search-location mr-1"></i> Lacak Status Detail
                            </a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                <?php } ?>
                
                <div class="text-center mt-4 pt-3 border-top">
                  <a href="peminjamanRuangUmum.php" class="btn btn-outline-secondary btn-premium px-4">
                    <i class="fas fa-home mr-1"></i> Kembali ke Portal Utama
                  </a>
                </div>
              </div>
            <?php } else { ?>
              <!-- TOKEN NOT FOUND GUEST VIEW -->
              <div class="card p-5 text-center border-0 shadow-lg" style="border-radius: 20px;">
                <div class="mb-4">
                  <i class="fas fa-search-minus fa-5x text-muted" style="opacity: 0.5;"></i>
                </div>
                <h3 class="font-weight-bold text-dark mb-2">Token Tidak Ditemukan</h3>
                <p class="text-muted mb-4 max-width-md mx-auto">Mohon maaf, token pelacakan peminjaman ruangan <strong>"<?php echo htmlspecialchars($token); ?>"</strong> tidak terdaftar dalam database kami. Pastikan token yang Anda masukkan benar.</p>
                <div class="d-flex justify-content-center">
                  <a href="peminjamanRuangUmum.php" class="btn btn-info btn-premium btn-premium-info px-4">
                    <i class="fas fa-home mr-1"></i> Kembali & Cari Lagi
                  </a>
                </div>
              </div>
            <?php } ?>
            
          <?php } else { ?>
            
            <!-- NOTIFIKASI BARU SAJA DIAJUKAN -->
            <?php if (isset($_GET['new']) && $_GET['new'] == 'true') { ?>
              <div class="alert alert-success border-0 shadow-sm p-4 mb-4" style="border-radius: 16px; background: #ecfdf5;">
                <div class="d-flex align-items-start">
                  <i class="fas fa-check-circle text-success fa-2x mr-3 mt-1"></i>
                  <div>
                    <h5 class="font-weight-bold text-success mb-1">Pengajuan Berhasil Dikirim!</h5>
                    <p class="text-muted small mb-3">Pengajuan peminjaman ruangan Anda telah berhasil direkam ke sistem. Catat atau salin token peminjaman di bawah ini untuk melacak status persetujuan BMN di masa mendatang.</p>
                    
                    <div class="d-flex align-items-center flex-wrap">
                      <div class="bg-white border rounded px-3 py-2 mr-3 font-weight-bold text-info" style="font-size: 1.1rem; letter-spacing: 0.5px;" id="tokenVal">
                        <?php echo $booking['booking_token']; ?>
                      </div>
                      <button class="btn btn-outline-success btn-sm btn-premium py-2 px-3" onclick="copyToken()">
                        <i class="far fa-copy mr-1"></i> Salin Token
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <script>
                function copyToken() {
                  var tokenText = document.getElementById('tokenVal').innerText;
                  navigator.clipboard.writeText(tokenText).then(function() {
                    alert('Token berhasil disalin ke clipboard!');
                  }, function(err) {
                    alert('Gagal menyalin token.');
                  });
                }
              </script>
            <?php } ?>

            <!-- NOTIFIKASI AKSI POST USER -->
            <?php if (!empty($post_action_message)) { ?>
              <?php if ($post_action_message == 'success_accept') { ?>
                <div class="alert alert-success border-0 shadow-sm p-3 mb-4" style="border-radius: 12px;">
                  <i class="fas fa-check-circle mr-2"></i> Usulan perubahan admin telah <strong>Anda terima</strong>. Booking Anda kini telah resmi disetujui!
                </div>
              <?php } elseif ($post_action_message == 'success_decline') { ?>
                <div class="alert alert-danger border-0 shadow-sm p-3 mb-4" style="border-radius: 12px;">
                  <i class="fas fa-times-circle mr-2"></i> Usulan perubahan admin telah <strong>Anda tolak</strong>. Status peminjaman ini dibatalkan.
                </div>
              <?php } elseif ($post_action_message == 'gagal') { ?>
                <div class="alert alert-warning border-0 shadow-sm p-3 mb-4" style="border-radius: 12px;">
                  <i class="fas fa-exclamation-triangle mr-2"></i> Terjadi kesalahan saat memproses keputusan Anda. Silakan coba beberapa saat lagi.
                </div>
              <?php } ?>
              <script>
                setTimeout(function() {
                  window.location.href = 'peminjamanRuangDetail.php?token=<?php echo $booking['booking_token']; ?>';
                }, 2500);
              </script>
            <?php } ?>

            <!-- DETAIL CARD -->
            <div class="detail-card shadow-lg mb-5">
              
              <!-- Header -->
              <div class="detail-header">
                <div class="row align-items-center">
                  <div class="col-md-7 mb-3 mb-md-0">
                    <span class="small text-white-50 text-uppercase font-weight-bold">Token Pelacakan: <code><?php echo $booking['booking_token']; ?></code></span>
                    <h2 class="font-weight-bold mt-1 mb-2"><?php echo htmlspecialchars($booking['kegiatan']); ?></h2>
                    <p class="text-white-50 small mb-0"><i class="fas fa-building mr-1 text-info"></i> <?php echo htmlspecialchars($booking['nama_organisasi']); ?> &bull; Unit: <?php echo htmlspecialchars($booking['unit']); ?></p>
                  </div>
                  
                  <div class="col-md-5 text-md-right">
                    <?php
                    $status = $booking['status'];
                    if ($status == 'pending') {
                        echo '<span class="badge-status-large bg-warning text-dark"><i class="fas fa-hourglass-half mr-1"></i> Menunggu Review BMN</span>';
                    } elseif ($status == 'approved') {
                        echo '<span class="badge-status-large bg-success text-white"><i class="fas fa-check-circle mr-1"></i> Pengajuan Disetujui</span>';
                    } elseif ($status == 'rejected') {
                        echo '<span class="badge-status-large bg-danger text-white"><i class="fas fa-times-circle mr-1"></i> Pengajuan Ditolak</span>';
                    } elseif ($status == 'proposed') {
                        echo '<span class="badge-status-large bg-info text-white"><i class="fas fa-exclamation-circle mr-1"></i> Usulan Jadwal Baru</span>';
                    } elseif ($status == 'accepted_change') {
                        echo '<span class="badge-status-large bg-success text-white"><i class="fas fa-check-double mr-1"></i> Booking Selesai (Perubahan Diterima)</span>';
                    } elseif ($status == 'declined_change') {
                        echo '<span class="badge-status-large bg-danger text-white"><i class="fas fa-ban mr-1"></i> Usulan Perubahan Ditolak</span>';
                    }
                    ?>
                  </div>
                </div>
              </div>
              
              <div class="card-body p-5">
                
                <!-- SPECIAL SECTION: PROPOSED CHANGE COMPARISON -->
                <?php if ($status == 'proposed') { ?>
                  <div class="comparison-card p-4 mb-5 border-info shadow-xs">
                    <h5 class="font-weight-bold text-info mb-3"><i class="fas fa-exchange-alt mr-2"></i>Admin BMN Mengusulkan Perubahan Jadwal / Ruangan</h5>
                    
                    <div class="alert alert-info border-0 py-3 mb-4 small text-dark" style="background: rgba(23,162,184,0.1);">
                      <strong>Pesan / Alasan Admin BMN:</strong><br>
                      <?php echo nl2br(htmlspecialchars($booking['admin_comment'])); ?>
                    </div>
                    
                    <div class="row mb-4">
                      <!-- ORIGINAL SIDE -->
                      <div class="col-md-6 mb-3 mb-md-0">
                        <div class="comparison-side p-3 h-100">
                          <h6 class="font-weight-bold text-muted border-bottom pb-2 mb-3"><i class="fas fa-history mr-1"></i> Rencana Awal Anda</h6>
                          
                          <!-- Ambil data ruangan asli -->
                          <?php
                          $orig_room_nama = "-";
                          if (!empty($booking['original_ruangan_id'])) {
                              $q_or = mysqli_query($con, "SELECT nama_ruangan FROM bmn_ruangan_booking WHERE id=" . $booking['original_ruangan_id']);
                              if ($d_or = mysqli_fetch_assoc($q_or)) {
                                  $orig_room_nama = $d_or['nama_ruangan'];
                              }
                          }
                          ?>
                          
                          <div class="small mb-2">
                            <span class="text-muted d-block">Ruangan:</span>
                            <strong><?php echo htmlspecialchars($orig_room_nama); ?></strong>
                          </div>
                          
                          <div class="small mb-2">
                            <span class="text-muted d-block">Tanggal:</span>
                            <strong><?php echo !empty($booking['original_tanggal']) ? date('d-m-Y', strtotime($booking['original_tanggal'])) : '-'; ?></strong>
                          </div>
                          
                          <div class="small">
                            <span class="text-muted d-block">Waktu:</span>
                            <strong><?php echo !empty($booking['original_jam_mulai']) ? substr($booking['original_jam_mulai'], 0, 5) . ' - ' . substr($booking['original_jam_selesai'], 0, 5) : '-'; ?></strong>
                          </div>
                        </div>
                      </div>
                      
                      <!-- PROPOSED SIDE -->
                      <div class="col-md-6">
                        <div class="comparison-side p-3 h-100 border-success" style="border: 2px solid #28a745 !important;">
                          <h6 class="font-weight-bold text-success border-bottom pb-2 mb-3"><i class="fas fa-check-circle mr-1"></i> Usulan Penyesuaian BMN</h6>
                          
                          <div class="small mb-2">
                            <span class="text-muted d-block">Ruangan Baru:</span>
                            <span class="<?php echo ($booking['ruangan_id'] != $booking['original_ruangan_id']) ? 'highlight-change' : ''; ?>">
                              <?php echo htmlspecialchars($booking['nama_ruangan']); ?>
                            </span>
                          </div>
                          
                          <div class="small mb-2">
                            <span class="text-muted d-block">Tanggal Baru:</span>
                            <span class="<?php echo ($booking['tanggal'] != $booking['original_tanggal']) ? 'highlight-change' : ''; ?>">
                              <?php echo date('d-m-Y', strtotime($booking['tanggal'])); ?>
                            </span>
                          </div>
                          
                          <div class="small">
                            <span class="text-muted d-block">Waktu Baru:</span>
                            <span class="<?php echo ($booking['jam_mulai'] != $booking['original_jam_mulai'] || $booking['jam_selesai'] != $booking['original_jam_selesai']) ? 'highlight-change' : ''; ?>">
                              <?php echo substr($booking['jam_mulai'], 0, 5) . ' - ' . substr($booking['jam_selesai'], 0, 5); ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Form Tindakan Konfirmasi User -->
                    <div class="text-center bg-white p-4 rounded-lg border">
                      <h6 class="font-weight-bold mb-3 text-dark">Apakah Anda menyetujui perubahan jadwal / ruangan di atas?</h6>
                      
                      <div class="d-flex justify-content-center flex-wrap gap-3">
                        <!-- Tombol Setuju -->
                        <form action="" method="post" class="m-1">
                          <input type="hidden" name="action" value="accept">
                          <button type="submit" class="btn btn-success btn-premium px-4 shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menyetujui jadwal/ruangan usulan BMN?')">
                            <i class="fas fa-check mr-1"></i> Ya, Saya Setuju & Booking
                          </button>
                        </form>
                        
                        <!-- Tombol Tolak (Triggers collapse form) -->
                        <button type="button" class="btn btn-danger btn-premium px-4 shadow-sm m-1" data-toggle="collapse" data-target="#declineReasonCollapse">
                          <i class="fas fa-times mr-1"></i> Tidak, Batalkan Booking
                        </button>
                      </div>
                      
                      <!-- Collapse Area untuk Alasan Penolakan -->
                      <div class="collapse mt-4 text-left" id="declineReasonCollapse">
                        <div class="card card-body bg-light border-0">
                          <form action="" method="post">
                            <input type="hidden" name="action" value="decline">
                            <div class="form-group">
                              <label class="font-weight-bold small text-muted text-uppercase">Berikan alasan Anda menolak usulan ini (Opsional):</label>
                              <textarea name="user_reason" class="form-control" rows="2" placeholder="Contoh: Kami tidak bisa melaksanakannya pada jam tersebut karena pembicara berhalangan hadir."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger btn-sm btn-premium px-3">
                              Konfirmasi Batalkan Booking
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                
                <!-- GENERAL DETAILS -->
                <div class="row">
                  <div class="col-md-6 border-right">
                    <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-info-circle text-info mr-2"></i>Detail Pengajuan</h5>
                    
                    <div class="row mb-3">
                      <div class="col-4 text-muted small">Ruangan</div>
                      <div class="col-8">
                        <strong class="text-info"><?php echo htmlspecialchars($booking['nama_ruangan']); ?></strong><br>
                        <span class="text-muted small"><i class="fas fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($booking['lokasi']); ?></span>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <div class="col-4 text-muted small">Tanggal Peminjaman</div>
                      <div class="col-8">
                        <strong><?php echo date('d-m-Y', strtotime($booking['tanggal'])); ?></strong>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <div class="col-4 text-muted small">Waktu Kegiatan</div>
                      <div class="col-8">
                        <strong><?php echo substr($booking['jam_mulai'], 0, 5) . " - " . substr($booking['jam_selesai'], 0, 5); ?></strong>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <div class="col-4 text-muted small">Kapasitas Orang</div>
                      <div class="col-8">
                        <span class="badge badge-info px-2 py-1"><?php echo $booking['kapasitas']; ?> Orang</span>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <div class="col-4 text-muted small">Tanggal Submit</div>
                      <div class="col-8 text-muted small">
                        <?php echo date('d-m-Y H:i', strtotime($booking['tgl_input'])); ?> WIB
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-6 pl-md-4">
                    <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-file-alt text-info mr-2"></i>Rincian Tambahan</h5>
                    
                    <div class="mb-3">
                      <span class="text-muted small d-block">Keterangan / Fasilitas Tambahan:</span>
                      <p class="text-secondary small bg-light p-3 rounded" style="line-height: 1.5; white-space: pre-wrap;"><?php echo !empty($booking['keterangan']) ? htmlspecialchars($booking['keterangan']) : 'Tidak ada keterangan tambahan.'; ?></p>
                    </div>
                    
                    <!-- ADMIN COMMENT (IF EXISTS AND STATUS IS NOT PROPOSED) -->
                    <?php if (!empty($booking['admin_comment']) && $status != 'proposed') { ?>
                      <div class="card border-info" style="border-radius: 10px; overflow: hidden;">
                        <div class="card-header bg-info-light py-2 px-3 font-weight-bold text-info small" style="background: rgba(23,162,184,0.08);">
                          <i class="fas fa-comment-dots mr-1"></i> Komentar/Catatan Admin BMN:
                        </div>
                        <div class="card-body py-2 px-3 small text-muted" style="white-space: pre-wrap;"><?php echo htmlspecialchars($booking['admin_comment']); ?></div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                
              </div>
            </div>
            
          <?php } ?>
          
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
