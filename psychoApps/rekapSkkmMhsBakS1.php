<?php include( "contentsConAdm.php" ); ?>
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
                <h6 class="m-0">Rekap SKKM Mahasiswa</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Rekap SKKM Mahasiswa</li>
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
                $reload = "rekapSkkmMhsBakS1.php?pagination=true";
                $sql = "SELECT angkatan FROM dt_mhssw GROUP BY angkatan ORDER BY angkatan DESC";
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
                      <h4 class="card-title float-left">Rekap SKKM Mahasiswa Per Angkatan</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="70%">Angkatan</td>
                            <td width="20%">Jumlah Mahasiswa Mengisi</td>
                            <td width="6%" class="pr-1">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $angkatan = $data['angkatan'];

                            // Hitung mahasiswa yang sudah mengisi SKKM di angkatan ini
                            $qry888 = "SELECT COUNT(DISTINCT skkm.nim) AS jumData FROM skkm INNER JOIN dt_mhssw ON skkm.nim = dt_mhssw.nim WHERE dt_mhssw.angkatan='$angkatan'";
                            $has888 = mysqli_query($con,  $qry888 )or DIE( mysqli_error($con) );
                            $data888 = mysqli_fetch_assoc( $has888 );
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-center"> <?php echo $angkatan;?> </td>
                            <td class="text-center"> 
                                <?php if($data888['jumData']==0) { 
                                    echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data888['jumData'].'</a>';
                                } else { 
                                    echo '<a href="skkmMhsPerAngkAdm.php?angkatan='.$angkatan.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data mahasiswa">'.$data888['jumData'].' Mahasiswa</a>';
                                } ?> 
                            </td>
                            <td width="6%" class="text-center pr-1"> 
                                <a href="skkmMhsPerAngkAdm.php?angkatan=<?php echo $angkatan;?>&page=<?php echo $page;?>" type="button" class="btn btn-outline-info btn-flat btn-xs btn-block" title="Lihat Detail"><i class="fas fa-eye"></i> Detail</a>
                            </td>
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
