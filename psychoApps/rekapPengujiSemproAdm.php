<?php include( "contentsConAdm.php" );
  $qta = "SELECT * FROM dt_ta WHERE status='1'";
  $rta = mysqli_query($con, $qta)or die( mysqli_error($con));
  $dta = mysqli_fetch_assoc($rta);
  
  $qpsempro = "SELECT * FROM pendaftaran_sempro WHERE status='1'";
  $rpsempro = mysqli_query($con, $qpsempro)or die( mysqli_error($con));
  $dpsempro = mysqli_fetch_assoc($rpsempro);
   
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
              <h6 class="m-0">Penguji Seminar Proposal</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active small">Penguji Seminar Proposal</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <?php
        include 'pagination.php';
         $reload = "rekapPengujiSemproAdm.php?pagination=true";
         $sql = "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' AND status = '1' ORDER BY nama_tg ASC";
         $result = mysqli_query($con, $sql);
         
         $rpp = 100;
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
                    <h4 class="card-title float-left">Grafik Penguji Seminar Proposal</h4>
                  </div>
                </div>
                <div class="card-body p-0">
                   <canvas id="myChart"></canvas>
                </div>
              </div>
            </section>
          </div>
          <div class="row">
            <section class="col-md-12 connectedSortable">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <div class="clearfix">
                    <h4 class="card-title float-left">Detail Penguji Seminar Proposal</h4>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                      <thead>
                        <tr class="text-center bg-secondary">
                          <td width="4%" class="pl-1" rowspan="2">No.</td>
                          <td width="68%" rowspan="2">Nama</td>
                          <td class="border-bottom-0" colspan="2">Total Menjadi</td>
                          <td width="6%" rowspan="2" class="pr-1">Opsi</td>
                        </tr>
                        <tr class="text-center bg-secondary">
                          <td class="pl-1" width="8%">Penguji I</td>
                          <td class="pr-1" width="8%">Penguji II</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          while(($count<$rpp) && ($i<$tcount)) {
                          mysqli_data_seek($result, $i);
                          $data = mysqli_fetch_array($result);
                          
                          $nip = $data['id'];
                          
                          $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$data[kepakaran_mayor]'";
                          $rr = mysqli_query($con, $qr)or die( mysqli_error($con));
                          $dr = mysqli_fetch_assoc($rr);
                                                      
                          $qry1 = "SELECT COUNT(id) AS jumData FROM jadwal_sempro WHERE penguji1='$data[id]'";
                          $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                          $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                          $jumlahData1 = $dataku1['jumData'];
                          
                          $qry2 = "SELECT COUNT(id) AS jumData FROM jadwal_sempro WHERE penguji2='$data[id]'";
                          $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                          $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                          $jumlahData2 = $dataku2['jumData'];
                          
                          $qry3 = "SELECT COUNT(id) AS jumData FROM jadwal_sempro WHERE penguji1='$data[id]' AND penguji2 != '' AND id_sempro='$dpsempro[id]'";
                          $result3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
                          $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($con));
                          $jumlahData3 = $dataku3['jumData'];
                          
                          $qry4 = "SELECT COUNT(id) AS jumData FROM jadwal_sempro WHERE penguji2='$data[id]' AND id_sempro='$dpsempro[id]'";
                          $result4 =  mysqli_query($con, $qry4) or die(mysqli_error($con));
                          $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($con));
                          $jumlahData4 = $dataku4['jumData'];
                          ?> 
                        <tr data-widget="expandable-table" aria-expanded="false">
                          <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                          <td class="text-left"> <?php echo $data['nama_tg'];?> </td>
                          <td class="text-center"> <?php if($jumlahData1==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$jumlahData1.'</a>';} else { echo '<a href="rekapPenguji1SemproAdm.php?id='.$nip.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$jumlahData1.'</a>';} ?> </td>
                          <td class="text-center"> <?php if($jumlahData2==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$jumlahData2.'</a>';} else { echo '<a href="rekapPenguji2SemproAdm.php?id='.$nip.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$jumlahData2.'</a>';} ?> </td>
                          <td width="6%" class="text-center pr-1"> <a href="detailPengujiSemproAdm.php?id=<?php echo "$nip";?>&page=<?php echo "$page";?>" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Lihat detail penguji"><i class="fas fa-book-open"></i></a> </td>
                        </tr>
                        <tr class="expandable-body">
                          <td colspan="6"> <?php include "detailPengujiSemproPerPengujiAdm.php";?> </td>
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
      </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script>
      var ctx = document.getElementById("myChart").getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [ <?php
            $sqlgraphname = "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' AND status = '1' ORDER BY nama_tg ASC";
            $resultgraphname = mysqli_query($con, $sqlgraphname);
            while ($datagraphname = mysqli_fetch_array($resultgraphname)) {
              echo '"'.$datagraphname['nama_tg'].'",';
            } ?>
          ],
          datasets: [{
              label: 'Penguji I',
              data: [ <?php
                $sqlgraphp1 = "SELECT id FROM dt_pegawai WHERE jenis_pegawai = '1' AND status = '1' ORDER BY nama_tg ASC";
                $resgraphp1 = mysqli_query($con, $sqlgraphp1);
                while ($datagraphp1 = mysqli_fetch_array($resgraphp1)) {

                  $qrygraphp1 = "SELECT COUNT(id) AS jumData FROM jadwal_sempro WHERE penguji1='$datagraphp1[id]'";
                  $resultgraphp1 = mysqli_query($con, $qrygraphp1) or die(mysqli_error($con));
                  $datakugraphp1 = mysqli_fetch_assoc($resultgraphp1) or die(mysqli_error($con));
                  $jumlahDatagraphp1 = $datakugraphp1['jumData'];

                  echo '"'.$jumlahDatagraphp1.'",';
                } ?>
              ],
              backgroundColor: '#E900FF'
            },
            {
              label: 'Penguji II',
              data: [ <?php
                $sqlgraphp2 = "SELECT id FROM dt_pegawai WHERE jenis_pegawai = '1' AND status = '1' ORDER BY nama_tg ASC";
                $resgraphp2 = mysqli_query($con, $sqlgraphp2);
                while ($datagraphp2 = mysqli_fetch_array($resgraphp2)) {

                  $qrygraphp2 = "SELECT COUNT(id) AS jumData FROM jadwal_sempro WHERE penguji2='$datagraphp2[id]'";
                  $resultgraphp2 = mysqli_query($con, $qrygraphp2) or die(mysqli_error($con));
                  $datakugraphp2 = mysqli_fetch_assoc($resultgraphp2) or die(mysqli_error($con));
                  $jumlahDatagraphp2 = $datakugraphp2['jumData'];

                  echo '"'.$jumlahDatagraphp2.
                  '",';
                } ?>
              ],
              backgroundColor: '#109CE6'
            }
          ]
        },
        options: {
          tooltips: {
            displayColors: true,
            callbacks: {
              mode: 'x',
            },
          },
          scales: {
            x: {
              stacked: true,
            },
            y: {
              stacked: true
            }
          },
          responsive: true
        }
      });
    </script>
  </body>
</html>