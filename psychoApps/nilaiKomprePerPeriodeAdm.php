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
                  <li class="breadcrumb-item active small">Nilai Ujian</li>
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
                      <h4 class="card-title float-left">Nilai Ujian</h4>
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
                            <td colspan="2" class="border-bottom-0">Penilaian</td>
                            <td width="10%" class="pr-1" rowspan="2" colspan="2">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="12%" class="pl-1">Tanggal</td>
                            <td width="10%">Pukul</td>
                            <td width="20%">Ruang</td>
                            <td width="18%">I</td>
                            <td width="18%">II</td>
                            <td width="4%">Belum</td>
                            <td width="4%" class="pr-1">Selesai</td>

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
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE hasil_ujian='' AND id_jdwl='$data[id]' AND id_kompre='$id_kompre'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );

                            $qry2 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE hasil_ujian <> '' AND id_jdwl='$data[id]' AND id_kompre='$id_kompre'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE id_jdwl='$data[id]' AND id_kompre='$id_kompre'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );

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
                            <td class="text-center"> <?php echo $data1['jumData'];?> </td>
                            <td class="text-center"> <?php echo $data2['jumData'];?> </td>
                            <td class="text-center pr-1"> <?php if($data3['jumData']==0) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data"><i class="fas fa-chart-line"></i> Input Nilai</a>';} else { echo '<a href="inputNilaiPesertaKompreAdm.php?id='.$id_jadwal.'&id_kompre='.$id_kompre.'&page='.$page.'" class="btn btn-outline-danger btn-flat btn-xs btn-block" title="Input nilai kompre"><i class="fas fa-chart-line"></i> Input Nilai</a>';}?> </td>
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
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>