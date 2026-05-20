<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];
$id_bimtek = isset($_GET['id_bimtek']) ? mysqli_real_escape_string($con, $_GET['id_bimtek']) : '';

// Get peserta record (must have reviewer)
$q_peserta = mysqli_query($con, "SELECT bp.*, p.nama as reviewer_nama, b.nama_bimtek
    FROM bimtek_peserta bp 
    JOIN bimtek_pendaftaran b ON bp.id_bimtek = b.id
    LEFT JOIN dt_pegawai p ON bp.id_reviewer = p.id
    WHERE bp.nim='$username' AND bp.id_bimtek='$id_bimtek' AND bp.id_reviewer != '' AND bp.id_reviewer IS NOT NULL
    ORDER BY bp.id DESC LIMIT 1");
$d_peserta = mysqli_fetch_assoc($q_peserta);

if (!$d_peserta) {
  header("location:listPraPropBimtekUser.php");
  exit();
}

// Get existing pra proposal
$q_prop = mysqli_query($con, "SELECT * FROM bimtek_pra_proposal WHERE nim='$username' AND id_bimtek='$id_bimtek'");
$d_prop = mysqli_fetch_assoc($q_prop);

// Get list of lecturers for suggestions with their specialization
$q_dosen = mysqli_query($con, "SELECT id, nama, kepakaran_mayor FROM dt_pegawai ORDER BY nama ASC");
$lecturers = [];
while ($ld = mysqli_fetch_assoc($q_dosen)) $lecturers[] = $ld;
$mhs_peminatan = $d_peserta['peminatan'];

$errors_map = [
  'filetype'  => 'File Proposal harus berformat PDF.',
  'filesize'  => 'Ukuran file Proposal maksimal 5MB.',
  'filetypesert' => 'File Sertifikat harus berformat PDF.',
  'filesizesert' => 'Ukuran file Sertifikat maksimal 5MB.',
  'nofile'    => 'File wajib diunggah.',
  'notrevisi' => 'Proposal sudah diproses, tidak bisa diubah.',
  'invalid'   => 'Data tidak valid.',
];
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include("navtopAdm.php");
    include("navSideBarUserS1.php"); ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Pra Proposal Bimtek</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="listPraPropBimtekUser.php">Pra Proposal Bimtek</a></li>
                <li class="breadcrumb-item active">Detail</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">

              <!-- Info Reviewer -->
              <div class="card card-outline card-info mb-3">
                <div class="card-header">
                  <h5 class="card-title">Informasi Bimtek</h5>
                </div>
                <div class="card-body">
                  <table class="table table-sm table-borderless mb-0">
                    <tr>
                      <th width="200">Periode Bimtek</th>
                      <td>: <?php echo $d_peserta['nama_bimtek']; ?></td>
                    </tr>
                    <tr>
                      <th>Reviewer Anda</th>
                      <td>: <strong class="text-primary"><?php echo $d_peserta['reviewer_nama']; ?></strong></td>
                    </tr>
                    <?php if ($d_prop): ?>
                      <tr>
                        <th>Status Pra Proposal</th>
                        <td>:
                          <?php
                          $badge = ['proses' => 'badge-warning', 'revisi' => 'badge-danger', 'diterima' => 'badge-success'];
                          $label = ['proses' => 'Sedang Diproses', 'revisi' => 'Perlu Revisi', 'diterima' => 'Diterima ✓'];
                          echo "<span class='badge " . $badge[$d_prop['status']] . "'>" . $label[$d_prop['status']] . "</span>";
                          ?>
                        </td>
                      </tr>
                      <?php if ($d_prop['file_sertifikat']): ?>
                        <tr>
                          <th>Status Sertifikat</th>
                          <td>:
                            <?php
                            $cs = $d_prop['status_sertifikat'] ?? 'pending';
                            $s_badge = ['pending' => 'badge-warning', 'valid' => 'badge-success', 'invalid' => 'badge-danger', 'bypassed' => 'badge-info'];
                            $s_label = ['pending' => 'Menunggu Validasi Admin', 'valid' => 'Valid ✓', 'invalid' => 'Tidak Valid ✗', 'bypassed' => 'Valid (Auto)'];
                            $bc = $s_badge[$cs] ?? 'badge-secondary';
                            $bl = $s_label[$cs] ?? $cs;
                            echo "<span class='badge " . $bc . "'>" . $bl . "</span>";
                            ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                    <?php endif; ?>
                  </table>
                </div>
              </div>

              <?php if ($d_prop && !empty($d_prop['catatan'])): ?>
                <!-- Catatan Revisi -->
                <div class="card card-outline card-danger">
                  <div class="card-header">
                    <h5 class="card-title text-danger"><i class="fas fa-comment-dots"></i> Catatan / Revisi dari Reviewer</h5>
                  </div>
                  <div class="card-body">
                    <div style="width: 100%; word-break: break-word; padding-right: 10px;">
                      <?php echo $d_prop['catatan']; ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <?php if ($d_prop && $d_prop['status_sertifikat'] == 'invalid'): ?>
                <!-- Catatan Sertifikat Invalid -->
                <div class="callout callout-danger shadow-sm">
                  <h5><i class="fas fa-certificate"></i> Sertifikat Tidak Valid</h5>
                  <p>Admin menyatakan sertifikat Anda tidak valid dengan catatan:</p>
                  <blockquote class="mb-0 border-left pl-3 ml-2" style="border-left: 3px solid #dc3545 !important;">
                    <?php echo nl2br(htmlspecialchars($d_prop['catatan_sertifikat'])); ?>
                  </blockquote>
                  <p class="mt-2 mb-0 small text-danger">Silakan unggah ulang sertifikat yang benar melalui form di bawah.</p>
                </div>
              <?php endif; ?>

              <?php if ($d_prop && $d_prop['status'] == 'diterima'): ?>
                <!-- Diterima -->
                <div class="callout callout-success shadow-sm">
                  <h5><i class="fas fa-check-circle"></i> Pra Proposal Anda Telah Diterima!</h5>
                  <p class="mb-0">Reviewer telah menyetujui pra proposal Anda. Selamat!</p>
                </div>

                <!-- Saran Dosen Pembimbing -->
                <?php 
                $has_selected = (!empty($d_prop['pembimbing_saran_1']) || !empty($d_prop['pembimbing_saran_2']));
                ?>
                <div class="card card-outline card-warning shadow-sm mb-4">
                  <div class="card-header">
                    <h5 class="card-title text-warning font-weight-bold">
                      <i class="fas fa-user-friends"></i> Saran Dosen Pembimbing
                      <?php if ($has_selected): ?>
                        <span class="badge badge-success ml-2"><i class="fas fa-check-circle"></i> Sudah Dipilih</span>
                      <?php endif; ?>
                    </h5>
                  </div>
                  <div class="card-body">
                    <form action="simpanSaranPembimbingUser.php" method="POST">
                      <input type="hidden" name="id_prop" value="<?php echo $d_prop['id']; ?>">
                      <input type="hidden" name="id_bimtek" value="<?php echo $id_bimtek; ?>">
                      <input type="hidden" name="redirect_detail" value="1">
                      <input type="hidden" class="peminatan-val" value="<?php echo $mhs_peminatan; ?>">

                      <div class="callout callout-info py-2 px-3 mb-3 border-left" style="border-left-width: 4px !important;">
                        <i class="fas fa-info-circle mr-1 text-info"></i> <strong>Disclaimer:</strong> Pemilihan ini bersifat aspirasi untuk pertimbangan plotting dan tidak bersifat mengikat.
                        <?php if ($has_selected): ?>
                          <br><span class="text-danger font-weight-bold"><i class="fas fa-lock"></i> Pilihan sudah disimpan dan tidak dapat dirubah kembali.</span>
                        <?php endif; ?>
                      </div>

                      <div class="row align-items-end">
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input toggle-rumpun" id="toggle_rumpun" <?php echo $has_selected ? 'disabled' : ''; ?>>
                            <label class="custom-control-label font-weight-bold" for="toggle_rumpun">Tampilkan dosen luar rumpun</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group mb-md-0">
                            <label class="small font-weight-bold">Pilihan 1</label>
                            <select name="pembimbing_saran_1" class="form-control select2-dosen" <?php echo $has_selected ? 'disabled' : ''; ?> required>
                              <option value="">-- Pilih Dosen 1 --</option>
                              <?php foreach ($lecturers as $l):
                                $is_same = ($l['kepakaran_mayor'] == $mhs_peminatan);
                              ?>
                                <option value="<?php echo $l['id']; ?>" data-rumpun="<?php echo $l['kepakaran_mayor']; ?>" <?php echo ($d_prop['pembimbing_saran_1'] == $l['id']) ? 'selected' : ''; ?>>
                                  <?php echo $l['nama'] . (!$is_same ? ' (Luar Rumpun)' : ''); ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group mb-md-0">
                            <label class="small font-weight-bold">Pilihan 2</label>
                            <select name="pembimbing_saran_2" class="form-control select2-dosen" <?php echo $has_selected ? 'disabled' : ''; ?>>
                              <option value="">-- Pilih Dosen 2 --</option>
                              <?php foreach ($lecturers as $l):
                                $is_same = ($l['kepakaran_mayor'] == $mhs_peminatan);
                              ?>
                                <option value="<?php echo $l['id']; ?>" data-rumpun="<?php echo $l['kepakaran_mayor']; ?>" <?php echo ($d_prop['pembimbing_saran_2'] == $l['id']) ? 'selected' : ''; ?>>
                                  <?php echo $l['nama'] . (!$is_same ? ' (Luar Rumpun)' : ''); ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <?php if (!$has_selected): ?>
                            <button type="submit" class="btn btn-warning btn-block font-weight-bold shadow-sm"><i class="fas fa-save"></i> Simpan</button>
                          <?php else: ?>
                            <button type="button" class="btn btn-secondary btn-block disabled font-weight-bold" disabled><i class="fas fa-lock"></i> Terkunci</button>
                          <?php endif; ?>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h5>Detail Pra Proposal</h5>
                  </div>
                  <div class="card-body">
                    <table class="table table-sm table-borderless">
                      <tr>
                        <th width="180">Judul</th>
                        <td>: <?php echo htmlspecialchars($d_prop['judul']); ?></td>
                      </tr>
                      <tr>
                        <th>Abstrak</th>
                        <td>: <?php echo nl2br(htmlspecialchars($d_prop['abstrak'])); ?></td>
                      </tr>
                      <tr>
                        <th>File Proposal</th>
                        <td>: <a href="file_pra_proposal_bimtek/<?php echo $d_prop['file_proposal']; ?>" target="_blank" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> Lihat PDF</a></td>
                      </tr>
                      <?php if ($d_prop['file_sertifikat']): ?>
                        <tr>
                          <th>Sertifikat</th>
                          <td>: <a href="file_pra_proposal_bimtek/<?php echo $d_prop['file_sertifikat']; ?>" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file-pdf"></i> Lihat Sertifikat</a></td>
                        </tr>
                      <?php endif; ?>
                      <tr>
                        <th>Tgl Submit</th>
                        <td>: <?php echo $d_prop['tgl_submit']; ?></td>
                      </tr>
                    </table>
                  </div>
                </div>

                <a href="listPraPropBimtekUser.php" class="btn btn-secondary btn-block mb-4 mt-3">
                  <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <!-- Sedang diproses -->
                <div class="callout callout-warning shadow-sm">
                  <h5><i class="fas fa-clock"></i> Menunggu Review</h5>
                  <p class="mb-0">Pra proposal Anda sedang dalam proses review oleh dosen reviewer. Silakan tunggu.</p>
                </div>
                <div class="card card-outline card-warning">
                  <div class="card-header">
                    <h5>Detail Pra Proposal</h5>
                  </div>
                  <div class="card-body">
                    <table class="table table-sm table-borderless">
                      <tr>
                        <th width="180">Judul</th>
                        <td>: <?php echo htmlspecialchars($d_prop['judul']); ?></td>
                      </tr>
                      <tr>
                        <th>Abstrak</th>
                        <td>: <?php echo nl2br(htmlspecialchars($d_prop['abstrak'])); ?></td>
                      </tr>
                      <tr>
                        <th>File Proposal</th>
                        <td>: <a href="file_pra_proposal_bimtek/<?php echo $d_prop['file_proposal']; ?>" target="_blank" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> Lihat PDF</a></td>
                      </tr>
                      <?php if ($d_prop['file_sertifikat']): ?>
                        <tr>
                          <th>Sertifikat</th>
                          <td>: <a href="file_pra_proposal_bimtek/<?php echo $d_prop['file_sertifikat']; ?>" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file-pdf"></i> Lihat Sertifikat</a></td>
                        </tr>
                      <?php endif; ?>
                      <tr>
                        <th>Tgl Submit</th>
                        <td>: <?php echo $d_prop['tgl_submit']; ?></td>
                      </tr>
                    </table>
                  </div>
                </div>

              <?php else: ?>
                <!-- Form Submit / Revisi -->
                <div class="card card-outline card-primary">
                  <div class="card-header">
                    <h5 class="card-title">
                      <?php echo $d_prop ? '<i class="fas fa-redo text-warning"></i> Upload Revisi Pra Proposal' : '<i class="fas fa-upload"></i> Submit Pra Proposal'; ?>
                    </h5>
                  </div>
                  <div class="card-body">
                    <form action="sformPraPropBimtekUser.php" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="id_bimtek" value="<?php echo $id_bimtek; ?>">
                      <input type="hidden" name="id_reviewer" value="<?php echo $d_peserta['id_reviewer']; ?>">

                      <div class="form-group">
                        <label><strong>Judul Pra Proposal <span class="text-danger">*</span></strong></label>
                        <input type="text" name="judul" class="form-control" required placeholder="Judul penelitian Anda" value="<?php echo $d_prop ? htmlspecialchars($d_prop['judul']) : ''; ?>">
                      </div>

                      <div class="form-group">
                        <label><strong>Abstrak <span class="text-danger">*</span></strong></label>
                        <textarea name="abstrak" class="form-control" rows="6" required placeholder="Tuliskan abstrak penelitian Anda..."><?php echo $d_prop ? htmlspecialchars($d_prop['abstrak']) : ''; ?></textarea>
                      </div>

                      <div class="form-group">
                        <label><strong>File Pra Proposal (PDF, maks. 5MB) <?php echo $d_prop ? '' : '<span class="text-danger">*</span>'; ?></strong></label>
                        <?php if ($d_prop && $d_prop['file_proposal']): ?>
                          <div class="mb-2">
                            <a href="file_pra_proposal_bimtek/<?php echo $d_prop['file_proposal']; ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                              <i class="fas fa-file-pdf"></i> File Sebelumnya
                            </a>
                            <small class="text-muted ml-2">(Upload file baru untuk mengganti)</small>
                          </div>
                        <?php endif; ?>
                        <div class="custom-file">
                          <input type="file" name="file_proposal" class="custom-file-input" id="file_proposal" accept=".pdf" <?php echo $d_prop ? '' : 'required'; ?>>
                          <label class="custom-file-label" for="file_proposal">Pilih file PDF Proposal...</label>
                        </div>
                      </div>

                      <div class="form-group">
                        <label><strong>Sertifikat Terkait Bimtek (Opsional, PDF, maks. 5MB)</strong></label>
                        <?php if ($d_prop && $d_prop['file_sertifikat']): ?>
                          <div class="mb-2">
                            <a href="file_pra_proposal_bimtek/<?php echo $d_prop['file_sertifikat']; ?>" target="_blank" class="btn btn-sm btn-outline-info">
                              <i class="fas fa-file-pdf"></i> Sertifikat Sebelumnya
                            </a>
                            <small class="text-muted ml-2">(Upload file baru untuk mengganti)</small>
                          </div>
                        <?php endif; ?>
                        <div class="custom-file">
                          <input type="file" name="file_sertifikat" class="custom-file-input" id="file_sertifikat" accept=".pdf">
                          <label class="custom-file-label" for="file_sertifikat">Pilih file PDF Sertifikat...</label>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> <?php echo $d_prop ? 'Kirim Revisi' : 'Kirim Pra Proposal'; ?>
                      </button>
                      <a href="listPraPropBimtekUser.php" class="btn btn-secondary ml-2">Kembali</a>
                    </form>
                  </div>
                </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php include("footerAdm.php");
  include("jsAdm.php"); ?>
  <script>
    $(document).ready(function() {
      bsCustomFileInput.init();

      $('.toggle-rumpun').on('change', function() {
        var showAll = $(this).is(':checked');
        var peminatan = $('.peminatan-val').val();
        $('.select2-dosen option').each(function() {
          var lecturerRumpun = $(this).data('rumpun');
          var isSame = (lecturerRumpun == peminatan);
          var val = $(this).val();
          if (showAll || isSame || val == "") {
            $(this).show().prop('disabled', false);
          } else {
            $(this).hide().prop('disabled', true);
            if ($(this).is(':selected')) $(this).parent().val("");
          }
        });
      });

      // Initial state
      var hasOutside = false;
      $('.select2-dosen option:selected').each(function() {
        if ($(this).val() != "" && $(this).data('rumpun') != $('.peminatan-val').val()) hasOutside = true;
      });
      if (hasOutside) $('#toggle_rumpun').prop('checked', true);
      $('.toggle-rumpun').trigger('change');

      <?php
      $err = $_GET['error'] ?? '';
      if (isset($errors_map[$err])): ?>
        Swal.fire('Gagal!', '<?php echo $errors_map[$err]; ?>', 'error');
      <?php endif; ?>

      <?php if (!empty($_GET['msg']) && $_GET['msg'] == 'pembimbing_saved'): ?>
        Swal.fire('Berhasil!', 'Pilihan dosen pembimbing berhasil disimpan.', 'success');
      <?php endif; ?>
    });
  </script>
</body>

</html>