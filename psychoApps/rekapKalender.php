<?php
include("conAdm.php"); // Load session and db connection without blocking
$isLoggedIn = !empty($_SESSION['username']);
$isAuthorizedCalendarAdmin = false;
$isAdminUtama = false;

if ($isLoggedIn) {
    $isAdminUtama = (isset($_SESSION['level']) && ($_SESSION['level'] === 'adminutama' || $_SESSION['level'] == 10));
    $isAuthorizedCalendarAdmin = $isAdminUtama;
    if (!$isAuthorizedCalendarAdmin) {
        $username_esc = mysqli_real_escape_string($con, $_SESSION['username']);
        $q_auth = mysqli_query($con, "SELECT jabatan_instansi FROM dt_pegawai WHERE id='$username_esc' LIMIT 1");
        if ($q_auth && mysqli_num_rows($q_auth) > 0) {
            $d_auth = mysqli_fetch_assoc($q_auth);
            $jab = $d_auth['jabatan_instansi'];
            if ($jab === '1' || $jab === '3' || $jab === '28') {
                $isAuthorizedCalendarAdmin = true;
            }
        }
    }
}

// Strict access control: only authorized calendar admins can access this page
if (!$isAuthorizedCalendarAdmin) {
    if ($isLoggedIn) {
        header('Location: dashboardAdm.php');
    } else {
        header('Location: ../index.php');
    }
    exit;
}

// Fetch all distinct years of activities to populate the filter dropdown
$years = [];
$q_years = mysqli_query($con, "SELECT DISTINCT YEAR(start_date) as yr FROM kalender_kegiatan ORDER BY yr DESC");
if ($q_years && mysqli_num_rows($q_years) > 0) {
    while ($row = mysqli_fetch_assoc($q_years)) {
        if ($row['yr']) $years[] = intval($row['yr']);
    }
}
$current_year = intval(date('Y'));
if (!in_array($current_year, $years)) {
    $years[] = $current_year;
}
rsort($years);

// Determine the selected year
$selected_year = isset($_GET['year']) ? intval($_GET['year']) : $current_year;
$selected_year_esc = mysqli_real_escape_string($con, (string)$selected_year);

// Fetch activities for the selected year
$query = "SELECT id, title, description, tempat, penanggung_jawab, start_date as start, end_date as end, color, created_by 
          FROM kalender_kegiatan 
          WHERE YEAR(start_date) = $selected_year_esc 
          ORDER BY start_date ASC";

$result = mysqli_query($con, $query);
$kegiatan_list = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $keg_id = $row['id'];
        $q_files = mysqli_query($con, "SELECT id, file_name, file_path, file_desc FROM kalender_kegiatan_files WHERE kegiatan_id = $keg_id ORDER BY id DESC");
        $files = [];
        if ($q_files) {
            while ($f_row = mysqli_fetch_assoc($q_files)) {
                $files[] = $f_row;
            }
        }
        $row['files'] = $files;
        $kegiatan_list[] = $row;
    }
}

$q_jab = mysqli_query($con, "SELECT nm FROM opsi_jabatan_instansi ORDER BY nm ASC");
$opsi_jabatan = [];
if ($q_jab) {
    while ($r = mysqli_fetch_assoc($q_jab)) {
        $opsi_jabatan[] = $r['nm'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<?php include("headAdm.php"); ?>

<style>
  /* ─── Premium Google Calendar Dark Theme Style ─── */
  .content-wrapper {
    background-color: #12141c !important;
    color: #f8fafc;
  }

  .card-calendar {
    border-radius: 24px !important;
    border: 1px solid #2f3242 !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
    background: #1a1d26 !important;
    overflow: hidden;
  }

  .text-dark {
    color: #ffffff !important;
  }

  .breadcrumb-item.active {
    color: #94a3b8 !important;
  }

  /* Table Recap Styles */
  .table-rekap {
    color: #f1f5f9;
    background-color: #1a1d26;
    border: 1px solid #2f3242;
    border-radius: 16px;
    overflow: hidden;
    width: 100%;
    margin-bottom: 0;
  }

  .table-rekap th {
    background-color: #1e212d !important;
    color: #94a3b8 !important;
    border-bottom: 2px solid #2f3242 !important;
    border-top: none !important;
    text-transform: uppercase;
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 0.05em;
    padding: 14px !important;
  }

  .table-rekap td {
    border-bottom: 1px solid #2f3242 !important;
    border-top: none !important;
    padding: 14px !important;
    vertical-align: middle !important;
    color: #cbd5e1;
    font-size: 0.85rem;
  }

  .table-rekap tbody tr:hover {
    background-color: #232733 !important;
  }

  /* Filter/Search Section Styles */
  .search-container {
    background: #1a1d26;
    border: 1px solid #2f3242;
    border-radius: 16px;
    padding: 18px;
    margin-bottom: 20px;
  }

  .form-control.search-input {
    background-color: #151720 !important;
    color: #ffffff !important;
    border: 1px solid #2a2d3a !important;
    border-radius: 10px;
    padding: 10px 14px;
    height: auto;
  }

  .form-control.search-input:focus {
    border-color: #3b82f6 !important;
    box-shadow: none;
  }

  .select-year {
    background-color: #151720 !important;
    color: #ffffff !important;
    border: 1px solid #2a2d3a !important;
    border-radius: 10px;
    height: 42px;
    padding: 6px 12px;
    width: 100%;
    font-weight: 600;
    outline: none;
    transition: border-color 0.2s;
  }

  .select-year:focus {
    border-color: #3b82f6 !important;
  }

  /* Color swatches in modal */
  .color-swatch {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    display: inline-block;
    border: 3px solid transparent;
    transition: all 0.2s ease;
  }

  .color-swatch.selected,
  .color-swatch:hover {
    border-color: #ffffff;
    transform: scale(1.15);
  }

  /* Legend styles */
  .legend-item {
    font-size: 0.85rem;
    font-weight: 500;
    color: #94a3b8;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 10px;
    display: inline-block;
    flex-shrink: 0;
  }

  /* File pill style */
  .file-pill {
    display: inline-flex;
    align-items: center;
    background-color: #232733;
    color: #60a5fa;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.76rem;
    font-weight: 700;
    margin-right: 6px;
    margin-bottom: 6px;
    text-decoration: none;
    border: 1px solid #2f3242;
    transition: all 0.15s ease;
    max-width: 180px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .file-pill:hover {
    background-color: #2e344a;
    color: #93c5fd;
    text-decoration: none;
  }

  /* Custom Action Button Hover Styles */
  .btn-action-edit {
    background-color: #3b82f6 !important;
    border: none !important;
    border-radius: 8px !important;
    font-weight: 600;
    transition: all 0.2s;
  }

  .btn-action-edit:hover {
    background-color: #2563eb !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.25);
  }

  .btn-action-delete {
    background-color: #ef4444 !important;
    border: none !important;
    border-radius: 8px !important;
    font-weight: 600;
    transition: all 0.2s;
  }

  .btn-action-delete:hover {
    background-color: #dc2626 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
  }

  .badge-creator {
    background-color: #2e344a;
    color: #94a3b8;
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 8px;
  }

  /* Modal styling overrides */
  .modal-content {
    background-color: #1a1d26 !important;
    color: #f1f5f9;
  }

  .modal-header {
    border-bottom: 1px solid #2a2d3a !important;
  }

  .modal-footer {
    border-top: 1px solid #2a2d3a !important;
    background-color: #161820 !important;
  }

  .form-control.bg-light {
    background-color: #232733 !important;
    color: #ffffff !important;
    border: 1px solid #2a2d3a !important;
  }

  .form-control.bg-light:focus {
    border-color: #3b82f6 !important;
  }

  .form-control-plaintext {
    color: #ffffff !important;
  }

  #btnAddEvent {
    background: linear-gradient(135deg, #3b82f6, #6366f1) !important;
    border: none !important;
    transition: all 0.2s ease;
  }

  #btnAddEvent:hover {
    background: linear-gradient(135deg, #2563eb, #4f46e5) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarDynamic.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2 animate__animated animate__fadeIn">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold text-dark">
                <i class="fas fa-list mr-2 text-primary"></i>Rekap Kegiatan Kalender
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-primary" href="dashboardAdm.php">Dashboard</a></li>
                <li class="breadcrumb-item small"><a class="text-primary" href="adminKalender.php">Kalender Kegiatan</a></li>
                <li class="breadcrumb-item active small">Rekap Kegiatan</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- Left Panel: Actions & Filters -->
            <div class="col-lg-3 animate__animated animate__fadeInLeft">
              <!-- Action Button Card -->
              <div class="card card-calendar mb-4 shadow-sm">
                <div class="card-body p-3">
                  <button id="btnAddEvent" class="btn btn-primary btn-block py-2 mb-3" style="border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-plus mr-2"></i> Tambah Kegiatan
                  </button>
                  <a href="adminKalender.php" class="btn btn-outline-light btn-block py-2" style="border-radius: 8px; font-weight: 600; font-size: 0.9rem; border-color: #2a2d3a; color: #cbd5e1;">
                    <i class="fas fa-calendar-alt mr-2"></i> Tampilan Kalender
                  </a>
                </div>
              </div>

              <!-- Filter & Search Card -->
              <div class="card card-calendar mb-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0 pt-3">
                  <h6 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-sliders-h text-primary mr-2"></i>Filter & Pencarian
                  </h6>
                </div>
                <div class="card-body p-3">
                  <!-- Year Selector -->
                  <div class="form-group mb-3">
                    <label for="yearFilter" class="font-weight-bold mb-1" style="color: #cbd5e1; font-size: 0.8rem;">PILIH TAHUN</label>
                    <select id="yearFilter" class="select-year">
                      <?php foreach ($years as $yr): ?>
                        <option value="<?php echo $yr; ?>" <?php echo $yr == $selected_year ? 'selected' : ''; ?>>
                          Tahun <?php echo $yr; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- Live Search Bar -->
                  <div class="form-group mb-0">
                    <label for="searchInput" class="font-weight-bold mb-1" style="color: #cbd5e1; font-size: 0.8rem;">CARI KEGIATAN</label>
                    <input type="text" id="searchInput" class="form-control search-input" placeholder="Ketik judul, keterangan, pembuat...">
                  </div>
                </div>
              </div>

              <!-- Color Category Legend -->
              <div class="card card-calendar mb-4 shadow-sm">
                <div class="card-body p-3">
                  <p class="text-muted text-uppercase font-weight-bold mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Kategori Warna</p>
                  <div id="legendContainer"></div>
                </div>
              </div>
            </div>

            <!-- Right Panel: List Table -->
            <div class="col-lg-9 animate__animated animate__fadeInRight">
              <div class="card card-calendar shadow-sm">
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-rekap" id="kegiatanTable">
                      <thead>
                        <tr>
                          <th style="width: 5%; text-align: center;">No</th>
                          <th style="width: 20%;">Judul Kegiatan</th>
                          <th style="width: 15%;">Tanggal</th>
                          <th style="width: 15%;">Penanggung Jawab</th>
                          <th style="width: 15%; text-align: center;">Laporan</th>
                          <th style="width: 20%;">Keterangan</th>
                          <th style="width: 10%; text-align: center;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (empty($kegiatan_list)): ?>
                          <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                              <i class="fas fa-calendar-times mb-3" style="font-size: 2.5rem; display: block; opacity: 0.5;"></i>
                              Tidak ditemukan kegiatan untuk tahun <?php echo $selected_year; ?>.
                            </td>
                          </tr>
                        <?php else: ?>
                          <?php 
                          $no = 1;
                          foreach ($kegiatan_list as $keg): 
                            $start_dt = new DateTime($keg['start']);
                            $end_dt = new DateTime($keg['end']);
                            
                            $start_date_str = $start_dt->format('d M Y');
                            $start_time_str = $start_dt->format('H:i');
                            
                            $end_date_str = $end_dt->format('d M Y');
                            $end_time_str = $end_dt->format('H:i');
                            
                            if ($start_date_str === $end_date_str) {
                                $time_display = "$start_date_str · $start_time_str - $end_time_str";
                            } else {
                                $time_display = "$start_date_str $start_time_str s.d. $end_date_str $end_time_str";
                            }
                          ?>
                            <tr>
                              <td style="text-align: center; font-weight: bold; color: #94a3b8;"><?php echo $no++; ?></td>
                              <!-- Sleek Left border using category color -->
                              <td style="border-left: 5px solid <?php echo $keg['color']; ?> !important; font-weight: 700; color: #ffffff; padding-left: 14px;">
                                <?php echo htmlspecialchars($keg['title']); ?>
                                <div class="mt-1">
                                  <span class="badge-creator" title="Pembuat Kegiatan"><i class="fas fa-user mr-1" style="font-size: 0.7rem;"></i><?php echo htmlspecialchars($keg['created_by'] ?: 'Admin'); ?></span>
                                </div>
                              </td>
                              <td style="font-weight: 600; line-height: 1.3;">
                                <?php echo $time_display; ?>
                              </td>
                              <td style="word-break: break-word; overflow-wrap: anywhere; line-height: 1.4; font-weight: 600; color: #cbd5e1;">
                                <?php echo htmlspecialchars($keg['penanggung_jawab'] ?: '-'); ?>
                              </td>
                              <td style="text-align: center;">
                                <?php if (empty($keg['files'])): ?>
                                  <span class="text-muted small">-</span>
                                <?php else: ?>
                                  <div class="d-flex flex-column align-items-center">
                                    <span class="badge badge-info mb-1" style="font-size: 0.72rem; font-weight: 800; border-radius: 12px; padding: 4px 8px;">
                                      <i class="fas fa-paperclip mr-1"></i><?php echo count($keg['files']); ?>
                                    </span>
                                    <div class="d-none d-lg-flex flex-wrap justify-content-center mt-1" style="max-width: 100%;">
                                      <?php 
                                      foreach ($keg['files'] as $f): 
                                        $label = $f['file_desc'] ?: $f['file_name'];
                                        
                                        // Normalize relative path
                                        $p = (string)($f['file_path']);
                                        $p = preg_replace('/^(\/+)/', '/', $p);
                                        $p = preg_replace('/^\/?psychoApps\/psychoApps\//', 'psychoApps/', $p);
                                        $p = preg_replace('/^\/?psychoApps\//', 'psychoApps/', $p);
                                        $file_href = '/' . $p;
                                      ?>
                                        <a href="<?php echo htmlspecialchars($file_href); ?>" target="_blank" class="file-pill" title="<?php echo htmlspecialchars($f['file_desc'] ?: $f['file_name']); ?>">
                                          <?php echo htmlspecialchars($label); ?>
                                        </a>
                                      <?php endforeach; ?>
                                    </div>
                                  </div>
                                <?php endif; ?>
                              </td>
                              <td style="word-break: break-word; overflow-wrap: anywhere; line-height: 1.4;">
                                <?php echo nl2br(htmlspecialchars($keg['description'] ?: '-')); ?>
                              </td>
                              <td style="text-align: center;">
                                <div class="d-flex justify-content-center" style="gap: 6px;">
                                  <button class="btn btn-primary btn-sm btn-action-edit btn-edit-kegiatan" data-event='<?php echo htmlspecialchars(json_encode($keg), ENT_QUOTES, 'UTF-8'); ?>' title="Edit Kegiatan">
                                    <i class="fas fa-edit"></i>
                                  </button>
                                  <button class="btn btn-danger btn-sm btn-action-delete btn-delete-kegiatan" data-id="<?php echo $keg['id']; ?>" title="Hapus Kegiatan">
                                    <i class="fas fa-trash-alt"></i>
                                  </button>
                                </div>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <footer class="main-footer" style="background: #161820; border-top: 1px solid #2a2d3a; color: #94a3b8; text-align: center; padding: 15px;">
      PsychoApps :: <small>Sistem Informasi Terintegrasi Fakultas Psikologi UIN Maliki Malang</small>
      <div class="float-right d-none d-sm-inline-block"> Copyright &copy; 2017-<?php echo date('Y');?> </div>
    </footer>
  </div>

  <!-- Modern Dynamic Modal for Add/Edit Event -->
  <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content shadow-lg border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="modal-header bg-primary text-white py-3 border-0">
          <h5 class="modal-title font-weight-bold" id="eventModalLabel">Detail Kegiatan</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="eventForm">
          <input type="hidden" id="eventId" name="id">
          <div class="modal-body p-4">
            <div class="row">
              <!-- Left Column: Details -->
              <div class="col-md-7">
                <div class="form-group">
                  <label for="eventTitle" class="font-weight-bold" style="color: #475569;">Judul Kegiatan <span class="text-danger">*</span></label>
                  <input type="text" class="form-control border-0 bg-light" id="eventTitle" name="title" required placeholder="Masukkan judul kegiatan..." style="border-radius: 8px; padding: 10px 14px;">
                </div>
                <div class="form-group">
                  <label for="eventDescription" class="font-weight-bold" style="color: #475569;">Deskripsi / Keterangan</label>
                  <textarea class="form-control border-0 bg-light" id="eventDescription" name="description" rows="3" placeholder="Masukkan detail atau deskripsi kegiatan..." style="border-radius: 8px; padding: 10px 14px;"></textarea>
                </div>

                <div class="form-group">
                  <label for="eventLocation" class="font-weight-bold" style="color: #475569;">Tempat</label>
                  <input type="text" class="form-control border-0 bg-light" id="eventLocation" name="tempat" placeholder="Contoh: Ruang Seminar, Gedung A" style="border-radius: 8px; padding: 10px 14px;">
                </div>

                <div class="form-group">
                  <label for="eventPenanggungJawab" class="font-weight-bold" style="color: #475569;">Penanggung Jawab (Jabatan)</label>
                  <select class="form-control border-0 bg-light" id="eventPenanggungJawab" name="penanggung_jawab" style="border-radius: 8px; padding: 10px 14px; height: auto;">
                    <option value="">-- Pilih Jabatan --</option>
                    <?php foreach($opsi_jabatan as $j): ?>
                      <option value="<?php echo htmlspecialchars($j); ?>"><?php echo htmlspecialchars($j); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="eventStart" class="font-weight-bold" style="color: #475569;">Waktu Mulai <span class="text-danger">*</span></label>
                      <input type="datetime-local" class="form-control border-0 bg-light" id="eventStart" name="start" required style="border-radius: 8px;">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="eventEnd" class="font-weight-bold" style="color: #475569;">Waktu Selesai <span class="text-danger">*</span></label>
                      <input type="datetime-local" class="form-control border-0 bg-light" id="eventEnd" name="end" required style="border-radius: 8px;">
                    </div>
                  </div>
                </div>

                <div class="form-group" id="colorGroup">
                  <label class="font-weight-bold" style="color: #475569;">Warna Label Kegiatan</label>
                  <div id="colorPicker" class="d-flex flex-wrap align-items-center mt-1" style="gap: 10px;"></div>
                  <input type="hidden" id="eventColor" name="color" value="#4e73df">
                </div>

                <div class="form-group d-none" id="creatorGroup">
                  <label class="font-weight-bold mb-0" style="color: #475569;">Dibuat Oleh</label>
                  <input type="text" class="form-control-plaintext text-muted font-weight-bold" id="eventCreator" readonly style="outline: none; padding-left: 0;">
                </div>
              </div>

              <!-- Right Column: Lampiran -->
              <div class="col-md-5">
                <div class="form-group" id="lampiranGroup">
                  <label class="font-weight-bold" style="color: #cbd5e1;">Lampiran Kegiatan</label>
                  
                  <!-- Form upload lampiran (admin only) -->
                  <div id="lampiranUploadSection" class="d-none">
                    <div class="text-muted small mb-2">1 file = 1 deskripsi. Gunakan tombol Tambah Lampiran untuk tambah file berikutnya.</div>
                    <div id="lampiranItems" class="mt-2">
                      <div class="border rounded p-2 mb-2" style="background:#151720; border-color:#2a2d3a;">
                        <label for="lampiranDesc_0" class="font-weight-bold" style="color: #cbd5e1;">Deskripsi Lampiran</label>
                        <input type="text" class="form-control border-0 bg-light" id="lampiranDesc_0" name="file_desc" placeholder="Contoh: Proposal, surat tugas, dll" style="border-radius: 8px; padding: 10px 14px;">

                        <div class="mt-2">
                          <label class="font-weight-bold" style="color: #cbd5e1;">Pilih File</label>
                          <input type="file" class="form-control border-0 bg-light" id="lampiranFiles_0" name="files" style="border-radius: 8px; padding: 8px 10px;">
                          <small class="text-muted d-block mt-1">Format bebas, sistem akan menyimpan ke: <b>psychoApps/kalender_kegiatan_files/<kegiatan_id>/</b></small>
                        </div>
                      </div>
                    </div>

                    <button type="button" id="btnTambahLampiran" class="btn btn-info btn-sm mt-1" style="border-radius:10px; font-weight:700;">
                      <i class="fas fa-plus mr-1"></i> Tambah Lampiran
                    </button>
                  </div>

                  <!-- Daftar lampiran -->
                  <div class="mt-3" id="lampiranListSection">
                    <label class="font-weight-bold" style="color: #cbd5e1; font-size: 0.9rem;">Daftar Unduhan Lampiran</label>
                    <div id="lampiranList">
                      <p class="text-muted small mb-0">Belum ada lampiran.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer bg-light border-0 py-3 px-4 d-flex justify-content-end" style="gap: 8px;">
            <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Tutup</button>
            <a href="#" target="_blank" id="btnGoogleCalendar" class="btn btn-outline-info btn-sm px-3 d-none" style="border-radius: 8px; font-weight: 600;"><i class="fab fa-google mr-1"></i> Google Cal</a>
            <button type="button" id="btnDeleteEvent" class="btn btn-danger btn-sm px-3 d-none" style="border-radius: 8px; font-weight: 600;"><i class="fas fa-trash-alt mr-1"></i> Hapus</button>
            <button type="submit" id="btnSaveEvent" class="btn btn-primary btn-sm px-4" style="border-radius: 8px; font-weight: 600;"><i class="fas fa-save mr-1"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include("jsAdm.php"); ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const isAdminUtama = <?php echo $isAdminUtama ? 'true' : 'false'; ?>;

      // Premium Color Palette
      const colorPalette = [
        {color: '#4e73df', label: '-'},
        {color: '#1cc88a', label: '-'},
        {color: '#e74a3b', label: '-'},
        {color: '#f6c23e', label: '-'},
        {color: '#36b9cc', label: '-'},
        {color: '#6f42c1', label: '-'},
        {color: '#858796', label: '-'},
        {color: '#fd7e14', label: '-'}
      ];

      let selectedColor = '#4e73df';

      // Build Interactive Color Picker inside Modal
      const cpDiv = document.getElementById('colorPicker');
      colorPalette.forEach(p => {
        const sw = document.createElement('span');
        sw.className = 'color-swatch';
        sw.style.backgroundColor = p.color;
        sw.title = p.label;
        sw.dataset.color = p.color;
        sw.addEventListener('click', function() {
          document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
          this.classList.add('selected');
          selectedColor = this.dataset.color;
          document.getElementById('eventColor').value = selectedColor;
        });
        cpDiv.appendChild(sw);
      });

      // Build Sidebar Legend
      const legendDiv = document.getElementById('legendContainer');
      colorPalette.forEach(p => {
        const item = document.createElement('div');
        item.className = 'legend-item animate__animated animate__fadeIn';
        item.innerHTML = `<span class="legend-dot" style="background-color: ${p.color}"></span> ${p.label}`;
        legendDiv.appendChild(item);
      });

      // Year Filter Dropdown redirect
      document.getElementById('yearFilter').addEventListener('change', function() {
        const yr = this.value;
        window.location.href = `rekapKalender.php?year=${yr}`;
      });

      // Realtime Live Search filter
      const searchInput = document.getElementById('searchInput');
      searchInput.addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('#kegiatanTable tbody tr');

        rows.forEach(row => {
          // If no events found row, ignore
          if (row.cells.length < 2) return;

          const text = row.textContent.toLowerCase();
          if (text.includes(keyword)) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
      });

      // Open Modal for Edit
      $(document).on('click', '.btn-edit-kegiatan', function() {
        const ev = $(this).data('event');
        openEventModal(ev);
      });

      // Quick Add Button
      const btnAddEvent = document.getElementById('btnAddEvent');
      if (btnAddEvent) {
        btnAddEvent.addEventListener('click', function() {
          document.getElementById('eventForm').reset();
          document.getElementById('eventId').value = '';

          const now = new Date();
          const pad = (n) => String(n).padStart(2, '0');
          const nowLocal = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())}T${pad(now.getHours())}:${pad(now.getMinutes())}`;

          document.getElementById('eventStart').value = nowLocal;
          document.getElementById('eventEnd').value = nowLocal;

          selectedColor = '#4e73df';
          document.getElementById('eventColor').value = selectedColor;
          document.querySelectorAll('.color-swatch').forEach(s => {
            s.classList.toggle('selected', s.dataset.color === selectedColor);
          });

          document.getElementById('eventModalLabel').innerText = 'Tambah Kegiatan Baru';
          document.getElementById('btnSaveEvent').innerHTML = '<i class="fas fa-save mr-1"></i> Simpan';
          document.getElementById('btnSaveEvent').classList.remove('d-none');
          document.getElementById('btnDeleteEvent').classList.add('d-none');
          document.getElementById('btnGoogleCalendar').classList.add('d-none');
          document.getElementById('creatorGroup').classList.add('d-none');
          enableFormFields(true);
          
          // reset lampiran uploads in form
          resetUploadSection();

          $('#eventModal').modal('show');
        });
      }

      function resetUploadSection() {
        document.getElementById('lampiranItems').innerHTML = `
          <div class="border rounded p-2 mb-2" style="background:#151720; border-color:#2a2d3a;">
            <label for="lampiranDesc_0" class="font-weight-bold" style="color: #475569;">Deskripsi Lampiran</label>
            <input type="text" class="form-control border-0 bg-light" id="lampiranDesc_0" name="file_desc" placeholder="Contoh: Proposal, surat tugas, dll" style="border-radius: 8px; padding: 10px 14px;">

            <div class="mt-2">
              <label class="font-weight-bold" style="color: #475569;">Pilih File</label>
              <input type="file" class="form-control border-0 bg-light" id="lampiranFiles_0" name="files" style="border-radius: 8px; padding: 8px 10px;">
              <small class="text-muted d-block mt-1">Format bebas, sistem akan menyimpan ke: <b>psychoApps/kalender_kegiatan_files/&lt;kegiatan_id&gt;/</b></small>
            </div>
          </div>
        `;
        window._lampiranIndex = 1;
        document.getElementById('lampiranList').innerHTML = '<p class="text-muted small mb-0">Belum ada lampiran.</p>';
      }

      function openEventModal(ev) {
        resetUploadSection();

        const propsStart = new Date(ev.start);
        const propsEnd = ev.end ? new Date(ev.end) : propsStart;

        document.getElementById('eventId').value = ev.id;
        document.getElementById('eventTitle').value = ev.title;
        document.getElementById('eventDescription').value = ev.description || '';
        document.getElementById('eventLocation').value = ev.tempat || '';
        document.getElementById('eventPenanggungJawab').value = ev.penanggung_jawab || '';

        // datetime-local expects YYYY-MM-DDTHH:mm
        document.getElementById('eventStart').value = formatDateTimeLocal(ev.start);
        document.getElementById('eventEnd').value = formatDateTimeLocal(ev.end || ev.start);

        selectedColor = ev.color || '#4e73df';
        document.getElementById('eventColor').value = selectedColor;
        document.querySelectorAll('.color-swatch').forEach(s => {
          s.classList.toggle('selected', s.dataset.color === selectedColor);
        });

        document.getElementById('eventCreator').value = ev.created_by || 'Admin';
        document.getElementById('eventModalLabel').innerText = 'Edit Kegiatan';
        document.getElementById('creatorGroup').classList.remove('d-none');

        // Hide/show upload section
        const uploadSection = document.getElementById('lampiranUploadSection');
        if (uploadSection) {
          uploadSection.classList.remove('d-none');
        }

        // Load files list
        loadLampiran(ev.id);

        setupGoogleCalendarLink(ev.title, ev.description, propsStart, propsEnd);

        enableFormFields(true);
        document.getElementById('btnSaveEvent').classList.remove('d-none');
        document.getElementById('btnSaveEvent').innerHTML = '<i class="fas fa-save mr-1"></i> Simpan';
        document.getElementById('btnDeleteEvent').classList.remove('d-none');

        $('#eventModal').modal('show');
      }

      async function loadLampiran(kegiatanId) {
        const listEl = document.getElementById('lampiranList');
        if (!listEl || !kegiatanId) return;

        listEl.innerHTML = '<p class="text-muted small mb-0">Memuat lampiran...</p>';

        try {
          const url = `apiKalenderKegiatan.php?action=fetch_files&kegiatan_id=${encodeURIComponent(kegiatanId)}`;
          const res = await fetch(url);
          const data = await res.json();

          if (!data || data.status !== 'success') {
            listEl.innerHTML = '<p class="text-danger small mb-0">Gagal memuat lampiran.</p>';
            return;
          }

          const files = Array.isArray(data.files) ? data.files : [];
          if (!files.length) {
            listEl.innerHTML = '<p class="text-muted small mb-0">Belum ada lampiran.</p>';
            return;
          }

          const html = files.map(f => {
            const fileLabel = f.file_name || 'file';
            
            // Normalize path
            let p = String(f.file_path);
            p = p.replace(/^(\/+)/, '/');
            p = p.replace(/^\/?psychoApps\/psychoApps\//, 'psychoApps/');
            p = p.replace(/^\/?psychoApps\//, 'psychoApps/');
            const href = '/' + p;

            const desc = f.file_desc ? `<div class="text-muted small mt-1">${f.file_desc}</div>` : '';
            return `
              <div class="border rounded p-2 mb-2" style="background:#151720; border-color:#2a2d3a;">
                <div class="d-flex align-items-center justify-content-between gap-2">
                  <div style="min-width:0;">
                    <a href="${href}" target="_blank" class="font-weight-bold" style="color:#60a5fa; text-decoration:none; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; display:inline-block; max-width:240px;">${fileLabel}</a>
                    ${desc}
                    <div class="text-muted small mt-1">Dibuat: ${f.created_at || ''}</div>
                  </div>
                </div>
              </div>
            `;
          }).join('');

          listEl.innerHTML = html;
        } catch (e) {
          console.error('loadLampiran error', e);
          listEl.innerHTML = '<p class="text-danger small mb-0">Gagal memuat lampiran.</p>';
        }
      }

      // Add dynamic attachment row
      document.getElementById('btnTambahLampiran').addEventListener('click', function() {
        const idx = window._lampiranIndex || 0;
        const itemsEl = document.getElementById('lampiranItems');
        if (!itemsEl) return;

        const wrapper = document.createElement('div');
        wrapper.className = 'border rounded p-2 mb-2';
        wrapper.style.background = '#151720';
        wrapper.style.borderColor = '#2a2d3a';

        wrapper.innerHTML = `
          <label for="lampiranDesc_${idx}" class="font-weight-bold" style="color: #475569;">Deskripsi Lampiran</label>
          <input type="text" class="form-control border-0 bg-light" id="lampiranDesc_${idx}" name="file_desc" placeholder="Contoh: Proposal, surat tugas, dll" style="border-radius: 8px; padding: 10px 14px;" required>

          <div class="mt-2">
            <label class="font-weight-bold" style="color: #475569;">Pilih File</label>
            <input type="file" class="form-control border-0 bg-light" id="lampiranFiles_${idx}" name="files" style="border-radius: 8px; padding: 8px 10px;" required>
            <small class="text-muted d-block mt-1">Format bebas, sistem akan menyimpan ke: <b>psychoApps/kalender_kegiatan_files/&lt;kegiatan_id&gt;/</b></small>
          </div>
        `;

        itemsEl.appendChild(wrapper);
        window._lampiranIndex = idx + 1;
      });

      // Submit Form via AJAX
      document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const eventId = document.getElementById('eventId').value;
        const action = eventId ? 'update' : 'add';

        const formData = new FormData(this);
        formData.append('action', action);

        fetch('apiKalenderKegiatan.php', {
            method: 'POST',
            body: formData
          })
          .then(r => r.json())
          .then(async res => {
            if (res.status === 'success') {
              const kegiatanId = action === 'add' ? res.id : eventId;

              // Upload attachments
              if (kegiatanId) {
                const itemsEl = document.getElementById('lampiranItems');
                if (itemsEl) {
                  const descInputs = itemsEl.querySelectorAll('input[id^="lampiranDesc_"]');
                  const fdLamp = new FormData();
                  fdLamp.append('action', 'save_files');
                  fdLamp.append('kegiatan_id', kegiatanId);

                  let uploadedSomething = false;
                  descInputs.forEach((descEl) => {
                    const idSuffix = descEl.id.split('_').pop();
                    const fileEl = document.getElementById('lampiranFiles_' + idSuffix);
                    const descVal = descEl ? descEl.value : '';
                    if (fileEl && fileEl.files && fileEl.files.length > 0) {
                      fdLamp.append('file_descs[]', descVal);
                      fdLamp.append('files[]', fileEl.files[0]);
                      uploadedSomething = true;
                    }
                  });

                  if (uploadedSomething) {
                    const r2 = await fetch('apiKalenderKegiatan.php', {
                      method: 'POST',
                      body: fdLamp
                    });
                    const res2 = await r2.json();
                    if (res2.status !== 'success') {
                      Swal.fire('Lampiran Gagal', res2.message || 'Gagal menyimpan lampiran.', 'error');
                    }
                  }
                }
              }

              $('#eventModal').modal('hide');
              Swal.fire({
                title: 'Berhasil',
                text: res.message,
                icon: 'success',
                timer: 1500,
                showConfirmButton: true
              }).then(() => {
                window.location.reload();
              });
            } else {
              Swal.fire('Gagal', res.message, 'error');
            }
          })
          .catch(() => {
            Swal.fire('Error', 'Gagal memproses permintaan.', 'error');
          });
      });

      // Handle Delete Event from Modal
      document.getElementById('btnDeleteEvent').addEventListener('click', function() {
        const eventId = document.getElementById('eventId').value;
        if (!eventId) return;
        deleteEventAction(eventId);
      });

      // Handle Delete Event directly from Table
      $(document).on('click', '.btn-delete-kegiatan', function() {
        const eventId = $(this).data('id');
        if (!eventId) return;
        deleteEventAction(eventId);
      });

      function deleteEventAction(eventId) {
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Kegiatan ini akan dihapus secara permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef4444',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            const payload = new URLSearchParams();
            payload.append('action', 'delete');
            payload.append('id', eventId);

            fetch('apiKalenderKegiatan.php', {
                method: 'POST',
                body: payload
              })
              .then(r => r.json())
              .then(res => {
                if (res.status === 'success') {
                  $('#eventModal').modal('hide');
                  Swal.fire({
                    title: 'Terhapus!',
                    text: res.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: true
                  }).then(() => {
                    window.location.reload();
                  });
                } else {
                  Swal.fire('Gagal', res.message, 'error');
                }
              })
              .catch(err => {
                Swal.fire('Error', 'Gagal menghapus kegiatan.', 'error');
              });
          }
        });
      }

      // Enable/Disable form inputs
      function enableFormFields(enable) {
        const fields = ['eventTitle', 'eventDescription', 'eventLocation', 'eventPenanggungJawab', 'eventStart', 'eventEnd'];
        fields.forEach(id => {
          document.getElementById(id).disabled = !enable;
        });
        document.querySelectorAll('.color-swatch').forEach(sw => {
          sw.style.pointerEvents = enable ? 'auto' : 'none';
        });
      }

      // Format ISO string / datetime string to local datetime-local value
      function formatDateTimeLocal(dateStr) {
        if (!dateStr) return '';
        let d;
        if (typeof dateStr === 'string') {
          if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
            d = new Date(dateStr + 'T00:00:00');
          } else {
            // Replace space with T for browser ISO compatibility if necessary
            d = new Date(dateStr.replace(' ', 'T'));
          }
        } else {
          d = dateStr;
        }
        if (isNaN(d.getTime())) return '';
        const pad = (n) => String(n).padStart(2, '0');
        return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
      }

      // Setup URL to add event directly into user's Google Calendar
      function setupGoogleCalendarLink(title, desc, start, end) {
        const btn = document.getElementById('btnGoogleCalendar');
        if (!start) {
          btn.classList.add('d-none');
          return;
        }

        const formatGCalDate = (dateObj) => {
          const d = new Date(dateObj);
          const pad = (n) => String(n).padStart(2, '0');
          return d.getUTCFullYear() +
            pad(d.getUTCMonth() + 1) +
            pad(d.getUTCDate()) + 'T' +
            pad(d.getUTCHours()) +
            pad(d.getUTCMinutes()) +
            pad(d.getUTCSeconds()) + 'Z';
        };

        const gStart = formatGCalDate(start);
        const gEnd = formatGCalDate(end || start);
        const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${gStart}/${gEnd}&details=${encodeURIComponent(desc || '')}`;
        btn.href = url;
        btn.classList.remove('d-none');
      }
    });
  </script>
</body>
</html>
