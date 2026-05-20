<?php
include("contentsConAdm.php");
$isAdminUtama = (isset($_SESSION['level']) && ($_SESSION['level'] === 'adminutama' || $_SESSION['level'] == 10));
?>
<!DOCTYPE html>
<html lang="id">
<?php include("headAdm.php"); ?>
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet' />
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
    background-color: #1a1d26 !important; /* Keep background cohesive */
  }
  
  .fc-day-today .fc-daygrid-day-number {
    background-color: #5c8ef2 !important; /* Premium Blue Accent */
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
    border-radius: 30px !important; /* Highly rounded pill - both ends */
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
    box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
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
  
  .color-swatch.selected, .color-swatch:hover {
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
                <i class="fas fa-calendar-alt mr-2 text-primary"></i>Kalender Kegiatan
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-primary" href="dashboardAdm.php">Dashboard</a></li>
                <li class="breadcrumb-item active small">Kalender Kegiatan</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- Left Side Panel: Legend & Upcoming events -->
            <div class="col-lg-3 col-md-4 animate__animated animate__fadeInLeft">
              <!-- Action Button Card -->
              <div class="card card-calendar mb-4 shadow-sm">
                <div class="card-body p-3">
                  <button id="btnAddEvent" class="btn btn-primary btn-block py-2" style="border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-plus mr-2"></i><?php echo $isAdminUtama ? 'Tambah Kegiatan' : 'Ajukan Kegiatan'; ?>
                  </button>
                  <hr class="my-3" style="border-color: #2a2d3a;">
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
                  <!-- Custom Premium Calendar Header -->
                  <div class="d-flex align-items-center justify-content-between mb-4 custom-calendar-header">
                    <div class="h3 font-weight-bold text-white mb-0" id="calendarTitle">Mei 2026</div>
                    <div class="d-flex align-items-center" style="gap: 16px;">
                      <!-- Prev / Next Navigation -->
                      <div class="d-flex align-items-center bg-dark" style="border: 1px solid #2a2d3a; border-radius: 30px; padding: 2px;">
                        <button id="btnPrev" type="button" class="btn btn-link text-white nav-arrow-btn m-0" style="padding: 6px;"><i class="fas fa-chevron-left"></i></button>
                        <button id="btnNext" type="button" class="btn btn-link text-white nav-arrow-btn m-0" style="padding: 6px;"><i class="fas fa-chevron-right"></i></button>
                      </div>
                      <!-- Add Event FAB -->
                      <button id="btnFabAdd" type="button" class="btn btn-fab-add" title="<?php echo $isAdminUtama ? 'Tambah Kegiatan' : 'Ajukan Kegiatan'; ?>">
                        <i class="fas fa-plus text-dark font-weight-bold" style="font-size: 1.15rem;"></i>
                      </button>
                    </div>
                  </div>
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include("footerAdm.php"); ?>
  </div>

  <!-- Modern Dynamic Modal for Add/Edit/View Event -->
  <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
            <div class="form-group">
              <label for="eventTitle" class="font-weight-bold" style="color: #475569;">Judul Kegiatan <span class="text-danger">*</span></label>
              <input type="text" class="form-control border-0 bg-light" id="eventTitle" name="title" required placeholder="Masukkan judul kegiatan..." style="border-radius: 8px; padding: 10px 14px;">
            </div>
            <div class="form-group">
              <label for="eventDescription" class="font-weight-bold" style="color: #475569;">Deskripsi / Keterangan</label>
              <textarea class="form-control border-0 bg-light" id="eventDescription" name="description" rows="3" placeholder="Masukkan detail atau deskripsi kegiatan..." style="border-radius: 8px; padding: 10px 14px;"></textarea>
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
  <!-- FullCalendar JS CDN -->
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const calendarEl = document.getElementById('calendar');
      const isAdminUtama = <?php echo $isAdminUtama ? 'true' : 'false'; ?>;

      // Premium Color Palette
      const colorPalette = [
        { color: '#4e73df', label: 'Akademik (Biru)' },
        { color: '#1cc88a', label: 'Keuangan (Hijau)' },
        { color: '#e74a3b', label: 'Sarpras / BMN (Merah)' },
        { color: '#f6c23e', label: 'Kepegawaian (Kuning)' },
        { color: '#36b9cc', label: 'Persuratan (Toska)' },
        { color: '#6f42c1', label: 'Protokol / Rapat (Ungu)' },
        { color: '#858796', label: 'Umum (Abu-abu)' },
        { color: '#fd7e14', label: 'Kemahasiswaan (Oranye)' }
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

      // Initialize FullCalendar
      const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'id',
        initialView: 'dayGridMonth',
        headerToolbar: false, // Use custom premium header toolbar
        weekNumbers: true, // Display week number column on left like Google Calendar
        weekNumberFormat: { week: 'numeric' },
        dayHeaderFormat: { weekday: 'narrow' }, // Single letter column headers (M, S, S, R, K, J, S)
        eventDisplay: 'block', // Render all events as solid block pills
        navLinks: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: false, // Show all events dynamically, no "+more" collapse
        displayEventTime: false, // Don't show times since we use allDay format
        editable: isAdminUtama, // drag and drop resize/move only for adminutama
        datesSet: function(dateInfo) {
          document.getElementById('calendarTitle').innerText = dateInfo.view.title;
        },
        eventContent: function(arg) {
          const titleText = arg.event.title || '';
          let iconHtml = '';
          
          const titleLower = titleText.toLowerCase();
          if (titleLower.includes('ngantor') || titleLower.includes('kerja') || titleLower.includes('dinas') || titleLower.includes('rapat')) {
            iconHtml = '<i class="fas fa-briefcase mr-1" style="font-size: 0.75rem; opacity: 0.9;"></i>';
          } else if (titleLower.includes('libur') || titleLower.includes('jalan') || titleLower.includes('cuti') || titleLower.includes('wisata') || titleLower.includes('jogja')) {
            iconHtml = '<i class="fas fa-plane mr-1" style="font-size: 0.75rem; opacity: 0.9;"></i>';
          } else if (titleLower.includes('tugas') || titleLower.includes('ujian') || titleLower.includes('buat') || titleLower.includes('skripsi')) {
            iconHtml = '<i class="fas fa-check-circle mr-1" style="font-size: 0.75rem; opacity: 0.9;"></i>';
          } else if (titleLower.includes('sholat') || titleLower.includes('pengajian') || titleLower.includes('ibadah') || titleLower.includes('sholawat')) {
            iconHtml = '<i class="fas fa-place-of-worship mr-1" style="font-size: 0.75rem; opacity: 0.9;"></i>';
          } else {
            iconHtml = '<i class="far fa-calendar-alt mr-1" style="font-size: 0.75rem; opacity: 0.9;"></i>';
          }

          return {
            html: `<div class="fc-event-main-custom d-flex align-items-center text-truncate w-100" style="padding: 2px 4px;">
                     ${iconHtml}
                     <span class="text-truncate" style="font-weight: 600;">${titleText}</span>
                   </div>`
          };
        },
        events: function(fetchInfo, successCallback, failureCallback) {
          fetch('apiKalenderKegiatan.php?action=fetch&start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr)
            .then(response => response.json())
            .then(data => {
              successCallback(data);
              loadUpcoming();
            })
            .catch(err => failureCallback(err));
        },
        
        // Date and Range selection trigger:
        select: function(info) {
          document.getElementById('eventForm').reset();
          document.getElementById('eventId').value = '';
          
          document.getElementById('eventStart').value = formatDateTimeLocal(info.startStr);
          
          let endDate;
          if (info.allDay) {
            // allDay selection: end is exclusive (next day midnight), subtract 1 day
            let tempDate = new Date(info.end);
            tempDate.setDate(tempDate.getDate() - 1);
            tempDate.setHours(23, 59, 0, 0);
            endDate = tempDate;
          } else {
            endDate = info.endStr;
          }
          document.getElementById('eventEnd').value = formatDateTimeLocal(endDate);
          
          // Select default color
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
          calendar.unselect();
        },

        // Event click trigger:
        eventClick: function(info) {
          const event = info.event;
          const props = event.extendedProps;
          
          document.getElementById('eventId').value = event.id;
          document.getElementById('eventTitle').value = event.title;
          document.getElementById('eventDescription').value = props.description || '';
          
          // For multi-day allDay events, use realStart/realEnd stored in extendedProps
          // to display the actual datetime instead of the exclusive end boundary used by FullCalendar.
          const displayStart = props.realStart ? props.realStart : event.start;
          const displayEnd   = props.realEnd   ? props.realEnd   : (event.end || event.start);
          
          document.getElementById('eventStart').value = formatDateTimeLocal(displayStart);
          document.getElementById('eventEnd').value   = formatDateTimeLocal(displayEnd);
          
          selectedColor = event.backgroundColor || '#4e73df';
          document.getElementById('eventColor').value = selectedColor;
          document.querySelectorAll('.color-swatch').forEach(s => {
            s.classList.toggle('selected', s.dataset.color === selectedColor);
          });
          
          document.getElementById('eventCreator').value = props.created_by || 'Admin';
          document.getElementById('eventModalLabel').innerText = isAdminUtama ? 'Edit Kegiatan' : 'Detail Kegiatan';
          document.getElementById('creatorGroup').classList.remove('d-none');
          
          // Use realStart/realEnd for Google Calendar link too
          setupGoogleCalendarLink(event.title, props.description, displayStart, displayEnd);
          
          if (isAdminUtama) {
            enableFormFields(true);
            document.getElementById('btnSaveEvent').classList.remove('d-none');
            document.getElementById('btnSaveEvent').innerHTML = '<i class="fas fa-save mr-1"></i> Simpan';
            document.getElementById('btnDeleteEvent').classList.remove('d-none');
          } else {
            enableFormFields(false);
            document.getElementById('btnSaveEvent').classList.add('d-none');
            document.getElementById('btnDeleteEvent').classList.add('d-none');
          }
          
          $('#eventModal').modal('show');
        },

        // Drag‑and‑drop time shift:
        eventDrop: function(info) {
          updateEventTimes(info);
        },
        
        // Event duration resize:
        eventResize: function(info) {
          updateEventTimes(info);
        },
        
        // Interactive Tooltip Hover:
        eventMouseEnter: function(info) {
          const event = info.event;
          const props = event.extendedProps;
          const tooltip = document.getElementById('eventTooltip');
          
          tooltip.style.borderLeftColor = event.backgroundColor || '#4e73df';
          document.getElementById('tipTitle').textContent = event.title;
          
          // Use realStart/realEnd for multi-day events to show accurate datetime in tooltip
          const tipStart = props.realStart ? new Date(props.realStart) : event.start;
          const tipEnd   = props.realEnd   ? new Date(props.realEnd)   : event.end;
          const startFmt = tipStart ? tipStart.toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : '';
          const endFmt   = tipEnd   ? tipEnd.toLocaleString('id-ID',   { dateStyle: 'medium', timeStyle: 'short' }) : '';
          document.getElementById('tipTime').textContent = startFmt + (endFmt && endFmt !== startFmt ? ' – ' + endFmt : '');
          document.getElementById('tipDesc').textContent = props.description || 'Tidak ada deskripsi.';
          
          if (props.created_by) {
            document.getElementById('tipCreator').textContent = '👤 ' + props.created_by;
            document.getElementById('tipCreatorContainer').style.display = 'block';
          } else {
            document.getElementById('tipCreatorContainer').style.display = 'none';
          }
          
          tooltip.style.display = 'block';
          tooltip.style.opacity = '1';
          document.addEventListener('mousemove', moveTooltip);
        },
        eventMouseLeave: function() {
          const tooltip = document.getElementById('eventTooltip');
          tooltip.style.display = 'none';
          tooltip.style.opacity = '0';
          document.removeEventListener('mousemove', moveTooltip);
        }
      });

      calendar.render();

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
        
        fetch('apiKalenderKegiatan.php?action=fetch&start=' + today.toISOString() + '&end=' + future.toISOString())
          .then(r => r.json())
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
              
              const startDayStr = startDt.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
              const startTimeStr = startDt.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
              
              let timeText = `${startDayStr} · ${startTimeStr}`;
              if (endDt && !isNaN(endDt.getTime())) {
                const endDayStr = endDt.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                const endTimeStr = endDt.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                
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
      document.getElementById('btnAddEvent').addEventListener('click', function() {
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
        
        document.getElementById('eventModalLabel').innerText = isAdminUtama ? 'Tambah Kegiatan Baru' : 'Ajukan Kegiatan Baru';
        document.getElementById('btnSaveEvent').innerHTML = isAdminUtama ? '<i class="fas fa-save mr-1"></i> Simpan' : '<i class="fas fa-paper-plane mr-1"></i> Ajukan';
        document.getElementById('btnSaveEvent').classList.remove('d-none');
        document.getElementById('btnDeleteEvent').classList.add('d-none');
        document.getElementById('btnGoogleCalendar').classList.add('d-none');
        document.getElementById('creatorGroup').classList.add('d-none');
        enableFormFields(true);
        $('#eventModal').modal('show');
      });

      // Hook up custom premium header navigation and add event FAB triggers
      document.getElementById('btnPrev').addEventListener('click', function() {
        calendar.prev();
      });
      document.getElementById('btnNext').addEventListener('click', function() {
        calendar.next();
      });
      document.getElementById('btnFabAdd').addEventListener('click', function() {
        document.getElementById('btnAddEvent').click();
      });

      // Enable/Disable form inputs
      function enableFormFields(enable) {
        const fields = ['eventTitle', 'eventDescription', 'eventStart', 'eventEnd'];
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
          .then(res => {
            if (res.status === 'success') {
              $('#eventModal').modal('hide');
              calendar.refetchEvents();
              loadUpcoming();
              Swal.fire('Berhasil', res.message, 'success');
            } else {
              Swal.fire('Gagal', res.message, 'error');
            }
          })
          .catch(err => {
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
                  calendar.refetchEvents();
                  loadUpcoming();
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
