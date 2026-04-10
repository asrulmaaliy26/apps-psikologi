<?php include( "contentsConAdm.php" );?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS2.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Peminatan Rumpun Psikologi</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Edit Pengajuan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "magEditPprpAdm.php?pagination=true";
           $sql = "SELECT * FROM mag_pengelompokan_rumpun GROUP BY angkatan ORDER BY angkatan DESC";
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
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Edit Pengajuan</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th rowspan="2" width="4%" class="pl-1">No.</th>
                            <th rowspan="2" width="52%">Angkatan</th>
                            <th colspan="5">Rumpun Psikologi</th>
                            <th rowspan="2" width="4%" class="pr-1">Opsi</th>
                          </tr>
                          <tr>
                            <th class="pl-1" width="8%">Klinis</th>
                            <th width="8%">Pendidikan</th>
                            <th width="8%">Industri</th>
                            <th width="8%">Sosial</th>
                            <th class="pr-1" width="8%">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $angkatan=$data['angkatan'];
                            
                            $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE rumpun='1' AND angkatan='$angkatan'";
                            $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];
                            
                            $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE rumpun='2' AND angkatan='$angkatan'";
                            $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                            $jumlahData2 = $dataku2['jumData'];
                            
                            $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE rumpun='3' AND angkatan='$angkatan'";
                            $result3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
                            $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($con));
                            $jumlahData3 = $dataku3['jumData'];
                            
                            $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE rumpun='4' AND angkatan='$angkatan'";
                            $result4 =  mysqli_query($con, $qry4) or die(mysqli_error($con));
                            $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($con));
                            $jumlahData4 = $dataku4['jumData'];
                            
                            $qry5 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE cek='1' AND angkatan='$angkatan'";
                            $result5 =  mysqli_query($con, $qry5) or die(mysqli_error($con));
                            $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($con));
                            $jumlahData5 = $dataku5['jumData'];
                            
                            $qry6 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE cek='2' AND angkatan='$angkatan'";
                            $result6 =  mysqli_query($con, $qry6) or die(mysqli_error($con));
                            $dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($con));
                            $jumlahData6 = $dataku6['jumData'];
                            
                            $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE angkatan='$angkatan'";
                            $result0 =  mysqli_query($con, $qry0) or die(mysqli_error($con));
                            $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($con));
                            $jumlahData0 = $dataku0['jumData'];
                                ?> 
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td><?php echo $data['angkatan'];?></td>
                            <td><?php echo"$jumlahData1";?></td>
                            <td><?php echo"$jumlahData2";?></td>
                            <td><?php echo"$jumlahData3";?></td>
                            <td><?php echo"$jumlahData4";?></td>
                            <td><?php echo"$jumlahData0";?></td>
                            <td class="pr-1"><a href='magEditPprpPerAngkatanAdm.php?id=<?php echo "$angkatan";?>&page=<?php echo "$page";?>' type="button" class="btn btn-outline-success btn-xs btn-block" title='Edit'><i class="far fa-edit"></i></a></td>
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