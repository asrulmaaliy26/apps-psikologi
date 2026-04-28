<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];
$id_prop = isset($_GET['id']) ? mysqli_real_escape_string($con, $_GET['id']) : '';

$q_prop = mysqli_query($con, "SELECT pp.*, m.nama as mhs_nama, b.nama_bimtek, b.bypass_sertifikat, o.nm as nm_pem,
    bp.file_outline
    FROM bimtek_pra_proposal pp
    JOIN dt_mhssw m ON pp.nim = m.nim
    JOIN bimtek_pendaftaran b ON pp.id_bimtek = b.id
    JOIN bimtek_peserta bp ON bp.nim = pp.nim AND bp.id_bimtek = pp.id_bimtek
    JOIN opsi_bidang_skripsi o ON bp.peminatan = o.id
    WHERE pp.id='$id_prop' AND pp.id_reviewer='$username'");
$d_prop = mysqli_fetch_assoc($q_prop);

if(!$d_prop){
    header("location:reviewerBimtekDsn.php?error=notfound");
    exit();
}

// Block if certificate is still pending or invalid AND not bypassed
$is_bypass = ($d_prop['bypass_sertifikat'] == 1);
if(($d_prop['status_sertifikat'] == 'pending' || $d_prop['status_sertifikat'] == 'invalid') && !$is_bypass){
    header("location:reviewerBimtekDsn.php?error=cert_wait");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <?php include("headAdm.php"); ?>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php include("navtopAdm.php"); include("navSideBarDosen.php"); ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if(!empty($_GET['message']) && $_GET['message'] == 'success'){
                  echo '<div class="alert alert-success alert-dismissible fade show"><span>Berhasil! Status pra proposal telah diperbarui.</span><button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>';
              }
            ?>
            <div class="row">
              <div class="col-sm-6"><h6 class="m-0">Review Pra Proposal</h6></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="reviewerBimtekDsn.php">Bimtek Reviewer</a></li>
                  <li class="breadcrumb-item active">Review</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-8">
                    <div class="card card-outline card-warning shadow-sm">
                      <div class="card-header bg-warning">
                        <h5 class="card-title font-weight-bold"><i class="fas fa-edit"></i> Rubrik Penilaian Pra Proposal</h5>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped mb-0 small">
                            <thead class="bg-light text-center">
                              <tr>
                                <th width="5%">No</th>
                                <th>Aspek Penilaian / Indikator</th>
                                <th width="12%">Skor 4 (85-100)</th>
                                <th width="12%">Skor 3 (70-84)</th>
                                <th width="12%">Skor 2 (55-69)</th>
                                <th width="12%">Skor 1 (0-54)</th>
                                <th width="15%">Penilaian</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $aspects = [
                                'a1' => ['Identifikasi Masalah Penelitian', 'Mengidentifikasi masalah secara tajam, spesifik, aktual, dan didukung data/fakta yang kuat.', 'Mengidentifikasi masalah dengan cukup jelas dan terdapat dukungan data memadai.', 'Mengidentifikasi masalah namun kurang spesifik dan minim dukungan data.', 'Belum mampu mengidentifikasi masalah penelitian dengan jelas.'],
                                'a2' => ['Perumusan Masalah', 'Rumusan masalah jelas, terukur, relevan, dan menunjukkan nilai kebaruan tinggi.', 'Rumusan masalah jelas dan relevan, namun nilai kebaruan masih terbatas.', 'Rumusan masalah ada namun kurang tajam dan relevansinya masih lemah.', 'Rumusan masalah tidak jelas, tidak relevan, atau tidak ada.'],
                                'a3' => ['Penetapan Tujuan Penelitian', 'Tujuan sangat jelas, terukur (SMART), dan selaras penuh dengan rumusan masalah.', 'Tujuan jelas dan sebagian besar selaras dengan rumusan masalah.', 'Tujuan ada namun kurang terukur dan belum sepenuhnya selaras.', 'Tujuan penelitian tidak jelas, tidak selaras, atau tidak ada.'],
                                'a4' => ['Pemilihan Metode Penelitian', 'Memilih metode yang sangat tepat and mampu menjelaskan rasionalitas dengan argumen kuat.', 'Memilih metode yang tepat namun penjelasan rasionalitasnya masih terbatas.', 'Memilih metode namun kurang tepat atau penjelasannya tidak memadai.', 'Tidak dapat memilih metode penelitian yang sesuai dengan topik.'],
                                'a5' => ['Etika dan Integritas Akademik', 'Memahami dan mampu menerapkan prinsip etika penelitian secara menyeluruh.', 'Memahami etika penelitian dan sebagian besar diterapkan dengan baik.', 'Memahami etika namun penerapannya masih kurang konsisten.', 'Kurang memahami etika penelitian dan belum menerapkannya.'],
                                'a6' => ['Kemampuan Presentasi & Diskusi', 'Mempresentasikan dengan lancar, sistematis, dan mampu menjawab dengan argumen baik.', 'Presentasi cukup lancar dan mampu menjawab sebagian besar pertanyaan.', 'Presentasi ada namun kurang lancar dan kurang sistematis.', 'Tidak dapat mempresentasikan hasil kerja dengan jelas.']
                              ];
                              $i = 1;
                              foreach($aspects as $key => $data):
                                $val = $d_prop[$key] ?? 0;
                              ?>
                              <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><strong><?php echo $data[0]; ?></strong></td>
                                <td class="xsmall text-muted"><?php echo $data[1]; ?></td>
                                <td class="xsmall text-muted"><?php echo $data[2]; ?></td>
                                <td class="xsmall text-muted"><?php echo $data[3]; ?></td>
                                <td class="xsmall text-muted"><?php echo $data[4]; ?></td>
                                <td>
                                  <input type="number" name="<?php echo $key; ?>" class="form-control form-control-sm score-input text-center font-weight-bold" 
                                         min="0" max="100" placeholder="0-100" required 
                                         value="<?php echo ($val > 0) ? $val : ''; ?>"
                                         <?php echo ($d_prop['status'] == 'diterima') ? 'readonly' : ''; ?>>
                                </td>
                              </tr>
                              <?php endforeach; ?>
                            </tbody>
                            <tfoot class="bg-light font-weight-bold">
                              <tr>
                                <td colspan="6" class="text-right">Rata-rata Nilai:</td>
                                <td class="text-center text-primary" id="total-skor-display" style="font-size:1.2em;">0.00</td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card card-outline card-info shadow-sm">
                      <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold"><i class="fas fa-info-circle"></i> Skala Penilaian (0-100)</h5>
                      </div>
                      <div class="card-body p-0">
                        <table class="table table-sm table-striped mb-0 text-center small">
                          <thead class="bg-light">
                            <tr>
                              <th>Skor</th>
                              <th>Rentang</th>
                              <th>Huruf</th>
                              <th>Predikat</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="bg-success text-white"><td>4</td><td>85 - 100</td><td>A</td><td>Sangat Baik</td></tr>
                            <tr class="bg-info text-white"><td>3</td><td>70 - 84</td><td>B</td><td>Baik</td></tr>
                            <tr class="bg-warning"><td>2</td><td>55 - 69</td><td>C</td><td>Cukup</td></tr>
                            <tr class="bg-danger text-white"><td>1</td><td>0 - 54</td><td>D</td><td>Kurang</td></tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="card-footer bg-light p-3">
                        <div class="text-center">
                          <span class="text-muted small d-block mb-1">NILAI AKHIR KALKULASI</span>
                          <h1 class="text-primary font-weight-bold mb-0" id="nilai-akhir">0.00</h1>
                          <span class="badge badge-primary px-3 py-1 mt-2" id="predikat-akhir">-</span>
                        </div>
                        <div class="mt-3 border-top pt-2 xsmall text-muted italic">
                          * Nilai Akhir = Rata-rata dari 6 aspek penilaian.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-8 mt-3">
                <div class="card card-outline card-primary">
                  <div class="card-header">
                    <h5 class="card-title">Detail Pra Proposal</h5>
                    <div class="card-tools">
                      <?php
                        $b = ['proses'=>'badge-warning','revisi'=>'badge-danger','diterima'=>'badge-success'];
                        $l = ['proses'=>'Sedang Diproses','revisi'=>'Perlu Revisi','diterima'=>'Diterima ✓'];
                        echo "<span class='badge ".$b[$d_prop['status']]." p-2'>".$l[$d_prop['status']]."</span>";
                      ?>
                    </div>
                  </div>
                  <div class="card-body">
                    <table class="table table-sm table-borderless mb-3">
                      <tr><th width="160">Periode</th><td>: <?php echo $d_prop['nama_bimtek']; ?></td></tr>
                      <tr><th>NIM</th><td>: <?php echo $d_prop['nim']; ?></td></tr>
                      <tr><th>Nama Mahasiswa</th><td>: <strong><?php echo $d_prop['mhs_nama']; ?></strong></td></tr>
                      <tr><th>Peminatan</th><td>: <?php echo $d_prop['nm_pem']; ?></td></tr>
                      <tr><th>Tgl Submit</th><td>: <?php echo $d_prop['tgl_submit']; ?></td></tr>
                      <tr><th>Tgl Update</th><td>: <?php echo $d_prop['tgl_update']; ?></td></tr>
                    </table>
                    
                    <div class="form-group">
                      <label class="font-weight-bold">Judul</label>
                      <div class="border rounded p-3 bg-light"><?php echo htmlspecialchars($d_prop['judul']); ?></div>
                    </div>

                    <div class="form-group">
                      <label class="font-weight-bold">Abstrak</label>
                      <div class="border rounded p-3 bg-light" style="white-space:pre-wrap;"><?php echo htmlspecialchars($d_prop['abstrak']); ?></div>
                    </div>

                    <div class="form-group">
                      <label class="font-weight-bold">File Pra Proposal</label><br>
                      <a href="file_pra_proposal_bimtek/<?php echo $d_prop['file_proposal']; ?>" target="_blank" class="btn btn-danger mb-2 shadow-sm">
                        <i class="fas fa-file-pdf"></i> Download / Lihat Proposal
                      </a>
                      <?php if($d_prop['file_sertifikat']): ?>
                      <br>
                      <label class="font-weight-bold mt-2">Sertifikat Terkait Bimtek</label><br>
                       <a href="file_pra_proposal_bimtek/<?php echo $d_prop['file_sertifikat']; ?>" target="_blank" class="btn btn-info shadow-sm">
                        <i class="fas fa-file-pdf"></i> Download / Lihat Sertifikat
                      </a>
                      <?php endif; ?>

                      <?php if($d_prop['file_outline']): ?>
                      <br>
                      <label class="font-weight-bold mt-2">Outline Awal (Saat Pendaftaran)</label><br>
                      <a href="file_outline_bimtek/<?php echo $d_prop['file_outline']; ?>" target="_blank" class="btn btn-primary shadow-sm">
                        <i class="fas fa-file-word"></i> Download / Lihat Outline Awal
                      </a>
                      <?php endif; ?>
                    </div>

                    <?php if($d_prop['catatan']): ?>
                    <div class="alert alert-warning">
                      <strong><i class="fas fa-comment-dots"></i> Catatan Revisi Sebelumnya:</strong>
                      <div class="mt-2 border-top pt-2"><?php echo $d_prop['catatan']; ?></div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mt-3">
                <div class="card card-outline card-success shadow-sm">
                  <div class="card-header"><h5 class="card-title">Keputusan Reviewer</h5></div>
                  <div class="card-body">
                    <form action="sReviewPraPropBimtekDsn.php" method="POST" id="form-review">
                      <input type="hidden" name="id_prop" value="<?php echo $d_prop['id']; ?>">
                      <input type="hidden" name="aksi" id="aksi-input" value="">
                      <input type="hidden" name="catatan" id="catatan-hidden" value="">
                      
                      <!-- Carry over scores for hidden form submission if needed, 
                           but we'll just wrap the whole row in the form or handle with JS -->
                      <input type="hidden" name="a1_val" id="h_a1">
                      <input type="hidden" name="a2_val" id="h_a2">
                      <input type="hidden" name="a3_val" id="h_a3">
                      <input type="hidden" name="a4_val" id="h_a4">
                      <input type="hidden" name="a5_val" id="h_a5">
                      <input type="hidden" name="a6_val" id="h_a6">
                      <input type="hidden" name="nilai_akhir_val" id="h_nilai">

                      <div class="form-group" id="catatan-box" style="display:none;">
                        <label class="font-weight-bold text-danger"><i class="fas fa-comment"></i> Catatan / Revisi <span class="text-danger">*</span></label>
                        <textarea id="catatan-field" class="form-control"><?php echo $d_prop['catatan'] ? htmlspecialchars($d_prop['catatan']) : ''; ?></textarea>
                        <small class="text-muted">Wajib diisi jika memilih Minta Revisi.</small>
                      </div>

                      <?php if($d_prop['status'] !== 'diterima'): ?>
                      <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-block mb-3 py-2 font-weight-bold" id="btn-terima">
                          <i class="fas fa-check-circle"></i> Terima Pra Proposal
                        </button>
                        <hr>
                        <button type="button" class="btn btn-danger btn-block py-2 font-weight-bold" id="btn-revisi">
                          <i class="fas fa-redo"></i> Minta Revisi
                        </button>
                        <button type="submit" class="btn btn-dark btn-block mt-3" id="btn-submit" style="display:none;">
                          <i class="fas fa-save"></i> Simpan Revisi & Penilaian
                        </button>
                      </div>
                      <?php else: ?>
                      <div class="callout callout-success border-left">
                        <h5><i class="fas fa-check-circle text-success"></i> Sudah Diterima</h5>
                        <p class="small mb-0">Proposal ini sudah disetujui dan dinilai.</p>
                        <h4 class="text-center text-primary mt-2">Nilai: <?php echo $d_prop['nilai_akhir']; ?></h4>
                      </div>
                      <?php endif; ?>
                    </form>
                  </div>
                </div>

                <a href="reviewerBimtekDsn.php" class="btn btn-secondary btn-block mt-2">
                  <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include("footerAdm.php"); include("jsAdm.php"); ?>
    <script>
    function calculateScore(){
        var total = 0;
        var count = 0;
        $('.score-input').each(function(){
            var v = parseFloat($(this).val()) || 0;
            total += v;
            count++;
        });
        var final = (count > 0) ? (total / count) : 0;
        $('#total-skor-display').text(final.toFixed(2));
        $('#nilai-akhir').text(final.toFixed(2));

        // Predicate update
        var pred = "-";
        var badgeClass = "badge-secondary";
        if(final >= 85) { pred = "A - Sangat Baik"; badgeClass = "badge-success"; }
        else if(final >= 70) { pred = "B - Baik"; badgeClass = "badge-info"; }
        else if(final >= 55) { pred = "C - Cukup"; badgeClass = "badge-warning"; }
        else if(final > 0) { pred = "D - Kurang"; badgeClass = "badge-danger"; }
        
        $('#predikat-akhir').text(pred).removeClass().addClass('badge ' + badgeClass + ' px-3 py-1 mt-2');
        
        // Update hidden inputs
        $('#h_a1').val($('input[name="a1"]').val());
        $('#h_a2').val($('input[name="a2"]').val());
        $('#h_a3').val($('input[name="a3"]').val());
        $('#h_a4').val($('input[name="a4"]').val());
        $('#h_a5').val($('input[name="a5"]').val());
        $('#h_a6').val($('input[name="a6"]').val());
        $('#h_nilai').val(final.toFixed(2));
    }

    $(document).ready(function(){
        calculateScore();
        $('.score-input').on('change', function(){
            calculateScore();
        });
    });

    $('#btn-terima').on('click', function(){
        // Check if all scores are filled
        var allFilled = true;
        $('.score-input').each(function(){
            if($(this).val() == "" || $(this).val() == "0") allFilled = false;
        });

        if(!allFilled){
            Swal.fire('Belum Lengkap', 'Silakan isi semua nilai aspek (0-100) sebelum menerima proposal.', 'warning');
            return;
        }

        if(!confirm('Yakin ingin MENERIMA pra proposal ini dengan nilai tersebut?')) return;
        $('#aksi-input').val('terima');
        $('#catatan-hidden').val('');
        $('#form-review').submit();
    });

    $('#btn-revisi').on('click', function(){
        $('#catatan-box').slideToggle();
        $('#btn-submit').toggle();
        if($('#aksi-input').val() !== 'revisi'){
            $('#aksi-input').val('revisi');
        } else {
            $('#aksi-input').val('');
        }
    });

    // Init Summernote
    $('#catatan-field').summernote({
        height: 200,
        minHeight: 150,
        placeholder: 'Tuliskan catatan/revisi untuk mahasiswa secara lengkap...',
        toolbar: [
            ['style', ['bold', 'underline', 'clear']],
            ['font', ['fontname', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
    // Load existing catatan into Summernote
    <?php if($d_prop['catatan']): ?>
    $('#catatan-field').summernote('code', <?php echo json_encode($d_prop['catatan']); ?>);
    <?php endif; ?>

    $('#form-review').on('submit', function(e){
        var catatan = $('#catatan-field').summernote('code').trim();
        var stripped = catatan.replace(/<[^>]*>/g, '').trim();
        
        if($('#aksi-input').val() == 'revisi' && stripped === ''){
            Swal.fire('Peringatan', 'Catatan revisi wajib diisi!', 'warning');
            e.preventDefault();
            return false;
        }
        $('#catatan-hidden').val(catatan);
    });
    </script>
    <style>
      .xsmall { font-size: 0.75rem; line-height: 1.2; }
    </style>
  </body>
</html>
