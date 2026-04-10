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
                <h6 class="m-0">Rekap DPL PKL</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Rekap DPL PKL</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "rekapDplPklAdm.php?pagination=true";
           $sql = "SELECT * FROM pendaftaran_pkl ORDER BY status ASC, start_datetime DESC";
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
                      <h4 class="card-title float-left">Rekap DPL PKL Per Periode</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="50%" rowspan="2">Periode Pendaftaran</td>
                            <td class="border-bottom-0" colspan="2">Durasi Pendaftaran</td>
                            <td width="10%" rowspan="2">Total DPL PKL</td>
                            <td rowspan="2" colspan="2" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td class="pl-1" width="14%">Mulai</td>
                            <td class="pr-1" width="14%">Akhir</td>
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

                            $qryjumdpl = "SELECT COUNT(id) AS jumData FROM dpl_pkl WHERE id_pkl='$id'";
                            $resjumdpl = mysqli_query($con,  $qryjumdpl )or DIE( mysqli_error($con) );
                            $dtjumDpl = mysqli_fetch_array( $resjumdpl );
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php echo $data['start_datetime'];?> </td>
                            <td class="text-center"> <?php echo $data['end_datetime'];?> </td>
                            <td class="text-center"> <?php if($dtjumDpl['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$dtjumDpl['jumData'].'</a>';} else { echo '<a href="rekapDplPklPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$dtjumDpl['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakAllDataDplPklPerPeriodeAdm.php?id=<?php echo "$id";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporAllDataDplPklPerPeriodeAdm.php?id=<?php echo "$id";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
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
                $reload0 = "rekapPembimbinganAdm.php?pagination0=true";
                $sql0 = "SELECT * FROM peserta_pkl INNER JOIN dt_pegawai ON peserta_pkl.dpl=dt_pegawai.id GROUP BY peserta_pkl.dpl ORDER BY dt_pegawai.nama_tg ASC";
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
                      <h4 class="card-title float-left">Rekap Semua DPL PKL</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="70%">Nama</td>
                            <td width="18%">Total Menjadi DPL</td>
                            <td colspan="2" class="pr-1">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count0<$rpp0) && ($i0<$tcount0)) {
                            mysqli_data_seek($result0, $i0);
                            $data0 = mysqli_fetch_array($result0);
                            $nip=$data0['dpl'];
                            
                            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$data0[id_pkl]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);

                            $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$data0[dpl]'";
                            $res_dpl = mysqli_query($con, $qry_dpl);
                            $dt_dpl = mysqli_fetch_assoc($res_dpl);

                            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dt_dpl[kepakaran_mayor]'";
                            $rr = mysqli_query($con, $qr)or die( mysqli_error($con));
                            $dr = mysqli_fetch_assoc($rr);
                                                        
                            $qry1 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl='$data0[dpl]' AND id_dpl='$data0[id_dpl]'";
                            $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];

                            $qry2 = "SELECT COUNT(nilai) AS jumData FROM peserta_pkl WHERE dpl='$data0[dpl]' AND id_dpl='$data0[id_dpl]'";
                            $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                            $jumlahData2 = $dataku2['jumData'];

                            $qry3 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl='$data0[dpl]'";
                            $result3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
                            $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($con));
                            $jumlahData3 = $dataku3['jumData'];
                            
                            $qry4 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE  dpl='$data0[dpl]' AND id_dpl='$data0[id_dpl]' AND (nilai <= '$dt_grade[at]' AND nilai >= '$dt_grade[cb]')";
                            $result4 =  mysqli_query($con, $qry4) or die(mysqli_error($con));
                            $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($con));
                            $jumlahData4 = $dataku4['jumData'];

                            $qry5 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE  dpl='$data0[dpl]' AND id_dpl='$data0[id_dpl]' AND (nilai <= '$dt_grade[dt]' AND nilai >= '$dt_grade[db]')";
                            $result5 =  mysqli_query($con, $qry5) or die(mysqli_error($con));
                            $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($con));
                            $jumlahData5 = $dataku5['jumData'];

                            $qry6 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl='$data0[dpl]' AND (nilai <= '$dt_grade[at]' AND nilai >= '$dt_grade[cb]')";
                            $result6 =  mysqli_query($con, $qry6) or die(mysqli_error($con));
                            $dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($con));
                            $jumlahData6 = $dataku6['jumData'];

                            $qry7 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl='$data0[dpl]' AND (nilai <= '$dt_grade[dt]' AND nilai >= '$dt_grade[db]')";
                            $result7 =  mysqli_query($con, $qry7) or die(mysqli_error($con));
                            $dataku7 = mysqli_fetch_assoc($result7) or die(mysqli_error($con));
                            $jumlahData7 = $dataku7['jumData'];
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM dpl_pkl WHERE nip='$nip'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_array( $has1 );
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo ++$no_urut0;?> </td>
                            <td class="text-left"> <?php echo $dt_dpl['nama_tg'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data1['jumData'].'</a>';} else { echo '<a href="rekapDplPklPerDplAdm.php?id='.$nip.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakAllDataDplPklPerDplAdm.php?id=<?php echo "$nip";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporAllDataDplPklPerDplAdm.php?id=<?php echo "$nip";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="11"> <?php include "detailDplPerDplAdm.php";?> </td>
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