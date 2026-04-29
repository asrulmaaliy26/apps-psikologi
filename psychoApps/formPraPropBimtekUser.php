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
    WHERE bp.nim='$username' AND bp.id_bimtek='$id_bimtek' AND bp.id_reviewer != '' AND bp.id_reviewer IS NOT NULL");
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
                    <?php echo $d_prop['catatan']; ?>
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

      <?php
      $err = $_GET['error'] ?? '';
      if (isset($errors_map[$err])): ?>
        Swal.fire('Gagal!', '<?php echo $errors_map[$err]; ?>', 'error');
      <?php endif; ?>
    });
  </script>
</body>

</html>