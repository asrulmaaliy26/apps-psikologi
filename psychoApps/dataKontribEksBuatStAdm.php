<?php include( "contentsConAdm.php" );
 $username = $_SESSION['username'];

 $myquery = "SELECT * FROM dt_all_adm WHERE username='$username'";
 $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
 $dAdm = mysqli_fetch_assoc($d);
?>
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
                <h4 class="mb-0">Kontribusi Saya</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dataKontribEksekutorAdm.php">Sebagai Eksekutor</a></li>
                  <li class="breadcrumb-item active small">Buat Surat Tugas</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';

          $reload = "dataKontribEksBuatStAdm.php?pagination=true";
          $sql = "SELECT * FROM st WHERE executor = '$username' GROUP BY tahun ORDER BY tahun DESC";
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
                    <h4 class="card-title">Buat Surat Tugas</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead class="thead-light">
                          <th width="4%" class="text-center pl-1">No.</th>
                          <th width="82%" class="text-center">Tahun</th>
                          <th width="10%" class="text-center">Jumlah Data</th>
                          <th width="4%" class="text-center pr-2">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry = "SELECT COUNT(*) AS jumData FROM st WHERE executor = '$username' AND tahun = '$data[tahun]'";
                            $r =  mysqli_query($con, $qry) or die(mysqli_error($con));
                            $djum = mysqli_fetch_assoc($r) or die(mysqli_error($con));
                            ?>
                          <tr>
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-center"><?php echo $data['tahun'];?></td>
                            <td class="text-center"><?php echo $djum['jumData'];?></td>
                            <td class="text-center pr-2">
                              <a href="dataKontribEksBuatStPertahunAdm.php?page=<?php echo $page;?>&tahun=<?php echo $data['tahun'];?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
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