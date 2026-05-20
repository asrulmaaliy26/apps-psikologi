<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include("navtopAdm.php");
    include("navSideBarAdmBakS1.php"); ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Rekap Pra Proposal Bimtek</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="pndftrnBimtekAdm.php">Bimtek</a></li>
                <li class="breadcrumb-item active">Rekap Pra Proposal</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <!-- Filter -->
          <div class="card card-outline card-secondary mb-3">
            <div class="card-header">
              <h5 class="card-title">Filter Periode</h5>
            </div>
            <div class="card-body">
              <form method="GET" class="form-inline">
                <div class="form-group mr-3">
                  <label class="mr-2">Periode:</label>
                  <select name="id_bimtek" class="form-control form-control-sm">
                    <option value="">-- Semua Periode --</option>
                    <?php
                    $q_all_per = mysqli_query($con, "SELECT id, nama_bimtek FROM bimtek_pendaftaran ORDER BY id DESC");
                    $latest_id = '';
                    $periods = [];
                    while ($dp = mysqli_fetch_assoc($q_all_per)) {
                      $periods[] = $dp;
                      if ($latest_id == '') $latest_id = $dp['id'];
                    }

                    $current_id_bimtek = isset($_GET['id_bimtek']) ? $_GET['id_bimtek'] : $latest_id;

                    foreach ($periods as $dp) {
                      $sel = ($current_id_bimtek == $dp['id']) ? 'selected' : '';
                      echo "<option value='" . $dp['id'] . "' $sel>" . $dp['nama_bimtek'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group mr-3">
                  <label class="mr-2">Status:</label>
                  <select name="status" class="form-control form-control-sm">
                    <option value="">-- Semua Status --</option>
                    <?php
                    $statuses = ['proses' => 'Sedang Diproses', 'revisi' => 'Perlu Revisi', 'diterima' => 'Diterima'];
                    foreach ($statuses as $k => $v) {
                      $sel = (isset($_GET['status']) && $_GET['status'] == $k) ? 'selected' : '';
                      echo "<option value='$k' $sel>$v</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group mr-3">
                  <label class="mr-2">Pembimbing:</label>
                  <select name="pembimbing" class="form-control form-control-sm">
                    <option value="">-- Semua --</option>
                    <option value="sudah" <?php echo (isset($_GET['pembimbing']) && $_GET['pembimbing'] == 'sudah') ? 'selected' : ''; ?>>Sudah Pilih</option>
                    <option value="belum" <?php echo (isset($_GET['pembimbing']) && $_GET['pembimbing'] == 'belum') ? 'selected' : ''; ?>>Belum Pilih</option>
                  </select>
                </div>
                <div class="form-group mr-3">
                  <label class="mr-2">Reviewer:</label>
                  <select name="reviewer" class="form-control form-control-sm select2" style="max-width:200px;">
                    <option value="">-- Semua Reviewer --</option>
                    <option value="belum_diplot" <?php echo (isset($_GET['reviewer']) && $_GET['reviewer'] == 'belum_diplot') ? 'selected' : ''; ?>>[Belum Diplot]</option>
                    <?php
                    $qRev = mysqli_query($con, "SELECT DISTINCT bp.id_reviewer, p.nama FROM bimtek_peserta bp JOIN dt_pegawai p ON bp.id_reviewer = p.id WHERE bp.id_bimtek = '" . mysqli_real_escape_string($con, $current_id_bimtek) . "' ORDER BY p.nama ASC");
                    while($rev = mysqli_fetch_assoc($qRev)) {
                      $sel = (isset($_GET['reviewer']) && $_GET['reviewer'] == $rev['id_reviewer']) ? 'selected' : '';
                      echo "<option value='".$rev['id_reviewer']."' $sel>".$rev['nama']."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group mr-3">
                  <label class="mr-2">Sort:</label>
                  <select name="sort" class="form-control form-control-sm">
                    <option value="terbaru" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'terbaru') ? 'selected' : ''; ?>>Terbaru (Default)</option>
                    <option value="nim" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nim') ? 'selected' : ''; ?>>NIM</option>
                    <option value="reviewer" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'reviewer') ? 'selected' : ''; ?>>Reviewer</option>
                    <option value="status" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'status') ? 'selected' : ''; ?>>Status</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="rekapPraPropBimtekAdm.php" class="btn btn-secondary btn-sm ml-2"><i class="fas fa-times"></i> Reset</a>
                <?php
                // Build query string for export link based on current filters
                $export_params = $_GET;
                $export_params['id_bimtek'] = $current_id_bimtek; // ensure id_bimtek is included
                $query_string = http_build_query($export_params);
                ?>
                <a href="exportPraPropBimtekExcel.php?<?php echo $query_string; ?>" class="btn btn-success btn-sm ml-2" target="_blank"><i class="fas fa-file-excel"></i> Export Excel</a>
              </form>
            </div>
          </div>

          <!-- Tabel -->
          <div class="card card-outline card-info">
            <div class="card-header">
              <h5 class="card-title">Daftar Pra Proposal Mahasiswa</h5>
            </div>
            <div class="card-body p-0">
              <form id="bulkForm" action="bulkValidasiSertifikatAdm.php" method="POST">
                <div id="bulkActionArea" class="p-2 bg-light border-bottom align-items-center justify-content-between" style="display:none;">
                  <div class="text-dark ml-2">
                    <i class="fas fa-check-square mr-2 text-primary"></i>
                    <span id="selectedCount" class="font-weight-bold">0</span> data terpilih
                  </div>
                  <div class="form-inline mr-2">
                    <label class="mr-2 small font-weight-bold">Set Status Sertifikat:</label>
                    <select name="status" class="form-control form-control-sm mr-2" required>
                      <option value="pending">Pending</option>
                      <option value="valid">Valid</option>
                      <option value="invalid">Ditolak</option>
                      <option value="bypassed">Bypassed</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Terapkan perubahan status ke semua data terpilih?')">
                      <i class="fas fa-save mr-1"></i> Terapkan
                    </button>
                  </div>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm text-center small">
                  <thead class="bg-secondary">
                    <tr>
                      <th width="3%"><input type="checkbox" id="checkAll"></th>
                      <th width="5%">No</th>
                      <th width="10%">NIM</th>
                      <th width="17%">Nama Mahasiswa</th>
                      <th width="12%">Peminatan</th>
                      <th width="18%">Reviewer</th>
                      <th width="10%">Status</th>
                      <th width="12%">Sertifikat</th>
                      <th width="13%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $where = [];
                    if (!empty($current_id_bimtek)) $where[] = "bp.id_bimtek='" . mysqli_real_escape_string($con, $current_id_bimtek) . "'";
                    if (!empty($_GET['status'])) $where[] = "pp.status='" . mysqli_real_escape_string($con, $_GET['status']) . "'";
                    if (!empty($_GET['pembimbing'])) {
                      if ($_GET['pembimbing'] == 'sudah') {
                        $where[] = "(pp.pembimbing_saran_1 IS NOT NULL AND pp.pembimbing_saran_1 != '') OR (pp.pembimbing_saran_2 IS NOT NULL AND pp.pembimbing_saran_2 != '')";
                      } else {
                        $where[] = "(pp.pembimbing_saran_1 IS NULL OR pp.pembimbing_saran_1 = '') AND (pp.pembimbing_saran_2 IS NULL OR pp.pembimbing_saran_2 = '')";
                      }
                    }
                    $where_sql = $where ? "WHERE " . implode(' AND ', $where) : '';

                    if (!empty($_GET['reviewer'])) {
                        if ($_GET['reviewer'] == 'belum_diplot') {
                            $where_sql .= ($where_sql ? " AND " : "WHERE ") . "(bp.id_reviewer IS NULL OR bp.id_reviewer = '')";
                        } else {
                            $where_sql .= ($where_sql ? " AND " : "WHERE ") . "bp.id_reviewer = '" . mysqli_real_escape_string($con, $_GET['reviewer']) . "'";
                        }
                    }

                    $order_sql = "ORDER BY pp.tgl_submit DESC, bp.id DESC";
                    if (isset($_GET['sort'])) {
                        if ($_GET['sort'] == 'nim') {
                            $order_sql = "ORDER BY bp.nim ASC";
                        } else if ($_GET['sort'] == 'reviewer') {
                            $order_sql = "ORDER BY rev_nama ASC, bp.nim ASC";
                        } else if ($_GET['sort'] == 'status') {
                            $order_sql = "ORDER BY pp.status ASC, bp.nim ASC";
                        }
                    }

                    $q_list = mysqli_query($con, "SELECT bp.nim, bp.id_bimtek, bp.id_reviewer as bp_rev_id, m.nama as mhs_nama, b.nama_bimtek, 
                            p.nama as rev_nama, o.nm as nm_pem, pp.*, pp.id as pp_id,
                            d1.nama as saran1_nama, d2.nama as saran2_nama
                            FROM bimtek_peserta bp
                            JOIN (SELECT MAX(id) as max_id FROM bimtek_peserta GROUP BY nim, id_bimtek) latest ON bp.id = latest.max_id
                            LEFT JOIN bimtek_pra_proposal pp ON bp.nim = pp.nim AND bp.id_bimtek = pp.id_bimtek
                            LEFT JOIN dt_mhssw m ON bp.nim = m.nim
                            LEFT JOIN bimtek_pendaftaran b ON bp.id_bimtek = b.id
                            LEFT JOIN dt_pegawai p ON bp.id_reviewer = p.id
                            LEFT JOIN dt_pegawai d1 ON pp.pembimbing_saran_1 = d1.id
                            LEFT JOIN dt_pegawai d2 ON pp.pembimbing_saran_2 = d2.id
                            LEFT JOIN opsi_bidang_skripsi o ON bp.peminatan = o.id
                            $where_sql
                            $order_sql");
                    $no = 1;
                    while ($d = mysqli_fetch_assoc($q_list)):
                      $badge = ['proses' => 'badge-warning', 'revisi' => 'badge-danger', 'diterima' => 'badge-success'];
                      $label = ['proses' => 'Diproses', 'revisi' => 'Revisi', 'diterima' => 'Diterima'];
                    ?>
                      <tr data-widget="expandable-table" aria-expanded="false" style="cursor:pointer;">
                        <td onclick="event.stopPropagation();">
                          <?php if ($d['pp_id'] && $d['file_sertifikat']): ?>
                            <input type="checkbox" name="ids[]" value="<?php echo $d['pp_id']; ?>" class="row-check">
                          <?php else: ?>
                            <i class="fas fa-minus text-muted small"></i>
                          <?php endif; ?>
                        </td>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['nim']; ?></td>
                        <td class="text-left"><?php echo $d['mhs_nama']; ?></td>
                        <td><?php echo $d['nm_pem']; ?></td>
                        <td class="text-left"><?php echo $d['rev_nama'] ?: '<span class="text-muted"><i>Belum Diplot</i></span>'; ?></td>
                        <td>
                          <?php if ($d['status']): ?>
                            <span class="badge <?php echo $badge[$d['status']]; ?>"><?php echo $label[$d['status']]; ?></span>
                            <?php if (!empty($d['pembimbing_saran_1']) || !empty($d['pembimbing_saran_2'])): ?>
                              <br><span class="badge badge-primary mt-1" style="font-size: 85%;"><i class="fas fa-user-check"></i> Pilih Pembimbing</span>
                            <?php endif; ?>
                          <?php else: ?>
                            <span class="badge badge-secondary">Belum Upload</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($d['file_sertifikat']): ?>
                            <?php
                            $cur_s_status = $d['status_sertifikat'] ?? 'pending';
                            $s_badge = ['pending' => 'badge-warning', 'valid' => 'badge-success', 'invalid' => 'badge-danger', 'bypassed' => 'badge-info'];
                            $s_label = ['pending' => 'Pending', 'valid' => 'Valid', 'invalid' => 'Ditolak', 'bypassed' => 'Bypassed'];
                            $badge_class = isset($s_badge[$cur_s_status]) ? $s_badge[$cur_s_status] : 'badge-secondary';
                            $label_text = isset($s_label[$cur_s_status]) ? $s_label[$cur_s_status] : $cur_s_status;
                            echo "<span class='badge " . $badge_class . "'>" . $label_text . "</span>";
                            ?>
                          <?php else: ?>
                            <span class="text-muted small">-</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($d['pp_id']): ?>
                            <div class="btn-group">
                              <a href="hapusPraPropBimtekAdm.php?id=<?php echo $d['pp_id']; ?>" class="btn btn-xs btn-warning font-weight-bold" onclick="return confirm('Yakin ingin mereset data pra proposal ini? Mahasiswa harus mengunggah ulang.')" title="Reset Proposal / Upload Ulang">
                                <i class="fas fa-sync-alt"></i> Reset Prop
                              </a>
                              <?php if ($d['pembimbing_saran_1'] || $d['pembimbing_saran_2']): ?>
                                <a href="resetSaranPembimbingAdm.php?id=<?php echo $d['pp_id']; ?>" class="btn btn-xs btn-danger font-weight-bold" onclick="return confirm('Yakin ingin mereset pilihan pembimbing? Mahasiswa akan bisa memilih kembali.')" title="Reset Pilihan Pembimbing">
                                  <i class="fas fa-user-slash"></i> Reset Pemb.
                                </a>
                              <?php endif; ?>
                            </div>
                          <?php else: ?>
                            -
                          <?php endif; ?>
                        </td>
                      </tr>
                      <tr class="expandable-body d-none">
                        <td colspan="9">
                          <div class="p-0 text-left">
                            <?php if ($d['pp_id']): ?>
                              <div class="card card-widget widget-user-2 shadow-none mb-0 bg-light">
                              <div class="card-footer p-0">
                                <div class="row no-gutters">
                                  <div class="col-md-4 p-4 border-right">
                                    <h6 class="mb-3 text-uppercase font-weight-bold text-primary" style="letter-spacing: 1px;">
                                      <i class="fas fa-file-alt mr-2"></i> Detail Proposal
                                    </h6>
                                    <ul class="nav flex-column small">
                                      <li class="nav-item mb-2">
                                        <span class="text-muted d-block mb-1">Periode Bimtek</span>
                                        <span class="font-weight-bold bg-white px-2 py-1 rounded border shadow-sm d-inline-block"><?php echo $d['nama_bimtek']; ?></span>
                                      </li>
                                      <li class="nav-item mb-2">
                                        <span class="text-muted d-block mb-1">Judul Proposal</span>
                                        <span class="font-weight-bold text-dark" style="font-size: 1.1em;"><?php echo htmlspecialchars($d['judul']); ?></span>
                                      </li>
                                      <li class="nav-item mb-2">
                                        <span class="text-muted d-block mb-1">Dosen Reviewer</span>
                                        <span class="text-dark"><i class="fas fa-user-tie mr-1 text-secondary"></i> <?php echo $d['rev_nama'] ?: '<span class="text-muted"><i>Belum Diplot</i></span>'; ?></span>
                                      </li>
                                      <li class="nav-item mt-3 pt-2 border-top">
                                        <div class="d-flex justify-content-between">
                                          <div><span class="text-muted mr-2">Submit:</span> <span class="badge badge-light border"><?php echo $d['tgl_submit']; ?></span></div>
                                          <div><span class="text-muted mr-2">Update:</span> <span class="badge badge-light border"><?php echo $d['tgl_update']; ?></span></div>
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                                  <div class="col-md-4 p-4 border-right">
                                    <h6 class="mb-3 text-uppercase font-weight-bold text-success" style="letter-spacing: 1px;">
                                      <i class="fas fa-star mr-2"></i> Rekap Penilaian
                                    </h6>
                                    <table class="table table-sm table-bordered small mb-0 bg-white text-center">
                                      <thead class="bg-light">
                                        <tr><th>A1</th><th>A2</th><th>A3</th><th>A4</th><th>A5</th><th>A6</th></tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td><?php echo $d['a1']; ?></td>
                                          <td><?php echo $d['a2']; ?></td>
                                          <td><?php echo $d['a3']; ?></td>
                                          <td><?php echo $d['a4']; ?></td>
                                          <td><?php echo $d['a5']; ?></td>
                                          <td><?php echo $d['a6']; ?></td>
                                        </tr>
                                      </tbody>
                                      <tfoot>
                                        <tr class="font-weight-bold">
                                          <td colspan="4" class="text-right">Nilai Akhir:</td>
                                          <td colspan="2" class="text-primary" style="font-size:1.2em;"><?php echo $d['nilai_akhir']; ?></td>
                                        </tr>
                                      </tfoot>
                                    </table>
                                    <div class="mt-2 xsmall text-muted italic">
                                      A1:Masalah, A2:Rumusan, A3:Tujuan, A4:Metode, A5:Etika, A6:Presentasi
                                    </div>
                                  </div>
                                  <div class="col-md-4 p-4">
                                    <h6 class="mb-3 text-uppercase font-weight-bold text-warning" style="letter-spacing: 1px;">
                                      <i class="fas fa-user-check mr-2"></i> Saran & Validasi
                                    </h6>
                                    <div class="bg-white p-3 rounded border shadow-sm mb-3">
                                      <span class="text-muted small d-block mb-2 font-weight-bold text-uppercase">Saran Dosen Pembimbing</span>
                                      <?php if ($d['saran1_nama'] || $d['saran2_nama']): ?>
                                        <div class="d-flex align-items-center mb-2">
                                          <div class="bg-warning text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width:24px; height:24px; font-size:12px;">1</div>
                                          <span class="font-weight-bold"><?php echo $d['saran1_nama'] ?: '-'; ?></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                          <div class="bg-warning text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width:24px; height:24px; font-size:12px;">2</div>
                                          <span class="font-weight-bold"><?php echo $d['saran2_nama'] ?: '-'; ?></span>
                                        </div>
                                      <?php else: ?>
                                        <span class="text-muted italic">Mahasiswa belum mengisi saran pembimbing.</span>
                                      <?php endif; ?>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-6">
                                        <label class="text-muted small mb-1">File Proposal:</label>
                                        <a href="file_pra_proposal_bimtek/<?php echo $d['file_proposal']; ?>" target="_blank" class="btn btn-sm btn-danger btn-block shadow-sm">
                                          <i class="fas fa-file-pdf mr-1"></i> Lihat Proposal
                                        </a>
                                      </div>
                                      <div class="col-sm-6">
                                        <label class="text-muted small mb-1">File Sertifikat:</label>
                                        <?php if ($d['file_sertifikat']): ?>
                                          <a href="file_pra_proposal_bimtek/<?php echo $d['file_sertifikat']; ?>" target="_blank" class="btn btn-sm btn-info btn-block shadow-sm mb-2">
                                            <i class="fas fa-certificate mr-1"></i> Lihat Sertifikat
                                          </a>
                                          <?php if (($d['status_sertifikat'] ?? 'pending') == 'pending'): ?>
                                            <div class="d-flex">
                                              <a href="validasiSertifikatAdm.php?id=<?php echo $d['id']; ?>&status=valid" class="btn btn-xs btn-success flex-fill mr-1 py-1 font-weight-bold" onclick="return confirm('Sertifikat valid?')">
                                                <i class="fas fa-check mr-1"></i> Setujui
                                              </a>
                                              <button type="button" class="btn btn-xs btn-warning flex-fill py-1 font-weight-bold" data-toggle="modal" data-target="#modalTolakSertifikat" data-id="<?php echo $d['id']; ?>">
                                                <i class="fas fa-times mr-1"></i> Tolak
                                              </button>
                                            </div>
                                          <?php endif; ?>
                                        <?php else: ?>
                                          <div class="alert alert-light border py-1 px-2 small mb-0"><i class="fas fa-exclamation-triangle text-warning"></i> Belum diunggah</div>
                                        <?php endif; ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php else: ?>
                            <div class="alert alert-light text-center py-4 mb-0">
                                <i class="fas fa-info-circle text-info fa-2x mb-3"></i>
                                <p class="mb-0 text-muted">Mahasiswa ini belum mengunggah pra proposal.</p>
                            </div>
                          <?php endif; ?>
                          </div>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($q_list) == 0): ?>
                      <tr>
                        <td colspan="9" class="text-center text-muted">Belum ada pendaftar di periode ini.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </form>
          </div>
        </div>

        </div>
      </section>
    </div>
  </div>

  <!-- Modal Tolak Sertifikat -->
  <div class="modal fade" id="modalTolakSertifikat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="validasiSertifikatAdm.php" method="POST">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Tolak Sertifikat</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="modal_id">
            <input type="hidden" name="status" value="invalid">
            <div class="form-group">
              <label>Alasan Penolakan <span class="text-danger">*</span></label>
              <textarea name="catatan" class="form-control" rows="4" required placeholder="Contoh: Nama tidak sesuai, File buram, dll"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Simpan Penolakan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include("footerAdm.php");
  include("jsAdm.php"); ?>
  <script>
    $(function() {
      $('#modalTolakSertifikat').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('#modal_id').val(id);
      });
    });

    <?php if (!empty($_GET['msg'])): ?>
      <?php if ($_GET['msg'] == 'deleted'): ?>
        Swal.fire('Terhapus!', 'Data Pra Proposal beserta filenya berhasil dihapus.', 'success');
      <?php elseif ($_GET['msg'] == 'approved'): ?>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: 'Sertifikat berhasil disetujui.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      <?php elseif ($_GET['msg'] == 'rejected'): ?>
        Swal.fire({
          icon: 'info',
          title: 'Ditolak',
          text: 'Sertifikat berhasil ditolak.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      <?php elseif ($_GET['msg'] == 'notfound'): ?>
        Swal.fire('Gagal!', 'Data tidak ditemukan.', 'error');
      <?php elseif ($_GET['msg'] == 'bulk_success'): ?>
        Swal.fire('Berhasil!', 'Status sertifikat terpilih berhasil diperbarui.', 'success');
      <?php elseif ($_GET['msg'] == 'reset_pembimbing'): ?>
        Swal.fire('Berhasil!', 'Pilihan pembimbing mahasiswa telah di-reset. Mahasiswa kini dapat memilih kembali.', 'success');
      <?php endif; ?>
    <?php endif; ?>

    $(function() {
      // Check All logic
      $('#checkAll').on('click', function() {
        $('.row-check').prop('checked', this.checked);
        updateBulkActionArea();
      });

      $('.row-check').on('change', function() {
        updateBulkActionArea();
        if ($('.row-check:checked').length == $('.row-check').length) {
          $('#checkAll').prop('checked', true);
        } else {
          $('#checkAll').prop('checked', false);
        }
      });

      function updateBulkActionArea() {
        var count = $('.row-check:checked').length;
        $('#selectedCount').text(count);
        if (count > 0) {
          $('#bulkActionArea').css('display', 'flex');
        } else {
          $('#bulkActionArea').css('display', 'none');
        }
      }
    });
  </script>
</body>

</html>