<?php include( "contentsConAdm.php" );
  $qta = "SELECT * FROM dt_ta WHERE status='1'";
  $rta = mysqli_query($con, $qta)or die( mysqli_error($con));
  $dta = mysqli_fetch_assoc($rta);   
   
  $qwd1 = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '47'";
  $rkaprodi = mysqli_query($con, $qkaprodi)or die( mysqli_error($con));
  $dkaprodi = mysqli_fetch_assoc($rkaprodi);
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
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Submit berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Edit berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Delete berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifUpdateStatus') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Periode berhasil diaktifkan!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pendaftaran Bimtek Penulisan TA</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Periode Pendaftaran</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "pndftrnBimtekAdm.php?pagination=true";
           $sql = "SELECT * FROM bimtek_pendaftaran ORDER BY status ASC, start_datetime DESC";
           $result = mysqli_query($con, $sql);
           
           $rpp = 10;
           $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
           $tcount = mysqli_num_rows($result);
           $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
           $count = 0;
           $i = ($page-1)*$rpp;
           $no_urut = ($page-1)*$rpp;
           ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Periode Pendaftaran</h4>
                      <button type="button" class="btn btn-outline-danger btn-flat btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="fas fa-calendar-plus"></i> Input Periode Baru</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="2" class="pl-1">No.</td>
                            <td width="40%" rowspan="2">Nama Bimtek / Periode</td>
                            <td class="border-bottom-0" colspan="2">Durasi Pendaftaran</td>
                            <td class="pr-1" rowspan="2" colspan="5">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="14%" class="pl-1">Mulai</td>
                            <td width="14%" class="pr-1">Akhir</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $id = $data['id'];
                            
                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$data[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM bimtek_peserta WHERE id_bimtek = '$id'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo $data['nama_bimtek'].' - '.$dsemester['nama'].' '.$dnta['ta'];?> </td>
                            <td width="14%" class="text-center"> <?php echo $data['start_datetime'];?> </td>
                            <td width="14%" class="text-center"> <?php echo $data['end_datetime'];?> </td>
                            <td width="6%" class="text-center pr-1"> <?php if($data['status']==1) { echo "<button class='btn btn-outline-primary btn-flat btn-xs btn-block' title='Sedang aktif'><i class='fas fa-calendar-check'></i></button>";} else { echo "<a class='btn btn-outline-secondary btn-flat btn-xs btn-block' title='Tidak aktif' href='updateStatusPeriodeBimtek.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin periode pendaftaran ini diaktifkan?\")'><i class='far fa-calendar-times'></i></a>";}?> </td>
                            <td class="text-center" width="6%"> <a href="editPeriodePendBimtekAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Edit periode"><i class="far fa-edit"></i></a> </td>
                            <td class="text-center" width="6%"> <a href="rekapPndftrBimtekAdm.php?id_bimtek=<?php echo $id;?>" class="btn btn-outline-info btn-flat btn-xs btn-block" title="Lihat Pendaftar"><i class="fas fa-users"></i> Detail</a> </td>
                            <td class="text-center" width="6%"> <a href="plotReviewerBimtekAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Manajemen Reviewer"><i class="fas fa-user-tie"></i> Reviewer</a> </td>
                            <td class="text-center pr-1" width="6%"> <?php if($data1['jumData'] > 0) { echo "<a  class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Sudah ada peserta\")' title='Tidak bisa dihapus! Sudah ada peserta' disabled><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-flat btn-xs btn-block' href='deletePeriodeBimtek.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='far fa-trash-alt'></i></a>";}?> </td>
                          </tr>
                          <?php
                            $i++; 
                            $count++;
                            }
                            ?>                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages); ?></div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
      <form action="spndftrnBimtekAdm.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-secondary">
              <div class="modal-header">
                <h6 class="modal-title" id="inputModalLabel">Input Periode Baru & Detail Pelaksanaan</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
                <input type="text" name="kaprodi" class="sr-only" value="<?php echo $dkaprodi['id'];?>" required readonly>
                <input type="text" name="ta" class="sr-only" value="<?php echo $dta['id'];?>" required readonly>
                
                <div class="row">
                  <div class="col-md-6 border-right">
                    <h5>Periode Pendaftaran</h5>
                    <div class="form-group">
                      <label for="nama_bimtek">Nama Bimtek</label>
                      <input type="text" name="nama_bimtek" class="form-control form-control-sm bg-transparent text-white" placeholder="Contoh: Bimtek Penulisan TA Gelombang 1" required>
                    </div>
                    
                    <div class="form-group">
                      <label for="start_datetime">Waktu Awal Pendaftaran</label>
                      <div class="input-group date" id="start_datetime_input" data-target-input="nearest">
                        <input type="text" name="start_datetime" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#start_datetime_input" required/>
                        <div class="input-group-append" data-target="#start_datetime_input" data-toggle="datetimepicker">
                          <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="end_datetime">Waktu Akhir Pendaftaran</label>
                      <div class="input-group date" id="end_datetime_input" data-target-input="nearest">
                        <input type="text" name="end_datetime" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#end_datetime_input" required/>
                        <div class="input-group-append" data-target="#end_datetime_input" data-toggle="datetimepicker">
                          <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="tgl_tampil_pengumuman">Tampilkan Pengumuman ke Mahasiswa Sejak</label>
                      <div class="input-group date" id="tgl_tampil_pengumuman_input" data-target-input="nearest">
                        <input type="text" name="tgl_tampil_pengumuman" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#tgl_tampil_pengumuman_input" required/>
                        <div class="input-group-append" data-target="#tgl_tampil_pengumuman_input" data-toggle="datetimepicker">
                          <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="file_pengumuman">File Pengumuman (PDF, Max 5MB)</label>
                      <div class="custom-file">
                        <input type="file" name="file_pengumuman" class="custom-file-input" id="file_pengumuman">
                        <label class="custom-file-label bg-transparent text-white" for="file_pengumuman">Pilih file...</label>
                      </div>
                    </div>
                    
                    <div class="custom-control custom-radio custom-control-inline">
                      <input name="status" type="radio" id="customRadioInline1" class="custom-control-input" value="1" checked>
                      <label class="custom-control-label" for="customRadioInline1">Aktifkan</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input name="status" type="radio" id="customRadioInline2" class="custom-control-input" value="2">
                      <label class="custom-control-label" for="customRadioInline2">Non Aktifkan</label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <h5>Detail Pelaksanaan</h5>
                    <div class="form-group">
                      <label for="pemateri">Pemateri</label>
                      <input type="text" name="pemateri" class="form-control form-control-sm bg-transparent text-white" placeholder="Nama Pemateri" required>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <h6><i class="fas fa-building"></i> Sesi Offline (Tatap Muka)</h6>
                        <div class="form-group">
                          <label for="tempat_offline">Tempat / Ruangan</label>
                          <input type="text" name="tempat_offline" class="form-control form-control-sm bg-transparent text-white" placeholder="Contoh: Aula Lt. 4">
                        </div>
                        <div class="form-group">
                          <label for="waktu_offline">Waktu Pelaksanaan Offline</label>
                          <div class="input-group date" id="waktu_offline_input" data-target-input="nearest">
                            <input type="text" name="waktu_offline" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#waktu_offline_input"/>
                            <div class="input-group-append" data-target="#waktu_offline_input" data-toggle="datetimepicker">
                              <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 mt-3 border-top pt-2">
                        <h6><i class="fas fa-video"></i> Sesi Online (Virtual)</h6>
                        <div class="form-group">
                          <label for="link_online">Link Zoom / GMeet</label>
                          <input type="text" name="link_online" class="form-control form-control-sm bg-transparent text-white" placeholder="https://zoom.us/j/...">
                        </div>
                        <div class="form-group">
                          <label for="waktu_online">Waktu Pelaksanaan Online</label>
                          <div class="input-group date" id="waktu_online_input" data-target-input="nearest">
                            <input type="text" name="waktu_online" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#waktu_online_input"/>
                            <div class="input-group-append" data-target="#waktu_online_input" data-toggle="datetimepicker">
                              <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-warning btn-flat btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary btn-flat btn-sm">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(function () {
          $('#start_datetime_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#end_datetime_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#tgl_tampil_pengumuman_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#waktu_offline_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
          $('#waktu_online_input').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
      });
      $(document).ready(function () {
        bsCustomFileInput.init();
      });
    </script>
  </body>
</html>
