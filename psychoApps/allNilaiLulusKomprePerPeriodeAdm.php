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
  $passing_grade = $didper['passing_grade'];
  
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
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Rekap Nilai Kompre <?php echo 'Tahap '.$dthp['tahap'].' <span class="small text-secondary">'.$djp['nm'].'</span> '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapNilaiKompreAdm.php?page=<?php echo $page;?>">Rekap Nilai Kompre</a></li>
                  <li class="breadcrumb-item active small">List Peserta Lulus</li>
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
                      <h4 class="card-title float-left">List Peserta Lulus</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td rowspan="2" width="4%" class="pl-1">No.</td>
                            <td rowspan="2" width="38%">Nama</td>
                            <td colspan="3" class="border-bottom-0">Jadwal Ujian</td>
                            <td rowspan="2" width="12%" class="pr-1">Nilai</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="10%" class="pl-1">Tanggal</td>
                            <td width="10%">Pukul</td>
                            <td width="22%" class="pr-1">Ruang</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_kompre INNER JOIN dt_mhssw ON peserta_kompre.nim=dt_mhssw.nim WHERE (peserta_kompre.id_kompre='$id') AND (peserta_kompre.hasil_ujian <= 100 AND peserta_kompre.hasil_ujian >='$passing_grade') ORDER BY dt_mhssw.nama ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rmhssw = mysqli_query($con, $qry_mhssw);
                            $dmhssw = mysqli_fetch_assoc($rmhssw);

                            $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE nim='$data[nim]'";
                            $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
                            $dfrek = mysqli_fetch_assoc( $hfrek );
                            
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
                            
                            $qry_grade = "SELECT * FROM grade_kompre WHERE id_kompre='$id'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_assoc($res_grade);

                            $qry_jdwl = "SELECT * FROM jadwal_kompre WHERE id='$data[id_jdwl]'";
                            $rjdwl = mysqli_query($con, $qry_jdwl);
                            $djdwl = mysqli_fetch_assoc($rjdwl);
                            
                            $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$djdwl[ruang]'";
                            $rruang = mysqli_query($con, $qry_ruang);
                            $druang = mysqli_fetch_assoc($rruang);
                            
                            $qry_pengawas1 = "SELECT * FROM dt_pengawas_kompre WHERE id='$djdwl[pengawas1]'";
                            $rpengawas1 = mysqli_query($con, $qry_pengawas1);
                            $dpengawas1 = mysqli_fetch_assoc($rpengawas1);
                            
                            $qry_pengawas2 = "SELECT * FROM dt_pengawas_kompre WHERE id='$djdwl[pengawas2]'";
                            $rpengawas2 = mysqli_query($con, $qry_pengawas2);
                            $dpengawas2 = mysqli_fetch_assoc($rpengawas2);
                            
                            $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
                            $hdt_cek = mysqli_query($con, $qdt_cek);
                            $dcek = mysqli_fetch_assoc($hdt_cek);
                            $no++;
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php if($data['statusform']==1) { echo '<div class="clearfix"><div class="float-left">'.$dmhssw['nama'].' / '.$dmhssw['nim'].'</div><div class="float-right"><i class="fas fa-user-edit text-warning" title="'.$dcek['nm'].'"></i></div></div>';} else if($data['statusform']==2) { echo '<div class="clearfix"><div class="float-left">'.$dmhssw['nama'].' / '.$dmhssw['nim'].'</div><div class="float-right"><i class="fas fa-user-check text-success" title="'.$dcek['nm'].'"></i></div></div>';}?> </td>
                            <td class="text-center"> <?php if(empty($data['id_jdwl'])) { echo "Belum terjadwal";} else { echo $djdwl['tgl_kompre'];}?> </td>
                            <td class="text-center"> <?php if(empty($data['id_jdwl'])) { echo "Belum terjadwal";} else { echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];}?> </td>
                            <td class="text-center"> <?php if(empty($data['id_jdwl'])) { echo "Belum terjadwal";} else { echo $druang['nm'];}?> </td>
                            <td class="text-center pr-1"> <?php if(empty($data['hasil_ujian'])) { echo "Belum ada";} elseif($data['hasil_ujian'] <= 100 && $data['hasil_ujian'] >= 85) { echo $data['hasil_ujian']. ' (A)';} elseif ($data['hasil_ujian'] <= 84 && $data['hasil_ujian'] >= 75) { echo $data['hasil_ujian']. ' (B+)';} elseif ($data['hasil_ujian'] <= 74  && $data['hasil_ujian'] >= 70) { echo $data['hasil_ujian']. ' (B)';} elseif ($data['hasil_ujian'] <= 69 && $data['hasil_ujian'] >= 65) { echo $data['hasil_ujian']. ' (C+)';} elseif ($data['hasil_ujian'] <= 64 && $data['hasil_ujian'] >= 60) { echo $data['hasil_ujian']. ' (C)';} elseif ($data['hasil_ujian'] < 60) {echo $data['hasil_ujian']. ' (D)';}?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="6">
                              <section class="content pt-2">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-md-5">
                                      <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                          <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                              src="<?php echo $dmhssw['photo'];?>" onError="this.onerror=null;this.src='<?php if($dmhssw['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="">
                                          </div>
                                          <h3 class="profile-username text-center"><?php echo $dmhssw['nama'];?></h3>
                                          <p class="text-muted text-center"><?php echo $dmhssw['nim'];?></p>
                                          <ul class="list-group list-group-unbordered mb-3 text-left">
                                            <li class="list-group-item">
                                              <b>Kontak</b> <a class="float-right"><?php echo $dmhssw['kntk'];?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Email</b> <a class="float-right"><?php echo $dmhssw['imel'];?></a>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-7">
                                      <?php include('detailPesKompreAdm.php');?>
                                    </div>
                                  </div>
                                </div>
                              </section>
                            </td>
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