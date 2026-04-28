<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET['id']);
  $page = mysqli_real_escape_string($con, $_GET['page']);
  
  $query = "SELECT * FROM bimtek_pendaftaran WHERE id='$id'";
  $result = mysqli_query($con, $query);
  $data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Edit Periode Bimtek</h6>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12">
                <div class="card card-outline card-warning">
                  <form action="updatePeriodePendBimtekAdm.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <input type="hidden" name="id" value="<?php echo $id;?>">
                      <input type="hidden" name="page" value="<?php echo $page;?>">
                      
                      <div class="row">
                        <div class="col-md-6 border-right">
                          <h5>Periode Pendaftaran</h5>
                          <div class="form-group">
                            <label for="nama_bimtek">Nama Bimtek</label>
                            <input type="text" name="nama_bimtek" class="form-control form-control-sm" value="<?php echo $data['nama_bimtek'];?>" required>
                          </div>
                          
                          <div class="form-group">
                            <label for="start_datetime">Waktu Awal Pendaftaran</label>
                            <div class="input-group date" id="start_datetime_input" data-target-input="nearest">
                              <input type="text" name="start_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#start_datetime_input" value="<?php echo $data['start_datetime'];?>" required/>
                              <div class="input-group-append" data-target="#start_datetime_input" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="end_datetime">Waktu Akhir Pendaftaran</label>
                            <div class="input-group date" id="end_datetime_input" data-target-input="nearest">
                              <input type="text" name="end_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#end_datetime_input" value="<?php echo $data['end_datetime'];?>" required/>
                              <div class="input-group-append" data-target="#end_datetime_input" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="tgl_tampil_pengumuman">Tampilkan Pengumuman ke Mahasiswa Sejak</label>
                            <div class="input-group date" id="tgl_tampil_pengumuman_input" data-target-input="nearest">
                              <input type="text" name="tgl_tampil_pengumuman" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_tampil_pengumuman_input" value="<?php echo $data['tgl_tampil_pengumuman'];?>" required/>
                              <div class="input-group-append" data-target="#tgl_tampil_pengumuman_input" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="file_pengumuman">File Pengumuman (Kosongkan jika tidak ganti)</label>
                            <?php if($data['file_pengumuman']): ?>
                              <p class="small text-info mb-1">File saat ini: <a href="file_pengumuman_bimtek/<?php echo $data['file_pengumuman'];?>" target="_blank"><?php echo $data['file_pengumuman'];?></a></p>
                            <?php endif; ?>
                            <div class="custom-file">
                              <input type="file" name="file_pengumuman" class="custom-file-input" id="file_pengumuman">
                              <label class="custom-file-label" for="file_pengumuman">Pilih file...</label>
                            </div>
                          </div>

                          <div class="custom-control custom-radio custom-control-inline">
                            <input name="status" type="radio" id="status1" class="custom-control-input" value="1" <?php if($data['status']==1) echo 'checked';?>>
                            <label class="custom-control-label" for="status1">Aktifkan</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline mb-3">
                            <input name="status" type="radio" id="status2" class="custom-control-input" value="2" <?php if($data['status']==2) echo 'checked';?>>
                            <label class="custom-control-label" for="status2">Non Aktifkan</label>
                          </div>

                          <div class="card card-outline card-warning p-2">
                            <h6 class="mb-2"><i class="fas fa-shield-alt text-warning"></i> Pengaturan Validasi Sertifikat</h6>
                            <small class="text-muted mb-2 d-block">Pilih apakah dosen reviewer perlu menunggu admin menyetujui sertifikat mahasiswa sebelum bisa mereview proposal.</small>
                            <div class="custom-control custom-radio custom-control-inline">
                              <input name="bypass_sertifikat" type="radio" id="bypass0" class="custom-control-input" value="0" <?php if(!isset($data['bypass_sertifikat']) || $data['bypass_sertifikat']==0) echo 'checked';?>>
                              <label class="custom-control-label" for="bypass0">Wajib Divalidasi Admin</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                              <input name="bypass_sertifikat" type="radio" id="bypass1" class="custom-control-input" value="1" <?php if(isset($data['bypass_sertifikat']) && $data['bypass_sertifikat']==1) echo 'checked';?>>
                              <label class="custom-control-label" for="bypass1">Abaikan Validasi</label>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <h5>Detail Pelaksanaan</h5>
                          <div class="form-group">
                            <label for="pemateri">Pemateri</label>
                            <input type="text" name="pemateri" class="form-control form-control-sm" value="<?php echo $data['pemateri'];?>" required>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <h6><i class="fas fa-building"></i> Sesi Offline (Tatap Muka)</h6>
                              <div class="form-group">
                                <label for="tempat_offline">Tempat / Ruangan</label>
                                <input type="text" name="tempat_offline" class="form-control form-control-sm" value="<?php echo $data['tempat_offline'];?>">
                              </div>
                              <div class="form-group">
                                <label for="waktu_offline">Waktu Pelaksanaan Offline</label>
                                <div class="input-group date" id="waktu_offline_input" data-target-input="nearest">
                                  <input type="text" name="waktu_offline" class="form-control form-control-sm datetimepicker-input" data-target="#waktu_offline_input" value="<?php echo $data['waktu_offline'];?>"/>
                                  <div class="input-group-append" data-target="#waktu_offline_input" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12 mt-3 border-top pt-2">
                              <h6><i class="fas fa-video"></i> Sesi Online (Virtual)</h6>
                              <div class="form-group">
                                <label for="link_online">Link Zoom / GMeet</label>
                                <input type="text" name="link_online" class="form-control form-control-sm" value="<?php echo $data['link_online'];?>">
                              </div>
                              <div class="form-group">
                                <label for="waktu_online">Waktu Pelaksanaan Online</label>
                                <div class="input-group date" id="waktu_online_input" data-target-input="nearest">
                                  <input type="text" name="waktu_online" class="form-control form-control-sm datetimepicker-input" data-target="#waktu_online_input" value="<?php echo $data['waktu_online'];?>"/>
                                  <div class="input-group-append" data-target="#waktu_online_input" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary btn-sm">Update</button>
                      <a href="pndftrnBimtekAdm.php?page=<?php echo $page;?>" class="btn btn-secondary btn-sm">Batal</a>
                    </div>
                  </form>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(function () {
          $('#start_datetime_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#end_datetime_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#tgl_tampil_pengumuman_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#tgl_buka_praprop_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#tgl_tutup_praprop_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#waktu_offline_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#waktu_online_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
      });
      $(document).ready(function () {
        bsCustomFileInput.init();
      });
    </script>
  </body>
</html>
