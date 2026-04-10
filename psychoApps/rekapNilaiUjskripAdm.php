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
                <h6 class="m-0">Nilai Ujian Skripsi</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Nilai Ujian Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "rekapNilaiUjskripAdm.php?pagination=true";
           $sql = "SELECT * FROM pendaftaran_skripsi ORDER BY status ASC, start_datetime DESC";
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
                      <h4 class="card-title float-left">Nilai Ujian Skripsi Per Periode</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="3" class="pl-1">No.</td>
                            <td width="12%" rowspan="3">Periode Pendaftaran</td>
                            <td class="border-bottom-0" colspan="2" rowspan="2">Durasi Pendaftaran</td>
                            <td class="border-bottom-0" colspan="6">Isian Nilai dari</td>
                            <td width="6%" rowspan="3">Pendaftar</td>
                            <td rowspan="3" colspan="3" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="6%" colspan="2" class="border-bottom-0 pl-1">Sekretaris Penguji</td>
                            <td width="6%" colspan="2" class="border-bottom-0">Ketua Penguji</td>
                            <td width="6%" colspan="2" class="border-bottom-0 pr-1">Penguji Utama</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="9%" class="pl-1">Mulai</td>
                            <td width="9%" class="pr-1">Akhir</td>
                            <td width="5%" class="pl-1">Belum </td>
                            <td width="5%" class="pr-1">Selesai</td>
                            <td width="5%" class="pl-1">Belum</td>
                            <td width="5%" class="pr-1">Selesai</td>
                            <td width="5%" class="pl-1">Belum</td>
                            <td width="5%" class="pr-1">Selesai</td>
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
                            
                            $qry_grade = "SELECT * FROM grade_ujskrip WHERE id_ujskrip='$id'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);

                            $qry1 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_sekretaris IS NULL AND id_ujskrip='$id'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                              
                            $qry2 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_sekretaris IS NOT NULL AND id_ujskrip='$id'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );

                            $qry3 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_ketua IS NULL AND id_ujskrip='$id'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );

                            $qry4 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_ketua IS NOT NULL AND id_ujskrip='$id'";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );

                            $qry5 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_utama IS NULL AND id_ujskrip='$id'";
                            $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
                            $data5 = mysqli_fetch_assoc( $has5 );

                            $qry6 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_utama IS NOT NULL AND id_ujskrip='$id'";
                            $has6 = mysqli_query($con,  $qry6 )or DIE( mysqli_error($con) );
                            $data6 = mysqli_fetch_assoc( $has6 );                            

                            $qry7 = "SELECT COUNT(id) AS jumData FROM peserta_ujskrip WHERE id_ujskrip = '$id'";
                            $has7 = mysqli_query($con,  $qry7 )or DIE( mysqli_error($con) );
                            $data7 = mysqli_fetch_assoc( $has7 );
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php echo $data['start_datetime'];?> </td>
                            <td class="text-center"> <?php echo $data['end_datetime'];?> </td>
                            <td class="text-center pl-1"> <?php if($data1['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data1['jumData'].'</a>';} else { echo '<a href="nilaiUjskripSekretarisBelumPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center pr-1"> <?php if($data2['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data2['jumData'].'</a>';} else { echo '<a href="nilaiUjskripSekretarisSelesaiPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data2['jumData'].'</a>';} ?> </td>
                            <td class="text-center pl-1"> <?php if($data3['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data3['jumData'].'</a>';} else { echo '<a href="nilaiUjskripKetuaBelumPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data3['jumData'].'</a>';} ?> </td>
                            <td class="text-center pr-1"> <?php if($data4['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data4['jumData'].'</a>';} else { echo '<a href="nilaiUjskripKetuaSelesaiPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data4['jumData'].'</a>';} ?> </td>
                            <td class="text-center pl-1"> <?php if($data5['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data5['jumData'].'</a>';} else { echo '<a href="nilaiUjskripUtamaBelumPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data5['jumData'].'</a>';} ?> </td>
                            <td class="text-center pr-1"> <?php if($data6['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data6['jumData'].'</a>';} else { echo '<a href="nilaiUjskripUtamaSelesaiPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data6['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data7['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data7['jumData'].'</a>';} else { echo '<a href="rekapPesUjskripPerPeriodeNilaiAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data7['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <?php if($data2['jumData']==0 && $data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-book-open"></i></a>';} else { echo '<a href="detailNilaiUjskripPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Lihat detail nilai"><i class="fas fa-book-open"></i></a>';} ?> </td>
                             <td width="4%" class="text-center"> <?php if($data2['jumData']==0 && $data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-print"></i></a>';} else { echo '<a href="cetakNilaiUjskripPerPeriodeAdm.php?id='.$id.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" target="_blank" title="Cetak data"><i class="fas fa-print"></i></a>';} ?> </td>
                             <td width="4%" class="text-center pr-1"> <?php if($data2['jumData']==0 && $data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-download"></i></a>';} else { echo '<a href="eksporNilaiUjskripPerPeriodeAdm.php?id='.$id.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a>';} ?> </td>
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
                $reload0 = "rekapNilaiUjskripAdm.php?pagination0=true";
                $sql0 = "SELECT * FROM nilai_ujskrip INNER JOIN dt_mhssw ON nilai_ujskrip.nim=dt_mhssw.nim GROUP BY nilai_ujskrip.angkatan ORDER BY nilai_ujskrip.angkatan DESC";
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
                    <h4 class="card-title float-left">Form Berita Acara Ujian Skripsi Per Angkatan</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="3" class="pl-1">No.</td>
                            <td width="30%" rowspan="3">Angkatan</td>
                            <td class="border-bottom-0" colspan="6">Isian Nilai dari</td>
                            <td width="6%" rowspan="3">Pendaftar</td>
                            <td rowspan="3" colspan="3" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="6%" colspan="2" class="border-bottom-0 pl-1">Sekretaris Penguji</td>
                            <td width="6%" colspan="2" class="border-bottom-0">Ketua Penguji</td>
                            <td width="6%" colspan="2" class="border-bottom-0 pr-1">Penguji Utama</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="5%" class="pl-1">Belum </td>
                            <td width="5%" class="pr-1">Selesai</td>
                            <td width="5%" class="pl-1">Belum</td>
                            <td width="5%" class="pr-1">Selesai</td>
                            <td width="5%" class="pl-1">Belum</td>
                            <td width="5%" class="pr-1">Selesai</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count0<$rpp0) && ($i0<$tcount0)) {
                            mysqli_data_seek($result0, $i0);
                            $data0 = mysqli_fetch_array($result0);
                            $angkatan=$data0['angkatan'];
                            
                            $qry11 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_sekretaris IS NULL AND angkatan='$angkatan'";
                            $has11 = mysqli_query($con,  $qry11 )or DIE( mysqli_error($con) );
                            $data11 = mysqli_fetch_assoc( $has11 );

                            $qry22 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_sekretaris IS NOT NULL AND angkatan='$angkatan'";
                            $has22 = mysqli_query($con,  $qry22 )or DIE( mysqli_error($con) );
                            $data22 = mysqli_fetch_assoc( $has22 );

                            $qry33 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_ketua IS NULL AND angkatan='$angkatan'";
                            $has33 = mysqli_query($con,  $qry33 )or DIE( mysqli_error($con) );
                            $data33 = mysqli_fetch_assoc( $has33 );

                            $qry44 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_ketua IS NOT NULL AND angkatan='$angkatan'";
                            $has44 = mysqli_query($con,  $qry44 )or DIE( mysqli_error($con) );
                            $data44 = mysqli_fetch_assoc( $has44 );

                            $qry55 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_utama IS NULL AND angkatan='$angkatan'";
                            $has55 = mysqli_query($con,  $qry55 )or DIE( mysqli_error($con) );
                            $data55 = mysqli_fetch_assoc( $has55 );

                            $qry66 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_utama IS NOT NULL AND angkatan='$angkatan'";
                            $has66 = mysqli_query($con,  $qry66 )or DIE( mysqli_error($con) );
                            $data66 = mysqli_fetch_assoc( $has66 );

                            $qry77 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE angkatan='$angkatan'";
                            $has77 = mysqli_query($con,  $qry77 )or DIE( mysqli_error($con) );
                            $data77 = mysqli_fetch_assoc( $has77 );                            
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut0;?> </td>
                            <td class="text-center"> <?php echo $data0['angkatan'];?> </td>
                            <td class="text-center"> <?php if($data11['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data11['jumData'].'</a>';} else { echo '<a href="nilaiUjskripSekretarisBelumPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data11['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data22['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data22['jumData'].'</a>';} else { echo '<a href="nilaiUjskripSekretarisSelesaiPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data22['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data33['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data33['jumData'].'</a>';} else { echo '<a href="nilaiUjskripKetuaBelumPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data33['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data44['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data44['jumData'].'</a>';} else { echo '<a href="nilaiUjskripKetuaSelesaiPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data44['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data55['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data55['jumData'].'</a>';} else { echo '<a href="nilaiUjskripUtamaBelumPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data55['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data66['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data66['jumData'].'</a>';} else { echo '<a href="nilaiUjskripUtamaSelesaiPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data66['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data77['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data77['jumData'].'</a>';} else { echo '<a href="rekapPesUjskripPerAngkNilaiAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data77['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <?php if($data22['jumData']==0 && $data44['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-book-open"></i></a>';} else { echo '<a href="detailNilaiUjskripPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Lihat detail nilai"><i class="fas fa-book-open"></i></a>';} ?> </td>
                             <td width="4%" class="text-center"> <?php if($data22['jumData']==0 && $data44['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-print"></i></a>';} else { echo '<a href="cetakNilaiUjskripPerAngkAdm.php?angkatan='.$angkatan.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" target="_blank" title="Cetak data"><i class="fas fa-print"></i></a>';} ?> </td>
                             <td width="4%" class="text-center pr-1"> <?php if($data22['jumData']==0 && $data44['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-download"></i></a>';} else { echo '<a href="eksporNilaiUjskripPerAngkAdm.php?angkatan='.$angkatan.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a>';} ?> </td>
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