<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];

// Validasi: hanya Kaprodi (jabatan_instansi = 47)
$q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
$dMe = mysqli_fetch_assoc($q_me);
if ($dMe['jabatan_instansi'] != '47') {
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
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="rekapSaranPembimbingBimtekKaprodi.php" class="btn btn-secondary btn-sm ml-2"><i class="fas fa-times"></i> Reset</a>
              </form>
            </div>
          </div>

          <!-- Tabel -->
          <div class="card card-outline card-warning">
            <div class="card-header">
              <h5 class="card-title"><i class="fas fa-user-friends"></i> Rekap Saran Dosen Pembimbing Mahasiswa</h5>
              <div class="card-tools">
                <span class="badge badge-warning">Hanya tampil yang sudah diterima dan memilih saran pembimbing</span>
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
                      <th>Periode Bimtek</th>
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

                    $where = ["pp.status='diterima'", "(pp.pembimbing_saran_1 IS NOT NULL OR pp.pembimbing_saran_2 IS NOT NULL)"];
                    if (!empty($current_id_bimtek)) $where[] = "pp.id_bimtek='" . mysqli_real_escape_string($con, $current_id_bimtek) . "'";
                    $where_sql = "WHERE " . implode(' AND ', $where);

                    $q_list = mysqli_query($con, "SELECT pp.nim, pp.pembimbing_saran_1, pp.pembimbing_saran_2,
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
                            LEFT JOIN bimtek_peserta bp ON bp.nim = pp.nim AND bp.id_bimtek = pp.id_bimtek
                            LEFT JOIN opsi_bidang_skripsi o ON bp.peminatan = o.id
                            $where_sql
                            ORDER BY b.id DESC, m.nama ASC");
                    $no = 1;
                    while ($d = mysqli_fetch_assoc($q_list)):
                      // Hitung realisasi bimbingan saat ini (status 2=proses, 3=selesai)
                      $s1_real = 0;
                      $s1_full = false;
                      $s1_zero = false;
                      if($d['pembimbing_saran_1']) {
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
                      if($d['pembimbing_saran_2']) {
                        $q_r2 = mysqli_query($con, "SELECT COUNT(*) as total FROM pengelompokan_dospem_skripsi WHERE (dospem_skripsi1='$d[pembimbing_saran_2]' OR dospem_skripsi2='$d[pembimbing_saran_2]') AND id_periode='$active_period_id' AND status IN ('2','3')");
                        $dr2 = mysqli_fetch_assoc($q_r2);
                        $s2_real = $dr2['total'];

                        $s2_total_k = (int)$d['s2_k1'] + (int)$d['s2_k2'];
                        if ($s2_total_k == 0) $s2_zero = true;
                        if ($s2_total_k > 0 && $s2_real >= $s2_total_k) $s2_full = true;
                      }

                      $row_class = ($s1_full || $s1_zero || $s2_full || $s2_zero) ? 'table-danger' : '';
                    ?>
                      <tr class="<?php echo $row_class; ?>">
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['nim']; ?></td>
                        <td class="text-left font-weight-bold">
                          <?php echo $d['mhs_nama']; ?>
                          <?php if($row_class): ?>
                            <br><small class="text-danger font-italic"><i class="fas fa-exclamation-triangle"></i> Kuota Pembimbing Bermasalah</small>
                          <?php endif; ?>
                        </td>
                        <td><?php echo $d['nm_pem']; ?></td>
                        <td class="small text-muted"><?php echo $d['nama_bimtek']; ?></td>
                        <td class="text-left">
                          <?php if ($d['saran1_nama']): ?>
                            <div class="mb-1"><i class="fas fa-user-tie text-warning mr-1"></i><?php echo $d['saran1_nama']; ?></div>
                            <div class="">
                              <span class="badge <?php echo ($s1_zero || $s1_full) ? 'badge-danger' : 'badge-light border'; ?> text-dark py-1 px-2" style="font-size: 0.9rem;" title="Kuota Aktif (I / II)">K: <?php echo (int)$d['s1_k1']; ?> / <?php echo (int)$d['s1_k2']; ?></span>
                              <span class="badge badge-info ml-1 py-1 px-2" style="font-size: 0.9rem;" title="Total Bimbingan Terisi">T: <?php echo $s1_real; ?></span>
                            </div>
                          <?php else: ?>
                            <span class="text-muted">-</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-left">
                          <?php if ($d['saran2_nama']): ?>
                            <div class="mb-1"><i class="fas fa-user-tie text-warning mr-1"></i><?php echo $d['saran2_nama']; ?></div>
                            <div class="">
                              <span class="badge <?php echo ($s2_zero || $s2_full) ? 'badge-danger' : 'badge-light border'; ?> text-dark py-1 px-2" style="font-size: 0.9rem;" title="Kuota Aktif (I / II)">K: <?php echo (int)$d['s2_k1']; ?> / <?php echo (int)$d['s2_k2']; ?></span>
                              <span class="badge badge-info ml-1 py-1 px-2" style="font-size: 0.9rem;" title="Total Bimbingan Terisi">T: <?php echo $s2_real; ?></span>
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
                                      data-nim="'.$d['nim'].'" 
                                      data-nama="'.htmlspecialchars($d['mhs_nama']).'">
                                      <i class="fas fa-undo"></i> Batalkan
                                    </button>';
                          } else {
                              if ($d['pembimbing_saran_1'] || $d['pembimbing_saran_2']) {
                                  echo '<button type="button" class="btn btn-xs btn-info btn-detail mr-1" 
                                          data-nim="'.$d['nim'].'" 
                                          data-nama="'.htmlspecialchars($d['mhs_nama']).'"
                                          data-idbimtek="'.$current_id_bimtek.'">
                                          <i class="fas fa-eye"></i> Detail
                                        </button>';
                                  echo '<button type="button" class="btn btn-xs btn-success btn-approve" 
                                          data-nim="'.$d['nim'].'" 
                                          data-nama="'.htmlspecialchars($d['mhs_nama']).'"
                                          data-saran1="'.$d['pembimbing_saran_1'].'" 
                                          data-s1nama="'.htmlspecialchars($d['saran1_nama']).'"
                                          data-s1k1="'.(int)$d['s1_k1'].'" 
                                          data-s1k2="'.(int)$d['s1_k2'].'" 
                                          data-s1real="'.$s1_real.'"
                                          data-saran2="'.$d['pembimbing_saran_2'].'" 
                                          data-s2nama="'.htmlspecialchars($d['saran2_nama']).'"
                                          data-s2k1="'.(int)$d['s2_k1'].'" 
                                          data-s2k2="'.(int)$d['s2_k2'].'" 
                                          data-s2real="'.$s2_real.'"
                                          data-idbimtek="'.$current_id_bimtek.'">
                                          <i class="fas fa-check"></i> Setujui & Data
                                        </button>';
                              } else {
                                  echo '<span class="text-muted small">Belum ada saran</span>';
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
            proceedApproval();
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

      $.ajax({
        url: 'getBimtekDetail.php',
        type: 'GET',
        data: { nim: nim, id_bimtek: idBimtek },
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
                      <tr><td width="120">NIM / Nama</td><td>: ${nim} / ${nama}</td></tr>
                    </table>
                  </div>
                </div>
                <div class="col-md-6 border-right">
                  <h6 class="font-weight-bold text-info border-bottom pb-1">Review Hasil Bimtek</h6>
                  <div class="mb-2">
                    <label class="small mb-0 font-weight-bold">Judul Proposal:</label>
                    <p class="small bg-light p-2 border rounded">${d.judul || '-'}</p>
                  </div>
                  <div class="mb-2">
                    <label class="small mb-0 font-weight-bold">Abstrak:</label>
                    <div class="small bg-light p-2 border rounded" style="max-height: 150px; overflow-y: auto;">${d.abstrak || '-'}</div>
                  </div>
                  <div class="row small">
                    <div class="col-6"><label class="mb-0 font-weight-bold">Reviewer:</label><br>${d.reviewer_nama || '-'}</div>
                    <div class="col-6"><label class="mb-0 font-weight-bold">Nilai Akhir:</label><br><span class="badge badge-info">${d.nilai_akhir || '0'}</span></div>
                  </div>
                  <div class="mt-2 small">
                    <label class="font-weight-bold mb-1">Rincian Nilai:</label>
                    <table class="table table-bordered table-sm text-center m-0">
                      <tr class="bg-light"><td>A1</td><td>A2</td><td>A3</td><td>A4</td><td>A5</td><td>A6</td></tr>
                      <tr><td>${d.a1}</td><td>${d.a2}</td><td>${d.a3}</td><td>${d.a4}</td><td>${d.a5}</td><td>${d.a6}</td></tr>
                    </table>
                  </div>
                </div>
                <div class="col-md-6">
                  <h6 class="font-weight-bold text-success border-bottom pb-1">Saran Pembimbing</h6>
                  <form id="formUpdateSaran">
                    <input type="hidden" name="nim" value="${nim}">
                    <input type="hidden" name="id_bimtek" value="${idBimtek}">
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
                  </form>
                </div>
              </div>
            `;
            $('#detailContent').html(html);
            $('#btnSaveDetail, #btnApproveDetail').prop('disabled', false);

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
            $('select[name="saran1"]').on('change', function() { updateQuotaBadge('saran1', 'quota-info-1'); });
            $('select[name="saran2"]').on('change', function() { updateQuotaBadge('saran2', 'quota-info-2'); });
            
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
          title: 'Setujui & Daftarkan?',
          html: `Apakah Anda yakin ingin menyetujui dan mendaftarkan <b>${nama}</b> ke sistem Skripsi dengan pembimbing yang dipilih?`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          confirmButtonText: 'Ya, Daftarkan!',
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
            proceedApprovalModal();
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
            data: { nim: nim },
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
  </script>
</body>

</html>
