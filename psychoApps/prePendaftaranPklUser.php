<?php include("contentsConAdm.php");
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
$nim = $dataku['nim'];

$qry_moment = "SELECT * FROM pendaftaran_pkl WHERE status='1'";
$hasil = mysqli_query($con, $qry_moment);
$data = mysqli_fetch_assoc($hasil);
$id_pkl = $data['id'];
$thp = $data['tahap'];
$ta = $data['ta'];

$qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$thp'";
$hasil = mysqli_query($con, $qry_thp);
$dthp = mysqli_fetch_assoc($hasil);

$qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
$hasil = mysqli_query($con, $qry_nm_ta);
$dnta = mysqli_fetch_assoc($hasil);

$qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
$h = mysqli_query($con, $qry_nm_smt);
$dsemester = mysqli_fetch_assoc($h);

$DATE_NOW = date("Y-m-d H:i:s");
$START_DATE = date($data['start_datetime']);
$END_DATE = date($data['end_datetime']);

$SPLIT_START_DATE = date_create($data['start_datetime']);
$SPLIT_END_DATE = date_create($data['end_datetime']);

$dateStart = date_format($SPLIT_START_DATE, "d-m-Y");
$dateEnd = date_format($SPLIT_END_DATE, "d-m-Y");
$timeStart = date_format($SPLIT_START_DATE, "H:i");
$timeEnd = date_format($SPLIT_END_DATE, "H:i");
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarUserS1.php");
    ?>
    <div class="content-wrapper">
      <?php include("alertUser.php"); ?>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 float-left">Pendaftaran</h1>
            </div>
            <div class="col-sm-6">
              <ol class="mt-2 breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Praktik Kerja Lapangan (PKL)</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm">
              <div class="card card-success card-outline">
                <div class="card-header">
                  <h3 class="card-title">Form Pendaftaran</h3>
                </div>
                <?php if ($END_DATE < $DATE_NOW) {
                  echo
                  '<div class="card-body">
                       <h5>Pendaftaran Praktik Kerja Lapangan (PKL) Tahap ' . $dthp['tahap'] . ' Semester ' . $dsemester['nama'] . ' ' . $dnta['ta'] . ' telah ditutup.</h5>
                      </div>';
                } else if ($START_DATE > $DATE_NOW) {
                  echo
                  '<div class="card-body">
                       <h5>Pendaftaran Praktik Kerja Lapangan (PKL) Tahap ' . $dthp['tahap'] . ' Semester ' . $dsemester['nama'] . ' ' . $dnta['ta'] . ' belum dibuka. <br>Pendaftaran dibuka mulai tanggal ' . $dateStart . ' pukul ' . $timeStart . ' sampai dengan tanggal ' . $dateEnd . ' pukul ' . $timeEnd . '.</h5>
                      </div>';
                } else {
                  $cek_dospem = "SELECT nim FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]' AND status='1'";
                  $res = mysqli_query($con, $cek_dospem)  or die(mysqli_error($con));
                  $dt = mysqli_num_rows($res);

                  $cekbio = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
                  $rbio = mysqli_query($con, $cekbio) or die(mysqli_error($con));
                  $dbio = mysqli_fetch_array($rbio);

                  $myquery1 = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
                  $res1 = mysqli_query($con,  $myquery1) or die(mysqli_error($con));
                  $dataku1 = mysqli_fetch_assoc($res1);
                  $angkatan = $dataku1['angkatan'];
                  $yearnow = date("Y");
                  $monthnow = date("m");
                  $jarakyear = ($yearnow - $angkatan);
                  $jaraksemestergenap = ($monthnow <= 6) + 1 + ($jarakyear * 2);
                  $jaraksemestergasal = ($monthnow > 6) + ($jarakyear * 2);

                  $cekdata = "SELECT nim FROM peserta_pkl WHERE nim='$username' AND id_pkl='$id_pkl'";
                  $ada = mysqli_query($con, $cekdata)  or die(mysqli_error($con));

                  if ($dbio['fakultas_pertama_daftar'] == '' || $dbio['jurusan_pertama_daftar'] == '' || $dbio['jurusan_pertama_daftar'] == '' || $dbio['asal_sekolah'] == '' || $dbio['pend_terakhir'] == '' || $dbio['dosen_wali'] == '' || $dbio['tempat_lahir'] == '' || $dbio['tanggal_lahir'] == '' || $dbio['jenis_kelamin'] == '' || $dbio['alamat_ktp'] == '' || $dbio['alamat_malang'] == '' || $dbio['kntk'] == '' || $dbio['imel'] == '' || $dbio['nama_ayah'] == '' || $dbio['alamat_ayah'] == '' || $dbio['telepon_ayah'] == '' || $dbio['nama_ibu'] == '' || $dbio['pekerjaan_ibu'] == '' || $dbio['alamat_ibu'] == '' || $dbio['telepon_ibu'] == '' || $dbio['photo'] == '') {
                    echo
                    '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Cek dan lengkapi isian biodata terlebih dahulu di menu Profil.</h5>
                           </div>';
                  } else if ($jaraksemestergasal < 7) {
                    echo
                    '<div class="card-body">
                           <h5>Tidak bisa mendaftar! Anda sekarang masih semester ' . $jaraksemestergasal . '.</h5>
                         </div>';
                  } else if ($jaraksemestergenap < 7) {
                    echo
                    '<div class="card-body">
                                 <h5>Tidak bisa mendaftar! Anda sekarang masih semester ' . $jaraksemestergenap . '.</h5>
                               </div>';
                  } else if ($dt >= 1) {
                    echo
                    '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda dinyatakan belum mendapatkan Dospem Pembimbing Skripsi.</h5>
                           </div>';
                  } else {
                    $cekIsian = "SELECT * FROM peserta_pkl WHERE nim='$username' AND id_pkl='$id_pkl'";
                    $r = mysqli_query($con, $cekIsian)  or die(mysqli_error($con));
                    $adaIsian = mysqli_fetch_assoc($r);

                    if (empty($adaIsian['id_pkl']) && empty($adaIsian['nim'])) {
                      include("formPendaftaranPklUserSatu.php");
                    } else if (!empty($adaIsian['id_pkl']) && !empty($adaIsian['nim'])) {
                      echo
                      '<div class="card-body">
                             <h5>Anda telah submit. Silahkan lihat di menu riwayat.</h5>
                           </div>';
                    }
                  }
                } ?>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm">
              <div class="card card-info card-outline shadow-sm">
                <div class="card-header bg-light">
                  <h3 class="card-title font-weight-bold"><i class="fas fa-history mr-1 text-info"></i> Riwayat Pendaftaran</h3>
                </div>
                <div class="card-body pl-0 pr-0 pb-0">
                  <div class="table-responsive">
                    <table class="table table-hover table-striped m-0 text-center table-sm custom">
                      <thead class="bg-info text-white">
                        <tr>
                          <th width="4%" class="pl-1">No.</th>
                          <th width="12%">Tgl. pendaftaran</th>
                          <th width="36%">Nama Instansi</th>
                          <th width="22%">DPL</th>
                          <th width="10%">Status</th>
                          <th colspan="4" class="pr-1">Opsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no=0;
                          $sql_riwayat = "SELECT * FROM peserta_pkl WHERE nim='$username'";
                          $result_riwayat = mysqli_query($con,  $sql_riwayat )or die( mysqli_error($con) );
                          while($data_riwayat = mysqli_fetch_assoc( $result_riwayat )) {
                          $id_r = $data_riwayat['id'];
                          $no++;
                          
                          $myquery_r_dpl = "SELECT * FROM dpl_pkl WHERE id='".$data_riwayat['id_dpl']."'";
                          $res_r_dpl = mysqli_query($con, $myquery_r_dpl);
                          $dt_r_dpl = mysqli_fetch_assoc($res_r_dpl);
                          
                          $myquery_r = "SELECT * FROM dt_pegawai WHERE id='".(isset($dt_r_dpl['nip']) ? $dt_r_dpl['nip'] : $data_riwayat['dpl'])."'";
                          $res_r = mysqli_query($con,  $myquery_r )or die( mysqli_error($con) );
                          $dt_r = mysqli_fetch_assoc( $res_r );
                          
                          $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data_riwayat[val_adm]'";
                          $hdt_cek = mysqli_query($con, $qdt_cek);
                          $dcek = mysqli_fetch_assoc($hdt_cek);
                          ?>
                        <tr>
                          <td class="text-center pl-1"><?php echo $no;?></td>
                          <td class="text-center"><?php echo $data_riwayat['tgl_pengajuan'];?></td>
                          <td class="text-center"><?php echo $data_riwayat['nama_instansi'];?></td>
                          <td class="text-center pr-1"><?php echo $dt_r ? $dt_r['nama'] : '-';?></td>
                          <td class="text-center pr-1"><?php echo $dcek['nm'];?></td>
                          <td width="4%" class="text-center pl-1"><?php if(!empty($data_riwayat['file_pembekalan'])) { echo "<a class='btn btn-outline-success btn-xs btn-block' href='".$data_riwayat['file_pembekalan']."' target='_blank' title='Lihat Tugas Pembekalan'><i class='fas fa-file-pdf'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' title='Tidak ada Tugas Pembekalan' disabled><i class='fas fa-file-pdf'></i></a>";}?></td>
                          <td width="4%" class="text-center"><?php if($data_riwayat['val_adm']==1 OR $data_riwayat['val_adm']==4) { echo "<a class='btn btn-outline-danger btn-xs btn-block' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Yakin data ini dihapus?' href='deletePendaftaranPklUser.php?id=".$id_r."'><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus. Pendaftaran telah diterima\")' title='Tidak bisa dihapus. Pendaftaran telah diterima' disabled><i class='far fa-trash-alt'></i></a>";}?></td>
                          <td width="4%" class="text-center"><?php if(!empty($data_riwayat['catatan'])) { echo "<a class='btn btn-outline-primary btn-xs btn-block' title='Lihat catatan' href='catatanPendaftaranPklUser.php?id=".$id_r."'><i class='far fa-comment-dots'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak ada catatan.\")' title='Tidak ada catatan.' disabled><i class='far fa-comment-dots'></i></a>";}?></td>
                          <td width="4%" class="text-center pr-1"><button class='btn btn-outline-primary btn-xs btn-block' data-toggle='modal' data-target='#modal-pre-cetak' data-whatever='<?php echo $id_r;?>' target='_blank' title='Cetak bukti pendaftaran'><i class='fas fa-print'></i></button></td>
                        </tr>
                        <?php
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <?php
          // Tampilkan info DPL di luar tabel riwayat
          $sql_dpl_info = "SELECT * FROM peserta_pkl WHERE nim='$username' ORDER BY id DESC LIMIT 1";
          $r_dpl_info = mysqli_query($con, $sql_dpl_info);
          if ($r_dpl_info && mysqli_num_rows($r_dpl_info) > 0) {
            $md_dpl = mysqli_fetch_assoc($r_dpl_info);
            if (!empty($md_dpl['dpl'])) {
              // Coba ambil via dpl_pkl jika id_dpl tersedia
              $d_dpl_pkl = [];
              if (!empty($md_dpl['id_dpl']) && $md_dpl['id_dpl'] != '0') {
                $q_dpl_pkl = "SELECT * FROM dpl_pkl WHERE id='".$md_dpl['id_dpl']."'";
                $r_dpl_pkl = mysqli_query($con, $q_dpl_pkl);
                $d_dpl_pkl = mysqli_fetch_assoc($r_dpl_pkl) ?: [];
              }
              // Ambil nama DPL langsung dari dt_pegawai via NIP di kolom dpl
              $q_nm_dpl = "SELECT * FROM dt_pegawai WHERE id='".$md_dpl['dpl']."'";
              $r_nm_dpl = mysqli_query($con, $q_nm_dpl);
              $d_nm_dpl = mysqli_fetch_assoc($r_nm_dpl);
          ?>
          <div class="row mt-4">
            <!-- Info DPL -->
            <div class="col-md-4 col-sm-12 mb-3">
              <div class="info-box shadow-sm border-top border-success h-100">
                <span class="info-box-icon bg-success text-white"><i class="fas fa-user-tie"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-muted font-weight-bold">Dosen Pembimbing Lapangan</span>
                  <span class="info-box-number h5 mb-0" style="white-space: normal;"><?php echo $d_nm_dpl ? htmlspecialchars($d_nm_dpl['nama']) : '<span class="text-danger">Belum ditetapkan</span>'; ?></span>
                </div>
              </div>
            </div>
            
            <!-- Info Lokasi -->
            <div class="col-md-4 col-sm-12 mb-3">
              <div class="info-box shadow-sm border-top border-info h-100">
                <span class="info-box-icon bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-muted font-weight-bold">Lokasi PKL</span>
                  <span class="info-box-number mb-0 font-weight-normal" style="white-space: normal;"><?php echo !empty($md_dpl['alamat_instansi']) ? htmlspecialchars($md_dpl['alamat_instansi']) : '<span class="text-muted">-</span>'; ?></span>
                </div>
              </div>
            </div>

            <!-- Info Instansi -->
            <div class="col-md-4 col-sm-12 mb-3">
              <div class="info-box shadow-sm border-top border-primary h-100">
                <span class="info-box-icon bg-primary text-white"><i class="fas fa-building"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-muted font-weight-bold">Instansi</span>
                  <span class="info-box-number mb-0 font-weight-normal" style="white-space: normal;"><?php echo htmlspecialchars($md_dpl['nama_instansi']); ?></span>
                </div>
              </div>
            </div>
          </div>
          <?php
            }
          }
          ?>

          <?php 
          $cekIsian = "SELECT * FROM peserta_pkl WHERE nim='$username' ORDER BY id DESC LIMIT 1";
          $r_isian = mysqli_query($con, $cekIsian);
          if($r_isian && mysqli_num_rows($r_isian) > 0) {
            $md = mysqli_fetch_assoc($r_isian);
            if ($md['val_adm'] == 2) { 
          ?>

          <div class="row mt-2">
            <div class="col-sm">
              <div class="card card-primary card-outline shadow-sm">
                <div class="card-header bg-light">
                  <h3 class="card-title font-weight-bold"><i class="fas fa-cloud-upload-alt mr-1 text-primary"></i> Unggah Laporan dan Output PKL (Instansi: <?php echo htmlspecialchars($md['nama_instansi']); ?>)</h3>
                </div>
                <div class="card-body">
                  <form action="sformUploadLaporanPklUser.php" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                      
                      <!-- Laporan Akademik -->
                      <div class="form-group col-md-4 mb-4">
                        <label class="font-weight-bold"><i class="fas fa-file-pdf text-danger mr-1"></i> Laporan Akademik (PDF)</label>
                        <div class="p-3 border rounded bg-light h-100 shadow-sm">
                            <?php if(!empty($md['file_laporan_akademik'])): ?>
                              <div class="mb-3">
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Sudah Diunggah</span>
                                <a href="<?php echo htmlspecialchars($md['file_laporan_akademik']); ?>" target="_blank" class="btn btn-xs btn-outline-primary ml-2"><i class="fas fa-eye mr-1"></i> Lihat File</a>
                              </div>
                              <small class="d-block mb-1 font-weight-bold text-muted">Ganti file (opsional):</small>
                            <?php else: ?>
                              <div class="mb-3">
                                <span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1"></i> Belum Diunggah</span>
                              </div>
                              <small class="d-block mb-1 font-weight-bold text-muted">Pilih file baru:</small>
                            <?php endif; ?>
                            <input type="file" accept="application/pdf" class="form-control-file text-sm" name="file_laporan_akademik">
                        </div>
                      </div>

                      <!-- Laporan Output -->
                      <div class="form-group col-md-4 mb-4">
                        <label class="font-weight-bold"><i class="fas fa-file-pdf text-danger mr-1"></i> Laporan Output (PDF)</label>
                        <div class="p-3 border rounded bg-light h-100 shadow-sm">
                            <?php if(!empty($md['file_laporan_output'])): ?>
                              <div class="mb-3">
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Sudah Diunggah</span>
                                <a href="<?php echo htmlspecialchars($md['file_laporan_output']); ?>" target="_blank" class="btn btn-xs btn-outline-success ml-2"><i class="fas fa-eye mr-1"></i> Lihat File</a>
                              </div>
                              <small class="d-block mb-1 font-weight-bold text-muted">Ganti file (opsional):</small>
                            <?php else: ?>
                              <div class="mb-3">
                                <span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1"></i> Belum Diunggah</span>
                              </div>
                              <small class="d-block mb-1 font-weight-bold text-muted">Pilih file baru:</small>
                            <?php endif; ?>
                            <input type="file" accept="application/pdf" class="form-control-file text-sm" name="file_laporan_output">
                        </div>
                      </div>

                      <!-- Link Output -->
                      <div class="form-group col-md-4 mb-4">
                        <label class="font-weight-bold"><i class="fas fa-link text-info mr-1"></i> Link Output Publikasi</label>
                        <div class="p-3 border rounded bg-light h-100 shadow-sm">
                            <?php if(!empty($md['link_output'])): ?>
                              <div class="mb-3">
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Sudah Diisi</span>
                                <a href="<?php echo htmlspecialchars($md['link_output']); ?>" target="_blank" class="btn btn-xs btn-outline-info ml-2"><i class="fas fa-external-link-alt mr-1"></i> Buka Link</a>
                              </div>
                              <small class="d-block mb-1 font-weight-bold text-muted">Ubah link (opsional):</small>
                            <?php else: ?>
                              <div class="mb-3">
                                <span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1"></i> Belum Diisi</span>
                              </div>
                              <small class="d-block mb-1 font-weight-bold text-muted">Masukkan link URL:</small>
                            <?php endif; ?>
                            <input type="text" class="form-control form-control-sm border-info" name="link_output" value="<?php echo htmlspecialchars($md['link_output'] ?? ''); ?>" placeholder="https://...">
                        </div>
                      </div>

                    </div>
                    <input type="hidden" name="id" value="<?php echo $md['id'];?>">
                    <input type="hidden" name="nim" value="<?php echo $md['nim'];?>">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan Laporan & Output</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm">
              <div class="card card-warning card-outline shadow-sm">
                <div class="card-header bg-light">
                  <h3 class="card-title font-weight-bold"><i class="fas fa-star mr-1 text-warning"></i> Hasil Penilaian PKL</h3>
                </div>
                <div class="card-body p-0">
                  <?php
                    include("calculateTotalPkl.php");
                    $nilai_detail = calculateTotalPkl($con, $md['id']);
                  ?>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm m-0 text-left custom">
                      <thead class="bg-warning text-dark">
                        <tr class="text-center">
                          <th width="30%">Komponen Penilaian</th>
                          <th width="25%">Penilai</th>
                          <th width="15%">Bobot</th>
                          <th width="15%">Nilai Rata-Rata</th>
                          <th width="15%">Nilai Tertimbang</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1. Pembekalan</td>
                          <td class="text-center">Panitia PKL</td>
                          <td class="text-center">10%</td>
                          <td class="text-center"><?php echo number_format($nilai_detail['panitia_avg'], 2); ?></td>
                          <td class="text-center"><?php echo number_format($nilai_detail['panitia_avg'] * 0.10, 2); ?></td>
                        </tr>
                        <tr>
                          <td>2. Pelaksanaan PKL</td>
                          <td class="text-center">Supervisor Lapangan</td>
                          <td class="text-center">40%</td>
                          <td class="text-center"><?php echo number_format($nilai_detail['super_avg'], 2); ?></td>
                          <td class="text-center"><?php echo number_format($nilai_detail['super_avg'] * 0.40, 2); ?></td>
                        </tr>
                        <tr>
                          <td>3. Pelaksanaan PKL</td>
                          <td class="text-center">DPL</td>
                          <td class="text-center">10%</td>
                          <td class="text-center"><?php echo number_format($nilai_detail['dpl_pel_avg'], 2); ?></td>
                          <td class="text-center"><?php echo number_format($nilai_detail['dpl_pel_avg'] * 0.10, 2); ?></td>
                        </tr>
                        <tr>
                          <td>4. Laporan</td>
                          <td class="text-center">DPL</td>
                          <td class="text-center">10%</td>
                          <td class="text-center"><?php echo number_format($nilai_detail['dpl_lap_avg'], 2); ?></td>
                          <td class="text-center"><?php echo number_format($nilai_detail['dpl_lap_avg'] * 0.10, 2); ?></td>
                        </tr>
                        <tr>
                          <td>5. Laporan</td>
                          <td class="text-center">Dosen Penguji</td>
                          <td class="text-center">10%</td>
                          <td class="text-center"><?php echo number_format($nilai_detail['peng_lap_avg'], 2); ?></td>
                          <td class="text-center"><?php echo number_format($nilai_detail['peng_lap_avg'] * 0.10, 2); ?></td>
                        </tr>
                        <tr>
                          <td>6. Presentasi Seminar Hasil</td>
                          <td class="text-center">DPL</td>
                          <td class="text-center">10%</td>
                          <td class="text-center"><?php echo number_format($nilai_detail['dpl_pres_avg'], 2); ?></td>
                          <td class="text-center"><?php echo number_format($nilai_detail['dpl_pres_avg'] * 0.10, 2); ?></td>
                        </tr>
                        <tr>
                          <td>7. Presentasi Seminar Hasil</td>
                          <td class="text-center">Dosen Penguji</td>
                          <td class="text-center">10%</td>
                          <td class="text-center"><?php echo number_format($nilai_detail['peng_pres_avg'], 2); ?></td>
                          <td class="text-center"><?php echo number_format($nilai_detail['peng_pres_avg'] * 0.10, 2); ?></td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                          <td colspan="4" class="text-right">Total Nilai Angka (100%)</td>
                          <td class="text-center"><?php echo number_format($nilai_detail['total'], 2); ?></td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                          <td colspan="4" class="text-right">Nilai Huruf Mutu</td>
                          <td class="text-center">
                            <?php 
                              // Use standard grading scale logic or include "nilaiHurufPesPklAdm.php" logic
                              $tot = $nilai_detail['total'];
                              if($tot >= 85) { echo 'A'; }
                              elseif($tot >= 80) { echo 'A-'; }
                              elseif($tot >= 75) { echo 'B+'; }
                              elseif($tot >= 70) { echo 'B'; }
                              elseif($tot >= 65) { echo 'B-'; }
                              elseif($tot >= 60) { echo 'C+'; }
                              elseif($tot >= 55) { echo 'C'; }
                              elseif($tot >= 40) { echo 'D'; }
                              elseif($tot > 0) { echo 'E'; }
                              else { echo '-'; }
                            ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php 
            }
          }
          ?>
          
          <div class="row">
            <?php include ("notifKetPngjnPendftrn.php");?>
          </div>
          <div class="modal fade" id="modal-pre-cetak">
            <div class="modal-dialog modal-lg">
              <div class="modal-content bg-info">
                <div class="isi-modal-pre-cetak"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php include("footerAdm.php"); ?>
  <?php include("jsAdm.php"); ?>
  <script>
    $( '#modal-pre-cetak' ).on( 'show.bs.modal', function ( event ) {
        var button = $( event.relatedTarget )
        var recipient = button.data( 'whatever' )
        var modal = $( this );
        var dataString = 'id=' + recipient;
       
        $.ajax( {
          type: "GET",
          url: "bodyPetunjukCetakPpkl.php",
          data: dataString,
          cache: false,
          success: function ( data ) {
            console.log( data );
            modal.find( '.isi-modal-pre-cetak' ).html( data );
          },
          error: function ( err ) {
            console.log( err );
          }
        } );
       } );
  </script>
</body>

</html>