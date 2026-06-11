<?php
include("contentsConAdm.php");

// Proteksi Level: Hanya Admin BMN (5) dan Admin Utama (10)
if ($_SESSION['level'] != '5' && $_SESSION['level'] != '10') {
    header("location:dashboardAdm.php");
    exit();
}

// Hitung total pending untuk badge
$q_pending_count = mysqli_query($con, "SELECT COUNT(id) AS tot FROM bmn_peminjaman_ruangan WHERE status='pending'");
$d_pending_count = mysqli_fetch_assoc($q_pending_count);
$pending_count = $d_pending_count['tot'];

// Count for each status
$q_approved = mysqli_query($con, "SELECT COUNT(id) AS tot FROM bmn_peminjaman_ruangan WHERE status IN ('approved', 'accepted_change')");
$d_approved = mysqli_fetch_assoc($q_approved);
$approved_count = $d_approved['tot'];

$q_proposed = mysqli_query($con, "SELECT COUNT(id) AS tot FROM bmn_peminjaman_ruangan WHERE status = 'proposed'");
$d_proposed = mysqli_fetch_assoc($q_proposed);
$proposed_count = $d_proposed['tot'];

$q_rejected = mysqli_query($con, "SELECT COUNT(id) AS tot FROM bmn_peminjaman_ruangan WHERE status IN ('rejected', 'declined_change')");
$d_rejected = mysqli_fetch_assoc($q_rejected);
$rejected_count = $d_rejected['tot'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>
<style>
  .btn-premium {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
  }
  .btn-premium:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  }
  .modal-content-premium {
    border-radius: 15px;
    border: none;
  }
  .modal-header-premium {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
  }
  .nav-tabs-premium {
    border-bottom: 2px solid #dee2e6;
  }
  .nav-tabs-premium .nav-link {
    border: none;
    color: #495057;
    font-weight: 600;
    padding: 10px 20px;
    position: relative;
    transition: all 0.3s;
  }
  .nav-tabs-premium .nav-link.active {
    color: #17a2b8;
    background: transparent;
  }
  .nav-tabs-premium .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background-color: #17a2b8;
    border-radius: 3px;
  }
  .badge-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.75rem;
  }
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarAdmBmn.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold text-info"><i class="fas fa-check-square mr-2"></i>Persetujuan Peminjaman Ruangan</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="dashboardAdmBmn.php">Dashboard</a></li>
                <li class="breadcrumb-item active small">Persetujuan Booking</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      
      <section class="content">
        <div class="container-fluid">
          
          <?php
          $msg_title = "";
          $msg_body = "";
          $msg_icon = "";
          $msg_color = "";
          
          if (!empty($_GET['message'])) {
            $m = $_GET['message'];
            if ($m == 'notifApprove') {
              $msg_title = "Berhasil Disetujui!";
              $msg_body = "Permohonan peminjaman ruangan telah disetujui.";
              $msg_icon = "fa-check-circle";
              $msg_color = "success";
            } elseif ($m == 'notifReject') {
              $msg_title = "Berhasil Ditolak!";
              $msg_body = "Permohonan peminjaman ruangan telah ditolak.";
              $msg_icon = "fa-times-circle";
              $msg_color = "danger";
            } elseif ($m == 'notifPropose') {
              $msg_title = "Perubahan Diajukan!";
              $msg_body = "Usulan perubahan jadwal / ruangan berhasil dikirim ke pengaju.";
              $msg_icon = "fa-paper-plane";
              $msg_color = "info";
            } elseif ($m == 'notifGagal') {
              $msg_title = "Gagal Memproses!";
              $msg_body = "Terjadi masalah database atau input data tidak valid.";
              $msg_icon = "fa-exclamation-triangle";
              $msg_color = "warning";
            }
          }
          ?>
          
          <div class="row">
            <div class="col-12">
              <div class="card card-outline card-info shadow-sm">
                <div class="card-header border-0 bg-white">
                  <ul class="nav nav-tabs nav-tabs-premium card-header-tabs" id="bookingTabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">
                        Menunggu Persetujuan 
                        <?php if ($pending_count > 0) { ?>
                          <span class="badge badge-danger ml-1 px-2"><?php echo $pending_count; ?></span>
                        <?php } ?>
                      </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="approved-tab" data-toggle="tab" href="#approved" role="tab" aria-controls="approved" aria-selected="false">Disetujui / Aktif<?php if ($approved_count > 0) { ?> <span class="badge badge-success ml-1 px-2"><?php echo $approved_count; ?></span><?php } ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="proposed-tab" data-toggle="tab" href="#proposed" role="tab" aria-controls="proposed" aria-selected="false">Usulan Perubahan<?php if ($proposed_count > 0) { ?> <span class="badge badge-warning ml-1 px-2"><?php echo $proposed_count; ?></span><?php } ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Ditolak / Batal<?php if ($rejected_count > 0) { ?> <span class="badge badge-danger ml-1 px-2"><?php echo $rejected_count; ?></span><?php } ?></a>
                    </li>
                  </ul>
                </div>
                
                <div class="card-body">
                  <div class="tab-content" id="bookingTabsContent">
                    
                    <!-- TAB 1: PENDING -->
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle small">
                          <thead class="bg-light text-muted">
                            <tr>
                              <th width="4%">No</th>
                              <th width="15%">Pengaju / Unit</th>
                              <th width="15%">Ruangan</th>
                              <th width="15%">Waktu Pengajuan</th>
                              <th width="15%">Kegiatan</th>
                              <th width="8%">Kapasitas</th>
                              <th width="28%">Opsi Tindakan</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            $q_pending = mysqli_query($con, "SELECT p.*, r.nama_ruangan, r.lokasi FROM bmn_peminjaman_ruangan p JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id WHERE p.status = 'pending' ORDER BY p.tgl_input DESC");
                            if (mysqli_num_rows($q_pending) == 0) {
                                echo '<tr><td colspan="7" class="text-muted p-5"><i class="fas fa-inbox fa-3x mb-3 text-gray"></i><br>Tidak ada pengajuan peminjaman ruangan yang menunggu persetujuan.</td></tr>';
                            }
                            while ($d = mysqli_fetch_array($q_pending)) {
                            ?>
                              <tr>
                                <td class="align-middle"><?php echo $no++; ?></td>
                                <td class="align-middle text-left">
                                  <strong><?php echo htmlspecialchars($d['nama_organisasi']); ?></strong><br>
                                  <span class="text-muted small"><?php echo htmlspecialchars($d['unit']); ?></span><br>
                                  <a href="mailto:<?php echo $d['email']; ?>" class="text-info small"><i class="far fa-envelope mr-1"></i><?php echo $d['email']; ?></a>
                                </td>
                                <td class="align-middle text-left">
                                  <strong><?php echo htmlspecialchars($d['nama_ruangan']); ?></strong><br>
                                  <span class="text-muted small"><i class="fas fa-map-marker-alt text-info mr-1"></i><?php echo htmlspecialchars($d['lokasi']); ?></span>
                                </td>
                                <td class="align-middle text-left">
                                  <span class="badge badge-light border"><i class="far fa-calendar-alt text-info mr-1"></i><?php echo date('d-m-Y', strtotime($d['tanggal'])); ?></span><br>
                                  <span class="small text-muted"><i class="far fa-clock text-info mr-1"></i><?php echo substr($d['jam_mulai'], 0, 5) . " - " . substr($d['jam_selesai'], 0, 5); ?></span>
                                </td>
                                <td class="align-middle text-left font-weight-bold text-wrap"><?php echo htmlspecialchars($d['kegiatan']); ?></td>
                                <td class="align-middle"><span class="badge badge-info"><?php echo $d['kapasitas']; ?> Orang</span></td>
                                <td class="align-middle">
                                  <button class="btn btn-success btn-xs btn-premium px-2 py-1 m-1" data-toggle="modal" data-target="#modalApprove<?php echo $d['id']; ?>">
                                    <i class="fas fa-check"></i> Setujui
                                  </button>
                                  <button class="btn btn-danger btn-xs btn-premium px-2 py-1 m-1" data-toggle="modal" data-target="#modalReject<?php echo $d['id']; ?>">
                                    <i class="fas fa-times"></i> Tolak
                                  </button>
                                  <button class="btn btn-info btn-xs btn-premium px-2 py-1 m-1" data-toggle="modal" data-target="#modalPropose<?php echo $d['id']; ?>">
                                    <i class="fas fa-edit"></i> Ubah & Usulkan
                                  </button>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <!-- TAB 2: APPROVED -->
                    <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle small">
                          <thead class="bg-light text-muted">
                            <tr>
                              <th width="4%">No</th>
                              <th width="18%">Pengaju / Unit</th>
                              <th width="18%">Ruangan</th>
                              <th width="15%">Waktu Peminjaman</th>
                              <th width="15%">Kegiatan</th>
                              <th width="10%">Status</th>
                              <th width="20%">Token Pelacakan</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            $q_appr = mysqli_query($con, "SELECT p.*, r.nama_ruangan, r.lokasi FROM bmn_peminjaman_ruangan p JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id WHERE p.status IN ('approved', 'accepted_change') ORDER BY p.tanggal DESC, p.jam_mulai DESC");
                            if (mysqli_num_rows($q_appr) == 0) {
                                echo '<tr><td colspan="7" class="text-muted p-5"><i class="fas fa-calendar-check fa-3x mb-3 text-gray"></i><br>Belum ada peminjaman ruangan yang disetujui.</td></tr>';
                            }
                            while ($d = mysqli_fetch_array($q_appr)) {
                                $badgeColor = $d['status'] == 'accepted_change' ? 'badge-success' : 'badge-teal text-white bg-teal';
                                $statusLabel = $d['status'] == 'accepted_change' ? 'Perubahan Disetujui' : 'Disetujui';
                            ?>
                              <tr>
                                <td class="align-middle"><?php echo $no++; ?></td>
                                <td class="align-middle text-left">
                                  <strong><?php echo htmlspecialchars($d['nama_organisasi']); ?></strong><br>
                                  <span class="text-muted small"><?php echo htmlspecialchars($d['unit']); ?></span><br>
                                  <a href="mailto:<?php echo $d['email']; ?>" class="text-info small"><?php echo $d['email']; ?></a>
                                </td>
                                <td class="align-middle text-left">
                                  <strong><?php echo htmlspecialchars($d['nama_ruangan']); ?></strong><br>
                                  <span class="text-muted small"><?php echo htmlspecialchars($d['lokasi']); ?></span>
                                </td>
                                <td class="align-middle text-left">
                                  <span class="badge badge-light border"><i class="far fa-calendar-alt text-info mr-1"></i><?php echo date('d-m-Y', strtotime($d['tanggal'])); ?></span><br>
                                  <span class="small text-muted"><i class="far fa-clock text-info mr-1"></i><?php echo substr($d['jam_mulai'], 0, 5) . " - " . substr($d['jam_selesai'], 0, 5); ?></span>
                                </td>
                                <td class="align-middle text-left font-weight-bold text-wrap"><?php echo htmlspecialchars($d['kegiatan']); ?></td>
                                <td class="align-middle">
                                  <span class="badge-status <?php echo $badgeColor; ?> shadow-xs"><?php echo $statusLabel; ?></span>
                                </td>
                                <td class="align-middle">
                                  <code><?php echo $d['booking_token']; ?></code><br>
                                  <a href="peminjamanRuangDetail.php?token=<?php echo $d['booking_token']; ?>" target="_blank" class="btn btn-outline-info btn-xs btn-premium mt-1">
                                    <i class="fas fa-eye"></i> Lihat Laman
                                  </a>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <!-- TAB 3: PROPOSED -->
                    <div class="tab-pane fade" id="proposed" role="tabpanel" aria-labelledby="proposed-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle small">
                          <thead class="bg-light text-muted">
                            <tr>
                              <th width="4%">No</th>
                              <th width="20%">Pengaju / Unit</th>
                              <th width="22%">Ruangan (Usulan Baru)</th>
                              <th width="18%">Waktu (Usulan Baru)</th>
                              <th width="16%">Keterangan Perubahan</th>
                              <th width="20%">Lacak / Token</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            $q_prop = mysqli_query($con, "SELECT p.*, r.nama_ruangan, r.lokasi FROM bmn_peminjaman_ruangan p JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id WHERE p.status = 'proposed' ORDER BY p.tgl_input DESC");
                            if (mysqli_num_rows($q_prop) == 0) {
                                echo '<tr><td colspan="6" class="text-muted p-5"><i class="fas fa-paper-plane fa-3x mb-3 text-gray"></i><br>Tidak ada peminjaman dengan status usulan perubahan jadwal/ruang.</td></tr>';
                            }
                            while ($d = mysqli_fetch_array($q_prop)) {
                            ?>
                              <tr>
                                <td class="align-middle"><?php echo $no++; ?></td>
                                <td class="align-middle text-left">
                                  <strong><?php echo htmlspecialchars($d['nama_organisasi']); ?></strong><br>
                                  <span class="text-muted small"><?php echo htmlspecialchars($d['unit']); ?></span><br>
                                  <a href="mailto:<?php echo $d['email']; ?>" class="text-info small"><?php echo $d['email']; ?></a>
                                </td>
                                <td class="align-middle text-left">
                                  <strong><?php echo htmlspecialchars($d['nama_ruangan']); ?></strong><br>
                                  <span class="text-muted small"><?php echo htmlspecialchars($d['lokasi']); ?></span>
                                </td>
                                <td class="align-middle text-left">
                                  <span class="badge badge-light border"><i class="far fa-calendar-alt text-info mr-1"></i><?php echo date('d-m-Y', strtotime($d['tanggal'])); ?></span><br>
                                  <span class="small text-muted"><i class="far fa-clock text-info mr-1"></i><?php echo substr($d['jam_mulai'], 0, 5) . " - " . substr($d['jam_selesai'], 0, 5); ?></span>
                                </td>
                                <td class="align-middle text-left text-wrap">
                                  <span class="badge badge-warning mb-1">Menunggu Jawaban</span><br>
                                  <span class="text-muted small"><?php echo htmlspecialchars($d['admin_comment']); ?></span>
                                </td>
                                <td class="align-middle">
                                  <code><?php echo $d['booking_token']; ?></code><br>
                                  <a href="peminjamanRuangDetail.php?token=<?php echo $d['booking_token']; ?>" target="_blank" class="btn btn-outline-warning btn-xs btn-premium mt-1">
                                    <i class="fas fa-external-link-alt"></i> Detail Konfirmasi
                                  </a>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <!-- TAB 4: HISTORY -->
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle small">
                          <thead class="bg-light text-muted">
                            <tr>
                              <th width="4%">No</th>
                              <th width="20%">Pengaju / Unit</th>
                              <th width="20%">Ruangan</th>
                              <th width="15%">Waktu Pengajuan</th>
                              <th width="15%">Kegiatan</th>
                              <th width="12%">Status Akhir</th>
                              <th width="14%">Komentar Admin</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            $q_hist = mysqli_query($con, "SELECT p.*, r.nama_ruangan, r.lokasi FROM bmn_peminjaman_ruangan p JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id WHERE p.status IN ('rejected', 'declined_change') ORDER BY p.tgl_input DESC");
                            if (mysqli_num_rows($q_hist) == 0) {
                                echo '<tr><td colspan="7" class="text-muted p-5"><i class="fas fa-history fa-3x mb-3 text-gray"></i><br>Tidak ada riwayat penolakan atau pembatalan.</td></tr>';
                            }
                            while ($d = mysqli_fetch_array($q_hist)) {
                                $badgeColor = $d['status'] == 'declined_change' ? 'badge-danger' : 'badge-secondary';
                                $statusLabel = $d['status'] == 'declined_change' ? 'Usulan Ditolak User' : 'Ditolak BMN';
                            ?>
                              <tr>
                                <td class="align-middle"><?php echo $no++; ?></td>
                                <td class="align-middle text-left">
                                  <strong><?php echo htmlspecialchars($d['nama_organisasi']); ?></strong><br>
                                  <span class="text-muted small"><?php echo htmlspecialchars($d['unit']); ?></span>
                                </td>
                                <td class="align-middle text-left">
                                  <strong><?php echo htmlspecialchars($d['nama_ruangan']); ?></strong><br>
                                  <span class="text-muted small"><?php echo htmlspecialchars($d['lokasi']); ?></span>
                                </td>
                                <td class="align-middle text-left">
                                  <span class="badge badge-light border"><?php echo date('d-m-Y', strtotime($d['tanggal'])); ?></span><br>
                                  <span class="small text-muted"><?php echo substr($d['jam_mulai'], 0, 5) . " - " . substr($d['jam_selesai'], 0, 5); ?></span>
                                </td>
                                <td class="align-middle text-left text-wrap"><?php echo htmlspecialchars($d['kegiatan']); ?></td>
                                <td class="align-middle">
                                  <span class="badge-status <?php echo $badgeColor; ?>"><?php echo $statusLabel; ?></span>
                                </td>
                                <td class="align-middle text-left text-muted small text-wrap"><?php echo htmlspecialchars($d['admin_comment']); ?></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </section>
    </div>
    
    <!-- MODALS FOR OPERATIONS -->
    <?php
    $modalCode = "";
    
    // Ulangi query pending untuk memproduksi modal tindakan per item
    $q_pending_modal = mysqli_query($con, "SELECT p.*, r.nama_ruangan, r.lokasi FROM bmn_peminjaman_ruangan p JOIN bmn_ruangan_booking r ON p.ruangan_id = r.id WHERE p.status = 'pending'");
    while ($d = mysqli_fetch_array($q_pending_modal)) {
        
        // 1. Modal Approve
        $modalCode .= '
        <div class="modal fade" id="modalApprove' . $d['id'] . '" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-premium text-left">
              <form action="bmnBookingPersetujuanAksi.php?act=approve" method="post">
                <input type="hidden" name="id" value="' . $d['id'] . '">
                <div class="modal-header modal-header-premium text-white border-0 bg-success">
                  <h5 class="modal-title font-weight-bold"><i class="fas fa-check-circle mr-2"></i>Setujui Peminjaman Ruangan</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <p>Apakah Anda yakin ingin menyetujui peminjaman ruangan <strong>' . htmlspecialchars($d['nama_ruangan']) . '</strong> oleh <strong>' . htmlspecialchars($d['nama_organisasi']) . '</strong> pada tanggal <strong>' . date('d-m-Y', strtotime($d['tanggal'])) . '</strong>?</p>
                  
                  <div class="form-group">
                    <label class="font-weight-bold">Catatan / Komentar Tambahan (Opsional)</label>
                    <textarea name="admin_comment" class="form-control form-control-sm" rows="3" placeholder="Contoh: Silakan berkoordinasi dengan petugas lapangan sebelum hari H."></textarea>
                  </div>
                </div>
                <div class="modal-footer border-0">
                  <button type="button" class="btn btn-secondary btn-premium" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success btn-premium px-4">Setujui Sekarang</button>
                </div>
              </form>
            </div>
          </div>
        </div>';
        
        // 2. Modal Reject
        $modalCode .= '
        <div class="modal fade" id="modalReject' . $d['id'] . '" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-premium text-left">
              <form action="bmnBookingPersetujuanAksi.php?act=reject" method="post">
                <input type="hidden" name="id" value="' . $d['id'] . '">
                <div class="modal-header modal-header-premium text-white border-0 bg-danger" style="background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%) !important;">
                  <h5 class="modal-title font-weight-bold"><i class="fas fa-times-circle mr-2"></i>Tolak Peminjaman Ruangan</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <p>Anda sedang menolak peminjaman ruangan <strong>' . htmlspecialchars($d['nama_ruangan']) . '</strong> oleh <strong>' . htmlspecialchars($d['nama_organisasi']) . '</strong>.</p>
                  
                  <div class="form-group">
                    <label class="font-weight-bold text-danger">Alasan Penolakan (Wajib Diisi)</label>
                    <textarea name="admin_comment" class="form-control form-control-sm" rows="3" placeholder="Sebutkan alasan penolakan secara jelas. Contoh: Ruangan digunakan untuk kegiatan fakultas / maintenance." required></textarea>
                  </div>
                </div>
                <div class="modal-footer border-0">
                  <button type="button" class="btn btn-secondary btn-premium" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger btn-premium px-4">Tolak Peminjaman</button>
                </div>
              </form>
            </div>
          </div>
        </div>';
        
        // 3. Modal Propose Change (Ubah & Usulkan)
        // Ambil data ruangan yang aktif untuk opsi
        $optRooms = "";
        $q_rooms = mysqli_query($con, "SELECT id, nama_ruangan, kapasitas FROM bmn_ruangan_booking WHERE status_aktif = 1 ORDER BY nama_ruangan ASC");
        

while ($r = mysqli_fetch_array($q_rooms)) {
            $selected = $r['id'] == $d['ruangan_id'] ? 'selected' : '';
            $optRooms .= '<option value="' . $r['id'] . '" ' . $selected . '>' . htmlspecialchars($r['nama_ruangan']) . ' (Kapasitas: ' . $r['kapasitas'] . ')</option>';
        }
        
        $modalCode .= '
        <div class="modal fade" id="modalPropose' . $d['id'] . '" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-premium text-left">
              <form action="bmnBookingPersetujuanAksi.php?act=propose" method="post">
                <input type="hidden" name="id" value="' . $d['id'] . '">
                <div class="modal-header modal-header-premium text-white border-0 bg-info">
                  <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Ubah Detail & Usulkan ke Pengaju</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <div class="alert alert-light border small text-muted mb-4">
                    <i class="fas fa-info-circle text-info mr-1"></i> Form di bawah ini akan mengubah jadwal atau ruangan. Pengaju akan mendapatkan notifikasi perubahan ini pada halaman pelacakan dan harus memilih untuk <strong>Menerima</strong> atau <strong>Menolak</strong> usulan Anda.
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="font-weight-bold">Sesuaikan Ruangan</label>
                        <select name="ruangan_id" class="form-control form-control-sm" required>
                          ' . $optRooms . '
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold">Sesuaikan Tanggal</label>
                        <input type="date" name="tanggal" class="form-control form-control-sm" value="' . $d['tanggal'] . '" required>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="font-weight-bold">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control form-control-sm" value="' . substr($d['jam_mulai'], 0, 5) . '" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control form-control-sm" value="' . substr($d['jam_selesai'], 0, 5) . '" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="font-weight-bold text-info">Alasan Perubahan / Pesan ke Pengaju (Wajib Diisi)</label>
                    <textarea name="admin_comment" class="form-control form-control-sm" rows="3" placeholder="Sebutkan bagian apa saja yang diubah dan alasannya. Contoh: Ruangan Aula terpakai ujian, kami usulkan pindah ke Lab Komputer pada jam yang sama." required></textarea>
                  </div>
                </div>
                <div class="modal-footer border-0">
                  <button type="button" class="btn btn-secondary btn-premium" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-info btn-premium px-4">Kirim Usulan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>';
    }
    echo $modalCode;
    ?>
    
    <!-- Modal Notification Centered -->
    <?php if (!empty($msg_title)) { ?>
    <div class="modal fade" id="modalNotification" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
          <div class="modal-body text-center p-5">
            <div class="mb-4">
              <i class="fas <?php echo $msg_icon; ?> text-<?php echo $msg_color; ?>" style="font-size: 5rem; opacity: 0.8;"></i>
            </div>
            <h3 class="font-weight-bold mb-2 text-dark"><?php echo $msg_title; ?></h3>
            <p class="text-muted mb-4"><?php echo $msg_body; ?></p>
            <button type="button" class="btn btn-<?php echo $msg_color; ?> btn-lg btn-block btn-premium py-3" data-dismiss="modal" style="border-radius: 12px;">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
    <script>
      window.onload = function() {
        $('#modalNotification').modal('show');
        window.history.replaceState({}, document.title, window.location.pathname);
      };
    </script>
    <?php } ?>
    
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
  </div>
</body>
</html>
