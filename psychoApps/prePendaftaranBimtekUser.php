<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $q_cek_aktif = "SELECT * FROM bimtek_pendaftaran WHERE status='1'";
  $r_cek_aktif = mysqli_query($con, $q_cek_aktif);
  $d_aktif = mysqli_fetch_assoc($r_cek_aktif);
  $ada_aktif = mysqli_num_rows($r_cek_aktif);

  $q_cek_daftar = "SELECT * FROM bimtek_peserta WHERE nim='$username' ORDER BY tgl_daftar DESC";
  $r_cek_daftar = mysqli_query($con, $q_cek_daftar);
  $sudah_daftar = mysqli_num_rows($r_cek_daftar);
?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarUserS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
              echo '
              <div class="callout callout-success" role="alert">
              <h5><i class="icon fas fa-check"></i> Pendaftaran berhasil!</h5>
              <span>Silakan lihat riwayat pendaftaran Anda di bawah ini.</span>
              </div>
              ';}
            ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Bimtek Penulisan TA</h6>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h4 class="card-title">Status Pendaftaran</h4>
                  </div>
                  <div class="card-body">
                    <?php if($ada_aktif > 0): ?>
                      <div class="callout callout-info">
                        <h5><i class="icon fas fa-info"></i> Pendaftaran Dibuka!</h5>
                        Pendaftaran <strong><?php echo $d_aktif['nama_bimtek'];?></strong> dibuka dari <strong><?php echo date('d M Y H:i', strtotime($d_aktif['start_datetime']));?></strong> sampai <strong><?php echo date('d M Y H:i', strtotime($d_aktif['end_datetime']));?></strong>.
                      </div>
                      <?php
                        $now = date('Y-m-d H:i:s');
                        
                        // Cek status pendaftaran
                        if($now < $d_aktif['start_datetime'] || $now > $d_aktif['end_datetime']):
                      ?>
                        <div class="callout callout-warning">
                          <h5><i class="icon fas fa-exclamation-triangle"></i> Waktu Pendaftaran Belum Tersedia</h5>
                          Maaf, saat ini belum memasuki waktu pendaftaran atau waktu pendaftaran telah berakhir.
                        </div>
                      <?php endif; ?>

                      <?php
                        // Check if attendance is open
                        $w_off = ($d_aktif['waktu_offline'] != '0000-00-00 00:00:00') ? $d_aktif['waktu_offline'] : '9999-12-31 23:59:59';
                        $w_on = ($d_aktif['waktu_online'] != '0000-00-00 00:00:00') ? $d_aktif['waktu_online'] : '9999-12-31 23:59:59';
                        $open_at = ($w_off < $w_on) ? $w_off : $w_on;
                        
                        if($now >= $open_at && $sudah_daftar > 0):
                      ?>
                        <div class="callout callout-success">
                          <h5><i class="icon fas fa-check"></i> Absensi Telah Dibuka!</h5>
                          Silakan isi absensi pada tabel <strong>Riwayat Pendaftaran & Absensi</strong> di bawah ini.
                        </div>
                      <?php endif; ?>

                      <?php
                        // Tombol daftar
                        if($now >= $d_aktif['start_datetime'] && $now <= $d_aktif['end_datetime']):
                      ?>
                        <a href="formPendaftaranBimtekUser.php" class="btn btn-primary btn-lg mb-3"><i class="fas fa-edit"></i> Daftar Sekarang</a>
                      <?php endif; ?>

                      <?php if($now >= $d_aktif['tgl_tampil_pengumuman']): ?>
                        <div class="card card-widget widget-user-2 mt-4 shadow-sm">
                          <div class="widget-user-header bg-info">
                            <h3 class="widget-user-username ml-0">Informasi Pelaksanaan Bimtek</h3>
                            <h5 class="widget-user-desc ml-0"><?php echo $d_aktif['nama_bimtek'];?></h5>
                          </div>
                          <div class="card-footer p-0">
                            <ul class="nav flex-column">
                              <li class="nav-item">
                                <span class="nav-link">
                                  <i class="fas fa-user-tie mr-2"></i> Pemateri <span class="float-right badge bg-primary"><?php echo $d_aktif['pemateri'];?></span>
                                </span>
                              </li>
                              <li class="nav-item">
                                <div class="nav-link border-bottom">
                                  <h6><i class="fas fa-building mr-2"></i> Sesi Offline (Tatap Muka)</h6>
                                  <p class="mb-1 ml-4 small"><strong>Tempat:</strong> <?php echo $d_aktif['tempat_offline'] ? $d_aktif['tempat_offline'] : '-';?></p>
                                  <p class="mb-0 ml-4 small"><strong>Waktu:</strong> <?php echo $d_aktif['waktu_offline'] ? $d_aktif['waktu_offline'] : '-';?></p>
                                </div>
                              </li>
                              <li class="nav-item">
                                <div class="nav-link border-bottom">
                                  <h6><i class="fas fa-video mr-2"></i> Sesi Online (Virtual)</h6>
                                  <p class="mb-1 ml-4 small"><strong>Link:</strong> <?php if($d_aktif['link_online']) { echo "<a href='".$d_aktif['link_online']."' target='_blank'>".$d_aktif['link_online']."</a>"; } else { echo "-"; }?></p>
                                  <p class="mb-0 ml-4 small"><strong>Waktu:</strong> <?php echo $d_aktif['waktu_online'] ? $d_aktif['waktu_online'] : '-';?></p>
                                </div>
                              </li>
                              <?php if($d_aktif['file_pengumuman']): ?>
                              <li class="nav-item">
                                <a href="file_pengumuman_bimtek/<?php echo $d_aktif['file_pengumuman'];?>" class="nav-link text-danger" target="_blank">
                                  <i class="fas fa-file-pdf mr-2"></i> Download File Pengumuman <span class="float-right badge bg-danger">PDF</span>
                                </a>
                              </li>
                              <?php endif; ?>
                            </ul>
                          </div>
                        </div>
                      <?php endif; ?>

                    <?php else: ?>
                      <div class="callout callout-danger">
                        <h5><i class="icon fas fa-ban"></i> Pendaftaran Ditutup!</h5>
                        Saat ini tidak ada periode pendaftaran Bimtek yang aktif.
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <?php if($sudah_daftar > 0): ?>
                <div class="card card-outline card-success mt-4">
                  <div class="card-header">
                    <h4 class="card-title">Riwayat Pendaftaran & Absensi</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm small">
                        <thead>
                          <tr>
                            <th>Bimtek</th>
                            <th>Peminatan</th>
                            <th>Periode</th>
                            <th>Outline</th>
                            <th>Reviewer</th>
                            <th>Tgl Daftar</th>
                            <th>Status Absensi</th>
                            <th>Pra Proposal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            mysqli_data_seek($r_cek_daftar, 0); // reset pointer
                            while($row = mysqli_fetch_array($r_cek_daftar)): 
                            $q_bim = mysqli_query($con, "SELECT * FROM bimtek_pendaftaran WHERE id='$row[id_bimtek]'");
                            $d_bim = mysqli_fetch_assoc($q_bim);
                            $q_pem = mysqli_query($con, "SELECT nm FROM opsi_bidang_skripsi WHERE id='$row[peminatan]'");
                            $d_pem = mysqli_fetch_assoc($q_pem);
                            $reviewer_name = "<span class='text-muted font-italic small'>Menunggu Plotting</span>";
                            if(!empty($row['id_reviewer'])) {
                                $q_rev = mysqli_query($con, "SELECT nama FROM dt_pegawai WHERE id='$row[id_reviewer]'");
                                if($d_rev = mysqli_fetch_assoc($q_rev)) {
                                    $reviewer_name = "<strong>".$d_rev['nama']."</strong>";
                                }
                            }
                          ?>
                          <tr>
                            <td><?php echo $d_bim['nama_bimtek'];?></td>
                            <td><?php echo $d_pem['nm'];?></td>
                            <td>
                               <span class="badge badge-info"><?php echo date('d/m/y H:i', strtotime($d_bim['start_datetime']));?></span> - 
                               <span class="badge badge-info"><?php echo date('d/m/y H:i', strtotime($d_bim['end_datetime']));?></span>
                            </td>
                            <td><a href="file_outline_bimtek/<?php echo $row['file_outline'];?>" target="_blank">Lihat File</a></td>
                            <td><?php echo $reviewer_name;?></td>
                            <td><?php echo $row['tgl_daftar'];?></td>
                            <td>
                              <div class="d-flex flex-column">
                                <?php for($s=1; $s<=3; $s++): 
                                  $col_file = 'file_absensi_'.$s;
                                  $col_tgl = 'tgl_absensi_'.$s;
                                ?>
                                  <div class="mb-1">
                                    <span class="small font-weight-bold">Absensi <?php echo $s;?>:</span>
                                    <?php if($row[$col_file]): ?>
                                      <span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>
                                      <a href="file_absensi_bimtek/<?php echo $row[$col_file];?>" target="_blank" class="ml-1"><i class="fas fa-file-image"></i></a>
                                    <?php else: ?>
                                      <?php
                                        $now = date('Y-m-d H:i:s');
                                        $w_off = ($d_bim['waktu_offline'] != '0000-00-00 00:00:00') ? $d_bim['waktu_offline'] : '9999-12-31 23:59:59';
                                        $w_on = ($d_bim['waktu_online'] != '0000-00-00 00:00:00') ? $d_bim['waktu_online'] : '9999-12-31 23:59:59';
                                        $min_start = ($w_off < $w_on) ? $w_off : $w_on;

                                        if($now >= $min_start):
                                      ?>
                                        <button type="button" class="btn btn-xs btn-primary py-0" data-toggle="modal" data-target="#absensiModal" data-id="<?php echo $row['id'];?>" data-bimtek="<?php echo $d_bim['nama_bimtek'];?>" data-slot="<?php echo $s;?>">
                                          Isi Absen
                                        </button>
                                      <?php else: ?>
                                        <span class="badge badge-secondary">Belum</span>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  </div>
                                <?php endfor; ?>
                              </div>
                            </td>
                            <td class="text-center">
                              <?php
                                if(!empty($row['id_reviewer'])){
                                  $q_pp = mysqli_query($con, "SELECT status FROM bimtek_pra_proposal WHERE nim='$username' AND id_bimtek='".$row['id_bimtek']."'");
                                  $d_pp = mysqli_fetch_assoc($q_pp);
                                  $badge_pp = ['proses'=>'badge-warning','revisi'=>'badge-danger','diterima'=>'badge-success'];
                                  $label_pp = ['proses'=>'Diproses','revisi'=>'Revisi','diterima'=>'Diterima ✓'];
                                  if($d_pp){
                                    echo "<span class='badge ".$badge_pp[$d_pp['status']]."'>".$label_pp[$d_pp['status']]."</span> ";
                                    if($d_pp['status'] == 'revisi'){
                                      echo "<br><a href='formPraPropBimtekUser.php?id_bimtek=".$row['id_bimtek']."' class='btn btn-xs btn-danger mt-1'><i class='fas fa-redo'></i> Upload Revisi</a>";
                                    }
                                  } else {
                                    echo "<a href='formPraPropBimtekUser.php?id_bimtek=".$row['id_bimtek']."' class='btn btn-xs btn-primary'><i class='fas fa-upload'></i> Submit</a>";
                                  }
                                } else {
                                  echo "<span class='text-muted small'>Menunggu Reviewer</span>";
                                }
                              ?>
                            </td>
                          </tr>
                          <?php endwhile; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php endif; ?>

              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Modal Absensi -->
      <div class="modal fade" id="absensiModal" tabindex="-1" role="dialog" aria-labelledby="absensiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="sAbsensiBimtekUser.php" method="post" enctype="multipart/form-data">
              <div class="modal-header bg-primary">
                <h5 class="modal-title" id="absensiModalLabel">Isi Absensi <span id="label-slot"></span></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id_peserta" id="absensi-id">
                <input type="hidden" name="slot" id="absensi-slot">
                <div class="form-group">
                  <label>Nama Bimtek</label>
                  <input type="text" class="form-control" id="absensi-bimtek" readonly>
                </div>
                <div class="form-group">
                  <label>Bukti Mengikuti (Screenshot/Foto, JPG/PNG/PDF Max 2MB)</label>
                  <div class="custom-file">
                    <input type="file" name="file_absensi" class="custom-file-input" id="file_absensi" required>
                    <label class="custom-file-label" for="file_absensi">Pilih file...</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Kirim Absensi</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script>
      $('#absensiModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var bimtek = button.data('bimtek');
        var slot = button.data('slot');
        var modal = $(this);
        modal.find('#absensi-id').val(id);
        modal.find('#absensi-bimtek').val(bimtek);
        modal.find('#absensi-slot').val(slot);
        modal.find('#label-slot').text(slot);
      });
      $(document).ready(function () {
        bsCustomFileInput.init();
      });
    </script>
  </body>
</html>
