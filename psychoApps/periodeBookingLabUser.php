<?php 
include("contentsConAdm.php");
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>
<style>
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
    box-shadow: 0 15px 35px rgba(0,0,0,0.5);
  }
  .modal-header-premium {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
  }
  .list-pendaftar-adm {
    max-height: 200px;
    overflow-y: auto;
    font-size: 0.95rem;
    text-align: left;
    padding: 12px;
    background: #fdfdfd;
    border-radius: 12px;
    border: 1px solid #eee;
  }
  .reg-item {
    background: #fff;
    border: 1px solid #ebedef;
    border-radius: 10px;
    padding: 8px 12px;
    margin-bottom: 8px;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
  }
  .reg-item:hover {
    background: #f0f4f8;
    border-color: #d1d9e6;
    transform: translateX(3px);
  }
  .schedule-move-item {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 10px 15px;
    margin-bottom: 10px;
    border: 1px solid #dee2e6;
    transition: all 0.2s;
  }
  .schedule-move-item:hover {
    background: #e9ecef;
    border-color: #ced4da;
  }
  .scroll-move {
    max-height: 400px;
    overflow-y: auto;
    padding-right: 5px;
  }
  .row-overlap {
    background-color: #fff5f5 !important;
    border-left: 5px solid #ff4d4d !important;
  }
  .row-overlap:hover {
    background-color: #ffe6e6 !important;
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
          if (!empty($_GET['message']) && $_GET['message'] == 'notifAdd') {
            echo '<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <span>Berhasil menambah periode jadwal!</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>';
          }
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
            echo '<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <span>Berhasil memperbarui periode jadwal!</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>';
          }
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDel') {
            echo '<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <span>Berhasil menghapus periode jadwal!</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>';
          }
          if (!empty($_GET['message']) && $_GET['message'] == 'notifMove') {
            echo '<div class="alert alert-primary alert-dismissible fade show shadow-sm" role="alert">
                    <span>Berhasil memindahkan pendaftar ke jadwal baru!</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>';
          }
          ?>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold">Kelola Pendaftaran Lab</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-12">
              <div class="card bg-white shadow-sm border-0">
                <div class="card-body py-2 px-3 d-flex align-items-center flex-wrap">
                  <span class="small font-weight-bold text-muted mr-3 uppercase"><i class="fas fa-info-circle mr-1"></i> Legend:</span>
                  <div class="mr-4">
                    <span class="badge badge-primary badge-premium" style="font-size:0.7rem; padding: 4px 8px;">K</span>
                    <span class="small font-weight-bold ml-1">Kelompok</span>
                  </div>
                  <div class="mr-4">
                    <span class="badge badge-warning badge-premium" style="font-size:0.7rem; padding: 4px 8px;">I</span>
                    <span class="small font-weight-bold ml-1">Individu</span>
                  </div>
                  <div class="mr-4">
                    <span class="badge badge-danger badge-premium" style="font-size:0.7rem; padding: 4px 8px;"><i class="fas fa-exclamation-triangle"></i></span>
                    <span class="small font-weight-bold ml-1 text-danger">Jadwal Bentrok</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card card-outline card-success shadow-sm">
                <div class="card-header border-0">
                  <h3 class="card-title font-weight-bold text-success">Daftar Jadwal & Pendaftar</h3>
                  <button type="button" class="btn btn-success btn-sm float-right btn-premium shadow-sm px-4" data-toggle="modal" data-target="#modalAdd">
                    <i class="fas fa-plus mr-1"></i> Buat Jadwal Baru
                  </button>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-hover m-0 table-bordered text-center align-middle">
                      <thead class="bg-light text-muted">
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Waktu</th>
                          <th>Ruangan</th>
                          <th width="35%">Daftar Pendaftar (Individu/Kelompok)</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Fetch all data first to detect overlaps
                        $all_rows = [];
                        $q = mysqli_query($con, "SELECT p.*, r.nm as nama_ruang 
                                               FROM lab_booking_periode p 
                                               LEFT JOIN dt_ruang r ON p.ruangan_id = r.id 
                                               ORDER BY p.tgl DESC, p.jam_mulai DESC");
                        while($row = mysqli_fetch_array($q)) {
                          $all_rows[] = $row;
                        }

                        $no = 1;
                        $modals = "";
                        
                        // Re-fetch open schedules for move modal (same as before)
                        $schedules_data = [];
                        foreach($all_rows as $sch) {
                          if($sch['status'] == 1) $schedules_data[] = $sch;
                        }

                        foreach ($all_rows as $d) {
                          $periode_id = $d['id'];
                          
                          // Overlap Detection Logic
                          $is_overlap = false;
                          foreach ($all_rows as $other) {
                            if ($d['id'] == $other['id']) continue;
                            if ($d['tgl'] == $other['tgl'] && $d['ruangan_id'] == $other['ruangan_id']) {
                              $s1 = $d['jam_mulai']; $e1 = $d['jam_selesai'];
                              $s2 = $other['jam_mulai']; $e2 = $other['jam_selesai'];
                              if (($s1 >= $s2 && $s1 < $e2) || ($e1 > $s2 && $e1 <= $e2) || ($s2 >= $s1 && $s2 < $e1)) {
                                $is_overlap = true;
                                break;
                              }
                            }
                          }
                          
                          // Get all registrants
                          $q_reg = mysqli_query($con, "SELECT * FROM lab_booking_data WHERE periode_id='$periode_id' ORDER BY kategori_peserta DESC, tgl_input ASC");
                          $registrants_html = "";
                          while($reg = mysqli_fetch_array($q_reg)) {
                            $badge_color = ($reg['kategori_peserta'] == 'Kelompok' ? 'primary' : 'warning');
                            $registrants_html .= '
                            <div class="reg-item d-flex justify-content-between align-items-center">
                              <div style="cursor:pointer; flex-grow:1" data-toggle="modal" data-target="#modalDetail'.$reg['id'].'">
                                <span class="badge badge-'.$badge_color.' mr-2" style="font-size:0.7rem">'.($reg['kategori_peserta'] == 'Kelompok' ? 'K' : 'I').'</span>
                                <span class="font-weight-bold text-dark">'.$reg['nama'].'</span>
                              </div>
                              <button class="btn btn-primary btn-xs btn-premium shadow-sm ml-2" data-toggle="modal" data-target="#modalMove'.$reg['id'].'" title="Pindahkan Pendaftar">
                                <i class="fas fa-exchange-alt"></i>
                              </button>
                            </div>';

                            // Modal Detail Pendaftar
                            $modals .= '
                            <div class="modal fade" id="modalDetail'.$reg['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content modal-content-premium bg-dark text-white">
                                  <div class="modal-header modal-header-premium border-0">
                                    <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-info-circle mr-2"></i>Detail Pendaftar</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body p-4 text-left">
                                    <table class="table table-sm table-borderless text-white">
                                      <tr><th width="40%" class="text-muted small uppercase">Nama</th><td>: '.$reg['nama'].'</td></tr>
                                      <tr><th class="text-muted small uppercase">NIM</th><td>: '.$reg['nim'].'</td></tr>
                                      <tr><th class="text-muted small uppercase">Kategori</th><td>: <span class="badge badge-'.$badge_color.'">'.$reg['kategori_peserta'].'</span></td></tr>
                                      <tr><th class="text-muted small uppercase">Jumlah Orang</th><td>: '.$reg['jml_orang'].'</td></tr>
                                      <tr><th class="text-muted small uppercase">Layanan</th><td>: '.$reg['jenis_layanan'].'</td></tr>
                                      <tr><th class="text-muted small uppercase">Alat</th><td>: '.($reg['tipe_alat'] ?: '-').'</td></tr>
                                      <tr><th class="text-muted small uppercase">Keperluan</th><td>: '.nl2br($reg['keperluan_alat']).'</td></tr>
                                      <tr><th class="text-muted small uppercase">Terdaftar Pada</th><td>: '.$reg['tgl_input'].'</td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>';

                            // Modal Move Pendaftar
                            $modals .= '
                            <div class="modal fade" id="modalMove'.$reg['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content modal-content-premium bg-dark text-white">
                                  <div class="modal-header border-0 bg-primary">
                                    <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-exchange-alt mr-2"></i>Pilih Jadwal Baru</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body p-4 text-left">
                                    <div class="alert alert-info py-2 small mb-4">
                                      Memindahkan: <b>'.$reg['nama'].'</b> ('.$reg['kategori_peserta'].')<br>
                                      Silakan klik tombol <b>"Pindahkan ke Sini"</b> pada jadwal yang diinginkan.
                                    </div>
                                    <div class="scroll-move">';
                                    
                                    foreach($schedules_data as $sch) {
                                      if($sch['id'] == $periode_id) continue;
                                      
                                      $can_move = true;
                                      if ($reg['kategori_peserta'] == 'Kelompok') {
                                        $q_check_k = mysqli_query($con, "SELECT id FROM lab_booking_data WHERE periode_id='$sch[id]' AND kategori_peserta='Kelompok'");
                                        if (mysqli_num_rows($q_check_k) > 0) $can_move = false;
                                      }

                                      $modals .= '
                                      <div class="schedule-move-item d-flex justify-content-between align-items-center">
                                        <div>
                                          <div class="font-weight-bold text-dark">'.date('d M Y', strtotime($sch['tgl'])).'</div>
                                          <div class="small text-muted">'.substr($sch['jam_mulai'], 0, 5).' - '.substr($sch['jam_selesai'], 0, 5).' | '.($sch['nama_ruang'] ?? '-').'</div>
                                        </div>
                                        <div>';
                                          if ($can_move) {
                                            $modals .= '
                                            <form action="aksiLabBooking.php?act=moveBooking" method="post" class="m-0">
                                              <input type="hidden" name="booking_id" value="'.$reg['id'].'">
                                              <input type="hidden" name="new_periode_id" value="'.$sch['id'].'">
                                              <button type="submit" class="btn btn-primary btn-sm btn-premium px-3">
                                                <i class="fas fa-check mr-1"></i> Pindahkan ke Sini
                                              </button>
                                            </form>';
                                          } else {
                                            $modals .= '<span class="badge badge-secondary p-2">Sudah ada Kelompok</span>';
                                          }
                                        $modals .= '
                                        </div>
                                      </div>';
                                    }
                            $modals .= '
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>';
                          }
                        ?>
                          <tr class="<?php echo $is_overlap ? 'row-overlap' : ''; ?>">
                            <td class="align-middle"><?php echo $no++; ?></td>
                            <td class="align-middle"><?php echo date('d/m/Y', strtotime($d['tgl'])); ?></td>
                            <td class="align-middle">
                              <?php if($is_overlap) echo '<i class="fas fa-exclamation-triangle text-danger" title="Jadwal Bentrok"></i> '; ?>
                              <?php echo substr($d['jam_mulai'], 0, 5) . ' - ' . substr($d['jam_selesai'], 0, 5); ?>
                            </td>
                            <td class="align-middle"><?php echo $d['nama_ruang'] ?? '-'; ?></td>
                            <td class="align-middle">
                              <div class="list-pendaftar-adm shadow-sm">
                                <?php echo $registrants_html ?: '<span class="text-muted italic small">Belum ada pendaftar</span>'; ?>
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
                              <button class="btn btn-warning btn-xs btn-premium" data-toggle="modal" data-target="#modalEdit<?php echo $d['id']; ?>" title="Edit Jadwal">
                                <i class="fas fa-edit"></i>
                              </button>
                              <a href="aksiLabBooking.php?act=delPeriode&id=<?php echo $d['id']; ?>" class="btn btn-danger btn-xs btn-premium" onclick="return confirm('Yakin ingin menghapus jadwal ini?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                          </tr>

                          <?php 
                          // Modal Edit Jadwal
                          $modals .= '
                          <div class="modal fade" id="modalEdit'.$d['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content modal-content-premium bg-dark text-white">
                                <form action="aksiLabBooking.php?act=editPeriode" method="post">
                                  <div class="modal-header modal-header-premium border-0">
                                    <h5 class="modal-title font-weight-bold text-white">Edit Jadwal Lab</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body p-4 text-left">
                                    <input type="hidden" name="id" value="'.$d['id'].'">
                                    <div class="form-group">
                                      <label class="small text-uppercase opacity-75">Tanggal</label>
                                      <input type="date" name="tgl" class="form-control bg-transparent text-white border-secondary" value="'.$d['tgl'].'" required>
                                    </div>
                                    <div class="row">
                                      <div class="col-6">
                                        <div class="form-group">
                                          <label class="small text-uppercase opacity-75">Jam Mulai</label>
                                          <input type="time" name="jam_mulai" class="form-control bg-transparent text-white border-secondary" value="'.$d['jam_mulai'].'" required>
                                        </div>
                                      </div>
                                      <div class="col-6">
                                        <div class="form-group">
                                          <label class="small text-uppercase opacity-75">Jam Selesai</label>
                                          <input type="time" name="jam_selesai" class="form-control bg-transparent text-white border-secondary" value="'.$d['jam_selesai'].'" required>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="small text-uppercase opacity-75">Ruangan</label>
                                      <select name="ruangan_id" class="form-control bg-dark text-white border-secondary" required>
                                        <option value="">- Pilih Ruangan -</option>';
                                        $q_ruang = mysqli_query($con, "SELECT * FROM dt_ruang ORDER BY nm ASC");
                                        while($r = mysqli_fetch_array($q_ruang)) {
                                          $selected = ($r['id'] == $d['ruangan_id']) ? 'selected' : '';
                                          $modals .= "<option value='$r[id]' $selected>$r[nm]</option>";
                                        }
                          $modals .= '
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label class="small text-uppercase opacity-75">Info Tenaga (Asisten/Laboran)</label>
                                      <textarea name="info_tenaga" class="form-control bg-transparent text-white border-secondary" rows="2">'.$d['info_tenaga'].'</textarea>
                                    </div>
                                    <div class="form-group">
                                      <label class="small text-uppercase opacity-75">Status</label>
                                      <select name="status" class="form-control bg-dark text-white border-secondary">
                                        <option value="1" '.($d['status'] == 1 ? 'selected' : '').'>Open</option>
                                        <option value="0" '.($d['status'] == 0 ? 'selected' : '').'>Closed</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-outline-light btn-premium" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success btn-premium px-4">Simpan Perubahan</button>
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

    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-premium bg-dark text-white">
          <form action="aksiLabBooking.php?act=addPeriode" method="post">
            <div class="modal-header modal-header-premium border-0">
              <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-calendar-plus mr-2"></i>Buat Jadwal Baru</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body p-4 text-left">
              <div class="form-group">
                <label class="small text-uppercase opacity-75">Tanggal</label>
                <input type="date" name="tgl" class="form-control bg-transparent text-white border-secondary" required>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="small text-uppercase opacity-75">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control bg-transparent text-white border-secondary" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="small text-uppercase opacity-75">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control bg-transparent text-white border-secondary" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="small text-uppercase opacity-75">Ruangan</label>
                <select name="ruangan_id" class="form-control bg-dark text-white border-secondary" required>
                  <option value="">- Pilih Ruangan -</option>
                  <?php 
                  $q_ruang = mysqli_query($con, "SELECT * FROM dt_ruang ORDER BY nm ASC");
                  while($r = mysqli_fetch_array($q_ruang)) {
                    echo "<option value='$r[id]'>$r[nm]</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="small text-uppercase opacity-75">Info Tenaga (Asisten/Laboran)</label>
                <textarea name="info_tenaga" class="form-control bg-transparent text-white border-secondary" rows="2" placeholder="Nama asisten yang bertugas..."></textarea>
              </div>
            </div>
            <div class="modal-footer border-0">
              <button type="button" class="btn btn-outline-light btn-premium" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success btn-premium px-4 shadow">Buat Jadwal</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php echo $modals; ?>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
  </div>
</body>

</html>
