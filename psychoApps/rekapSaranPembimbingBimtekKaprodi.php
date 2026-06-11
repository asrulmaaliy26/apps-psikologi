<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];

// Validasi: hanya Kaprodi (jabatan_instansi = 47)
$q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
$dMe = mysqli_fetch_assoc($q_me);
if ($dMe['jabatan_instansi'] != '47' && $dMe['jabatan_instansi'] != '46') {
  header("location:dashboardAdm.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include("navtopAdm.php");
    include("navSideBarDosen.php"); ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Rekap Saran Dosen Pembimbing - Bimtek</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active small">Rekap Saran Pembimbing</li>
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
              <h5 class="card-title"><i class="fas fa-filter mr-1"></i> Filter & Pencarian</h5>
            </div>
            <div class="card-body">
              <form method="GET" class="form-inline row">
                <div class="form-group col-md-3 mb-2">
                  <label class="mr-2 small font-weight-bold">Periode:</label>
                  <select name="id_bimtek" class="form-control form-control-sm w-100">
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
                      echo "<option value='" . $dp['id'] . "' $sel>" . htmlspecialchars($dp['nama_bimtek']) . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                  <label class="mr-2 small font-weight-bold">Status:</label>
                  <select name="status_filter" class="form-control form-control-sm w-100">
                    <?php
                    $current_status = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'all';
                    $status_options = [
                      'all' => 'Semua Status',
                      'pending' => 'Belum Diproses',
                      'approved' => 'Sudah Terdata'
                    ];
                    foreach ($status_options as $val => $lab) {
                      $sel = ($current_status == $val) ? 'selected' : '';
                      echo "<option value='$val' $sel>$lab</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                  <label class="mr-2 small font-weight-bold">Cari Mahasiswa:</label>
                  <div class="input-group input-group-sm w-100">
                    <input type="text" id="tableSearch" class="form-control" placeholder="Nama atau NIM...">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-2 d-flex align-items-end">
                  <button type="submit" class="btn btn-primary btn-sm mr-2"><i class="fas fa-sync-alt"></i> Terapkan</button>
                  <a href="rekapSaranPembimbingBimtekKaprodi.php" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Reset</a>
                </div>
              </form>
            </div>
          </div>

          <!-- Tabel -->
          <div class="card card-outline card-warning">
            <div class="card-header bg-white">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title font-weight-bold mb-0"><i class="fas fa-list-alt text-warning mr-2"></i> Rekap Saran Dosen Pembimbing Mahasiswa</h5>
                <div>
                  <button type="button" class="btn btn-sm btn-danger mr-2" id="btnResetAll" data-idbimtek="<?php echo htmlspecialchars($current_id_bimtek); ?>">
                    <i class="fas fa-trash-restore-alt mr-1"></i> Batalkan Semua Persetujuan
                  </button>
                  <span class="badge badge-info">Menampilkan seluruh progres mahasiswa Bimtek</span>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm text-center small">
                  <thead class="bg-warning">
                    <tr>
                      <th>No</th>
                      <th>NIM</th>
                      <th>Nama Mahasiswa</th>
                      <th>Peminatan</th>
                      <th>Status Bimtek</th>
                      <th>Saran Dosen Pembimbing 1</th>
                      <th>Saran Dosen Pembimbing 2</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Ambil ID periode pengajuan dospem yang aktif untuk kuota
                    $q_active_per = mysqli_query($con, "SELECT id FROM pengajuan_dospem WHERE status='1' ORDER BY id DESC LIMIT 1");
                    $active_period_id = '';
                    if ($d_per_active = mysqli_fetch_assoc($q_active_per)) {
                      $active_period_id = $d_per_active['id'];
                    }

                    $where = ["1=1"]; // Mulai dengan kondisi selalu benar
                    if (!empty($current_id_bimtek)) $where[] = "pp.id_bimtek='" . mysqli_real_escape_string($con, $current_id_bimtek) . "'";

                    // Filter Status Registrasi Dospem (Approved/Pending)
                    if ($current_status == 'pending') {
                      $where[] = "pp.nim NOT IN (SELECT nim FROM pengelompokan_dospem_skripsi WHERE id_periode = '$active_period_id' AND status IN ('2','3'))";
                    } elseif ($current_status == 'approved') {
                      $where[] = "pp.nim IN (SELECT nim FROM pengelompokan_dospem_skripsi WHERE id_periode = '$active_period_id' AND status IN ('2','3'))";
                    }

                    $where_sql = "WHERE " . implode(' AND ', $where);

                    $q_list = mysqli_query($con, "SELECT pp.nim, pp.pembimbing_saran_1, pp.pembimbing_saran_2, pp.status as status_bimtek,
                            m.nama as mhs_nama, b.nama_bimtek, o.nm as nm_pem,
                            d1.nama as saran1_nama, d2.nama as saran2_nama,
                            k1.kuota1 as s1_k1, k1.kuota2 as s1_k2,
                            k2.kuota1 as s2_k1, k2.kuota2 as s2_k2
                            FROM bimtek_pra_proposal pp
                            LEFT JOIN dt_mhssw m ON pp.nim = m.nim
                            LEFT JOIN bimtek_pendaftaran b ON pp.id_bimtek = b.id
                            LEFT JOIN dt_pegawai d1 ON pp.pembimbing_saran_1 = d1.id
                            LEFT JOIN dt_pegawai d2 ON pp.pembimbing_saran_2 = d2.id
                            LEFT JOIN dospem_skripsi k1 ON d1.id = k1.nip AND k1.id_periode = '$active_period_id'
                            LEFT JOIN dospem_skripsi k2 ON d2.id = k2.nip AND k2.id_periode = '$active_period_id'
                            LEFT JOIN (SELECT bp_inner.* FROM bimtek_peserta bp_inner JOIN (SELECT MAX(id) as max_id FROM bimtek_peserta GROUP BY nim, id_bimtek) latest ON bp_inner.id = latest.max_id) bp ON bp.nim = pp.nim AND bp.id_bimtek = pp.id_bimtek
                            LEFT JOIN opsi_bidang_skripsi o ON bp.peminatan = o.id
                            $where_sql
                            ORDER BY b.id DESC, m.nama ASC");
                    $no = 1;
                    while ($d = mysqli_fetch_assoc($q_list)):
                      // Hitung realisasi bimbingan saat ini (status 2=proses, 3=selesai)
                      $s1_real = 0;
                      $s1_full = false;
                      $s1_zero = false;
                      if ($d['pembimbing_saran_1']) {
                        $q_r1 = mysqli_query($con, "SELECT COUNT(*) as total FROM pengelompokan_dospem_skripsi WHERE (dospem_skripsi1='$d[pembimbing_saran_1]' OR dospem_skripsi2='$d[pembimbing_saran_1]') AND id_periode='$active_period_id' AND status IN ('2','3')");
                        $dr1 = mysqli_fetch_assoc($q_r1);
                        $s1_real = $dr1['total'];

                        $s1_total_k = (int)$d['s1_k1'] + (int)$d['s1_k2'];
                        if ($s1_total_k == 0) $s1_zero = true;
                        if ($s1_total_k > 0 && $s1_real >= $s1_total_k) $s1_full = true;
                      }

                      $s2_real = 0;
                      $s2_full = false;
                      $s2_zero = false;
                      if ($d['pembimbing_saran_2']) {
                        $q_r2 = mysqli_query($con, "SELECT COUNT(*) as total FROM pengelompokan_dospem_skripsi WHERE (dospem_skripsi1='$d[pembimbing_saran_2]' OR dospem_skripsi2='$d[pembimbing_saran_2]') AND id_periode='$active_period_id' AND status IN ('2','3')");
                        $dr2 = mysqli_fetch_assoc($q_r2);
                        $s2_real = $dr2['total'];

                        $s2_total_k = (int)$d['s2_k1'] + (int)$d['s2_k2'];
                        if ($s2_total_k == 0) $s2_zero = true;
                        if ($s2_total_k > 0 && $s2_real >= $s2_total_k) $s2_full = true;
                      }

                      $row_class = ($s1_full || $s1_zero || $s2_full || $s2_zero) ? 'table-danger' : '';
                    ?>
                      <tr class="<?php echo $row_class; ?> mhs-row">
                        <td><?php echo $no++; ?></td>
                        <td class="nim-col"><?php echo htmlspecialchars($d['nim']); ?></td>
                        <td class="text-left font-weight-bold nama-col">
                          <?php echo htmlspecialchars($d['mhs_nama']); ?>
                          <?php if ($row_class): ?>
                            <br><small class="text-danger font-italic"><i class="fas fa-exclamation-triangle"></i> Kuota Pembimbing Bermasalah</small>
                          <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($d['nm_pem']); ?></td>
                        <td>
                          <?php
                          $st_class = ['proses' => 'badge-warning', 'revisi' => 'badge-danger', 'diterima' => 'badge-success'];
                          $st_label = ['proses' => 'Review', 'revisi' => 'Revisi', 'diterima' => 'Diterima'];
                          $cls = $st_class[$d['status_bimtek']] ?? 'badge-secondary';
                          $lab = $st_label[$d['status_bimtek']] ?? $d['status_bimtek'];
                          echo "<span class='badge $cls px-2 py-1'>$lab</span>";
                          ?>
                          <div class="xsmall text-muted mt-1"><?php echo htmlspecialchars($d['nama_bimtek']); ?></div>
                        </td>
                        <td class="text-left" style="min-width: 180px;">
                          <?php if ($d['saran1_nama']): ?>
                            <div class="mb-1"><i class="fas fa-user-tie text-primary mr-1"></i><b><?php echo htmlspecialchars($d['saran1_nama']); ?></b></div>
                            <?php
                            $s1_total_k = (int)$d['s1_k1'] + (int)$d['s1_k2'];
                            $s1_perc = ($s1_total_k > 0) ? round(($s1_real / $s1_total_k) * 100) : 0;
                            $s1_bar_class = 'bg-success';
                            if ($s1_perc >= 100) $s1_bar_class = 'bg-danger';
                            elseif ($s1_perc >= 80) $s1_bar_class = 'bg-warning';
                            ?>
                            <div class="progress mb-1" style="height: 12px; border-radius: 6px;" title="Terisi: <?php echo $s1_real; ?> / <?php echo $s1_total_k; ?>">
                              <div class="progress-bar <?php echo $s1_bar_class; ?>" role="progressbar" style="width: <?php echo min(100, $s1_perc); ?>%" aria-valuenow="<?php echo $s1_perc; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between small px-1">
                              <span class="text-muted">K: <?php echo (int)$d['s1_k1'] + (int)$d['s1_k2']; ?></span>
                              <a href="javascript:void(0)" class="font-weight-bold btn-lihat-bimbingan <?php echo ($s1_perc >= 100) ? 'text-danger' : 'text-primary'; ?>" data-nip="<?php echo $d['pembimbing_saran_1']; ?>" data-nama="<?php echo htmlspecialchars($d['saran1_nama']); ?>" style="text-decoration: underline;" title="Klik untuk melihat mahasiswa">T: <?php echo $s1_real; ?></a>
                            </div>
                          <?php else: ?>
                            <span class="text-muted">-</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-left" style="min-width: 180px;">
                          <?php if ($d['saran2_nama']): ?>
                            <div class="mb-1"><i class="fas fa-user-tie text-secondary mr-1"></i><b><?php echo htmlspecialchars($d['saran2_nama']); ?></b></div>
                            <?php
                            $s2_total_k = (int)$d['s2_k1'] + (int)$d['s2_k2'];
                            $s2_perc = ($s2_total_k > 0) ? round(($s2_real / $s2_total_k) * 100) : 0;
                            $s2_bar_class = 'bg-success';
                            if ($s2_perc >= 100) $s2_bar_class = 'bg-danger';
                            elseif ($s2_perc >= 80) $s2_bar_class = 'bg-warning';
                            ?>
                            <div class="progress mb-1" style="height: 12px; border-radius: 6px;" title="Terisi: <?php echo $s2_real; ?> / <?php echo $s2_total_k; ?>">
                              <div class="progress-bar <?php echo $s2_bar_class; ?>" role="progressbar" style="width: <?php echo min(100, $s2_perc); ?>%" aria-valuenow="<?php echo $s2_perc; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between small px-1">
                              <span class="text-muted">K: <?php echo (int)$d['s2_k1'] + (int)$d['s2_k2']; ?></span>
                              <a href="javascript:void(0)" class="font-weight-bold btn-lihat-bimbingan <?php echo ($s2_perc >= 100) ? 'text-danger' : 'text-primary'; ?>" data-nip="<?php echo $d['pembimbing_saran_2']; ?>" data-nama="<?php echo htmlspecialchars($d['saran2_nama']); ?>" style="text-decoration: underline;" title="Klik untuk melihat mahasiswa">T: <?php echo $s2_real; ?></a>
                            </div>
                          <?php else: ?>
                            <span class="text-muted">-</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php
                          // Cek apakah sudah terdata di pengelompokan_dospem_skripsi
                          $cek_exists = mysqli_query($con, "SELECT id FROM pengelompokan_dospem_skripsi WHERE nim='$d[nim]' AND (status='2' OR status='3') LIMIT 1");
                          if (mysqli_num_rows($cek_exists) > 0) {
                            echo '<span class="badge badge-success mb-1 d-block"><i class="fas fa-check-circle"></i> Sudah Terdata</span>';
                            echo '<button type="button" class="btn btn-xs btn-outline-danger btn-cancel-approve" 
                                      data-nim="' . $d['nim'] . '" 
                                      data-nama="' . htmlspecialchars($d['mhs_nama']) . '">
                                      <i class="fas fa-undo"></i> Batalkan
                                    </button>';
                          } else {
                            if ($d['status_bimtek'] == 'diterima') {
                              // Selalu tampilkan tombol Detail/Tentukan agar Kaprodi bisa memilihkan
                              $btn_label = ($d['pembimbing_saran_1'] || $d['pembimbing_saran_2']) ? 'Detail & Edit' : 'Tentukan Pembimbing';
                              $btn_class = ($d['pembimbing_saran_1'] || $d['pembimbing_saran_2']) ? 'btn-info' : 'btn-warning';

                              echo '<button type="button" class="btn btn-xs ' . $btn_class . ' btn-detail mr-1" 
                                          data-nim="' . $d['nim'] . '" 
                                          data-nama="' . htmlspecialchars($d['mhs_nama']) . '"
                                          data-idbimtek="' . $current_id_bimtek . '">
                                          <i class="fas fa-user-edit"></i> ' . $btn_label . '
                                        </button>';

                              if ($d['pembimbing_saran_1'] || $d['pembimbing_saran_2']) {
                                echo '<button type="button" class="btn btn-xs btn-success btn-approve" 
                                              data-nim="' . $d['nim'] . '" 
                                              data-nama="' . htmlspecialchars($d['mhs_nama']) . '"
                                              data-saran1="' . $d['pembimbing_saran_1'] . '" 
                                              data-s1nama="' . htmlspecialchars($d['saran1_nama']) . '"
                                              data-s1k1="' . (int)$d['s1_k1'] . '" 
                                              data-s1k2="' . (int)$d['s1_k2'] . '" 
                                              data-s1real="' . $s1_real . '"
                                              data-saran2="' . $d['pembimbing_saran_2'] . '" 
                                              data-s2nama="' . htmlspecialchars($d['saran2_nama']) . '"
                                              data-s2k1="' . (int)$d['s2_k1'] . '" 
                                              data-s2k2="' . (int)$d['s2_k2'] . '" 
                                              data-s2real="' . $s2_real . '"
                                              data-idbimtek="' . $current_id_bimtek . '">
                                              <i class="fas fa-check"></i> Setujui & Data
                                            </button>';
                              }
                            } else {
                              echo '<button type="button" class="btn btn-xs btn-outline-info btn-detail" 
                                          data-nim="' . $d['nim'] . '" 
                                          data-nama="' . htmlspecialchars($d['mhs_nama']) . '"
                                          data-idbimtek="' . $current_id_bimtek . '">
                                          <i class="fas fa-search"></i> Cek Progres
                                        </button>';
                            }
                          }
                          ?>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($q_list) == 0): ?>
                      <tr>
                        <td colspan="7" class="text-center text-muted py-3">Belum ada data saran pembimbing untuk periode ini.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>
  </div>

  <!-- Modal Jurnal Dosen -->
  <div class="modal fade" id="modalJurnalDosen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white"><i class="fas fa-book mr-1"></i> Rekam Jejak Dosen (Publikasi & Penelitian)</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0">
          <div class="p-2 bg-light border-bottom">
            <input type="text" id="searchJurnalDosen" class="form-control form-control-sm" placeholder="Cari nama dosen, NIP, penelitian, atau publikasi...">
          </div>
          <div class="p-2" style="max-height: 70vh; overflow-y: auto;">
            <div class="accordion" id="accordionJurnalDosen">
                <?php
                $csvFile = 'assets/jurnaldosen.csv';
                if (file_exists($csvFile)) {
                  $handle = fopen($csvFile, "r");
                  if ($handle !== FALSE) {
                    $row = 0;
                    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                      if ($row == 0) { // Skip header
                        $row++;
                        continue;
                      }
                      $nama = htmlspecialchars($data[0] ?? '-');
                      $nip = htmlspecialchars($data[1] ?? '-');

                      $publikasi_raw = htmlspecialchars($data[2] ?? '-');
                      $publikasi_list = array_filter(array_map('trim', explode(';', $publikasi_raw)));
                      $publikasi = '<ul class="pl-3 mb-0 small">';
                      foreach ($publikasi_list as $pub) {
                        $publikasi .= '<li class="mb-1" style="border-bottom: 1px dashed #eee; padding-bottom: 4px;">' . $pub . '</li>';
                      }
                      $publikasi .= '</ul>';

                      $penelitian_raw = htmlspecialchars($data[3] ?? '-');
                      $penelitian_list = array_filter(array_map('trim', explode(';', $penelitian_raw)));
                      $penelitian = '<ul class="pl-3 mb-0 small">';
                      foreach ($penelitian_list as $pen) {
                        $penelitian .= '<li class="mb-1" style="border-bottom: 1px dashed #eee; padding-bottom: 4px;">' . $pen . '</li>';
                      }
                      $penelitian .= '</ul>';

                      echo '
                      <div class="card mb-1 jurnal-row">
                        <div class="card-header p-1 bg-white" id="headingDosen'.$row.'">
                          <h6 class="mb-0">
                            <button class="btn btn-link btn-block text-left text-dark font-weight-bold text-decoration-none" type="button" data-toggle="collapse" data-target="#collapseDosen'.$row.'" aria-expanded="false" aria-controls="collapseDosen'.$row.'">
                              <i class="fas fa-user-tie mr-2 text-primary"></i>'.$nama.' <small class="text-muted ml-1">(NIP: '.$nip.')</small>
                            </button>
                          </h6>
                        </div>

                        <div id="collapseDosen'.$row.'" class="collapse" aria-labelledby="headingDosen'.$row.'" data-parent="#accordionJurnalDosen">
                          <div class="card-body p-3 bg-light">
                            <div class="row">
                              <div class="col-md-6 border-right">
                                <h6 class="text-info font-weight-bold border-bottom pb-1 mb-2"><i class="fas fa-book-open mr-1"></i>Publikasi</h6>
                                '.$publikasi.'
                              </div>
                              <div class="col-md-6">
                                <h6 class="text-success font-weight-bold border-bottom pb-1 mb-2"><i class="fas fa-flask mr-1"></i>Penelitian</h6>
                                '.$penelitian.'
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>';
                      $row++;
                    }
                    fclose($handle);
                    if ($row == 1) {
                      echo "<div class='alert alert-warning text-center m-3'>Data kosong</div>";
                    }
                  } else {
                    echo "<div class='alert alert-danger text-center m-3'>Gagal membaca file CSV</div>";
                  }
                } else {
                  echo "<div class='alert alert-danger text-center m-3'>File CSV tidak ditemukan</div>";
                }
                ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Detail -->
  <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title"><i class="fas fa-info-circle mr-1"></i> Detail Hasil Bimtek & Saran Pembimbing</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="detailContent">
          <div class="text-center py-4">
            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
            <p class="mt-2 text-muted">Memuat data...</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-sm" id="btnSaveDetail"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
          <button type="button" class="btn btn-success btn-sm" id="btnApproveDetail"><i class="fas fa-check-circle mr-1"></i> Setujui & Data</button>
        </div>
      </div>
    </div>
  </div>

  <?php include("footerAdm.php");
  include("jsAdm.php"); ?>
  <script>
    function escapeHTML(str) {
      if (str === null || str === undefined) return "";
      const s = String(str);
      return s.replace(/[&<>"']/g, function(m) {
        return {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#39;'
        } [m];
      });
    }

    $(document).on('click', '.btn-approve', function() {
      const nim = $(this).data('nim');
      const nama = $(this).data('nama');
      const saran1 = $(this).data('saran1');
      const s1nama = $(this).data('s1nama');
      const s1k1 = parseInt($(this).data('s1k1') || 0);
      const s1k2 = parseInt($(this).data('s1k2') || 0);
      const s1real = parseInt($(this).data('s1real') || 0);

      const saran2 = $(this).data('saran2');
      const s2nama = $(this).data('s2nama');
      const s2k1 = parseInt($(this).data('s2k1') || 0);
      const s2k2 = parseInt($(this).data('s2k2') || 0);
      const s2real = parseInt($(this).data('s2real') || 0);

      const idBimtek = $(this).data('idbimtek');

      if (saran1 && saran2 && saran1 == saran2) {
        Swal.fire('Peringatan!', 'Dosen Pembimbing 1 dan Dosen Pembimbing 2 tidak boleh sama.', 'warning');
        return;
      }

      // Cek Kuota Penuh
      let warningMsg = "";
      if (saran1 && s1real >= (s1k1 + s1k2)) {
        warningMsg += `<li><b>${s1nama}</b> (Saran 1) sudah mencapai batas kuota (${s1real}/${s1k1 + s1k2}).</li>`;
      }
      if (saran2 && s2real >= (s2k1 + s2k2)) {
        warningMsg += `<li><b>${s2nama}</b> (Saran 2) sudah mencapai batas kuota (${s2real}/${s2k1 + s2k2}).</li>`;
      }

      const proceedApproval = () => {
        Swal.fire({
          title: 'Setujui Saran Pembimbing?',
          html: `Apakah Anda yakin ingin menyetujui saran pembimbing untuk <b>${nama}</b> (${nim})?<br><br>Mahasiswa akan langsung terdaftar di sistem Skripsi dengan pembimbing tersebut.`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, Setujui!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            executeApprove(nim, saran1, saran2, idBimtek);
          }
        });
      };

      if (warningMsg !== "") {
        Swal.fire({
          title: 'Kuota Dosen Penuh!',
          html: `<div class="text-left small">Peringatan: <ul class="mt-2">${warningMsg}</ul></div><br>Apakah Anda tetap ingin <b>menambahkan secara paksa</b> pembimbing ini?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, Tambahkan Paksa!',
          cancelButtonText: 'Batalkan'
        }).then((result) => {
          if (result.isConfirmed) {
            executeApprove(nim, saran1, saran2, idBimtek);
          }
        });
      } else {
        proceedApproval();
      }
    });

    function executeApprove(nim, saran1, saran2, idBimtek) {
      $.ajax({
        url: 'sApproveSaranPembimbingBimtek.php',
        type: 'POST',
        data: {
          nim: nim,
          saran1: saran1,
          saran2: saran2,
          id_bimtek: idBimtek
        },
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            Swal.fire({
              title: 'Berhasil!',
              text: response.message,
              icon: 'success'
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Gagal!', response.message, 'error');
          }
        },
        error: function() {
          Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
        }
      });
    }

    // Detail Button Click
    $(document).on('click', '.btn-detail', function() {
      const nim = $(this).data('nim');
      const idBimtek = $(this).data('idbimtek');
      const nama = $(this).data('nama');

      $('#modalDetail').modal('show');
      $('#detailContent').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i><p class="mt-2 text-muted">Memuat data...</p></div>');
      $('#btnSaveDetail, #btnApproveDetail').prop('disabled', true);
      $('#btnApproveDetail').show(); // Reset visibility

      $.ajax({
        url: 'getBimtekDetail.php',
        type: 'GET',
        data: {
          nim: nim,
          id_bimtek: idBimtek
        },
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            const d = response.data;
            const advisors = response.advisors;
            // Simpan data dospem ke global atau data attribute modal untuk dicheck nanti
            $('#modalDetail').data('advisors', advisors);

            let advOptions1 = '<option value="">- Pilih Dospem 1 -</option>';
            let advOptions2 = '<option value="">- Pilih Dospem 2 -</option>';

            advisors.forEach(adv => {
              const sel1 = (adv.nip == d.pembimbing_saran_1) ? 'selected' : '';
              const sel2 = (adv.nip == d.pembimbing_saran_2) ? 'selected' : '';
              const quotaInfo = ` (K: ${adv.kuota1}/${adv.kuota2}, T: ${adv.real})`;
              advOptions1 += `<option value="${adv.nip}" ${sel1}>${adv.nama}${quotaInfo}</option>`;
              advOptions2 += `<option value="${adv.nip}" ${sel2}>${adv.nama}${quotaInfo}</option>`;
            });

            let html = `
              <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="bg-light p-2 border rounded">
                    <h6 class="font-weight-bold mb-1 text-primary">Informasi Mahasiswa</h6>
                    <table class="table table-sm table-borderless m-0 small">
                      <tr><td width="120">NIM / Nama</td><td>: ${escapeHTML(nim)} / ${escapeHTML(nama)}</td></tr>
                      <tr>
                        <td>Status Bimtek</td>
                        <td>: 
                            ${(function() {
                                if (d.status === 'proses') return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Sedang Direview: Menunggu penilaian reviewer.</span>';
                                if (d.status === 'revisi') return '<span class="badge badge-danger"><i class="fas fa-exclamation-circle mr-1"></i> Perlu Revisi: Mahasiswa sedang melakukan perbaikan.</span>';
                                if (d.status === 'diterima') return '<span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Lolos Review: Siap untuk ditentukan pembimbing.</span>';
                                return escapeHTML(d.status);
                            })()}
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="col-md-6 border-right">
                  <h6 class="font-weight-bold text-info border-bottom pb-1">Review Hasil Bimtek</h6>
                  <div id="review-status-container" class="mb-2"></div>

                  <div class="mb-2">
                    <label class="small mb-0 font-weight-bold">Judul Proposal:</label>
                    <p class="small bg-light p-2 border rounded m-0">${escapeHTML(d.judul) || '-'}</p>
                  </div>
                  <div class="mb-2">
                    <label class="small mb-0 font-weight-bold">Abstrak:</label>
                    <div class="small bg-light p-2 border rounded" style="max-height: 120px; overflow-y: auto;">${escapeHTML(d.abstrak) || '-'}</div>
                  </div>
                  <div class="row small mb-2">
                    <div class="col-6">
                        <label class="mb-0 font-weight-bold">Reviewer:</label><br>
                        <span class="text-muted"><i class="fas fa-user-shield mr-1"></i>${escapeHTML(d.reviewer_nama) || 'Belum Ditentukan'}</span>
                    </div>
                    <div class="col-6">
                        <label class="mb-0 font-weight-bold">Nilai Akhir:</label><br>
                        <span class="badge ${parseFloat(d.nilai_akhir) > 0 ? 'badge-primary' : 'badge-secondary'} px-2">${escapeHTML(d.nilai_akhir) || '0.00'}</span>
                    </div>
                  </div>
                  
                  <div class="mt-2 small ${d.status === 'proses' ? 'text-muted' : ''}">
                    <label class="font-weight-bold mb-1">Rincian Nilai:</label>
                    <table class="table table-bordered table-sm text-center m-0" style="font-size: 0.8rem;">
                      <tr class="bg-light"><td>A1</td><td>A2</td><td>A3</td><td>A4</td><td>A5</td><td>A6</td></tr>
                      <tr>
                        <td>${escapeHTML(d.a1)}</td>
                        <td>${escapeHTML(d.a2)}</td>
                        <td>${escapeHTML(d.a3)}</td>
                        <td>${escapeHTML(d.a4)}</td>
                        <td>${escapeHTML(d.a5)}</td>
                        <td>${escapeHTML(d.a6)}</td>
                      </tr>
                    </table>
                    ${d.status === 'proses' ? '<div class="xsmall italic mt-1">* Nilai akan muncul setelah proses review selesai.</div>' : ''}
                  </div>
                  
                  <div id="catatan-reviewer-placeholder"></div>
                </div>
                <div class="col-md-6">
                  <h6 class="font-weight-bold text-success border-bottom pb-1">Saran Pembimbing</h6>
                  <form id="formUpdateSaran">
                    <input type="hidden" name="nim" value="${escapeHTML(nim)}">
                    <input type="hidden" name="id_bimtek" value="${escapeHTML(idBimtek)}">
                    <div class="form-group mb-2">
                      <label class="small font-weight-bold">Dosen Pembimbing 1:</label>
                      <select name="saran1" class="form-control form-control-sm select2-adv" required>
                        ${advOptions1}
                      </select>
                      <div id="quota-info-1" class="mt-1"></div>
                    </div>
                    <div class="form-group mb-2">
                      <label class="small font-weight-bold">Dosen Pembimbing 2:</label>
                      <select name="saran2" class="form-control form-control-sm select2-adv">
                        ${advOptions2}
                      </select>
                      <div id="quota-info-2" class="mt-1"></div>
                    </div>
                    <p class="small text-muted mt-3"><i class="fas fa-info-circle mr-1"></i> Perubahan di sini akan memperbarui data Bimtek mahasiswa.</p>
                    <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#modalJurnalDosen">
                  <i class="fas fa-book"></i> Rekam Jejak Dosen
                </button>
                  </form>
                </div>
              </div>
            `;
            $('#detailContent').html(html);

            // Isi catatan reviewer secara aman jika ada
            if (d.catatan) {
              let catatanHtml = `
                  <div class="mt-3 small border-top pt-2">
                    <label class="font-weight-bold mb-0 text-danger"><i class="fas fa-comment-dots mr-1"></i> Catatan Reviewer:</label>
                    <div id="catatan-content-inner" class="p-2 bg-light border rounded mt-1" style="max-height: 80px; overflow-y: auto;"></div>
                  </div>
                `;
              $('#catatan-reviewer-placeholder').html(catatanHtml);
              $('#catatan-content-inner').html(d.catatan);
            }

            if (d.status === 'diterima') {
              $('#btnSaveDetail').show().prop('disabled', false);
              $('#btnApproveDetail').show().prop('disabled', false);
              $('select[name="saran1"], select[name="saran2"]').prop('disabled', false);
            } else {
              $('#btnSaveDetail').hide();
              $('#btnApproveDetail').hide();
              $('select[name="saran1"], select[name="saran2"]').prop('disabled', true);
              $('#formUpdateSaran').append('<div class="alert alert-warning mt-3 small p-2 mb-0"><i class="fas fa-exclamation-triangle mr-1"></i> Penentuan dospem hanya bisa dilakukan jika status mahasiswa sudah <b>Diterima</b>.</div>');
            }

            // Inisialisasi Select2 untuk dropdown di dalam modal
            $('.select2-adv').select2({
              theme: 'bootstrap4',
              dropdownParent: $('#modalDetail')
            });

            // Fungsi untuk update info kuota di modal
            const updateQuotaBadge = (selectName, targetId) => {
              const nip = $(`select[name="${selectName}"]`).val();
              const adv = advisors.find(a => a.nip == nip);
              const target = $(`#${targetId}`);

              if (adv) {
                const totalQuota = adv.kuota1 + adv.kuota2;
                const isFull = adv.real >= totalQuota;
                const badgeClass = isFull ? 'badge-danger' : 'badge-light border';
                const textClass = isFull ? 'text-white' : 'text-dark';

                target.html(`
                  <div class="small">
                    <span class="badge ${badgeClass} ${textClass}">Kuota (I/II): ${adv.kuota1} / ${adv.kuota2}</span>
                    <span class="badge badge-info ml-1">Terisi: ${adv.real}</span>
                    ${isFull ? '<span class="text-danger font-weight-bold ml-1">! PENUH</span>' : ''}
                  </div>
                `);
              } else {
                target.html('');
              }
            };

            // Update saat pertama kali load
            updateQuotaBadge('saran1', 'quota-info-1');
            updateQuotaBadge('saran2', 'quota-info-2');

            // Update saat ganti pilihan
            $('select[name="saran1"]').on('change', function() {
              updateQuotaBadge('saran1', 'quota-info-1');
            });
            $('select[name="saran2"]').on('change', function() {
              updateQuotaBadge('saran2', 'quota-info-2');
            });

            // Set data properties for buttons
            $('#btnApproveDetail').data('nim', nim);
            $('#btnApproveDetail').data('nama', nama);
            $('#btnApproveDetail').data('idbimtek', idBimtek);
          } else {
            $('#detailContent').html('<div class="alert alert-danger">' + response.message + '</div>');
          }
        },
        error: function() {
          $('#detailContent').html('<div class="alert alert-danger">Gagal memuat data.</div>');
        }
      });
    });

    // Save Detail Changes
    $('#btnSaveDetail').on('click', function() {
      const saran1 = $('select[name="saran1"]').val();
      const saran2 = $('select[name="saran2"]').val();
      if (saran1 && saran2 && saran1 === saran2) {
        Swal.fire('Peringatan!', 'Dosen Pembimbing 1 dan Dosen Pembimbing 2 tidak boleh sama.', 'warning');
        return;
      }

      const formData = $('#formUpdateSaran').serialize();
      $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

      $.ajax({
        url: 'sUpdateSaranPembimbingBimtek.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            Swal.fire('Berhasil!', response.message, 'success').then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Gagal!', response.message, 'error');
            $('#btnSaveDetail').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Perubahan');
          }
        },
        error: function() {
          Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
          $('#btnSaveDetail').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Perubahan');
        }
      });
    });

    // Approve from Detail Modal
    $('#btnApproveDetail').on('click', function() {
      const nim = $(this).data('nim');
      const nama = $(this).data('nama');
      const idBimtek = $(this).data('idbimtek');
      const saran1 = $('select[name="saran1"]').val();
      const saran2 = $('select[name="saran2"]').val();
      const advisors = $('#modalDetail').data('advisors') || [];

      if (!saran1) {
        Swal.fire('Peringatan!', 'Dosen Pembimbing 1 harus dipilih.', 'warning');
        return;
      }

      if (saran2 && saran1 === saran2) {
        Swal.fire('Peringatan!', 'Dosen Pembimbing 1 dan Dosen Pembimbing 2 tidak boleh sama.', 'warning');
        return;
      }

      // Cek Kuota
      let warningMsg = "";
      const d1 = advisors.find(a => a.nip == saran1);
      if (d1 && d1.real >= (d1.kuota1 + d1.kuota2)) {
        warningMsg += `<li><b>${d1.nama}</b> (Saran 1) sudah mencapai batas kuota (${d1.real}/${d1.kuota1 + d1.kuota2}).</li>`;
      }

      const d2 = advisors.find(a => a.nip == saran2);
      if (saran2 && d2 && d2.real >= (d2.kuota1 + d2.kuota2)) {
        warningMsg += `<li><b>${d2.nama}</b> (Saran 2) sudah mencapai batas kuota (${d2.real}/${d2.kuota1 + d2.kuota2}).</li>`;
      }

      const proceedApprovalModal = () => {
        Swal.fire({
          title: 'Setujui Saran Pembimbing?',
          html: `Apakah Anda yakin ingin menyetujui saran pembimbing untuk <b>${nama}</b> (${nim})?<br><br>Mahasiswa akan langsung terdaftar di sistem Skripsi dengan pembimbing tersebut.`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, Setujui!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            executeApprove(nim, saran1, saran2, idBimtek);
          }
        });
      };

      if (warningMsg !== "") {
        Swal.fire({
          title: 'Kuota Dosen Penuh!',
          html: `<div class="text-left small">Peringatan: <ul class="mt-2">${warningMsg}</ul></div><br>Apakah Anda tetap ingin <b>menambahkan secara paksa</b> pembimbing ini?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, Tambahkan Paksa!',
          cancelButtonText: 'Batalkan'
        }).then((result) => {
          if (result.isConfirmed) {
            executeApprove(nim, saran1, saran2, idBimtek);
          }
        });
      } else {
        proceedApprovalModal();
      }
    });

    // Cancel Approve
    $(document).on('click', '.btn-cancel-approve', function() {
      const nim = $(this).data('nim');
      const nama = $(this).data('nama');

      Swal.fire({
        title: 'Batalkan Persetujuan?',
        html: `Apakah Anda yakin ingin membatalkan persetujuan untuk <b>${nama}</b>?<br><br><small class="text-danger">Tindakan ini akan menghapus data mahasiswa dari periode pengajuan dospem aktif.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Batalkan!',
        cancelButtonText: 'Tutup'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'sCancelApproveSaranPembimbingBimtek.php',
            type: 'POST',
            data: {
              nim: nim
            },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                Swal.fire('Dibatalkan!', response.message, 'success').then(() => {
                  location.reload();
                });
              } else {
                Swal.fire('Gagal!', response.message, 'error');
              }
            },
            error: function() {
              Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
            }
          });
        }
      });
    });

    // Real-time Search
    $("#tableSearch").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".mhs-row").filter(function() {
        var nim = $(this).find(".nim-col").text().toLowerCase();
        var nama = $(this).find(".nama-col").text().toLowerCase();
        $(this).toggle(nim.indexOf(value) > -1 || nama.indexOf(value) > -1)
      });
    });

    // Real-time Search Jurnal Dosen
    $("#searchJurnalDosen").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#accordionJurnalDosen .jurnal-row").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    // Fix multiple modals overlap z-index issue
    $(document).on('show.bs.modal', '.modal', function () {
      var zIndex = 1040 + (10 * $('.modal:visible').length);
      $(this).css('z-index', zIndex);
      setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
      }, 0);
    });

    // Fix body scroll when inner modal is closed but outer modal is still open
    $(document).on('hidden.bs.modal', '.modal', function () {
      if ($('.modal:visible').length) {
        $(document.body).addClass('modal-open');
      }
    });

    // Lihat Daftar Bimbingan Dosen
    $(document).on('click', '.btn-lihat-bimbingan', function(e) {
      e.preventDefault();
      const nip = $(this).data('nip');
      const nama = $(this).data('nama');
      
      Swal.fire({
        title: 'Memuat Data...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
      });

      $.ajax({
        url: 'sGetDaftarBimbingan.php',
        type: 'GET',
        data: { nip: nip },
        dataType: 'json',
        success: function(res) {
          if (res.status === 'success') {
            let html = `<h6 class="text-left font-weight-bold mb-3">${nama}</h6>`;
            if (res.data.length === 0) {
              html += `<div class="alert alert-info">Belum ada mahasiswa bimbingan di periode ini.</div>`;
            } else {
              html += `<div class="table-responsive"><table class="table table-bordered table-sm text-left small">
                        <thead class="bg-light"><tr><th width="5%">No</th><th width="20%">NIM</th><th>Nama Mahasiswa</th><th width="30%">Jalur / Catatan</th><th width="10%">Aksi</th></tr></thead><tbody>`;
              res.data.forEach((m, i) => {
                const catatan = m.catatan ? m.catatan : 'Reguler/Lainnya';
                const nama = m.nama ? m.nama : '<i class="text-danger">Kosong / null</i>';
                const nim_val = m.nim ? m.nim : '<i class="text-danger">Kosong</i>';
                html += `<tr>
                          <td>${i+1}</td>
                          <td>${nim_val}</td>
                          <td>${nama}</td>
                          <td>${catatan}</td>
                          <td class="text-center">
                            <button class="btn btn-xs btn-danger btn-hapus-bimbingan" data-id="${m.id}" title="Hapus Mahasiswa Ini"><i class="fas fa-trash-alt"></i></button>
                          </td>
                         </tr>`;
              });
              html += `</tbody></table></div>`;
            }
            Swal.fire({
              title: 'Daftar Mahasiswa Bimbingan',
              html: html,
              width: '800px',
              confirmButtonText: 'Tutup'
            });
          } else {
            Swal.fire('Gagal!', res.message, 'error');
          }
        },
        error: function() {
          Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
        }
      });
    });

    // Aksi hapus mahasiswa spesifik dari modal Daftar Bimbingan
    $(document).on('click', '.btn-hapus-bimbingan', function() {
      const id = $(this).data('id');
      Swal.fire({
        title: 'Hapus Data Bimbingan?',
        html: 'Data mahasiswa ini akan dihapus dari sistem Skripsi dan beban dosen.<br>Aksi ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'sDeleteBimbingan.php',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                Swal.fire('Terhapus!', response.message, 'success').then(() => {
                  location.reload();
                });
              } else {
                Swal.fire('Gagal!', response.message, 'error');
              }
            },
            error: function() {
              Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
            }
          });
        }
      });
    });

    // Mass Reset / Batalkan Semua Persetujuan
    $('#btnResetAll').on('click', function() {
      const idBimtek = $(this).data('idbimtek');
      Swal.fire({
        title: 'Batalkan Semua Persetujuan?',
        html: `Apakah Anda yakin ingin membatalkan persetujuan Dospem untuk <b>SELURUH</b> mahasiswa pada Bimtek ini?<br><br><span class="text-danger font-weight-bold">Perhatian: Seluruh mahasiswa yang sudah di Setujui akan dihapus kembali dari sistem Skripsi. Aksi ini tidak dapat dibatalkan.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Batalkan Semua!',
        cancelButtonText: 'Kembali'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          $.ajax({
            url: 'sResetAllSaranPembimbingBimtek.php',
            type: 'POST',
            data: { id_bimtek: idBimtek },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                  location.reload();
                });
              } else {
                Swal.fire('Gagal!', response.message, 'error');
              }
            },
            error: function() {
              Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
            }
          });
        }
      });
    });
  </script>
</body>

</html>