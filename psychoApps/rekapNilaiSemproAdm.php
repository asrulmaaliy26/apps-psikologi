<?php include( "contentsConAdm.php" );
  $qta = "SELECT * FROM dt_ta WHERE status='1'";
  $rta = mysqli_query($con, $qta)or die( mysqli_error($con));
  $dta = mysqli_fetch_assoc($rta);   
   
  $qwd1 = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '36'";
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
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Nilai Seminar Proposal</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Nilai Seminar Proposal</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "rekapNilaiSemproAdm.php?pagination=true";
           $sql = "SELECT * FROM pendaftaran_sempro ORDER BY status ASC, start_datetime DESC";
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
                      <h4 class="card-title float-left">Nilai Seminar Proposal Per Periode</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="2" class="pl-1">No.</td>
                            <td width="20%" rowspan="2">Periode Pendaftaran</td>
                            <td class="border-bottom-0" colspan="2">Durasi Pendaftaran</td>
                            <td class="border-bottom-0" colspan="2">Nilai dari Penguji I</td>
                            <td class="border-bottom-0" colspan="2">Nilai dari Penguji II</td>
                            <td width="8%" rowspan="2">Pendaftar</td>
                            <td rowspan="2" colspan="3" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="12%" class="pl-1">Mulai</td>
                            <td width="12%" class="pr-1">Akhir</td>
                            <td width="8%" class="pl-1">Belum Diisi</td>
                            <td width="8%" class="pr-1">Telah Diisi</td>
                            <td width="8%" class="pl-1">Belum Diisi</td>
                            <td width="8%" class="pr-1">Telah Diisi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $id = $data['id'];
                            $tahap = $data['tahap'];
                            
                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$tahap'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$data[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qry_grade = "SELECT * FROM grade_sempro WHERE id_sempro='$id'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);

                            $qry1 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE nilai_narsum1 = '0' AND id_sempro='$id'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                              
                            $qry2 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE nilai_narsum1 != '0' AND id_sempro='$id'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );

                            $qry3 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE nilai_narsum2 = '0' AND id_sempro='$id'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );

                            $qry4 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE nilai_narsum2 != '0' AND id_sempro='$id'";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );

                            $qry5 = "SELECT COUNT(id) AS jumData FROM peserta_sempro WHERE id_sempro = '$id'";
                            $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
                            $data5 = mysqli_fetch_assoc( $has5 );
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php echo $data['start_datetime'];?> </td>
                            <td class="text-center"> <?php echo $data['end_datetime'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data1['jumData'].'</a>';} else { echo '<a href="nilaiSemproPenguji1BelumPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data2['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data2['jumData'].'</a>';} else { echo '<a href="nilaiSemproPenguji1SelesaiPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data2['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data3['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data3['jumData'].'</a>';} else { echo '<a href="nilaiSemproPenguji2BelumPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data3['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data4['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data4['jumData'].'</a>';} else { echo '<a href="nilaiSemproPenguji2SelesaiPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data4['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data5['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data5['jumData'].'</a>';} else { echo '<a href="rekapPesSemproPerPeriodeNilaiAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data5['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <?php if($data2['jumData']==0 && $data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-book-open"></i></a>';} else { echo '<a href="detailNilaiSemproPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Lihat detail nilai"><i class="fas fa-book-open"></i></a>';} ?> </td>
                             <td width="4%" class="text-center"> <?php if($data2['jumData']==0 && $data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-print"></i></a>';} else { echo '<a href="cetakNilaiSemproPerPeriodeAdm.php?id='.$id.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" target="_blank" title="Cetak data"><i class="fas fa-print"></i></a>';} ?> </td>
                             <td width="4%" class="text-center pr-1"> <?php if($data2['jumData']==0 && $data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-download"></i></a>';} else { echo '<a href="eksporNilaiSemproPerPeriodeAdm.php?id='.$id.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a>';} ?> </td>
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
            <div class="row">
              <?php
                include 'pagination0.php';
                $reload0 = "rekapNilaiSemproAdm.php?pagination0=true";
                $sql0 = "SELECT * FROM nilai_sempro INNER JOIN dt_mhssw ON nilai_sempro.nim=dt_mhssw.nim GROUP BY nilai_sempro.angkatan ORDER BY nilai_sempro.angkatan DESC";
                $result0 = mysqli_query($con, $sql0);
                
                $rpp0 = 10;
                $page0 = isset($_GET["page0"]) ? (intval($_GET["page0"])) : 1;
                $tcount0 = mysqli_num_rows($result0);
                $tpages0 = ($tcount0) ? ceil($tcount0/$rpp0) : 1;
                $count0 = 0;
                $i0 = ($page0-1)*$rpp0;
                $no_urut0 = ($page0-1)*$rpp0;
                ?>
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h4 class="card-title float-left">Form Berita Acara Seminar Proposal Per Angkatan</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="2" class="pl-1">No.</td>
                            <td width="44%" rowspan="2">Angkatan</td>
                            <td class="border-bottom-0" colspan="2">Nilai dari Penguji I</td>
                            <td class="border-bottom-0" colspan="2">Nilai dari Penguji II</td>
                            <td width="8%" rowspan="2">Pendaftar</td>
                           <td rowspan="2" colspan="3" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="8%" class="pl-1">Belum Diisi</td>
                            <td width="8%" class="pr-1">Telah Diisi</td>
                            <td width="8%" class="pl-1">Belum Diisi</td>
                            <td width="8%" class="pr-1">Telah Diisi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count0<$rpp0) && ($i0<$tcount0)) {
                            mysqli_data_seek($result0, $i0);
                            $data0 = mysqli_fetch_array($result0);
                            $angkatan=$data0['angkatan'];
                            
                            $qry11 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE nilai_narsum1 = '0' AND angkatan='$angkatan'";
                            $has11 = mysqli_query($con,  $qry11 )or DIE( mysqli_error($con) );
                            $data11 = mysqli_fetch_assoc( $has11 );

                            $qry22 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE nilai_narsum1 != '0' AND angkatan='$angkatan'";
                            $has22 = mysqli_query($con,  $qry22 )or DIE( mysqli_error($con) );
                            $data22 = mysqli_fetch_assoc( $has22 );

                            $qry33 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE nilai_narsum2 = '0' AND angkatan='$angkatan'";
                            $has33 = mysqli_query($con,  $qry33 )or DIE( mysqli_error($con) );
                            $data33 = mysqli_fetch_assoc( $has33 );

                            $qry44 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE nilai_narsum2 != '0' AND angkatan='$angkatan'";
                            $has44 = mysqli_query($con,  $qry44 )or DIE( mysqli_error($con) );
                            $data44 = mysqli_fetch_assoc( $has44 );

                            $qry55 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE angkatan='$angkatan'";
                            $has55 = mysqli_query($con,  $qry55 )or DIE( mysqli_error($con) );
                            $data55 = mysqli_fetch_assoc( $has55 );
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut0;?> </td>
                            <td class="text-center"> <?php echo $data0['angkatan'];?> </td>
                            <td class="text-center"> <?php if($data11['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data11['jumData'].'</a>';} else { echo '<a href="nilaiSemproPenguji1BelumPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data11['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data22['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data22['jumData'].'</a>';} else { echo '<a href="nilaiSemproPenguji1SelesaiPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data22['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data33['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data33['jumData'].'</a>';} else { echo '<a href="nilaiSemproPenguji2BelumPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data33['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data44['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data44['jumData'].'</a>';} else { echo '<a href="nilaiSemproPenguji2SelesaiPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data44['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data55['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data55['jumData'].'</a>';} else { echo '<a href="rekapPesSemproPerAngkNilaiAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data55['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <?php if($data22['jumData']==0 && $data44['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-book-open"></i></a>';} else { echo '<a href="detailNilaiSemproPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Lihat detail nilai"><i class="fas fa-book-open"></i></a>';} ?> </td>
                             <td width="4%" class="text-center"> <?php if($data22['jumData']==0 && $data44['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-print"></i></a>';} else { echo '<a href="cetakNilaiSemproPerAngkAdm.php?angkatan='.$angkatan.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" target="_blank" title="Cetak data"><i class="fas fa-print"></i></a>';} ?> </td>
                             <td width="4%" class="text-center pr-1"> <?php if($data22['jumData']==0 && $data44['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-download"></i></a>';} else { echo '<a href="eksporNilaiSemproPerAngkAdm.php?angkatan='.$angkatan.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a>';} ?> </td>
                          </tr>
                          <?php
                            $i0++; 
                            $count0++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one0($reload0, $page0, $tpages0); ?></div>
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