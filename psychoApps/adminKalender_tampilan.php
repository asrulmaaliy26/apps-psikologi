<?php
include("conAdm.php"); // Load session and db connection without blocking
$isLoggedIn = !empty($_SESSION['username']);
$isAdminUtama = false;
$isAuthorizedCalendarAdmin = false;

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

?>
<!DOCTYPE html>
<html lang="id">
<?php include("headAdm.php"); ?>
<style>
@media (min-width: 768px) {
    body .content-wrapper,
    body .main-footer,
    body .main-header {
        margin-left: 0 !important;
    }
}
</style>
<!-- Calendar Grid (no FullCalendar) -->

<style>
  /* ─── Premium Google Calendar Dark Theme Style ─── */
  .content-wrapper {
    background-color: #12141c !important;
    color: #f8fafc;
  }

  <?php if (!$isLoggedIn): ?>.content-wrapper {
    margin-left: 0 !important;
  }

  .main-footer {
    margin-left: 0 !important;
  }

  <?php endif; ?>.card-calendar {
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

  /* FullCalendar Dark Grid Customizations */
  .fc {
    background: transparent;
    color: #f1f5f9;
  }

  /* Make sure every td, th, and scrollgrid matches our premium dark palette */
  .fc-theme-standard td,
  .fc-theme-standard th,
  .fc-theme-standard .fc-scrollgrid {
    border: 1px solid #2f3242 !important;
    background-color: #1a1d26 !important;
  }

  /* Disable cell default backgrounds to prevent overrides */
  .fc-daygrid-day,
  .fc-daygrid-day-frame,
  .fc-daygrid-day-events,
  .fc-daygrid-day-bg {
    background-color: #1a1d26 !important;
  }

  /* Interactive Grid cell hover effect */
  .fc-daygrid-day:hover,
  .fc-daygrid-day-frame:hover {
    background-color: #232733 !important;
  }

  /* Center Day Numbers & Style Them */
  .fc-daygrid-day-top {
    display: flex !important;
    justify-content: center !important;
    padding-top: 8px !important;
  }

  .fc-daygrid-day-number {
    font-weight: 700 !important;
    color: #cbd5e1 !important;
    text-decoration: none !important;
    font-size: 0.82rem !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 28px !important;
    height: 28px !important;
  }

  .fc-daygrid-day-number:hover {
    color: #ffffff !important;
    text-decoration: none !important;
  }

  /* Today Circular Highlight Badge */
  .fc-theme-standard td.fc-day-today {
    background-color: #1a1d26 !important;
    /* Keep background cohesive */
  }

  .fc-day-today .fc-daygrid-day-number {
    background-color: #5c8ef2 !important;
    /* Premium Blue Accent */
    color: #ffffff !important;
    border-radius: 50% !important;
    width: 28px !important;
    height: 28px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
  }

  /* Days of Other Months Styling */
  .fc-day-other {
    background-color: #151720 !important;
  }

  .fc-day-other .fc-daygrid-day-number {
    color: #475569 !important;
    opacity: 0.6;
  }

  /* Week Column (Left Side) styling */
  .fc-week-number,
  th.fc-week-number,
  td.fc-week-number {
    background-color: #151720 !important;
    color: #475569 !important;
    font-size: 0.78rem !important;
    font-weight: 800 !important;
    text-align: center !important;
    vertical-align: middle !important;
    border-right: 1.5px solid #2f3242 !important;
  }

  .fc-week-number a {
    color: #475569 !important;
    text-decoration: none !important;
  }

  /* Header styling (Weekday Names) */
  .fc-theme-standard th.fc-col-header-cell {
    background-color: #1e212d !important;
    padding: 14px 0 !important;
    border-bottom: 2px solid #2f3242 !important;
    text-align: center !important;
  }

  .fc-col-header-cell a {
    color: #94a3b8 !important;
    font-weight: 700 !important;
    font-size: 0.8rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
    text-decoration: none !important;
  }

  /* Modern Premium Events Pill (Google Calendar Style) */
  .fc-event,
  .fc-daygrid-event,
  .fc-daygrid-block-event {
    cursor: pointer !important;
    font-size: 0.76rem !important;
    font-weight: 700 !important;
    border-radius: 30px !important;
    /* Highly rounded pill - both ends */
    border: none !important;
    padding: 3px 10px !important;
    margin: 2px 4px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
    transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.15s ease !important;
    display: flex !important;
    align-items: center !important;
    min-height: 22px !important;
  }

  /* ── Spanning event: when event continues from previous week (no left cap) ── */
  .fc-daygrid-event:not(.fc-event-start) {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
    margin-left: 0 !important;
    padding-left: 6px !important;
  }

  /* ── Spanning event: when event continues to next week (no right cap) ── */
  .fc-daygrid-event:not(.fc-event-end) {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    margin-right: 0 !important;
    padding-right: 6px !important;
  }

  /* ── The absolute harness: stretches the pill across day columns ── */
  .fc-daygrid-event-harness-abs {
    margin-top: 2px !important;
  }

  /* ── Ensure block event inner content has no extra padding ── */
  .fc-daygrid-block-event .fc-event-main {
    padding: 0 !important;
  }

  /* ── +more popup link style ── */
  .fc-daygrid-more-link {
    color: #94a3b8 !important;
    font-size: 0.72rem !important;
    font-weight: 700 !important;
    padding: 1px 6px !important;
  }

  .fc-daygrid-more-link:hover {
    color: #ffffff !important;
    background-color: #2a2d3a !important;
    border-radius: 6px !important;
  }

  /* ── Popover for +more events ── */
  .fc-popover {
    background-color: #1e212d !important;
    border: 1px solid #2f3242 !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
  }

  .fc-popover-header {
    background-color: #232733 !important;
    color: #f1f5f9 !important;
    border-radius: 12px 12px 0 0 !important;
    font-weight: 700 !important;
    font-size: 0.82rem !important;
  }

  .fc-popover-close {
    color: #94a3b8 !important;
  }

  .fc-event:hover,
  .fc-daygrid-event:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 5px 14px rgba(0, 0, 0, 0.45) !important;
    filter: brightness(1.12) !important;
  }

  .fc-event-main-custom {
    color: #ffffff !important;
    overflow: hidden !important;
    white-space: nowrap !important;
    text-overflow: ellipsis !important;
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
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

  /* Upcoming Events List */
  #upcomingEvents {
    max-height: 400px;
    overflow-y: auto;
  }

  /* Hover Tooltip styling */
  #eventTooltip {
    position: fixed;
    z-index: 9999;
    pointer-events: none;
    background: #1e2230;
    color: #f1f5f9;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
    padding: 14px 18px;
    min-width: 240px;
    max-width: 320px;
    border-left: 4px solid #3b82f6;
    font-size: 0.85rem;
    display: none;
    opacity: 0;
    transition: opacity 0.15s ease;
  }

  #eventTooltip .ev-title {
    font-weight: 700;
    font-size: 0.95rem;
    margin-bottom: 6px;
    color: #ffffff;
  }

  #eventTooltip .ev-time {
    color: #94a3b8;
    font-size: 0.78rem;
    margin-bottom: 8px;
  }

  #eventTooltip .ev-desc {
    color: #cbd5e1;
    line-height: 1.4;
  }

  .badge-creator {
    background-color: #2e344a;
    color: #94a3b8;
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 8px;
  }

  /* Custom Calendar Header & FAB styles */
  .custom-calendar-header {
    margin-bottom: 20px;
  }

  .btn-fab-add {
    background-color: #c2e7ff;
    border: none;
    border-radius: 16px;
    width: 56px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  .btn-fab-add:hover {
    background-color: #a8c7fa;
    transform: scale(1.05);
  }

  .nav-arrow-btn {
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
  }

  .nav-arrow-btn:hover {
    background-color: rgba(255, 255, 255, 0.1);
  }

  /* Custom Calendar Grid (5x7) */
  .calendar-grid-wrapper {
    border-radius: 18px;
    border: 1px solid #2f3242;
    background: #151720;
    overflow: hidden;
  }

  .calendar-grid-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: #1e212d;
    border-bottom: 1px solid #2f3242;
  }

  .calendar-grid-header .dow {
    padding: 10px 0;
    text-align: center;
    color: #94a3b8;
    font-weight: 800;
    font-size: .78rem;
    text-transform: uppercase;
    letter-spacing: .05em;
  }

  .calendar-grid {
    position: relative;
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    /* grid-template-rows: repeat(5, 1fr); */
    height: auto;
    min-height: 520px;
    grid-auto-rows: 120px;
  }

  .cal-cell {
    border-right: 1px solid #2f3242;
    border-bottom: 1px solid #2f3242;
    position: relative;
    overflow: hidden;
    padding: 6px 6px 0 6px;
    min-height: 100px;
    background: #1a1d26;
  }

  .cal-cell:nth-child(7n) {
    border-right: none;
  }

  .cal-cell .num {
    font-weight: 800;
    font-size: .78rem;
    color: #cbd5e1;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
  }

  .cal-cell.is-other {
    background: #151720;
  }

  .cal-cell.is-other .num {
    color: #475569;
    opacity: .6;
  }

  .cal-cell.is-today .num {
    background: #5c8ef2;
    color: #fff;
  }

  .cal-strips-layer {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: visible;
  }

  .cal-strip {
    /* jangan absolute supaya strip tidak saling menutupi sampai yang awal tidak terlihat */
    position: absolute;
    position: absolute;
    height: 22px;
    line-height: 22px;
    border-radius: 18px;
    padding: 0 10px;
    box-sizing: border-box;

    border-radius: 18px;
    padding: 3px 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .35);
    font-size: .76rem;
    font-weight: 800;
    color: #fff;
    display: flex;
    align-items: center;
    min-height: 22px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    cursor: pointer;
    pointer-events: auto;
    border: 1px solid rgba(255, 255, 255, .08);
  }

  .cal-strip:hover {
    filter: brightness(1.1);
  }

  /* Modal styling */
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

<body class="hold-transition <?php echo $isLoggedIn ? 'sidebar-mini layout-fixed' : ''; ?>">
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <!-- <div class="row mb-2 animate__animated animate__fadeIn">
            <div class="col-sm-6"> -->
          <h1 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-calendar-alt mr-2 text-primary"></i>Kalender Kegiatan Fakultas Psikologi
          </h1>
        </div>
        <!-- </div>
        </div> -->
      </div>

      <!-- <section class="content"> -->
        <div class="container-fluid">
          <div class="row">
            <!-- Left Side Panel: Legend & Upcoming events -->
            <div class="col-lg-3 col-md-4 animate__animated animate__fadeInLeft">
              <!-- Action Button Card -->
              <div class="card card-calendar mb-4 shadow-sm">
                <div class="card-body p-3">
                  <p class="text-muted text-uppercase font-weight-bold mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Kategori Warna</p>
                  <div id="legendContainer"></div>
                </div>
              </div>

              <!-- Upcoming Events Card -->
              <div class="card card-calendar mb-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0 pt-3">
                  <h6 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-clock text-warning mr-2"></i>Kegiatan Mendatang
                  </h6>
                </div>
                <div class="card-body p-3" id="upcomingEvents">
                  <p class="text-muted small mb-0">Memuat...</p>
                </div>
              </div>
            </div>

            <!-- Right Panel: Calendar Grid -->
            <div class="col-lg-9 col-md-8 animate__animated animate__fadeInRight">
              <div class="card card-calendar shadow-sm">
                <div class="card-body p-4">
                  <div class="d-flex align-items-center justify-content-between mb-3" style="gap:16px;">

                    <div class="d-flex align-items-center" style="gap:16px;">
                      <span class="h3 font-weight-bold text-white mb-0" id="calendarTitle">Mei 2026</span>
                    </div>
                    <div class="d-flex align-items-center" style="gap:16px;">
                      <div class="d-flex align-items-center bg-dark" style="border: 1px solid #2a2d3a; border-radius: 30px; padding: 2px;">
                        <button id="btnPrev" type="button" class="btn btn-link text-white nav-arrow-btn m-0" style="padding: 6px;"><i class="fas fa-chevron-left"></i></button>
                        <button id="btnNext" type="button" class="btn btn-link text-white nav-arrow-btn m-0" style="padding: 6px;"><i class="fas fa-chevron-right"></i></button>
                      </div>
                    </div>
                  </div>

                  <div id="calendar"></div>

                  <!-- Custom 5x7 Calendar Grid -->
                  <div id="calendarGridWrapper" class="calendar-grid-wrapper" style="display:none;">
                    <div class="calendar-grid-header" id="dowHeader"></div>
                    <div id="calendarGrid" class="calendar-grid"></div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- </section> -->
    </div>
  </div>

  <!-- Modern Dynamic Modal for Add/Edit/View Event -->
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
            <!-- DUA KOLOM: SAMPINGAN (LAMPIRAN DI KANAN) -->
            <div class="row">
              <!-- KOLOM KIRI: Judul, Deskripsi, Waktu, Warna -->
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

              <!-- KOLOM KANAN: LAMPIRAN (SEMUA UPLOAD & DAFTAR LAMPIRAN) -->
              <div class="col-md-5">
                <div class="form-group" id="lampiranGroup">
                  <label class="font-weight-bold" style="color: #cbd5e1;">Lampiran Kegiatan</label>

                  <!-- Form upload lampiran (hanya untuk admin saat edit/tambah) -->
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

                  <!-- Daftar lampiran yang sudah tersimpan (selalu muncul untuk semua orang jika ada) -->
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

  <!-- Event Tooltip element -->
  <div id="eventTooltip">
    <div class="ev-title" id="tipTitle"></div>
    <div class="ev-time" id="tipTime"></div>
    <div class="ev-desc" id="tipDesc"></div>
    <div class="mt-2" id="tipCreatorContainer">
      <span class="badge-creator" id="tipCreator"></span>
    </div>
  </div>

  <?php include("jsAdm.php"); ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const isAdminUtama = <?php echo $isAdminUtama ? 'true' : 'false'; ?>;
      const currentUserName = <?php echo json_encode(isset($_SESSION['nm_person']) && $_SESSION['nm_person'] !== '' ? $_SESSION['nm_person'] : (isset($_SESSION['username']) ? $_SESSION['username'] : '')); ?>;
      let currentEventCanUpload = false;

      function isCurrentUserCreator(ev) {
        if (!ev || !ev.created_by) return false;
        return String(ev.created_by).trim() === String(currentUserName).trim();
      }

      function canUploadForEvent(ev, isNew = false) {
        if (isAdminUtama) return true;
        if (isNew) return !!currentUserName;
        return isCurrentUserCreator(ev);
      }

      // ===============================
      // Custom Calendar Grid 5x7
      // ==============================
      const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
      ];
      const dowNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
      const gridRows = 5;
      const gridCols = 7;

      const calendarEl = document.getElementById('calendar');
      const gridWrapper = document.getElementById('calendarGridWrapper');
      const gridEl = document.getElementById('calendarGrid');
      const dowHeaderEl = document.getElementById('dowHeader');
      const stripsLayer = document.createElement('div');
      stripsLayer.className = 'cal-strips-layer';
      stripsLayer.id = 'calStripsLayer';

      // gridState: month view
      const gridState = {
        viewDate: new Date(),
        gridStart: null, // Date (00:00) of first cell in grid
        gridEndExclusive: null, // Date (00:00) after last cell
        monthStart: null,
        monthEndExclusive: null,
        events: []
      };

      function startOfDay(d) {
        const x = new Date(d);
        x.setHours(0, 0, 0, 0);
        return x;
      }

      function addDays(date, days) {
        const d = new Date(date);
        d.setDate(d.getDate() + days);
        return d;
      }

      function fmtYYYYMMDD(date) {
        const pad = (n) => String(n).padStart(2, '0');
        return `${date.getFullYear()}-${pad(date.getMonth()+1)}-${pad(date.getDate())}`;
      }

      function buildMonthGrid(viewDate) {
        const firstOfMonth = new Date(viewDate.getFullYear(), viewDate.getMonth(), 1);
        const monthStart = startOfDay(firstOfMonth);
        const monthEndExclusive = startOfDay(new Date(viewDate.getFullYear(), viewDate.getMonth() + 1, 1));

        // Determine grid start as the Monday before (or same day) of the 1st.
        // Using dowNames: [Min..Sab] where Min = Monday = 1.
        // JS getDay(): 0=Sun..6=Sat. Convert to Monday-based index.
        const jsDay = monthStart.getDay();
        const mondayIndex = (jsDay + 6) % 7; // 0..6 where 0=Mon
        const gridStart = addDays(monthStart, -mondayIndex);
        const gridEndExclusive = addDays(gridStart, gridRows * gridCols);

        gridState.viewDate = viewDate;
        gridState.monthStart = monthStart;
        gridState.monthEndExclusive = monthEndExclusive;
        gridState.gridStart = gridStart;
        gridState.gridEndExclusive = gridEndExclusive;
      }

      function clearGrid() {
        gridEl.innerHTML = '';
      }

      function renderHeader() {
        dowHeaderEl.innerHTML = '';
        for (const d of dowNames) {
          const div = document.createElement('div');
          div.className = 'dow';
          div.textContent = d;
          dowHeaderEl.appendChild(div);
        }
      }

      function renderCalendarCells() {
        clearGrid();
        const today = startOfDay(new Date());
        const {
          gridStart
        } = gridState;
        for (let i = 0; i < gridRows * gridCols; i++) {
          const cellDate = addDays(gridStart, i);
          const inMonth = (cellDate >= gridState.monthStart && cellDate < gridState.monthEndExclusive);

          const cell = document.createElement('div');
          cell.className = 'cal-cell' + (inMonth ? '' : ' is-other') + (cellDate.getTime() === today.getTime() ? ' is-today' : '');

          const num = document.createElement('div');
          num.className = 'num';
          num.textContent = cellDate.getDate();

          cell.appendChild(num);
          cell.dataset.date = fmtYYYYMMDD(cellDate);

          // stack baseline is just for visuals; strips are separate layer.
          gridEl.appendChild(cell);
        }

        // Ensure strips layer exists and sits above cells
        stripsLayer.style.position = 'absolute';
        stripsLayer.style.inset = 0;
        stripsLayer.style.pointerEvents = 'none';
        if (!document.getElementById('calStripsLayer')) {
          gridEl.appendChild(stripsLayer);
        }
      }

      function getEventDateSpan(ev) {
        // Strip spanning date columns harus konsisten memakai end EXCLUSIVE.
        // Di apiKalenderKegiatan.php, field `end` sudah dibuat eksklusif (+1 day) untuk all-day.
        // Supaya kegiatan 1 hari (mis. tgl sama) tidak kebaca 2 hari, strip hanya pakai `ev.end`.
        const start = new Date(ev.realStart || ev.start);
        const startDay = startOfDay(start);

        const endExclusiveDay = startOfDay(new Date(ev.end));

        return {
          startDay,
          endExclusiveDay
        };
      }

      function dateIndexInGrid(day) {
        const msPerDay = 86400000;
        const diff = Math.floor((startOfDay(day).getTime() - gridState.gridStart.getTime()) / msPerDay);
        return diff;
      }

      /* =========================================
   RENDER STRIPS FIX NO OVERLAP
========================================= */

      function renderStrips(events) {

        const layer = document.getElementById('calStripsLayer');
        layer.innerHTML = '';

        const rowHeight = 120;
        const cols = 7;

        // simpan tier per row
        const rowTiers = Array.from({
          length: gridRows
        }, () => []);

        // sort stabil
        const sorted = [...events].sort((a, b) => {

          const aStart = new Date(a.realStart || a.start).getTime();
          const bStart = new Date(b.realStart || b.start).getTime();

          if (aStart !== bStart) {
            return aStart - bStart;
          }

          const aEnd = new Date(a.realEnd || a.end).getTime();
          const bEnd = new Date(b.realEnd || b.end).getTime();

          return bEnd - aEnd;
        });

        sorted.forEach(ev => {

          const {
            startDay,
            endExclusiveDay
          } = getEventDateSpan(ev);

          const startIdx = dateIndexInGrid(startDay);
          const endExclusiveIdx = dateIndexInGrid(endExclusiveDay);

          if (endExclusiveIdx <= 0) return;
          if (startIdx >= gridRows * cols) return;

          const spanStart = Math.max(0, startIdx);
          const spanEnd = Math.min(gridRows * cols, endExclusiveIdx);

          if (spanEnd <= spanStart) return;

          let current = spanStart;

          while (current < spanEnd) {

            const row = Math.floor(current / cols);

            const rowEnd = (row + 1) * cols;

            const pieceStart = current;
            const pieceEnd = Math.min(spanEnd, rowEnd);

            const colStart = pieceStart % cols;
            const widthDays = pieceEnd - pieceStart;

            // ======================
            // CARI TIER KOSONG
            // ======================

            let tier = 0;

            while (true) {

              const occupied = rowTiers[row].some(item => {

                if (item.tier !== tier) return false;

                return !(
                  pieceEnd <= item.start ||
                  pieceStart >= item.end
                );

              });

              if (!occupied) {
                break;
              }

              tier++;
            }

            rowTiers[row].push({
              tier,
              start: pieceStart,
              end: pieceEnd
            });

            // ======================
            // POSITION
            // ======================

            const leftPct = (colStart / cols) * 100;
            const widthPct = (widthDays / cols) * 100;

            const rowTop = row * rowHeight;

            // offset bawah nomor tanggal
            const headerOffset = 34;

            // jarak antar event
            const eventGap = 26;

            const topPx = rowTop + headerOffset + (tier * eventGap);

            // ======================
            // CREATE STRIP
            // ======================

            const strip = document.createElement('div');

            strip.className = 'cal-strip';

            strip.dataset.eventId = ev.id;

            strip.style.background = ev.color || '#4e73df';

            strip.style.left = leftPct + '%';

            strip.style.width = widthPct + '%';

            strip.style.top = topPx + 'px';

            strip.style.zIndex = 50 + tier;

            strip.textContent = ev.title;

            strip.title = ev.title;

            strip.addEventListener('click', (e) => {
              e.stopPropagation();
              openEventModal(ev);
            });

            layer.appendChild(strip);

            current = pieceEnd;
          }

        });

      }

      function openEventModal(ev) {
        // Fill form with realStart/realEnd if available

        // reset lampiran UI
        document.getElementById('lampiranItems').innerHTML = `
          <div class="border rounded p-2 mb-2" style="background:#151720; border-color:#2a2d3a;">
            <label for="lampiranDesc_0" class="font-weight-bold" style="color: #475569;">Deskripsi Lampiran</label>
            <input type="text" class="form-control border-0 bg-light" id="lampiranDesc_0" name="file_desc" placeholder="Contoh: Proposal, surat tugas, dll" style="border-radius: 8px; padding: 10px 14px;">

            <div class="mt-2">
              <label class="font-weight-bold" style="color: #475569;">Pilih File</label>
              <input type="file" class="form-control border-0 bg-light" id="lampiranFiles_0" name="files" style="border-radius: 8px; padding: 8px 10px;">
              <small class="text-muted d-block mt-1">Format bebas, sistem akan menyimpan ke: <b>psychoApps/kalender_kegiatan_files/<kegiatan_id>/</b></small>
            </div>
          </div>
        `;
        window._lampiranIndex = 1;
        document.getElementById('lampiranList').innerHTML = '<p class="text-muted small mb-0">Memuat lampiran...</p>';


        const propsStart = ev.realStart ? new Date(ev.realStart) : new Date(ev.start);
        const propsEnd = ev.realEnd ? new Date(ev.realEnd) : (ev.end ? new Date(ev.end) : propsStart);

        document.getElementById('eventId').value = ev.id;
        document.getElementById('eventTitle').value = ev.title;
        document.getElementById('eventDescription').value = ev.description || '';

        // datetime-local expects YYYY-MM-DDTHH:mm
        document.getElementById('eventStart').value = formatDateTimeLocal(ev.realStart || ev.start);
        document.getElementById('eventEnd').value = formatDateTimeLocal(ev.realEnd || ev.end);

        selectedColor = ev.color || '#4e73df';
        document.getElementById('eventColor').value = selectedColor;
        document.querySelectorAll('.color-swatch').forEach(s => {
          s.classList.toggle('selected', s.dataset.color === selectedColor);
        });

        document.getElementById('eventCreator').value = ev.created_by || 'Admin';
        document.getElementById('eventLocation').value = ev.tempat || '';
        document.getElementById('eventModalLabel').innerText = isAdminUtama ? 'Edit Kegiatan' : 'Detail Kegiatan';
        document.getElementById('creatorGroup').classList.remove('d-none');

        // Hide/show upload section based on admin authority or event ownership
        const uploadSection = document.getElementById('lampiranUploadSection');
        currentEventCanUpload = canUploadForEvent(ev, false);
        if (uploadSection) {
          if (currentEventCanUpload) {
            uploadSection.classList.remove('d-none');
          } else {
            uploadSection.classList.add('d-none');
          }
        }

        // Load lampiran list for this kegiatan
        loadLampiran(ev.id);

        // Google Calendar button

        setupGoogleCalendarLink(ev.title, ev.description, ev.realStart ? new Date(ev.realStart) : propsStart, ev.realEnd ? new Date(ev.realEnd) : propsEnd);

        if (isAdminUtama) {
          enableFormFields(true);
          // only admin can upload lampiran
          document.getElementById('lampiranGroup').classList.remove('d-none');

          document.getElementById('btnSaveEvent').classList.remove('d-none');
          document.getElementById('btnSaveEvent').innerHTML = '<i class="fas fa-save mr-1"></i> Simpan';
          document.getElementById('btnDeleteEvent').classList.remove('d-none');
        } else {
          enableFormFields(false);
          document.getElementById('btnDeleteEvent').classList.add('d-none');
          if (currentEventCanUpload) {
            document.getElementById('btnSaveEvent').classList.remove('d-none');
            document.getElementById('btnSaveEvent').innerHTML = '<i class="fas fa-save mr-1"></i> Upload Lampiran';
          } else {
            document.getElementById('btnSaveEvent').classList.add('d-none');
          }
        }

        $('#eventModal').modal('show');
      }

      async function loadLampiran(kegiatanId) {
        const listEl = document.getElementById('lampiranList');
        if (!listEl || !kegiatanId) return;

        listEl.innerHTML = '<p class="text-muted small mb-0">Memuat lampiran...</p>';

        try {
          const url = `apiKalenderKegiatan.php?action=fetch_files&kegiatan_id=${encodeURIComponent(kegiatanId)}`;
          const res = await fetch(url);
          const txt = await res.text();
          const data = JSON.parse(txt);

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
            // DB sudah dibatasi di backend (fetch_files) berdasarkan created_by/adminutama.
            // Namun jika link file ternyata masih bisa diakses karena akses file statis tidak terproteksi,
            // buat href lewat endpoint yang tetap cek permission.

            // file_path is relative like psychoApps/kalender_kegiatan_files/{id}/{file}
            const href = (() => {
              if (!f.file_path) return '#';
              if (f.file_path.startsWith('http')) return f.file_path;

              // Normalisasi agar selalu jadi: /psychoApps/kalender_kegiatan_files/<id>/<file>
              // DB menyimpan relatif: psychoApps/kalender_kegiatan_files/... (kadang tanpa leading slash)
              // Kita buang kemungkinan dobel prefix:
              // - "psychoApps/psychoApps/..."
              // - "/psychoApps/psychoApps/..."
              // - "//psychoApps/psychoApps/..."
              let p = String(f.file_path);
              p = p.replace(/^(\/+)/, '/');
              p = p.replace(/^\/?psychoApps\/psychoApps\//, 'psychoApps/');
              p = p.replace(/^\/?psychoApps\//, 'psychoApps/');

              // Pastikan pakai leading slash supaya tidak ikut prefiks URL halaman
              // (misal halaman berada di /psychoApps/..., tanpa leading slash akan dianggap relative)
              return '/' + p;
            })();


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

      function fetchEventsForMonth() {
        const start = new Date(gridState.monthStart);
        const end = new Date(gridState.monthEndExclusive);
        // FullCalendar dulu kirim ISO string. Backend kita pakai strtotime, jadi cukup ISO.
        const url = `apiKalenderKegiatan.php?action=fetch&start=${encodeURIComponent(start.toISOString())}&end=${encodeURIComponent(end.toISOString())}`;
        return fetch(url).then(r => r.text()).then(txt => {
          try {
            return JSON.parse(txt);
          } catch (e) {
            console.error('apiKalenderKegiatan fetchEventsForMonth invalid JSON:', txt);
            return [];
          }
        });
      }


      async function renderMonth() {
        const view = gridState.viewDate;
        const titleEl = document.getElementById('calendarTitle');
        titleEl.textContent = `${monthNames[view.getMonth()]} ${view.getFullYear()}`;

        buildMonthGrid(view);
        renderHeader();
        renderCalendarCells();

        gridWrapper.style.display = 'block';
        // hide old fullcalendar container if any
        if (calendarEl) calendarEl.style.display = 'none';

        const events = await fetchEventsForMonth();
        gridState.events = events || [];
        renderStrips(gridState.events);
      }

      function initCalendarGrid() {
        // prev/next month
        document.getElementById('btnPrev').addEventListener('click', () => {
          const d = new Date(gridState.viewDate);
          d.setMonth(d.getMonth() - 1);
          gridState.viewDate = d;
          renderMonth();
        });
        document.getElementById('btnNext').addEventListener('click', () => {
          const d = new Date(gridState.viewDate);
          d.setMonth(d.getMonth() + 1);
          gridState.viewDate = d;
          renderMonth();
        });

        // initial render
        renderMonth()
          .catch(() => {
            gridWrapper.style.display = 'block';
            document.getElementById('upcomingEvents').innerHTML = '<p class="text-danger small mb-0">Gagal memuat kegiatan.</p>';
          })
          .finally(() => {
            // Pastikan list upcoming tampil saat pertama kali load
            loadUpcoming();
          });

      }

      // expose renderMonth & gridState for submit handler refresh
      window.renderMonth = renderMonth;
      window.gridState = gridState;

      initCalendarGrid();




      // Premium Color Palette
      const colorPalette = [{
          color: '#4e73df',
          label: '-'
        },
        {
          color: '#1cc88a',
          label: '-'
        },
        {
          color: '#e74a3b',
          label: '-'
        },
        {
          color: '#f6c23e',
          label: '-'
        },
        {
          color: '#36b9cc',
          label: '-'
        },
        {
          color: '#6f42c1',
          label: '-'
        },
        {
          color: '#858796',
          label: '-'
        },
        {
          color: '#fd7e14',
          label: '-'
        }
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

      // Calendar Grid Custom (tanpa FullCalendar)
      // Bersihkan semua konfigurasi FullCalendar yang sebelumnya masih tersisa.


      // Tooltip position update
      function moveTooltip(e) {
        const t = document.getElementById('eventTooltip');
        t.style.left = (e.clientX + 15) + 'px';
        t.style.top = (e.clientY - 10) + 'px';
      }

      // Load Upcoming Events (Next 30 days)
      function loadUpcoming() {
        const today = new Date();
        const future = new Date();
        future.setDate(future.getDate() + 30);

        const url = 'apiKalenderKegiatan.php?action=fetch&start=' + today.toISOString() + '&end=' + future.toISOString();
        fetch(url)
          .then(r => r.text())
          .then(txt => {
            try {
              return JSON.parse(txt);
            } catch (e) {
              console.error('apiKalenderKegiatan loadUpcoming invalid JSON:', txt);
              return [];
            }
          })
          .then(data => {
            const container = document.getElementById('upcomingEvents');
            if (!data.length) {
              container.innerHTML = '<p class="text-muted small mb-0">Tidak ada kegiatan dalam 30 hari ke depan.</p>';
              return;
            }
            // Sort by realStart date
            data.sort((a, b) => new Date(a.realStart || a.start) - new Date(b.realStart || b.start));
            let html = '';
            data.slice(0, 6).forEach(ev => {

              const startDt = new Date(ev.realStart || ev.start);
              const endDt = ev.realEnd ? new Date(ev.realEnd) : null;

              const startDayStr = startDt.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short'
              });
              const startTimeStr = startDt.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
              });

              let timeText = `${startDayStr} · ${startTimeStr}`;
              if (endDt && !isNaN(endDt.getTime())) {
                const endDayStr = endDt.toLocaleDateString('id-ID', {
                  day: 'numeric',
                  month: 'short'
                });
                const endTimeStr = endDt.toLocaleTimeString('id-ID', {
                  hour: '2-digit',
                  minute: '2-digit'
                });

                if (startDayStr === endDayStr) {
                  // Same day: show time range
                  timeText = `${startDayStr} · ${startTimeStr} - ${endTimeStr}`;
                } else {
                  // Different days: show full start to end
                  timeText = `${startDayStr} · ${startTimeStr} s.d. ${endDayStr} · ${endTimeStr}`;
                }
              }

              html += `
                <div class="d-flex align-items-start mb-3 animate__animated animate__fadeInUp" style="border-bottom: 1px solid #2a2d3a; padding-bottom: 8px;">
                  <span class="mr-2 mt-1" style="width: 8px; height: 8px; border-radius: 50%; background-color: ${ev.color || '#4e73df'}; display: inline-block; flex-shrink: 0;"></span>
                  <div style="line-height: 1.3;">
                    <div class="font-weight-bold text-dark" style="font-size: 0.82rem;">${ev.title}</div>
                    <div class="text-muted" style="font-size: 0.72rem;">${timeText}</div>
                  </div>
                </div>
              `;
            });
            container.innerHTML = html;
          })
          .catch(() => {
            document.getElementById('upcomingEvents').innerHTML = '<p class="text-danger small mb-0">Gagal memuat kegiatan.</p>';
          });
      }

      // Quick Add / Ajukan Button
      const btnAddEvent = document.getElementById('btnAddEvent');
      if (btnAddEvent) {
        btnAddEvent.addEventListener('click', function() {
          document.getElementById('eventForm').reset();
          document.getElementById('eventId').value = '';
          // Reset lampiran UI (clear upload inputs and file list) so new event doesn't show previous files
          const lampiranItemsEl = document.getElementById('lampiranItems');
          if (lampiranItemsEl) {
            lampiranItemsEl.innerHTML = `
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
          }
          const lampiranListEl = document.getElementById('lampiranList');
          if (lampiranListEl) {
            lampiranListEl.innerHTML = '<p class="text-muted small mb-0">Belum ada lampiran.</p>';
          }
          currentEventCanUpload = canUploadForEvent(null, true);

          const uploadSection = document.getElementById('lampiranUploadSection');
          if (uploadSection) {
            if (currentEventCanUpload) {
              uploadSection.classList.remove('d-none');
            } else {
              uploadSection.classList.add('d-none');
            }
          }

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

          document.getElementById('eventModalLabel').innerText = isAdminUtama ? 'Tambah Kegiatan Baru' : 'Ajukan Kegiatan Baru';
          document.getElementById('btnSaveEvent').innerHTML = isAdminUtama ? '<i class="fas fa-save mr-1"></i> Simpan' : '<i class="fas fa-paper-plane mr-1"></i> Ajukan';
          document.getElementById('btnSaveEvent').classList.remove('d-none');
          document.getElementById('btnDeleteEvent').classList.add('d-none');
          document.getElementById('btnGoogleCalendar').classList.add('d-none');
          document.getElementById('creatorGroup').classList.add('d-none');
          enableFormFields(true);
          $('#eventModal').modal('show');
        });
      }

      // Hook up custom premium header navigation and add event FAB triggers
      const btnFabAdd = document.getElementById('btnFabAdd');
      if (btnFabAdd) {
        btnFabAdd.addEventListener('click', function() {
          if (btnAddEvent) btnAddEvent.click();
        });
      }

      // Tambah lampiran item baru (1 file = 1 deskripsi)
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
          <input type="text" class="form-control border-0 bg-light" id="lampiranDesc_${idx}" name="file_desc" placeholder="Contoh: Proposal, surat tugas, dll" style="border-radius: 8px; padding: 10px 14px;">

          <div class="mt-2">
            <label class="font-weight-bold" style="color: #475569;">Pilih File</label>
            <input type="file" class="form-control border-0 bg-light" id="lampiranFiles_${idx}" name="files" style="border-radius: 8px; padding: 8px 10px;">
            <small class="text-muted d-block mt-1">Format bebas, sistem akan menyimpan ke: <b>psychoApps/kalender_kegiatan_files/<kegiatan_id>/</b></small>
          </div>
        `;

        itemsEl.appendChild(wrapper);
        window._lampiranIndex = idx + 1;
      });



      // Enable/Disable form inputs
      function enableFormFields(enable) {
        const fields = ['eventTitle', 'eventDescription', 'eventLocation', 'eventStart', 'eventEnd'];

        // lampiran only for admins
        const lampiranInputs = ['lampiranDesc', 'lampiranFiles'];
        lampiranInputs.forEach(id => {
          const el = document.getElementById(id);
          if (el) el.disabled = !enable;
        });

        fields.forEach(id => {
          document.getElementById(id).disabled = !enable;
        });
        // Enable color Picker only for admins
        document.querySelectorAll('.color-swatch').forEach(sw => {
          sw.style.pointerEvents = enable ? 'auto' : 'none';
        });
      }

      // Format ISO string to local datetime-local value
      function formatDateTimeLocal(dateStr) {
        if (!dateStr) return '';
        let d;
        if (typeof dateStr === 'string') {
          // If it's a date-only string (like YYYY-MM-DD), append T00:00:00 to parse it as local time
          if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
            d = new Date(dateStr + 'T00:00:00');
          } else {
            d = new Date(dateStr);
          }
        } else {
          d = dateStr;
        }
        if (isNaN(d.getTime())) return '';
        const pad = (n) => String(n).padStart(2, '0');
        return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
      }

      // Format local Date object as YYYY-MM-DD HH:mm:ss for backend MySQL DATETIME format
      function formatLocalISO(date) {
        if (!date) return '';
        let d = (date instanceof Date) ? date : new Date(date);
        if (isNaN(d.getTime())) return '';
        const pad = (n) => String(n).padStart(2, '0');
        return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
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

      // Ajax event update for Drag and Drop / Resizing
      function updateEventTimes(info) {
        const event = info.event;
        let startVal;
        let endVal;

        if (event.allDay) {
          // All-day event drag/resize:
          // event.start is at midnight local time.
          startVal = formatLocalISO(event.start);

          if (event.end) {
            // event.end is exclusive, subtract 1 day and set to 23:59:59 local
            let tempEnd = new Date(event.end);
            tempEnd.setDate(tempEnd.getDate() - 1);
            tempEnd.setHours(23, 59, 59, 0);
            endVal = formatLocalISO(tempEnd);
          } else {
            // Single day allDay event
            let tempEnd = new Date(event.start);
            tempEnd.setHours(23, 59, 59, 0);
            endVal = formatLocalISO(tempEnd);
          }
        } else {
          // Timed event drag/resize
          startVal = formatLocalISO(event.start);
          endVal = event.end ? formatLocalISO(event.end) : formatLocalISO(event.start);
        }

        const payload = new URLSearchParams();
        payload.append('action', 'update');
        payload.append('id', event.id);
        payload.append('start', startVal);
        payload.append('end', endVal);
        payload.append('is_drag', '1');

        fetch('apiKalenderKegiatan.php', {
            method: 'POST',
            body: payload
          })
          .then(r => r.json())
          .then(res => {
            if (res.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Waktu kegiatan berhasil diperbarui!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });
              loadUpcoming();
            } else {
              info.revert();
              Swal.fire('Gagal', res.message || 'Gagal memperbarui kegiatan.', 'error');
            }
          })
          .catch(err => {
            info.revert();
            Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error');
          });
      }

      // Handle Submit (Insert/Update) via AJAX
      document.getElementById('eventForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const eventId = document.getElementById('eventId').value;
        const action = eventId ? 'update' : 'add';

        if (action === 'update' && !isAdminUtama && currentEventCanUpload) {
          const kegiatanId = eventId;
          const itemsEl = document.getElementById('lampiranItems');
          if (!itemsEl) {
            Swal.fire('Info', 'Tidak ada lampiran untuk diupload.', 'info');
            return;
          }

          const descInputs = itemsEl.querySelectorAll('input[id^="lampiranDesc_"]');
          const fdLamp = new FormData();
          fdLamp.append('action', 'save_files');
          fdLamp.append('kegiatan_id', kegiatanId);

          let uploadedSomething = false;
          descInputs.forEach((descEl, idx) => {
            const fileEl = document.getElementById('lampiranFiles_' + descEl.id.split('_').pop());
            const descVal = descEl ? descEl.value : '';
            if (fileEl && fileEl.files && fileEl.files.length > 0) {
              fdLamp.append('file_descs[]', descVal);
              fdLamp.append('files[]', fileEl.files[0]);
              uploadedSomething = true;
            }
          });

          if (!uploadedSomething) {
            Swal.fire('Info', 'Pilih file terlebih dahulu sebelum upload.', 'info');
            return;
          }

          const r2 = await fetch('apiKalenderKegiatan.php', {
            method: 'POST',
            body: fdLamp
          });
          const res2 = await r2.json();
          if (res2.status === 'success') {
            $('#eventModal').modal('hide');
            loadUpcoming();
            if (typeof renderMonth === 'function') {
              renderMonth(gridState.viewDate);
            }
            Swal.fire('Berhasil', res2.message, 'success');
          } else {
            Swal.fire('Lampiran Gagal', res2.message || 'Gagal menyimpan lampiran.', 'error');
          }
          return;
        }

        const formData = new FormData(this);
        formData.append('action', action);

        fetch('apiKalenderKegiatan.php', {
            method: 'POST',
            body: formData
          })
          .then(r => r.json())
          .then(async res => {
            if (res.status === 'success') {
              // When add: kegiatan_id comes from res.id
              const kegiatanId = action === 'add' ? res.id : eventId;

              // Upload lampiran (admin or event creator on new event)
              if ((isAdminUtama || action === 'add') && kegiatanId) {
                const itemsEl = document.getElementById('lampiranItems');
                if (itemsEl) {
                  const descInputs = itemsEl.querySelectorAll('input[id^="lampiranDesc_"]');

                  // api akan menyimpan 1 file per request-item (pakai arrays)
                  // untuk sementara: kita kirim semua file + semua desc sebagai arrays
                  const fdLamp = new FormData();
                  fdLamp.append('action', 'save_files');
                  fdLamp.append('kegiatan_id', kegiatanId);

                  let uploadedSomething = false;
                  descInputs.forEach((descEl, idx) => {
                    const fileEl = document.getElementById('lampiranFiles_' + descEl.id.split('_').pop());
                    const descVal = descEl ? descEl.value : '';
                    if (fileEl && fileEl.files && fileEl.files.length > 0) {
                      // 1 file per input
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
              loadUpcoming();
              if (typeof renderMonth === 'function') {
                renderMonth(gridState.viewDate);
              }
              Swal.fire('Berhasil', res.message, 'success');
            } else {
              Swal.fire('Gagal', res.message, 'error');
            }
          })
          .catch(() => {
            Swal.fire('Error', 'Gagal memproses permintaan.', 'error');
          });
      });

      // Handle Delete Event
      document.getElementById('btnDeleteEvent').addEventListener('click', function() {

        const eventId = document.getElementById('eventId').value;
        if (!eventId) return;

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

                  // Refresh upcoming list & calendar grid instantly
                  loadUpcoming();
                  if (typeof renderMonth === 'function') {
                    renderMonth(gridState.viewDate);
                  }

                  Swal.fire('Terhapus!', res.message, 'success');
                } else {
                  Swal.fire('Gagal', res.message, 'error');
                }
              })
              .catch(err => {
                Swal.fire('Error', 'Gagal menghapus kegiatan.', 'error');
              });
          }
        });
      });
    });
  </script>
</body>

</html>