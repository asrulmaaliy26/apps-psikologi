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
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Rekap Nilai Kompre</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Rekap Nilai Kompre</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
                <?php
                 include 'pagination.php';
                 $reload = "rekapNilaiKompreAdm.php?pagination=true";
                 $sql = "SELECT * FROM pendaftaran_kompre ORDER BY status ASC, start_datetime DESC";
                 $result = mysqli_query($con, $sql);
                 
                 $rpp = 10;
                 $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
                 $tcount = mysqli_num_rows($result);
                 $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
                 $count = 0;
                 $i = ($page-1)*$rpp;
                 $no_urut = ($page-1)*$rpp;
                 ?>
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Rekap Nilai Kompre Per Periode</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="20%" rowspan="2">Periode Pendaftaran</td>
                            <td rowspan="2" colspan="2">Durasi Pendaftaran</td>
                            <td width="6%" rowspan="2">Passing Grade</td>
                            <td class="border-bottom-0" width="8%" rowspan="2">Peserta</td>
                            <td colspan="3" class="border-bottom-0">Hasil Ujian</td>
                            <td class="pr-1" rowspan="2" colspan="2">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="8%" class="pl-1">Lulus</td>
                            <td width="8%">Gagal</td>
                            <td width="8%" class="pr-1">Belum Dinilai</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $id = $data['id'];
                            $tahap = $data['tahap'];
                            $jenis_periode = $data['jenis_periode'];
                            $passing_grade = $data['passing_grade'];
                            
                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$tahap'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_jenis_periode = "SELECT * FROM opsi_kategori_periode_kompre WHERE id='$jenis_periode'";
                            $hasil = mysqli_query($con, $qry_jenis_periode);
                            $djp = mysqli_fetch_assoc($hasil);

                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$data[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qry_grade = "SELECT * FROM grade_kompre WHERE id_kompre='$id'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);

                            $qry1 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE val_adm = '2' AND id_kompre='$id'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                              
                            $qry2 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE (hasil_ujian <= $dt_grade[at] AND hasil_ujian >='$passing_grade') AND (id_kompre='$id')";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );

                            $qry3 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE (hasil_ujian < '$passing_grade' AND hasil_ujian >= $dt_grade[db]) AND (id_kompre='$id')";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );

                            $qry4 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE hasil_ujian='' AND id_kompre='$id'";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );                   
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' <span class="small text-secondary">'.$djp['nm'].'</span> '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td width="13%" class="text-center"> <?php echo $data['start_datetime'];?> </td>
                            <td width="13%" class="text-center"> <?php echo $data['end_datetime'];?> </td>
                            <td class="text-center"> <?php echo $data['passing_grade'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data1['jumData'].'</a>';} else { echo '<a href="allNilaiKomprePerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center pl-1"> <?php if($data2['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data2['jumData'].'</a>';} else { echo '<a href="allNilaiLulusKomprePerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data2['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data3['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data3['jumData'].'</a>';} else { echo '<a href="allNilaiGagalKomprePerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data3['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data4['jumData'].'</a>';} else { echo '<a href="allBelumDinilaiKomprePerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data4['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakAllNilaiKomprePerPeriodeAdm.php?id=<?php echo "$id";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporAllNilaiKomprePerPeriodeAdm.php?id=<?php echo "$id";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
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
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>