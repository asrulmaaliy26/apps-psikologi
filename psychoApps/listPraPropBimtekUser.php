<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];

// Ambil semua bimtek yang pernah didaftarkan oleh mahasiswa ini
$q_list = mysqli_query($con, "SELECT bp.id as id_peserta, bp.id_bimtek, bp.id_reviewer, bp.peminatan,
    b.nama_bimtek,
    p.nama as reviewer_nama,
    pp.id as id_prop, pp.status, pp.judul, pp.catatan, pp.tgl_submit, pp.tgl_update, pp.status_sertifikat, pp.catatan_sertifikat,
    pp.pembimbing_saran_1, pp.pembimbing_saran_2,
    pp.a1, pp.a2, pp.a3, pp.a4, pp.a5, pp.a6, pp.nilai_akhir
    FROM bimtek_peserta bp
    JOIN bimtek_pendaftaran b ON bp.id_bimtek = b.id
    LEFT JOIN dt_pegawai p ON bp.id_reviewer = p.id
    LEFT JOIN bimtek_pra_proposal pp ON pp.nim = bp.nim AND pp.id_bimtek = bp.id_bimtek
    WHERE bp.nim='$username'
    ORDER BY b.id DESC");

// Get list of lecturers for suggestions with their specialization
$q_dosen = mysqli_query($con, "SELECT id, nama, kepakaran_mayor FROM dt_pegawai ORDER BY nama ASC");
$lecturers = [];
while ($ld = mysqli_fetch_assoc($q_dosen)) $lecturers[] = $ld;
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
          <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'success') {
            echo '<div class="alert alert-success alert-dismissible"><span>Pra Proposal berhasil dikirim!</span><button class="close" data-dismiss="alert"><span>&times;</span></button></div>';
          }
          ?>
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Pra Proposal Bimtek</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active small">Pra Proposal Bimtek</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <?php if (mysqli_num_rows($q_list) == 0): ?>
            <div class="alert alert-info">
              <i class="fas fa-info-circle"></i> Anda belum mendaftarkan diri ke periode Bimtek manapun.
              <a href="prePendaftaranBimtekUser.php" class="alert-link ml-2">Daftar Bimtek</a>
            </div>
          <?php else: ?>

            <div class="card card-outline card-info">
              <div class="card-header">
                <h5 class="card-title"><i class="fas fa-file-alt"></i> Daftar Pra Proposal Saya</h5>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered table-sm small text-center">
                    <thead class="bg-secondary">
                      <tr>
                        <th>No</th>
                        <th>Periode Bimtek</th>
                        <th>Reviewer</th>
                        <th>Judul Pra Proposal</th>
                        <th>Status</th>
                        <th>Tgl Submit</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;
                      while ($d = mysqli_fetch_assoc($q_list)):
                        $has_reviewer = !empty($d['id_reviewer']);
                        $can_submit   = $has_reviewer && (!$d['status'] || $d['status'] == 'revisi');
                        $badge = ['proses' => 'badge-warning', 'revisi' => 'badge-danger', 'diterima' => 'badge-success'];
                        $label = ['proses' => 'Sedang Diproses', 'revisi' => 'Perlu Revisi', 'diterima' => 'Diterima ✓'];
                      ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td class="text-left"><strong><?php echo $d['nama_bimtek']; ?></strong></td>
                          <td class="text-left">
                            <?php if ($has_reviewer): ?>
                              <?php echo $d['reviewer_nama']; ?>
                            <?php else: ?>
                              <span class="text-muted"><i>Menunggu Plotting</i></span>
                            <?php endif; ?>
                          </td>
                          <td class="text-left">
                            <?php echo $d['judul'] ? htmlspecialchars(mb_strimwidth($d['judul'], 0, 60, '...')) : '<span class="text-muted">-</span>'; ?>
                          </td>
                          <td>
                            <?php if ($d['status']): ?>
                              <span class="badge <?php echo $badge[$d['status']]; ?>"><?php echo $label[$d['status']]; ?></span>
                              <?php if (isset($d['status_sertifikat']) && $d['status_sertifikat']): ?>
                                <?php
                                $cur_s = $d['status_sertifikat'];
                                $s_badge = ['pending' => 'badge-warning', 'valid' => 'badge-success', 'invalid' => 'badge-danger', 'bypassed' => 'badge-info'];
                                $s_label = ['pending' => 'Sertifikat Pending', 'valid' => 'Sertifikat Valid', 'invalid' => 'Sertifikat Ditolak', 'bypassed' => 'Sertifikat Valid'];
                                $bc = $s_badge[$cur_s] ?? 'badge-secondary';
                                $bl = $s_label[$cur_s] ?? $cur_s;
                                echo "<br><span class='badge " . $bc . "' style='margin-top:2px;'>" . $bl . "</span>";
                                ?>
                              <?php endif; ?>
                            <?php elseif (!$has_reviewer): ?>
                              <span class="badge badge-secondary">Menunggu Reviewer</span>
                            <?php else: ?>
                              <span class="badge badge-light border">Belum Submit</span>
                            <?php endif; ?>
                          </td>
                          <td><?php echo $d['tgl_submit'] ? $d['tgl_submit'] : '-'; ?></td>
                          <td>
                            <?php if ($d['id_prop']): ?>
                              <a href="formPraPropBimtekUser.php?id_bimtek=<?php echo $d['id_bimtek']; ?>" class="btn btn-xs <?php echo $d['status'] == 'diterima' ? 'btn-success' : ($d['status'] == 'revisi' ? 'btn-danger' : 'btn-info'); ?>">
                                <i class="fas fa-<?php echo $d['status'] == 'diterima' ? 'check' : ($d['status'] == 'revisi' ? 'redo' : 'eye'); ?>"></i>
                                <?php echo $d['status'] == 'diterima' ? 'Lihat' : ($d['status'] == 'revisi' ? 'Upload Revisi' : 'Lihat Status'); ?>
                              </a>
                            <?php elseif ($can_submit): ?>
                              <a href="formPraPropBimtekUser.php?id_bimtek=<?php echo $d['id_bimtek']; ?>" class="btn btn-xs btn-primary">
                                <i class="fas fa-upload"></i> Submit
                              </a>
                            <?php else: ?>
                              <span class="text-muted small">-</span>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <?php if ($d['status']): ?>
                          <tr class="bg-light">
                            <td colspan="7" class="text-left py-3 px-4">
                              <div class="card card-outline card-info shadow-sm mb-0">
                                <div class="card-header py-2 d-flex align-items-center">
                                  <h6 class="card-title text-info font-weight-bold mb-0 small">
                                    <i class="fas fa-star mr-1"></i> Hasil Penilaian Reviewer
                                  </h6>
                                  <button type="button" class="btn btn-xs btn-link ml-auto text-muted" data-toggle="tooltip" 
                                          title="A1:Masalah, A2:Rumusan, A3:Tujuan, A4:Metode, A5:Etika, A6:Presentasi">
                                    <i class="fas fa-question-circle"></i> Indikator
                                  </button>
                                </div>
                                <div class="card-body py-3">
                                  <div class="row align-items-center">
                                    <div class="col-md-9 border-right">
                                      <div class="row text-center">
                                        <?php 
                                          $aspek_labels = ['A1','A2','A3','A4','A5','A6'];
                                          foreach($aspek_labels as $al):
                                            $key = strtolower($al);
                                        ?>
                                        <div class="col-2">
                                          <div class="p-1 border rounded bg-white">
                                            <span class="text-muted xsmall d-block"><?php echo $al; ?></span>
                                            <span class="font-weight-bold"><?php echo $d[$key]; ?></span>
                                          </div>
                                        </div>
                                        <?php endforeach; ?>
                                      </div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                      <span class="text-muted xsmall d-block text-uppercase font-weight-bold">Nilai Akhir</span>
                                      <h3 class="text-primary font-weight-bold mb-0" style="font-size: 2rem;"><?php echo number_format($d['nilai_akhir'], 2); ?></h3>
                                      <?php
                                        $final = $d['nilai_akhir'];
                                        $pred = "-"; $bc = "badge-secondary";
                                        if($final >= 85) { $pred = "Sangat Baik"; $bc = "badge-success"; }
                                        else if($final >= 70) { $pred = "Baik"; $bc = "badge-info"; }
                                        else if($final >= 55) { $pred = "Cukup"; $bc = "badge-warning"; }
                                        else if($final > 0) { $pred = "Kurang"; $bc = "badge-danger"; }
                                      ?>
                                      <span class="badge <?php echo $bc; ?> px-2"><?php echo $pred; ?></span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                          </tr>
                        <?php endif; ?>

                        <?php if (!empty($d['catatan'])): ?>
                          <tr class="table-danger">
                            <td colspan="7" class="text-left py-2 px-3">
                              <div class="d-flex align-items-start">
                                <span class="badge badge-danger mr-2 mt-1" style="white-space:nowrap;"><i class="fas fa-comment-dots"></i> Catatan Revisi</span>
                                <div><?php echo $d['catatan']; ?></div>
                              </div>
                            </td>
                          </tr>
                        <?php endif; ?>
                        <?php if ($d['status_sertifikat'] == 'invalid'): ?>
                          <tr class="table-danger">
                            <td colspan="7" class="text-left py-2 px-3">
                              <div class="d-flex align-items-start">
                                <span class="badge badge-danger mr-2 mt-1" style="white-space:nowrap;"><i class="fas fa-certificate"></i> Sertifikat Tidak Valid</span>
                                <div class="text-danger small"><strong>Catatan Admin:</strong> <?php echo $d['catatan_sertifikat']; ?></div>
                              </div>
                            </td>
                          </tr>
                        <?php endif; ?>

                        <?php if ($d['status'] == 'diterima'): ?>
                          <tr class="bg-light">
                            <td colspan="7" class="text-left py-3 px-4">
                              <div class="card card-outline card-warning shadow-sm mb-0">
                                <div class="card-header py-2">
                                  <h6 class="card-title text-warning font-weight-bold mb-0 small"><i class="fas fa-user-friends"></i> Saran Dosen Pembimbing untuk: <strong><?php echo $d['nama_bimtek']; ?></strong></h6>
                                </div>
                                <div class="card-body py-3">
                                  <form action="simpanSaranPembimbingUser.php" method="POST">
                                    <input type="hidden" name="id_prop" value="<?php echo $d['id_prop']; ?>">
                                    <input type="hidden" name="id_bimtek" value="<?php echo $d['id_bimtek']; ?>">
                                    <input type="hidden" class="peminatan-val" value="<?php echo $d['peminatan']; ?>">

                                    <div class="callout callout-info py-1 px-2 mb-2 border-left" style="border-left-width: 4px !important; font-size: 0.85rem;">
                                      <i class="fas fa-info-circle mr-1 text-info"></i> <strong>Disclaimer:</strong> Pemilihan ini bersifat aspirasi untuk pertimbangan plotting dan tidak bersifat mengikat.
                                    </div>

                                    <div class="row align-items-end">
                                      <div class="col-md-4">
                                        <div class="custom-control custom-checkbox mb-2">
                                          <input type="checkbox" class="custom-control-input toggle-rumpun-inline" id="tr_<?php echo $d['id_prop']; ?>">
                                          <label class="custom-control-label small font-weight-bold" for="tr_<?php echo $d['id_prop']; ?>">Tampilkan dosen luar rumpun</label>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group mb-0">
                                          <label class="small font-weight-bold mb-1">Pilihan 1</label>
                                          <select name="pembimbing_saran_1" class="form-control form-control-xs select2-dosen-inline">
                                            <option value="">-- Pilih Dosen 1 --</option>
                                            <?php foreach ($lecturers as $l):
                                              $is_same = ($l['kepakaran_mayor'] == $d['peminatan']);
                                            ?>
                                              <option value="<?php echo $l['id']; ?>" data-rumpun="<?php echo $l['kepakaran_mayor']; ?>" <?php echo ($d['pembimbing_saran_1'] == $l['id']) ? 'selected' : ''; ?>>
                                                <?php echo $l['nama'] . (!$is_same ? ' (Luar Rumpun)' : ''); ?>
                                              </option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group mb-0">
                                          <label class="small font-weight-bold mb-1">Pilihan 2</label>
                                          <select name="pembimbing_saran_2" class="form-control form-control-xs select2-dosen-inline">
                                            <option value="">-- Pilih Dosen 2 --</option>
                                            <?php foreach ($lecturers as $l):
                                              $is_same = ($l['kepakaran_mayor'] == $d['peminatan']);
                                            ?>
                                              <option value="<?php echo $l['id']; ?>" data-rumpun="<?php echo $l['kepakaran_mayor']; ?>" <?php echo ($d['pembimbing_saran_2'] == $l['id']) ? 'selected' : ''; ?>>
                                                <?php echo $l['nama'] . (!$is_same ? ' (Luar Rumpun)' : ''); ?>
                                              </option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-2">
                                        <button type="submit" class="btn btn-xs btn-warning btn-block font-weight-bold py-1 shadow-sm"><i class="fas fa-save"></i> Simpan</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                        <?php endif; ?>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </section>
    </div>
  </div>

  <?php include("footerAdm.php");
  include("jsAdm.php"); ?>
  <script>
    $(function() {
      // Filter Rumpun Dosen Inline
      $('.toggle-rumpun-inline').on('change', function() {
        var card = $(this).closest('.card-body');
        var showAll = $(this).is(':checked');
        var peminatan = card.find('.peminatan-val').val();

        card.find('.select2-dosen-inline option').each(function() {
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

      // Initial trigger for each form
      $('.toggle-rumpun-inline').each(function() {
        var card = $(this).closest('.card-body');
        var peminatan = card.find('.peminatan-val').val();
        var hasOutside = false;

        card.find('.select2-dosen-inline option:selected').each(function() {
          if ($(this).val() != "" && $(this).data('rumpun') != peminatan) hasOutside = true;
        });

        if (hasOutside) {
          $(this).prop('checked', true);
        }
        $(this).trigger('change');
      });

      // SweetAlert for list page
      <?php if (!empty($_GET['msg']) && $_GET['msg'] == 'pembimbing_saved'): ?>
        Swal.fire({
          icon: 'success',
          title: 'Tersimpan',
          text: 'Pilihan dosen pembimbing berhasil disimpan!',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      <?php endif; ?>
    });
  </script>

</html>