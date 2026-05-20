<?php
include("contentsConAdm.php");
?>
<!DOCTYPE html>
<html lang="id">
<?php include("headAdm.php"); ?>
<link rel="stylesheet" href="../vendor/plugins/fullcalendar/main.min.css">
<style>
  /* ─── Custom Calendar Styles ─── */
  .fc .fc-toolbar-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2d3748;
  }
  .fc .fc-button-primary {
    background-color: #4e73df !important;
    border-color: #4e73df !important;
    border-radius: 6px !important;
    font-size: 0.8rem;
    padding: 6px 12px;
    box-shadow: none !important;
  }
  .fc .fc-button-primary:hover {
    background-color: #3651b5 !important;
    border-color: #3651b5 !important;
  }
  .fc .fc-button-primary:not(:disabled).fc-button-active {
    background-color: #3651b5 !important;
    border-color: #3651b5 !important;
  }
  .fc-daygrid-day:hover {
    background-color: #eef2ff !important;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }
  .fc-event {
    border-radius: 5px !important;
    border: none !important;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 2px 5px;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    transition: transform 0.1s ease, box-shadow 0.1s ease;
  }
  .fc-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
  }
  .fc-daygrid-day-number {
    font-weight: 600;
    color: #4a5568;
  }
  .fc-day-today .fc-daygrid-day-number {
    background-color: #4e73df;
    color: white !important;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 4px;
  }
  .fc-col-header-cell {
    background-color: #f8f9fa;
    font-weight: 700;
    font-size: 0.8rem;
    color: #6c757d;
    letter-spacing: 0.05em;
  }
  /* Color palette swatches */
  .color-swatch {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    display: inline-block;
    border: 3px solid transparent;
    transition: all 0.2s ease;
  }
  .color-swatch.selected, .color-swatch:hover {
    border-color: #333;
    transform: scale(1.15);
  }
  /* Badge for created_by */
  .badge-creator {
    font-size: 0.7rem;
    padding: 3px 8px;
    border-radius: 12px;
    background-color: #e2e8f0;
    color: #4a5568;
  }
  /* Tooltip-style event popup */
  #eventTooltip {
    position: fixed;
    z-index: 9999;
    pointer-events: none;
    background: white;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    padding: 12px 16px;
    min-width: 200px;
    max-width: 280px;
    border-left: 4px solid #4e73df;
    font-size: 0.85rem;
    opacity: 0;
    transition: opacity 0.15s ease;
  }
  #eventTooltip.show { opacity: 1; }
  #eventTooltip .ev-title { font-weight: 700; font-size: 0.95rem; margin-bottom: 6px; }
  #eventTooltip .ev-time { color: #6c757d; font-size: 0.78rem; }
  #eventTooltip .ev-desc { margin-top: 6px; color: #4a5568; }

  .card-calendar {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  }
  .legend-dot {
    width: 12px; height: 12px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 6px;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include("navtopAdm.php"); include("navSideBarAdminUtama.php"); ?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 font-weight-bold text-dark">
              <i class="fas fa-calendar-alt mr-2 text-primary"></i>Kalender Kegiatan
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Beranda</a></li>
              <li class="breadcrumb-item active">Kalender Kegiatan</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <!-- Left Panel: Legend + Quick Add -->
          <div class="col-md-3">
            <div class="card card-calendar mb-3">
              <div class="card-body p-3">
                <button id="btnAddEvent" class="btn btn-primary btn-block mb-3" style="border-radius:8px;">
                  <i class="fas fa-plus mr-2"></i>Tambah Kegiatan
                </button>
                <hr class="my-2">
                <p class="text-muted small font-weight-bold mb-2">KATEGORI WARNA</p>
                <div id="legendContainer" style="font-size:0.83rem; line-height:2;"></div>
              </div>
            </div>

            <!-- Upcoming Events -->
            <div class="card card-calendar">
              <div class="card-header bg-white border-0 pb-0">
                <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-clock text-warning mr-2"></i>Kegiatan Mendatang</h6>
              </div>
              <div class="card-body p-3" id="upcomingEvents">
                <p class="text-muted small">Memuat...</p>
              </div>
            </div>
          </div>

          <!-- Calendar -->
          <div class="col-md-9">
            <div class="card card-calendar">
              <div class="card-body p-3">
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

<!-- ─── EVENT TOOLTIP ─── -->
<div id="eventTooltip">
  <div class="ev-title" id="tipTitle"></div>
  <div class="ev-time" id="tipTime"></div>
  <div class="ev-desc" id="tipDesc"></div>
  <div class="mt-2">
    <span class="badge-creator" id="tipCreator"></span>
  </div>
</div>

<!-- ─── MODAL TAMBAH / EDIT KEGIATAN ─── -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 10px 40px rgba(0,0,0,0.2);">
      <div class="modal-header" style="background:linear-gradient(135deg,#4e73df,#667eea); border-radius:12px 12px 0 0; border:none;">
        <h5 class="modal-title text-white font-weight-bold" id="modalTitle">
          <i class="fas fa-calendar-plus mr-2"></i>Tambah Kegiatan
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="eventId">
        <div class="form-group">
          <label class="font-weight-bold">Judul Kegiatan <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="eventTitle" placeholder="Masukkan judul kegiatan..." style="border-radius:8px;">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Deskripsi</label>
          <textarea class="form-control" id="eventDesc" rows="3" placeholder="Tambahkan keterangan (opsional)..." style="border-radius:8px;"></textarea>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="font-weight-bold">Tanggal &amp; Waktu Mulai <span class="text-danger">*</span></label>
              <input type="datetime-local" class="form-control" id="eventStart" style="border-radius:8px;">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="font-weight-bold">Tanggal &amp; Waktu Selesai <span class="text-danger">*</span></label>
              <input type="datetime-local" class="form-control" id="eventEnd" style="border-radius:8px;">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Warna Kegiatan</label>
          <div id="colorPicker" class="d-flex flex-wrap gap-2 mt-1" style="gap:8px;">
          </div>
          <input type="hidden" id="eventColor" value="#4e73df">
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 px-4 pb-4" style="display:flex; gap:8px; justify-content:flex-end;">
        <button type="button" class="btn btn-danger btn-sm" id="btnDeleteEvent" style="display:none; border-radius:8px;">
          <i class="fas fa-trash mr-1"></i>Hapus
        </button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius:8px;">Batal</button>
        <button type="button" class="btn btn-primary btn-sm" id="btnSaveEvent" style="border-radius:8px; padding:8px 20px;">
          <i class="fas fa-save mr-1"></i>Simpan
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<?php include("footerScriptAdm.php"); ?>
<script src="../vendor/plugins/fullcalendar/main.min.js"></script>
<script src="../vendor/plugins/fullcalendar/locales-all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

  // ─── Color Palette ───
  const colorPalette = [
    { color: '#4e73df', label: 'Biru (Akademik)' },
    { color: '#1cc88a', label: 'Hijau (Keuangan)' },
    { color: '#e74a3b', label: 'Merah (BMN)' },
    { color: '#f6c23e', label: 'Kuning (Kepegawaian)' },
    { color: '#36b9cc', label: 'Tosca (Tata Persuratan)' },
    { color: '#858796', label: 'Abu-abu (Lainnya)' },
    { color: '#fd7e14', label: 'Oranye' },
    { color: '#6f42c1', label: 'Ungu' },
    { color: '#e83e8c', label: 'Pink' },
    { color: '#20c9a6', label: 'Teal' },
  ];

  let selectedColor = '#4e73df';

  // Build color picker swatches
  const cpDiv = document.getElementById('colorPicker');
  colorPalette.forEach(p => {
    const sw = document.createElement('span');
    sw.className = 'color-swatch' + (p.color === selectedColor ? ' selected' : '');
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

  // Build legend
  const legendDiv = document.getElementById('legendContainer');
  colorPalette.forEach(p => {
    const row = document.createElement('div');
    row.innerHTML = `<span class="legend-dot" style="background:${p.color}"></span>${p.label}`;
    legendDiv.appendChild(row);
  });

  // ─── FullCalendar Init ───
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'id',
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    buttonText: {
      today: 'Hari Ini',
      month: 'Bulan',
      week: 'Minggu',
      day: 'Hari',
      list: 'Daftar'
    },
    editable: true,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: 3,
    height: 'auto',
    eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: false },
    events: function(info, successCallback, failureCallback) {
      fetch(`apiKalenderKegiatan.php?action=fetch&start=${info.startStr}&end=${info.endStr}`)
        .then(r => r.json())
        .then(data => {
          successCallback(data);
          loadUpcoming();
        })
        .catch(() => failureCallback());
    },
    // Click on empty date: open add modal
    select: function(info) {
      openModal('add');
      document.getElementById('eventStart').value = info.startStr.substring(0,16);
      // End is exclusive in FullCalendar, subtract 1 minute for nicer UX
      var end = new Date(info.endStr);
      end.setMinutes(end.getMinutes() - 1);
      document.getElementById('eventEnd').value = end.toISOString().substring(0,16);
      calendar.unselect();
    },
    // Click on existing event: open edit modal
    eventClick: function(info) {
      var ev = info.event;
      openModal('edit', {
        id: ev.id,
        title: ev.title,
        description: ev.extendedProps.description || '',
        start: ev.startStr.substring(0,16),
        end: ev.endStr ? ev.endStr.substring(0,16) : ev.startStr.substring(0,16),
        color: ev.backgroundColor,
        created_by: ev.extendedProps.created_by || ''
      });
    },
    // Drag & drop to resize/move
    eventDrop: function(info) {
      updateEventTime(info.event);
    },
    eventResize: function(info) {
      updateEventTime(info.event);
    },
    // Hover tooltip
    eventMouseEnter: function(info) {
      var ev = info.event;
      var tooltip = document.getElementById('eventTooltip');
      tooltip.style.borderLeftColor = ev.backgroundColor || '#4e73df';
      document.getElementById('tipTitle').textContent = ev.title;
      var startFmt = ev.start ? ev.start.toLocaleString('id-ID', { dateStyle:'medium', timeStyle:'short' }) : '';
      var endFmt = ev.end ? ev.end.toLocaleString('id-ID', { dateStyle:'medium', timeStyle:'short' }) : '';
      document.getElementById('tipTime').textContent = startFmt + (endFmt ? ' – ' + endFmt : '');
      document.getElementById('tipDesc').textContent = ev.extendedProps.description || '';
      document.getElementById('tipCreator').textContent = ev.extendedProps.created_by ? '👤 ' + ev.extendedProps.created_by : '';
      tooltip.classList.add('show');
      document.addEventListener('mousemove', moveTooltip);
    },
    eventMouseLeave: function() {
      document.getElementById('eventTooltip').classList.remove('show');
      document.removeEventListener('mousemove', moveTooltip);
    }
  });

  calendar.render();

  // ─── Tooltip follow mouse ───
  function moveTooltip(e) {
    var t = document.getElementById('eventTooltip');
    t.style.left = (e.clientX + 15) + 'px';
    t.style.top = (e.clientY - 10) + 'px';
  }

  // ─── Load Upcoming Events ───
  function loadUpcoming() {
    var today = new Date();
    var future = new Date(); future.setDate(future.getDate() + 30);
    fetch(`apiKalenderKegiatan.php?action=fetch&start=${today.toISOString()}&end=${future.toISOString()}`)
      .then(r => r.json())
      .then(data => {
        var container = document.getElementById('upcomingEvents');
        if (!data.length) {
          container.innerHTML = '<p class="text-muted small mb-0">Tidak ada kegiatan dalam 30 hari ke depan.</p>';
          return;
        }
        var html = '';
        data.slice(0,6).forEach(ev => {
          var d = new Date(ev.start);
          var dateStr = d.toLocaleDateString('id-ID', { day:'numeric', month:'short' });
          var timeStr = d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
          html += `<div class="d-flex align-items-start mb-2">
            <div class="legend-dot flex-shrink-0 mt-1" style="background:${ev.color || '#4e73df'}"></div>
            <div>
              <div class="font-weight-bold" style="font-size:0.82rem; line-height:1.3;">${ev.title}</div>
              <div class="text-muted" style="font-size:0.75rem;">${dateStr} · ${timeStr}</div>
            </div>
          </div>`;
        });
        container.innerHTML = html;
      });
  }

  // ─── Modal Helpers ───
  function openModal(mode, data = {}) {
    document.getElementById('eventTitle').value = data.title || '';
    document.getElementById('eventDesc').value = data.description || '';
    document.getElementById('eventStart').value = data.start || '';
    document.getElementById('eventEnd').value = data.end || '';
    document.getElementById('eventId').value = data.id || '';
    
    // set color
    var color = data.color || '#4e73df';
    document.getElementById('eventColor').value = color;
    selectedColor = color;
    document.querySelectorAll('.color-swatch').forEach(s => {
      s.classList.toggle('selected', s.dataset.color === color);
    });

    var isEdit = mode === 'edit';
    document.getElementById('modalTitle').innerHTML = isEdit 
      ? '<i class="fas fa-edit mr-2"></i>Edit Kegiatan'
      : '<i class="fas fa-calendar-plus mr-2"></i>Tambah Kegiatan';
    document.getElementById('btnDeleteEvent').style.display = isEdit ? 'inline-block' : 'none';

    $('#eventModal').modal('show');
  }

  // Open modal when button clicked
  document.getElementById('btnAddEvent').addEventListener('click', function() {
    openModal('add');
  });

  // ─── Save ───
  document.getElementById('btnSaveEvent').addEventListener('click', function() {
    var id = document.getElementById('eventId').value;
    var title = document.getElementById('eventTitle').value.trim();
    var desc = document.getElementById('eventDesc').value.trim();
    var start = document.getElementById('eventStart').value;
    var end = document.getElementById('eventEnd').value;
    var color = document.getElementById('eventColor').value;

    if (!title) { alert('Judul kegiatan tidak boleh kosong!'); return; }
    if (!start || !end) { alert('Waktu mulai dan selesai harus diisi!'); return; }
    if (end < start) { alert('Waktu selesai tidak boleh sebelum waktu mulai!'); return; }

    var formData = new FormData();
    formData.append('action', id ? 'update' : 'add');
    if (id) formData.append('id', id);
    formData.append('title', title);
    formData.append('description', desc);
    formData.append('start', start);
    formData.append('end', end);
    formData.append('color', color);

    fetch('apiKalenderKegiatan.php', { method: 'POST', body: formData })
      .then(r => r.json())
      .then(res => {
        if (res.status === 'success') {
          $('#eventModal').modal('hide');
          calendar.refetchEvents();
        } else {
          alert('Gagal menyimpan: ' + res.message);
        }
      });
  });

  // ─── Delete ───
  document.getElementById('btnDeleteEvent').addEventListener('click', function() {
    if (!confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')) return;
    var id = document.getElementById('eventId').value;
    var formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);

    fetch('apiKalenderKegiatan.php', { method: 'POST', body: formData })
      .then(r => r.json())
      .then(res => {
        if (res.status === 'success') {
          $('#eventModal').modal('hide');
          calendar.refetchEvents();
        } else {
          alert('Gagal menghapus: ' + res.message);
        }
      });
  });

  // ─── Drag & Drop update ───
  function updateEventTime(event) {
    var formData = new FormData();
    formData.append('action', 'update');
    formData.append('is_drag', '1');
    formData.append('id', event.id);
    formData.append('start', event.startStr.substring(0,16).replace('T', ' '));
    formData.append('end', event.endStr ? event.endStr.substring(0,16).replace('T', ' ') : event.startStr.substring(0,16).replace('T', ' '));

    fetch('apiKalenderKegiatan.php', { method: 'POST', body: formData });
  }
});
</script>
</body>
</html>
