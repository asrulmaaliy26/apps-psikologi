<?php include( "contentsConAdm.php" );?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmTaper.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Rekap Data</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Surat Tugas</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $reload = "dataStAdm.php?pagination=true";
          $sql = "SELECT * FROM st GROUP BY tahun ORDER BY tahun DESC";
          $result = mysqli_query($con, $sql);
          
          $rpp = 20;
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
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Surat Tugas</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead class="thead-light">
                          <th width="4%" class="text-center pl-1">No.</th>
                          <th width="42%" class="text-center">Tahun</th>
                          <th width="42%" class="text-center">Jumlah Data</th>
                          <th colspan="3" class="text-center pr-2">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry = "SELECT COUNT(*) AS jumData FROM st WHERE tahun='$data[tahun]'";
                            $r =  mysqli_query($con, $qry) or die(mysqli_error($con));
                            $djum = mysqli_fetch_assoc($r) or die(mysqli_error($con));
                            ?>
                          <tr>
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-center"><?php echo $data['tahun'];?></td>
                            <td class="text-center"><?php echo $djum['jumData'];?></td>
                            <td class="text-center" width="4%"><a href="dataStPertahunAdm.php?tahun=<?php echo $data['tahun'];?>&page_a=<?php echo $page;?>" role="button" class="btn btn-block btn-outline-primary btn-xs" title="Buka data"><i class="far fa-folder-open"></i></a></td>
                            <td class="text-center" width="4%"><a href="cetakStPertahunAdm.php?tahun=<?php echo $data['tahun'];?>&page_a=<?php echo $page;?>" role="button" class="btn btn-block btn-outline-secondary btn-xs" target="_blank" title="Cetak data"><i class="bi bi-printer"></i></a></td>
                            <td class="text-center pr-2" width="4%"><a href="eksporStPertahunAdm.php?tahun=<?php echo $data['tahun'];?>&page_a=<?php echo $page;?>" role="button" class="btn btn-block btn-outline-success btn-xs" title="Ekspor data"><i class="fas fa-file-export"></i></a></td>
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
                </div>
                <div class="float-right"><?php echo paginate_one($reload, $page, $tpages);?></div>
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