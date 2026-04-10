<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $angkatan = mysqli_real_escape_string($con,  $_GET[ 'angkatan' ] );
  $page0 = mysqli_real_escape_string($con,  $_GET[ 'page0' ] );
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
                <h6 class="m-0">Rekap Nilai PKL</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapNilaiPklAdm.php?page=<?php echo $page0;?>">Rekap Nilai PKL</a></li>
                  <li class="breadcrumb-item active small">Nilai PKL Angkatan <?php echo $angkatan;?></li>
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
                      <h4 class="card-title float-left">Nilai PKL Angkatan <?php echo $angkatan;?></h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="2" class="pl-1">No.</td>
                            <td width="16%" rowspan="2">Periode Pendaftaran</td>
                            <td class="border-bottom-0" colspan="7">Nilai</td>
                            <td width="16%" rowspan="2">Total</td>
                            <td rowspan="2" colspan="2" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="8%" class="pl-1">A</td>
                            <td width="8%">B+</td>
                            <td width="8%">B</td>
                            <td width="8%">C+</td>
                            <td width="8%">C</td>
                            <td width="8%">D</td>
                            <td width="8%" class="pr-1">Belum Ada</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_pkl WHERE angkatan='$angkatan' GROUP BY id_pkl";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {

                            $id = $data['id_pkl'];
                            
                            $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id' ORDER BY '$id' DESC";
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
                            
                            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$id'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);
                            
                            $qry111 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE (nilai <= '$dt_grade[at]' AND nilai >= '$dt_grade[ab]') AND (angkatan='$angkatan') AND (id_pkl='$id')";
                            $has111 = mysqli_query($con,  $qry111 )or DIE( mysqli_error($con) );
                            $data111 = mysqli_fetch_assoc( $has111 );
                              
                            $qry222 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE (nilai <= '$dt_grade[bplust]' AND nilai >= '$dt_grade[bplusb]') AND (angkatan='$angkatan') AND (id_pkl='$id')";
                            $has222 = mysqli_query($con,  $qry222 )or DIE( mysqli_error($con) );
                            $data222 = mysqli_fetch_assoc( $has222 );
                              
                            $qry333 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE (nilai <= '$dt_grade[bt]' AND nilai >= '$dt_grade[bb]') AND (angkatan='$angkatan') AND (id_pkl='$id')";
                            $has333 = mysqli_query($con,  $qry333 )or DIE( mysqli_error($con) );
                            $data333 = mysqli_fetch_assoc( $has333 );
                              
                            $qry444 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE (nilai <= '$dt_grade[cplust]' AND nilai >= '$dt_grade[cplusb]') AND (angkatan='$angkatan') AND (id_pkl='$id')";
                            $has444 = mysqli_query($con,  $qry444 )or DIE( mysqli_error($con) );
                            $data444 = mysqli_fetch_assoc( $has444 );
                            
                            $qry555 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE (nilai <= '$dt_grade[ct]' AND nilai >= '$dt_grade[cb]') AND (angkatan='$angkatan') AND (id_pkl='$id')";
                            $has555 = mysqli_query($con,  $qry555 )or DIE( mysqli_error($con) );
                            $data555 = mysqli_fetch_assoc( $has555 );
                            
                            $qry666 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE (nilai <= '$dt_grade[dt]' AND nilai >= '$dt_grade[db]') AND (angkatan='$angkatan') AND (id_pkl='$id')";
                            $has666 = mysqli_query($con,  $qry666 )or DIE( mysqli_error($con) );
                            $data666 = mysqli_fetch_assoc( $has666 );
                            
                            $qry777 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nilai = '' AND (angkatan='$angkatan') AND (id_pkl='$id')";
                            $has777 = mysqli_query($con,  $qry777 )or DIE( mysqli_error($con) );
                            $data777 = mysqli_fetch_assoc( $has777 );
                            
                            $qry888 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE angkatan='$angkatan' AND id_pkl='$id'";
                            $has888 = mysqli_query($con,  $qry888 )or DIE( mysqli_error($con) );
                            $data888 = mysqli_fetch_assoc( $has888 );
                            $no++;
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-center"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php if($data111['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data (Grade A: '.$dt_grade['ab'].' sd. '.$dt_grade['at'].')" onclick="return confirm(\'Tidak ada data\')">'.$data111['jumData'].'</a>';} else { echo '<a href="nilaiPklAPerAngkAdm.php?angkatan='.$angkatan.'&id='.$id.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data (Grade A: '.$dt_grade['ab'].' sd. '.$dt_grade['at'].')">'.$data111['jumData'].'</a>';} ?> </td>
                            <td class="text-left"> <?php if($data222['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data (Grade B+: '.$dt_grade['bplusb'].' sd. '.$dt_grade['bplust'].')" onclick="return confirm(\'Tidak ada data\')">'.$data222['jumData'].'</a>';} else { echo '<a href="nilaiPklBplusPerAngkAdm.php?angkatan='.$angkatan.'&id='.$id.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data (Grade B+: '.$dt_grade['bplusb'].' sd. '.$dt_grade['bplust'].')">'.$data222['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data333['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data (Grade B: '.$dt_grade['bb'].' sd. '.$dt_grade['bt'].')" onclick="return confirm(\'Tidak ada data\')">'.$data333['jumData'].'</a>';} else { echo '<a href="nilaiPklBPerAngkAdm.php?angkatan='.$angkatan.'&id='.$id.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data (Grade B: '.$dt_grade['bb'].' sd. '.$dt_grade['bt'].')">'.$data333['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data444['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data (Grade C+: '.$dt_grade['cplusb'].' sd. '.$dt_grade['cplust'].')" onclick="return confirm(\'Tidak ada data\')">'.$data444['jumData'].'</a>';} else { echo '<a href="nilaiPklCplusPerAngkAdm.php?angkatan='.$angkatan.'&id='.$id.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data (Grade C+: '.$dt_grade['cplusb'].' sd. '.$dt_grade['cplust'].')">'.$data444['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data555['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data (Grade C: '.$dt_grade['cb'].' sd. '.$dt_grade['ct'].')" onclick="return confirm(\'Tidak ada data\')">'.$data555['jumData'].'</a>';} else { echo '<a href="nilaiPklCPerAngkAdm.php?angkatan='.$angkatan.'&id='.$id.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data (Grade C: '.$dt_grade['cb'].' sd. '.$dt_grade['ct'].')">'.$data555['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data666['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data (Grade D: '.$dt_grade['db'].' sd. '.$dt_grade['dt'].')" onclick="return confirm(\'Tidak ada data\')">'.$data666['jumData'].'</a>';} else { echo '<a href="nilaiPklDPerAngkAdm.php?angkatan='.$angkatan.'&id='.$id.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data (Grade D: '.$dt_grade['db'].' sd. '.$dt_grade['dt'].')">'.$data666['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data777['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data777['jumData'].'</a>';} else { echo '<a href="nilaiPklBelumPerAngkAdm.php?angkatan='.$angkatan.'&id='.$id.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data777['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data888['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data888['jumData'].'</a>';} else { echo '<a href="allNilaiPklPerAngkAdm.php?angkatan='.$angkatan.'&id='.$id.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data888['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakAllDataNilaiPklPerAngkPerPeriodeAdm.php?angkatan=<?php echo $angkatan;?>&id=<?php echo $id;?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporAllDataNilaiPklPerAngkPerPeriodeAdm.php?angkatan=<?php echo $angkatan;?>&id=<?php echo $id;?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
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