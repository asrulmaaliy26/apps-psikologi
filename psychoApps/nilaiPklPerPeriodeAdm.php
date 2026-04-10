<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qper = "SELECT * FROM peserta_pkl WHERE id_pkl='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);

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
                <h6 class="m-0">Pendaftaran PKL <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pndftrnPklAdm.php?page=<?php echo $page;?>">Periode Pendaftaran</a></li>
                  <li class="breadcrumb-item active small">Nilai PKL</li>
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
                      <h4 class="card-title float-left">Nilai PKL</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="24%" rowspan="2">Nama DPL</td>
                            <td width="48%" rowspan="2">Lokasi PKL</td>
                            <td width="6%" rowspan="2">Peserta</td>
                            <td colspan="2" class="border-bottom-0">Penilaian</td>
                            <td width="10%" class="pr-1" rowspan="2" colspan="2">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">Belum</td>
                            <td width="4%" class="pr-1">Selesai</td>

                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT dpl_pkl.id AS id_dpl, dpl_pkl.id_pkl AS id_pkl, dpl_pkl.nip AS nip, dpl_pkl.lokasi AS lokasi FROM dpl_pkl INNER JOIN dt_pegawai ON dpl_pkl.nip=dt_pegawai.id WHERE dpl_pkl.id_pkl='$id' ORDER BY dt_pegawai.nama_tg ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $id_dpl = $data['id_dpl'];
                            $id_pkl = $data['id_pkl'];

                            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$data[id_pkl]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);

                            $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$data[nip]'";
                            $res_dpl = mysqli_query($con, $qry_dpl);
                            $dt_dpl = mysqli_fetch_assoc($res_dpl);

                            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dt_dpl[kepakaran_mayor]'";
                            $rr = mysqli_query($con, $qr)or die( mysqli_error($con));
                            $dr = mysqli_fetch_assoc($rr);
                                                        
                            $qry1 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE id_pkl='$data[id_pkl]' AND dpl='$data[nip]' AND id_dpl='$data[id_dpl]'";
                            $has1 =  mysqli_query($con, $qry1 )or die(mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );

                            $qry2 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nilai='' AND id_pkl='$data[id_pkl]' AND dpl='$data[nip]' AND id_dpl='$data[id_dpl]'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );

                            $qry3 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nilai <> '' AND id_pkl='$data[id_pkl]' AND dpl='$data[nip]' AND id_dpl='$data[id_dpl]'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            $no++;
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $dt_dpl['nama_tg'];?> </td>
                            <td class="text-left"> <?php echo $data['lokasi'];?> </td>
                            <td class="text-center"> <?php echo $data1['jumData'];?> </td>
                            <td class="text-center"> <?php echo $data2['jumData'];?> </td>
                            <td class="text-center"> <?php echo $data3['jumData'];?> </td>
                            <td class="text-center pr-1"> <?php if($data1['jumData']==0) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data"><i class="fas fa-chart-line"></i> Input Nilai</a>';} else { echo '<a href="inputNilaiPesertaPklAdm.php?id='.$id_dpl.'&id_pkl='.$id_pkl.'&page='.$page.'" class="btn btn-outline-danger btn-flat btn-xs btn-block" title="Input nilai"><i class="fas fa-chart-line"></i> Input Nilai</a>';}?> </td>
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