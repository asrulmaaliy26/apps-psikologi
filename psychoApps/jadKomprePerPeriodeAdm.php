<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qper = "SELECT * FROM peserta_kompre WHERE id_kompre='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_kompre WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_jenis_periode = "SELECT * FROM opsi_kategori_periode_kompre WHERE id='$didper[jenis_periode]'";
  $hasil = mysqli_query($con, $qry_jenis_periode);
  $djp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
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
              <span>Input berhasil!</span>
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
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pendaftaran Ujian Kompre <?php echo 'Tahap '.$dthp['tahap'].' <span class="small text-secondary">'.$djp['nm'].'</span> '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pndftrnKompreAdm.php?page=<?php echo $page;?>">Periode Pendaftaran</a></li>
                  <li class="breadcrumb-item active small">Jadwal Ujian</li>
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
                      <h4 class="card-title float-left">Jadwal Ujian</h4>
                      <button type="button" class="btn btn-outline-danger btn-flat btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="fas fa-calendar-plus"></i> Input Jadwal Baru</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td class="border-bottom-0" colspan="3">Pelaksanaan</td>
                            <td colspan="2" class="border-bottom-0">Pengawas</td>
                            <td width="4%" rowspan="2" class="border-bottom-0">Peserta</td>
                            <td class="pr-1" rowspan="2" colspan="4">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="12%" class="pl-1">Tanggal</td>
                            <td width="10%">Pukul</td>
                            <td width="16%">Ruang</td>
                            <td width="16%">I</td>
                            <td width="16%" class="pr-1">II</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM jadwal_kompre WHERE id_kompre='$id' ORDER BY id DESC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            $no++;
                            $id_jadwal = $data['id'];
                            $id_kompre = $data['id_kompre'];
                            $sesuaikanTgl = date("d-m-Y", strtotime($data['tgl_kompre']));
                            
                            $qidper = "SELECT * FROM pendaftaran_kompre WHERE id='$id_kompre'";
                            $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
                            $didper = mysqli_fetch_assoc($ridper);
                            
                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_jenis_periode = "SELECT * FROM opsi_kategori_periode_kompre WHERE id='$didper[jenis_periode]'";
                            $hasil = mysqli_query($con, $qry_jenis_periode);
                            $djp = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qrypgws1 = "SELECT * FROM dt_pengawas_kompre WHERE id='$data[pengawas1]'";
                            $respgws1 = mysqli_query($con,  $qrypgws1 )or die( mysqli_error($con) );
                            $dpgws1 = mysqli_fetch_assoc( $respgws1 );        
                              
                            $qrypgws2 = "SELECT * FROM dt_pengawas_kompre WHERE id='$data[pengawas2]'";
                            $respgws2 = mysqli_query($con,  $qrypgws2 )or die( mysqli_error($con) );
                            $dpgws2 = mysqli_fetch_assoc( $respgws2 );        
                              
                            $qryruang = "SELECT * FROM dt_ruang WHERE id='$data[ruang]'";
                            $resruang = mysqli_query($con,  $qryruang )or die( mysqli_error($con) );
                            $druang = mysqli_fetch_assoc( $resruang );
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE id_jdwl='$data[id]' AND id_kompre='$id_kompre'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );

                            $qry2 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE id_kompre='$id_kompre' AND statusform='1'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $formatTgl=date("d-m-Y", strtotime($data['tgl_kompre']));
                              $day = date('D', strtotime($formatTgl));
                              $dayList = array(
                              'Sun' => 'Minggu',
                              'Mon' => 'Senin',
                              'Tue' => 'Selasa',
                              'Wed' => 'Rabu',
                              'Thu' => 'Kamis',
                              'Fri' => "Jum'at",
                              'Sat' => 'Sabtu'
                              );                             
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $dayList[$day].', '.$sesuaikanTgl;?> </td>
                            <td class="text-center"> <?php echo $data['jam_mulai'].' s.d '.$data['jam_selesai'];?> </td>
                            <td class="text-center"> <?php echo $druang['nm'];?> </td>
                            <td class="text-center"> <?php echo $dpgws1['nm'];?> </td>
                            <td class="text-center"> <?php echo $dpgws2['nm'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data1['jumData'].'</a>';} else { echo '<a href="pesKomprePerJadwalAdm.php?id='.$id_jadwal.'&id_kompre='.$id_kompre.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center" width="10%"> <?php if($data2['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data"><i class="fas fa-user-plus"></i> Input Peserta</a>';} else { echo '<a href="inputJadwalPesertaKompreAdm.php?id='.$id_jadwal.'&id_kompre='.$id_kompre.'&page='.$page.'" class="btn btn-outline-danger btn-flat btn-xs btn-block" title="Input peserta kompre"><i class="fas fa-user-plus"></i> Input Peserta</a>';}?> </td>
                            <td class="text-center" width="4%"> <a href="editJadKomprePerPeriodeAdm.php?id=<?php echo $id_jadwal;?>&id_kompre=<?php echo $id_kompre;?>&page=<?php echo $page;?>" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Edit jadwal"><i class="far fa-edit"></i></a> </td>
                            <td class="text-center" width="4%"> <a href="cetakAbsJdwlKompreAdm.php?id=<?php echo $id_jadwal;?>&page=<?php echo $page;?>" target="_blank" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak jadwal dan presensi"><i class="fas fa-print"></i></a> </td>
                            <td class="text-center pr-1" width="4%"> <?php if(($data1['jumData'] > 0)) { echo "<a class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Sudah ada peserta ujian\")' title='Tidak bisa dihapus! Sudah ada peserta ujian' disabled><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-flat btn-xs btn-block' href='deleteJadKompreAdm.php?id=".$id_jadwal."&id_kompre=".$id_kompre."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='far fa-trash-alt'></i></a>";}?> </td>
                          </tr>
                          <?php
                            }
                            ?>                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
      <form action="sformInputJadwalKompreAdm.php" method="post">
        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-secondary">
              <div class="modal-header">
                <h6 class="modal-title" id="inputModalLabel">Input Jadwal Baru</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="text" name="id_kompre" class="sr-only" value="<?php echo $id;?>" required readonly>
                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                <div class="form-group">
                  <label for="pengawas1">Pengawas I</label>
                  <select name="pengawas1" class="form-control form-control-sm bg-secondary text-white" id="pengawas1" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM dt_pengawas_kompre ORDER BY nm ASC");
                      while ($tampil = mysqli_fetch_array($q)){
                        echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="pengawas2">Pengawas II</label>
                  <select name="pengawas2" class="form-control form-control-sm bg-secondary text-white" id="pengawas2" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM dt_pengawas_kompre ORDER BY nm ASC");
                      while ($tampil = mysqli_fetch_array($q)){
                        echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="ruang">Ruang</label>
                  <select name="ruang" class="form-control form-control-sm bg-secondary text-white" id="ruang" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM dt_ruang ORDER BY nm ASC");
                      while ($tampil = mysqli_fetch_array($q)){
                        echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="tgl_kompre">Tanggal</label>
                  <div class="input-group date" id="tgl_kompre_input" data-target-input="nearest">
                    <input type="text" name="tgl_kompre" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#tgl_kompre_input" required/>
                    <div class="input-group-append" data-target="#tgl_kompre_input" data-toggle="datetimepicker">
                      <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="jam_mulai">Jam Mulai</label>
                  <div class="input-group date" id="jam_mulai" data-target-input="nearest">
                    <input type="text" name="jam_mulai" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#jam_mulai" required/>
                    <div class="input-group-append" data-target="#jam_mulai" data-toggle="datetimepicker">
                      <div class="input-group-text bg-transparent text-white"><i class="fas fa-clock"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="jam_selesai">Jam Mulai</label>
                  <div class="input-group date" id="jam_selesai" data-target-input="nearest">
                    <input type="text" name="jam_selesai" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#jam_selesai" required/>
                    <div class="input-group-append" data-target="#jam_selesai" data-toggle="datetimepicker">
                      <div class="input-group-text bg-transparent text-white"><i class="fas fa-clock"></i></div>
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
          $('#tgl_kompre_input').datetimepicker({
              format: 'YYYY-MM-DD',
              icons: {
              date: "fas fa-calendar-alt",
              up: "fas fa-chevron-up",
              down: "fas fa-chevron-down",
              previous: 'fas fa-chevron-left',
              next: 'fas fa-chevron-right'
          }
          });
      });
      
      $(function () {
          $('#jam_mulai').datetimepicker({
              format: 'HH:mm',
              icons: {
              time: "fas fa-clock",
              up: "fas fa-chevron-up",
              down: "fas fa-chevron-down"
          }
          });
      });
      
      $(function () {
          $('#jam_selesai').datetimepicker({
              format: 'HH:mm',
              icons: {
              time: "fas fa-clock",
              up: "fas fa-chevron-up",
              down: "fas fa-chevron-down"
          }
          });
      });
    </script>
  </body>
</html>