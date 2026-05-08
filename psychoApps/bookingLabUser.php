<?php
include("contentsConAdm.php");
$username = $_SESSION['username'];
$q_mhs = mysqli_query($con, "SELECT * FROM dt_mhssw WHERE nim='$username'");
$d_mhs = mysqli_fetch_array($q_mhs);
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>
<style>
  .booking-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border-radius: 12px;
  }

  .booking-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .badge-premium {
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
  }

  .btn-premium {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
  }

  .modal-content-premium {
    border-radius: 15px;
    border: none;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
  }

  .modal-header-premium {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
  }

  .list-pendaftar {
    max-height: 150px;
    overflow-y: auto;
    font-size: 0.9rem;
    text-align: left;
    padding: 10px;
    background: rgba(0, 0, 0, 0.03);
    border-radius: 10px;
    border: 1px dashed #dee2e6;
  }

  .btn-registrant {
    font-size: 0.85rem !important;
    padding: 5px 10px !important;
    border-radius: 6px !important;
    margin-bottom: 5px;
    width: 100%;
    text-align: left;
    transition: all 0.2s;
  }

  .btn-registrant:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .custom-selection {
    display: flex;
    gap: 15px;
    margin-top: 8px;
  }
  .selection-item {
    flex: 1;
    position: relative;
  }
  .selection-item input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }
  .selection-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 12px 10px;
    background: rgba(255,255,255,0.05);
    border: 2px solid #444;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
    height: 100%;
  }
  .selection-box i {
    font-size: 1.4rem;
    margin-bottom: 5px;
    color: #666;
  }
  .selection-box span {
    font-weight: 600;
    font-size: 0.85rem;
    line-height: 1.2;
    display: block;
  }
  .selection-item input:checked + .selection-box {
    background: rgba(23, 162, 184, 0.2);
    border-color: #17a2b8;
    color: #fff;
  }
  .selection-item input:checked + .selection-box i {
    color: #17a2b8;
  }
  .selection-box:hover {
    background: rgba(255,255,255,0.1);
    border-color: #666;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarUserS1.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <?php
          $msg_title = "";
          $msg_body = "";
          $msg_icon = "";
          $msg_color = "";
          
          if (!empty($_GET['message'])) {
            $m = $_GET['message'];
            if ($m == 'notifAdd') {
              $msg_title = "Pendaftaran Berhasil!";
              $msg_body = "Pendaftaran Anda telah berhasil direkam. Silakan cek email Anda untuk detail konfirmasi.";
              $msg_icon = "fa-check-circle";
              $msg_color = "success";
            } elseif ($m == 'failedQuota') {
              $msg_title = "Kuota Penuh!";
              $msg_body = "Mohon maaf, kuota pendaftar untuk sesi ruangan ini sudah penuh.";
              $msg_icon = "fa-users-slash";
              $msg_color = "danger";
            } elseif ($m == 'failedBooked') {
              $msg_title = "Gagal Booking!";
              $msg_body = "Slot ini baru saja di-booking oleh kelompok lain. Silakan pilih jadwal lainnya.";
              $msg_icon = "fa-exclamation-triangle";
              $msg_color = "danger";
            }
          }
          ?>
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0 font-weight-bold"><i class="fas fa-flask mr-2 text-info"></i>Pendaftaran Layanan Belajar Lab Psikodiagnostik dan Pengembangan Alat ukur</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
              <div class="card h-100 bg-gradient-info text-white shadow-sm border-0 booking-card">
                <div class="card-body">
                  <h5 class="font-weight-bold mb-3"><i class="fas fa-info-circle mr-2"></i>Informasi Pendaftaran</h5>
                  <ul class="list-unstyled mb-0" style="font-size: 0.9rem; line-height: 1.5;">
                    <li class="mb-2"><i class="fas fa-check-circle mr-2"></i>Booking Anda akan dikonfirmasi melalui <b>WhatsApp</b> oleh Asisten Lab (Aslab).</li>
                    <li><i class="fas fa-check-circle mr-2"></i>Jika nama Anda sudah tertera di daftar dan status jadwal sudah <b>Closed</b>, berarti Anda sudah resmi terdaftar/booking.</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100 shadow-sm border-0 booking-card">
                <div class="card-body">
                  <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-clipboard-list mr-2 text-info"></i>SOP Layanan Belajar</h5>
                  <ol class="small text-muted mb-0 pl-3" style="line-height: 1.4;">
                    <li class="mb-1">Mahasiswa masuk kelas tepat waktu. Maksimal keterlambatan <b>10 menit</b>.</li>
                    <li class="mb-1">Handphone wajib <b>silent</b> dan disimpan di dalam tas selama kelas berlangsung.</li>
                    <li class="mb-1">Tas diletakkan di depan. Di atas meja hanya terdapat buku dan alat tulis.</li>
                    <li class="mb-1">Pelaksanaan layanan belajar sesuai jadwal.</li>
                    <li>Mahasiswa wajib mengisi buku absensi kehadiran.</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12">
              <div class="card bg-white shadow-sm border-0">
                <div class="card-body py-2 px-3 d-flex align-items-center">
                  <span class="small font-weight-bold text-muted mr-3 uppercase"><i class="fas fa-info-circle mr-1"></i> Keterangan Warna:</span>
                  <div class="mr-4">
                    <span class="badge badge-primary badge-premium" style="font-size:0.7rem; padding: 4px 8px;">K</span>
                    <span class="small font-weight-bold ml-1">Kelompok</span>
                  </div>
                  <div>
                    <span class="badge badge-warning badge-premium" style="font-size:0.7rem; padding: 4px 8px;">I</span>
                    <span class="small font-weight-bold ml-1">Individu</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card card-outline card-info shadow-sm">
                <div class="card-header border-0">
                  <h3 class="card-title font-weight-bold text-secondary">Jadwal Lab Tersedia</h3>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-hover m-0 table-borderless text-center align-middle">
                      <thead class="bg-light text-muted">
                        <tr>
                          <th>NO</th>
                          <th>TANGGAL</th>
                          <th>WAKTU</th>
                          <th>RUANGAN</th>
                          <th>LAYANAN LAB</th>
                          <th>ASISTEN</th>
                          <th width="25%">PENDAFTAR (INDIVIDU/KELOMPOK)</th>
                          <th>STATUS</th>
                          <th>AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $modals = "";
                        $q = mysqli_query($con, "SELECT p.*, r.nm as nama_ruang 
                                               FROM lab_booking_periode p 
                                               LEFT JOIN dt_ruang r ON p.ruangan_id = r.id 
                                               ORDER BY p.status DESC, p.tgl ASC, p.jam_mulai ASC");
                        while ($d = mysqli_fetch_array($q)) {
                          $periode_id = $d['id'];

                          // Get all registrants for this period
                          $q_reg = mysqli_query($con, "SELECT * FROM lab_booking_data WHERE periode_id='$periode_id' ORDER BY kategori_peserta DESC, tgl_input ASC");
                          $has_kelompok = false;
                          $registrants_list = "";
                          while ($reg = mysqli_fetch_array($q_reg)) {
                            if ($reg['kategori_peserta'] == 'Kelompok') $has_kelompok = true;
                            $badge_class = ($reg['kategori_peserta'] == 'Kelompok' ? 'btn-primary shadow-sm' : 'btn-warning shadow-sm');
                            $label = ($reg['kategori_peserta'] == 'Kelompok' ? 'K' : 'I');

                            $registrants_list .= '
                               <button class="btn btn-registrant ' . $badge_class . '" data-toggle="modal" data-target="#modalDetail' . $reg['id'] . '">
                                 <div class="d-flex align-items-center">
                                   <span class="badge badge-light mr-2" style="font-size:0.65rem">' . $label . '</span>
                                   <div class="text-left">
                                     <div class="font-weight-bold" style="line-height: 1.1;">' . $reg['nama'] . '</div>
                                     <div class="small opacity-75" style="font-size: 0.7rem;">' . $reg['jenis_layanan'] . '</div>
                                   </div>
                                 </div>
                               </button>';

                            // Generate Modal Detail for each person
                            $modals .= '
                            <div class="modal fade" id="modalDetail' . $reg['id'] . '" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content modal-content-premium bg-dark">
                                  <div class="modal-header modal-header-premium text-white border-0">
                                    <h5 class="modal-title font-weight-bold"><i class="fas fa-info-circle mr-2"></i>Detail Pendaftar</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body p-4 text-white text-left">
                                    <div class="row mb-2">
                                      <div class="col-4 text-muted small">NAMA</div>
                                      <div class="col-8 font-weight-bold">' . $reg['nama'] . '</div>
                                    </div>
                                    <div class="row mb-2">
                                      <div class="col-4 text-muted small">NIM</div>
                                      <div class="col-8">' . $reg['nim'] . '</div>
                                    </div>
                                    <div class="row mb-2">
                                      <div class="col-4 text-muted small">KATEGORI</div>
                                      <div class="col-8"><span class="badge ' . ($reg['kategori_peserta'] == 'Kelompok' ? 'badge-primary' : 'badge-warning') . '">' . $reg['kategori_peserta'] . '</span></div>
                                    </div>
                                    <div class="row mb-2">
                                      <div class="col-4 text-muted small">LAYANAN UTAMA</div>
                                      <div class="col-8">' . ($reg['layanan_utama'] ?: '-') . '</div>
                                    </div>
                                    <div class="row mb-2">
                                      <div class="col-4 text-muted small">JENIS LAYANAN</div>
                                      <div class="col-8">' . $reg['jenis_layanan'] . '</div>
                                    </div>
                                    <div class="row mb-2">
                                      <div class="col-4 text-muted small">JUMLAH ORANG</div>
                                      <div class="col-8">' . $reg['jml_orang'] . ' Orang</div>
                                    </div>
                                    <div class="row mb-2">
                                      <div class="col-4 text-muted small">ALAT</div>
                                      <div class="col-8">' . ($reg['tipe_alat'] ?: '-') . '</div>
                                    </div>
                                    <div class="border-top border-secondary pt-2 mt-2">
                                      <div class="text-muted small mb-1">CATATAN:</div>
                                      <p class="mb-0 text-light small">' . nl2br($reg['keperluan_alat']) . '</p>
                                    </div>';

                                     $modals .= '
                                   </div>
                                 </div>
                               </div>
                             </div>';
                          }
                        ?>
                          <tr class="border-bottom">
                            <td class="align-middle"><?php echo $no++; ?></td>
                            <td class="align-middle font-weight-bold"><?php echo date('d M Y', strtotime($d['tgl'])); ?></td>
                            <td class="align-middle"><span class="badge bg-info-light text-info border border-info px-2 py-1"><?php echo substr($d['jam_mulai'], 0, 5) . ' - ' . substr($d['jam_selesai'], 0, 5); ?></span></td>
                            <td class="align-middle"><?php echo $d['nama_ruang'] ?? '-'; ?></td>
                             <td class="align-middle">
                               <?php if (!empty($d['layanan'])) { ?>
                                 <div class="small text-muted italic" style="font-size: 0.8rem;">
                                   <?php echo nl2br($d['layanan']); ?>
                                 </div>
                               <?php } else { echo '-'; } ?>
                             </td>
                            <td class="align-middle text-muted small"><?php echo $d['info_tenaga']; ?></td>
                            <td class="align-middle">
                              <div class="list-pendaftar">
                                <?php echo $registrants_list ?: '<span class="text-muted"><i>Belum ada pendaftar</i></span>'; ?>
                              </div>
                            </td>
                             <td class="align-middle">
                               <?php if ($d['status'] == 1) { ?>
                                 <span class="badge badge-success badge-premium">Open</span>
                               <?php } else { ?>
                                 <span class="badge badge-danger badge-premium">Closed</span>
                               <?php } ?>
                             </td>
                             <td class="align-middle">
                               <?php if ($d['status'] == 1) { ?>
                                 <button class="btn btn-primary btn-sm btn-premium shadow-sm px-3" data-toggle="modal" data-target="#modalBook<?php echo $d['id']; ?>">
                                   <i class="fas fa-plus-circle mr-1"></i> Daftar
                                 </button>
                               <?php } else { ?>
                                 <button class="btn btn-secondary btn-sm btn-premium shadow-sm px-3 disabled" disabled>
                                   <i class="fas fa-lock mr-1"></i> Daftar
                                 </button>
                               <?php } ?>
                             </td>
                          </tr>

                        <?php
                          // Generate Modal Booking Form
                          $modals .= '
                          <div class="modal fade" id="modalBook' . $d['id'] . '" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                              <div class="modal-content modal-content-premium bg-dark text-white">
                                <form action="aksiLabBooking.php?act=submitBooking" method="post">
                                  <div class="modal-header modal-header-premium border-0">
                                    <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-edit mr-2"></i>Form Pendaftaran Lab</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body p-4 text-left">
                                    <input type="hidden" name="periode_id" value="' . $d['id'] . '">
                                    <div class="alert bg-secondary text-white border-0 mb-4 py-3">
                                      <div class="small text-uppercase opacity-75">Jadwal Terpilih</div>
                                      <div class="font-weight-bold">' . date('d M Y', strtotime($d['tgl'])) . ' | ' . substr($d['jam_mulai'], 0, 5) . ' - ' . substr($d['jam_selesai'], 0, 5) . '</div>
                                      <div class="small">Ruangan: ' . ($d['nama_ruang'] ?? '-') . '</div>
                                    </div>
                                    
                                    ' . ($has_kelompok ? '<div class="alert alert-warning py-2 small"><i class="fas fa-exclamation-triangle mr-2"></i> Jadwal ini sudah dipesan oleh <b>Kelompok</b>. Anda masih dapat mendaftar sebagai <b>Individu</b>.</div>' : '') . '

                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-group mb-4">
                                          <label class="small text-uppercase opacity-75">Kategori Peserta <span class="text-danger">*</span></label>
                                          <div class="custom-selection">
                                            <label class="selection-item">
                                              <input type="radio" name="kategori_peserta" value="Individu" required onchange="handleCategoryChange(this, ' . $d['id'] . ')">
                                              <div class="selection-box">
                                                <i class="fas fa-user"></i>
                                                <span>Individu</span>
                                              </div>
                                            </label>
                                            ' . (!$has_kelompok ? '
                                            <label class="selection-item">
                                              <input type="radio" name="kategori_peserta" value="Kelompok" required onchange="handleCategoryChange(this, ' . $d['id'] . ')">
                                              <div class="selection-box">
                                                <i class="fas fa-users"></i>
                                                <span>Kelompok</span>
                                              </div>
                                            </label>' : '') . '
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="small text-uppercase opacity-75">Nama Pendaftar</label>
                                          <input type="text" name="nama" class="form-control bg-transparent text-white border-secondary" value="' . $d_mhs['nama'] . '" readonly>
                                          <input type="hidden" name="nim" value="' . $d_mhs['nim'] . '">
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="small text-uppercase opacity-75">Jumlah Orang <span class="text-danger">*</span></label>
                                          <input type="number" name="jml_orang" id="jml_orang_' . $d['id'] . '" class="form-control bg-transparent text-white border-secondary" required min="1">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="small text-uppercase opacity-75">Email <span class="text-danger">*</span></label>
                                          <input type="email" name="email" class="form-control bg-transparent text-white border-secondary" value="' . $d_mhs['imel'] . '" required>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="small text-uppercase opacity-75">Nomor WA <span class="text-danger">*</span></label>
                                          <input type="text" name="no_wa" class="form-control bg-transparent text-white border-secondary" placeholder="Contoh: 08123456789" required>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row mb-3">
                                      <div class="col-md-12">
                                        <div class="form-group mb-0">
                                          <label class="small text-uppercase opacity-75">Pilih Layanan Utama <span class="text-danger">*</span></label>
                                          <div class="custom-selection">
                                            <label class="selection-item">
                                              <input type="radio" name="layanan_utama" value="Alat Test Psikologi" required onchange="handleLayananUtamaChange(this, ' . $d['id'] . ')">
                                              <div class="selection-box">
                                                <i class="fas fa-brain"></i>
                                                <span>Alat Test Psikologi</span>
                                              </div>
                                            </label>
                                            <label class="selection-item">
                                              <input type="radio" name="layanan_utama" value="Alat Ukur" required onchange="handleLayananUtamaChange(this, ' . $d['id'] . ')">
                                              <div class="selection-box">
                                                <i class="fas fa-ruler-combined"></i>
                                                <span>Alat Ukur</span>
                                              </div>
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="small text-uppercase opacity-75">Jenis Layanan Spesifik <span class="text-danger">*</span></label>
                                      <select name="jenis_layanan" id="jenis_layanan_' . $d['id'] . '" class="form-control bg-dark text-white border-secondary" required disabled>
                                        <option value="">- Pilih Jenis Layanan Terlebih Dahulu -</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label class="small text-uppercase opacity-75">Catatan <span class="text-danger">*</span></label>
                                      <textarea name="keperluan_alat" class="form-control bg-transparent text-white border-secondary" rows="3" required placeholder="Tuliskan catatan tambahan..."></textarea>
                                    </div>
                                  </div>
                                  <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-outline-light btn-premium" data-dismiss="modal">Batal</button>
                                    <button type="submit" id="btnSubmit_' . $d['id'] . '" class="btn btn-primary btn-premium px-4 shadow">Konfirmasi</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>';
                        }
                        ?>
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
    <?php echo $modals; ?>

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
              Oke, Saya Mengerti
            </button>
          </div>
        </div>
      </div>
    </div>
    <script>
      window.onload = function() {
        $('#modalNotification').modal('show');
        // Clean URL after showing
        window.history.replaceState({}, document.title, window.location.pathname);
      };
    </script>
    <?php } ?>

    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
    <script>
      function handleCategoryChange(select, id) {
        const inputJml = document.getElementById('jml_orang_' + id);
        const btnSubmit = document.getElementById('btnSubmit_' + id);

        if (select.value === 'Individu') {
          inputJml.value = 1;
          inputJml.readOnly = true;
          btnSubmit.innerHTML = '<i class="fas fa-user mr-1"></i> Daftar Individu';
          btnSubmit.className = 'btn btn-warning btn-premium px-4 shadow';
        } else if (select.value === 'Kelompok') {
          inputJml.value = '';
          inputJml.readOnly = false;
          btnSubmit.innerHTML = '<i class="fas fa-users mr-1"></i> Daftar Kelompok';
          btnSubmit.className = 'btn btn-primary btn-premium px-4 shadow';
          inputJml.focus();
        } else {
          btnSubmit.innerHTML = 'Konfirmasi';
          btnSubmit.className = 'btn btn-primary btn-premium px-4 shadow';
        }
      }

      function handleLayananUtamaChange(select, id) {
        const jenisLayananSelect = document.getElementById('jenis_layanan_' + id);
        const options = {
          'Alat Test Psikologi': [
            'Self Assessment',
            'Scoring Alat Test',
            'Instruksi & Materi Alat Test',
            'Roleplay'
          ],
          'Alat Ukur': [
            'Instrumen Alat Ukur',
            'Validitas & Reliabilitas',
            'Uji Asumsi Klasik',
            'Uji Hipotesis'
          ]
        };

        jenisLayananSelect.innerHTML = '<option value="">- Pilih Jenis Layanan -</option>';
        
        if (select.value && options[select.value]) {
          jenisLayananSelect.disabled = false;
          options[select.value].forEach(opt => {
            const optionElement = document.createElement('option');
            optionElement.value = opt;
            optionElement.textContent = opt;
            jenisLayananSelect.appendChild(optionElement);
          });
        } else {
          jenisLayananSelect.disabled = true;
        }
      }
    </script>
  </div>
</body>

</html>