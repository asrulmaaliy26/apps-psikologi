<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id_peserta = mysqli_real_escape_string($con,  $_GET[ 'id_peserta' ] ?? '');
  $id_dpl = mysqli_real_escape_string($con,  $_GET[ 'id_dpl' ] ?? '');
  $id_pkl = mysqli_real_escape_string($con,  $_GET[ 'id_pkl' ] ?? '');
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] ?? '');
  $source = mysqli_real_escape_string($con,  $_GET[ 'source' ] ?? '');
  
  $qry = "SELECT p.*, m.nama as nama_mhs FROM peserta_pkl p INNER JOIN dt_mhssw m ON p.nim=m.nim WHERE p.id='$id_peserta'";
  $res = mysqli_query($con, $qry);
  $data = mysqli_fetch_assoc($res);

  $qry_nilai = "SELECT * FROM penilaian_pkl_detail WHERE id_peserta_pkl='$id_peserta'";
  $res_n = mysqli_query($con, $qry_nilai);
  $nilai = mysqli_fetch_assoc($res_n);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    <?php
      include( "navtopAdm.php" );
      if($source == 'dosen') {
          include( "navSideBarDosen.php" );
      } else {
          include( "navSideBarAdmBakS1.php" );
      }
      ?> 
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <?php
            if (!empty($_GET['message']) && $_GET['message'] == 'notifUpdate') {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span>Rincian nilai berhasil disimpan!</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            ';}
            ?>
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Rincian Penilaian DPL & Supervisor</h6>
            </div>
            <div class="col-sm-6">
                <li class="breadcrumb-item small">
                  <?php if($source == 'dosen'): ?>
                    <a class="text-info" href="rekapDplPklDosen.php">Kembali ke Daftar Peserta</a>
                  <?php else: ?>
                    <a class="text-info" href="inputNilaiPesertaPklAdm.php?id=<?php echo $id_dpl;?>&id_pkl=<?php echo $id_pkl;?>&page=<?php echo $page;?>">Kembali ke Daftar Peserta</a>
                  <?php endif; ?>
                </li>
                <li class="breadcrumb-item active small">Rincian Nilai</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <section class="col-md-12 connectedSortable">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <div class="clearfix">
                    <h4 class="card-title float-left">Input Nilai: <?php echo $data['nama_mhs'].' ('.$data['nim'].')';?></h4>
                  </div>
                </div>
                <div class="card-body pt-2 pb-2 pl-3 pr-3">
                  <form name="update" method="post" action="updateNilaiDplPklAdm.php" onSubmit="return confirm('Simpan nilai?')">
                    <input type="text" name="id_peserta_pkl" class="sr-only" value="<?php echo $id_peserta;?>">
                    <input type="text" name="id_dpl" class="sr-only" value="<?php echo $id_dpl;?>">
                    <input type="text" name="id_pkl" class="sr-only" value="<?php echo $id_pkl;?>">
                    <input type="text" name="page" class="sr-only" value="<?php echo $page;?>">
                    <input type="text" name="source" class="sr-only" value="<?php echo $source;?>">

                    <!-- Tab Navigation -->
                    <div class="row">
                      <div class="col-md-9">
                        <ul class="nav nav-tabs nav-fill mb-0" id="nilaiTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="tab-super-tab" data-toggle="tab" href="#tab-super" role="tab">
                          <i class="fas fa-user-tie mr-1"></i> Supervisor Lapangan
                          <br><small class="text-muted font-weight-normal">40%</small>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="tab-dpl-pel-tab" data-toggle="tab" href="#tab-dpl-pel" role="tab">
                          <i class="fas fa-chalkboard-teacher mr-1"></i> DPL - Pelaksanaan
                          <br><small class="text-muted font-weight-normal">10%</small>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="tab-dpl-lap-tab" data-toggle="tab" href="#tab-dpl-lap" role="tab">
                          <i class="fas fa-file-alt mr-1"></i> DPL - Laporan
                          <br><small class="text-muted font-weight-normal">10%</small>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="tab-dpl-pres-tab" data-toggle="tab" href="#tab-dpl-pres" role="tab">
                          <i class="fas fa-chalkboard mr-1"></i> DPL - Presentasi
                          <br><small class="text-muted font-weight-normal">10%</small>
                        </a>
                      </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content border border-top-0 rounded-bottom" id="nilaiTabContent">

                      <!-- Tab 1: Supervisor Lapangan -->
                      <div class="tab-pane fade show active p-3" id="tab-super" role="tabpanel">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover table-sm m-0">
                            <thead class="bg-info text-white">
                              <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="75%">Indikator Penilaian</th>
                                <th width="20%" class="text-center">Nilai (0-100)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $super_labels = [
                                  'Integritas', 'Etika', 'Kedisiplinan', 'Tanggung Jawab', 'Loyalitas', 
                                  'Analisis Masalah', 'Penyelesaian Masalah', 'Inisiatif', 'Kreativitas', 
                                  'Kerjasama', 'Komunikasi', 'Penguasaan Teknologi'
                              ];
                              for($i=1; $i<=12; $i++) {
                                  $f = 'super_pelaksanaan_'.$i;
                                  echo '<tr>
                                      <td class="text-center align-middle font-weight-bold">'.$i.'.</td>
                                      <td class="align-middle">'.$super_labels[$i-1].'</td>
                                      <td class="text-center">
                                          <input type="number" min="0" max="100" step="0.01" class="form-control form-control-sm text-center font-weight-bold text-primary" name="'.$f.'" value="'.($nilai ? $nilai[$f] : '').'" placeholder="0-100" required>
                                      </td>
                                  </tr>';
                              }
                              ?>
                            </tbody>
                            <tfoot class="bg-light">
                              <tr>
                                <td colspan="2" class="text-right font-weight-bold">Rata-Rata:</td>
                                <td class="text-center font-weight-bold text-success" id="avg_super">0.00</td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>

                      <!-- Tab 2: DPL Pelaksanaan -->
                      <div class="tab-pane fade p-3" id="tab-dpl-pel" role="tabpanel">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover table-sm m-0">
                            <thead class="bg-info text-white">
                              <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="75%">Indikator Penilaian</th>
                                <th width="20%" class="text-center">Nilai (0-100)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $dpl_pel_labels = [
                                  'Etika', 'Keaktifan Bimbingan', 'Pemenuhan Program', 'Komunikasi', 
                                  'Kerjasama', 'Pemahaman Teori', 'Analisis Masalah', 'Penyelesaian Masalah'
                              ];
                              for($i=1; $i<=8; $i++) {
                                  $f = 'dpl_pelaksanaan_'.$i;
                                  echo '<tr>
                                      <td class="text-center align-middle font-weight-bold">'.$i.'.</td>
                                      <td class="align-middle">'.$dpl_pel_labels[$i-1].'</td>
                                      <td class="text-center">
                                          <input type="number" min="0" max="100" step="0.01" class="form-control form-control-sm text-center font-weight-bold text-primary" name="'.$f.'" value="'.($nilai ? $nilai[$f] : '').'" placeholder="0-100" required>
                                      </td>
                                  </tr>';
                              }
                              ?>
                            </tbody>
                            <tfoot class="bg-light">
                              <tr>
                                <td colspan="2" class="text-right font-weight-bold">Rata-Rata:</td>
                                <td class="text-center font-weight-bold text-success" id="avg_dpl_pel">0.00</td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>

                      <!-- Tab 3: DPL Laporan -->
                      <div class="tab-pane fade p-3" id="tab-dpl-lap" role="tabpanel">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover table-sm m-0">
                            <thead class="bg-info text-white">
                              <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="75%">Indikator Penilaian</th>
                                <th width="20%" class="text-center">Nilai (0-100)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $dpl_lap_labels = [
                                  'Sistematika Penulisan', 'Kualitas Dokumen Tertulis', 'Akurasi dan Validitas Data', 
                                  'Kesesuaian Kegiatan', 'Kualitas Dokumen Output', 'Objektivitas Laporan'
                              ];
                              for($i=1; $i<=6; $i++) {
                                  $f = 'dpl_laporan_'.$i;
                                  echo '<tr>
                                      <td class="text-center align-middle font-weight-bold">'.$i.'.</td>
                                      <td class="align-middle">'.$dpl_lap_labels[$i-1].'</td>
                                      <td class="text-center">
                                          <input type="number" min="0" max="100" step="0.01" class="form-control form-control-sm text-center font-weight-bold text-primary" name="'.$f.'" value="'.($nilai ? $nilai[$f] : '').'" placeholder="0-100" required>
                                      </td>
                                  </tr>';
                              }
                              ?>
                            </tbody>
                            <tfoot class="bg-light">
                              <tr>
                                <td colspan="2" class="text-right font-weight-bold">Rata-Rata:</td>
                                <td class="text-center font-weight-bold text-success" id="avg_dpl_lap">0.00</td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>

                      <!-- Tab 4: DPL Presentasi -->
                      <div class="tab-pane fade p-3" id="tab-dpl-pres" role="tabpanel">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover table-sm m-0">
                            <thead class="bg-info text-white">
                              <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="75%">Indikator Penilaian</th>
                                <th width="20%" class="text-center">Nilai (0-100)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $dpl_pres_labels = [
                                  'Penguasaan Materi', 'Kemampuan Berargumentasi', 'Kualitas Media Presentasi', 
                                  'Komunikasi Lisan', 'Profesional dalam penyampaian materi', 'Ketajaman Analisis'
                              ];
                              for($i=1; $i<=6; $i++) {
                                  $f = 'dpl_presentasi_'.$i;
                                  echo '<tr>
                                      <td class="text-center align-middle font-weight-bold">'.$i.'.</td>
                                      <td class="align-middle">'.$dpl_pres_labels[$i-1].'</td>
                                      <td class="text-center">
                                          <input type="number" min="0" max="100" step="0.01" class="form-control form-control-sm text-center font-weight-bold text-primary" name="'.$f.'" value="'.($nilai ? $nilai[$f] : '').'" placeholder="0-100" required>
                                      </td>
                                  </tr>';
                              }
                              ?>
                            </tbody>
                            <tfoot class="bg-light">
                              <tr>
                                <td colspan="2" class="text-right font-weight-bold">Rata-Rata:</td>
                                <td class="text-center font-weight-bold text-success" id="avg_dpl_pres">0.00</td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>

                    </div><!-- end tab-content -->
                      </div><!-- end col-md-9 -->

                      <div class="col-md-3">
                        <div class="card card-info card-outline sticky-top" style="top: 20px;">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle mr-1 text-info"></i> Range Nilai</h3>
                          </div>
                          <div class="card-body p-0">
                            <table class="table table-sm table-striped text-center m-0">
                              <thead class="bg-light">
                                <tr><th>Huruf</th><th>Range Nilai</th></tr>
                              </thead>
                              <tbody>
                                <tr><th class="text-success">A</th><td>&ge; 85</td></tr>
                                <tr><th class="text-primary">B+</th><td>80 - 84.99</td></tr>
                                <tr><th class="text-info">B</th><td>75 - 79.99</td></tr>
                                <tr><th class="text-warning">C+</th><td>70 - 74.99</td></tr>
                                <tr><th class="text-warning">C</th><td>65 - 69.99</td></tr>
                                <tr><th class="text-danger">D</th><td>60 - 64.99</td></tr>
                                <tr><th class="text-danger">E</th><td>&lt; 60</td></tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div><!-- end col-md-3 -->
                    </div><!-- end row -->

                    <div class="mt-3 text-right">
                      <?php if($source == 'dosen'): ?>
                        <a href="rekapDplPklDosen.php" class="btn btn-default btn-lg mr-2"><i class="fas fa-times"></i> Batal</a>
                      <?php else: ?>
                        <a href="inputNilaiPesertaPklAdm.php?id=<?php echo $id_dpl;?>&id_pkl=<?php echo $id_pkl;?>&page=<?php echo $page;?>" class="btn btn-default btn-lg mr-2"><i class="fas fa-times"></i> Batal</a>
                      <?php endif; ?>
                      <button name="submit" type="submit" class="btn btn-info btn-lg px-5"><i class="fas fa-save"></i> Simpan Semua Penilaian</button>
                    </div>
                  </form>

                  <!-- Berkas & Dokumen Mahasiswa -->
                  <div class="mt-4">
                    <div class="card card-secondary card-outline">
                      <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-folder-open mr-1 text-warning"></i> Berkas & Dokumen Mahasiswa</h3>
                      </div>
                      <div class="card-body pb-2">
                        <div class="row">

                          <!-- Tugas Pembekalan -->
                          <div class="col-md-3 col-sm-6 mb-3">
                            <div class="d-flex align-items-start">
                              <i class="fas fa-file-pdf fa-2x text-danger mr-3 mt-1"></i>
                              <div>
                                <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size:0.7rem">Tugas Pembekalan</small>
                                <?php if(!empty($data['file_pembekalan'])): ?>
                                  <span class="badge badge-success mt-1 mb-1"><i class="fas fa-check mr-1"></i> Sudah Mengumpulkan</span><br>
                                  <a href="<?php echo htmlspecialchars($data['file_pembekalan']); ?>" target="_blank" class="btn btn-outline-danger btn-xs">
                                    <i class="fas fa-eye mr-1"></i> Lihat File
                                  </a>
                                <?php else: ?>
                                  <span class="badge badge-danger mt-1"><i class="fas fa-times mr-1"></i> Belum Mengumpulkan</span>
                                <?php endif; ?>
                              </div>
                            </div>
                          </div>

                          <!-- Laporan Akademik -->
                          <div class="col-md-3 col-sm-6 mb-3">
                            <div class="d-flex align-items-start">
                              <i class="fas fa-file-pdf fa-2x text-primary mr-3 mt-1"></i>
                              <div>
                                <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size:0.7rem">Laporan Akademik</small>
                                <?php if(!empty($data['file_laporan_akademik'])): ?>
                                  <span class="badge badge-success mt-1 mb-1"><i class="fas fa-check mr-1"></i> Sudah Mengumpulkan</span><br>
                                  <a href="<?php echo htmlspecialchars($data['file_laporan_akademik']); ?>" target="_blank" class="btn btn-outline-primary btn-xs">
                                    <i class="fas fa-eye mr-1"></i> Lihat File
                                  </a>
                                <?php else: ?>
                                  <span class="badge badge-danger mt-1"><i class="fas fa-times mr-1"></i> Belum Mengumpulkan</span>
                                <?php endif; ?>
                              </div>
                            </div>
                          </div>

                          <!-- Laporan Output -->
                          <div class="col-md-3 col-sm-6 mb-3">
                            <div class="d-flex align-items-start">
                              <i class="fas fa-file-pdf fa-2x text-success mr-3 mt-1"></i>
                              <div>
                                <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size:0.7rem">Laporan Output</small>
                                <?php if(!empty($data['file_laporan_output'])): ?>
                                  <span class="badge badge-success mt-1 mb-1"><i class="fas fa-check mr-1"></i> Sudah Mengumpulkan</span><br>
                                  <a href="<?php echo htmlspecialchars($data['file_laporan_output']); ?>" target="_blank" class="btn btn-outline-success btn-xs">
                                    <i class="fas fa-eye mr-1"></i> Lihat File
                                  </a>
                                <?php else: ?>
                                  <span class="badge badge-danger mt-1"><i class="fas fa-times mr-1"></i> Belum Mengumpulkan</span>
                                <?php endif; ?>
                              </div>
                            </div>
                          </div>

                          <!-- Link Output -->
                          <div class="col-md-3 col-sm-6 mb-3">
                            <div class="d-flex align-items-start">
                              <i class="fas fa-link fa-2x text-info mr-3 mt-1"></i>
                              <div>
                                <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size:0.7rem">Link Output</small>
                                <?php if(!empty($data['link_output'])): ?>
                                  <span class="badge badge-success mt-1 mb-1"><i class="fas fa-check mr-1"></i> Sudah Mengumpulkan</span><br>
                                  <a href="<?php echo htmlspecialchars($data['link_output']); ?>" target="_blank" class="btn btn-outline-info btn-xs">
                                    <i class="fas fa-external-link-alt mr-1"></i> Buka Link
                                  </a>
                                <?php else: ?>
                                  <span class="badge badge-danger mt-1"><i class="fas fa-times mr-1"></i> Belum Mengumpulkan</span>
                                <?php endif; ?>
                              </div>
                            </div>
                          </div>

                          <!-- Transkrip -->
                          <?php if(!empty($data['file_transkrip'])): ?>
                          <div class="col-md-3 col-sm-6 mb-3">
                            <div class="d-flex align-items-start">
                              <i class="fas fa-graduation-cap fa-2x text-warning mr-3 mt-1"></i>
                              <div>
                                <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size:0.7rem">Transkrip Nilai</small>
                                <span class="badge badge-success mt-1 mb-1"><i class="fas fa-check mr-1"></i> Sudah Mengumpulkan</span><br>
                                <a href="<?php echo htmlspecialchars($data['file_transkrip']); ?>" target="_blank" class="btn btn-outline-warning btn-xs">
                                  <i class="fas fa-eye mr-1"></i> Lihat File
                                </a>
                              </div>
                            </div>
                          </div>
                          <?php endif; ?>

                        </div>
                      </div>
                    </div>
                  </div>

                </div>
            </section>
            </div>
          </div>
      </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script>
      function getGradeLetter(score) {
          if (score == 0) return '-';
          if (score >= 85) return 'A';
          if (score >= 80) return 'B+';
          if (score >= 75) return 'B';
          if (score >= 70) return 'C+';
          if (score >= 65) return 'C';
          if (score >= 60) return 'D';
          return 'E';
      }

      function calculateAverages() {
          let sumSuper = 0, countSuper = 0;
          document.querySelectorAll('input[name^="super_pelaksanaan_"]').forEach(inp => {
              if (inp.value !== '') { sumSuper += parseFloat(inp.value); countSuper++; }
          });
          let avgSuper = countSuper > 0 ? (sumSuper / countSuper) : 0;
          document.getElementById('avg_super').innerText = avgSuper.toFixed(2) + " (" + getGradeLetter(avgSuper) + ")";

          let sumDplPel = 0, countDplPel = 0;
          document.querySelectorAll('input[name^="dpl_pelaksanaan_"]').forEach(inp => {
              if (inp.value !== '') { sumDplPel += parseFloat(inp.value); countDplPel++; }
          });
          let avgDplPel = countDplPel > 0 ? (sumDplPel / countDplPel) : 0;
          document.getElementById('avg_dpl_pel').innerText = avgDplPel.toFixed(2) + " (" + getGradeLetter(avgDplPel) + ")";

          let sumDplLap = 0, countDplLap = 0;
          document.querySelectorAll('input[name^="dpl_laporan_"]').forEach(inp => {
              if (inp.value !== '') { sumDplLap += parseFloat(inp.value); countDplLap++; }
          });
          let avgDplLap = countDplLap > 0 ? (sumDplLap / countDplLap) : 0;
          document.getElementById('avg_dpl_lap').innerText = avgDplLap.toFixed(2) + " (" + getGradeLetter(avgDplLap) + ")";

          let sumDplPres = 0, countDplPres = 0;
          document.querySelectorAll('input[name^="dpl_presentasi_"]').forEach(inp => {
              if (inp.value !== '') { sumDplPres += parseFloat(inp.value); countDplPres++; }
          });
          let avgDplPres = countDplPres > 0 ? (sumDplPres / countDplPres) : 0;
          document.getElementById('avg_dpl_pres').innerText = avgDplPres.toFixed(2) + " (" + getGradeLetter(avgDplPres) + ")";
      }

      // Initial calculation
      calculateAverages();

      // Listen to input changes
      document.querySelectorAll('input[type="number"]').forEach(inp => {
          inp.addEventListener('input', calculateAverages);
          inp.addEventListener('change', function() {
              // Auto-save silently
              let formData = new FormData(document.forms['update']);
              formData.append('submit', '1');
              fetch('updateNilaiDplPklAdm.php', {
                  method: 'POST',
                  body: formData
              }).then(res => {
                  // Option: Show small toast/notification
                  console.log('Auto-saved successfully');
              }).catch(err => console.error('Auto-save error', err));
          });
      });
    </script>
  </body>
</html>
