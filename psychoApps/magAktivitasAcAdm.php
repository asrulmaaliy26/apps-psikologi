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
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Academic Coach</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Aktivitas Academic Coach</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "magAktivitasAcAdm.php?pagination=true";
           $sql = "SELECT
           mag_pengelompokan_dosen_wali.id AS idPac,
           mag_pengelompokan_dosen_wali.nip_dosen_wali,
           mag_pengelompokan_dosen_wali.cek,
           mag_pengelompokan_dosen_wali.status,
           dt_pegawai.id,
           dt_pegawai.nama_tg

           FROM mag_pengelompokan_dosen_wali
           LEFT JOIN dt_pegawai
           ON mag_pengelompokan_dosen_wali.nip_dosen_wali=dt_pegawai.id
           GROUP BY nip_dosen_wali ORDER BY dt_pegawai.nama_tg ASC";
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
                    <h3 class="card-title">Aktivitas Academic Coach</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th rowspan="2" class="pl-1" width="4%">No.</th>
                            <th rowspan="2" width="44%">Nama</th>
                            <th colspan="3">Progres Academic Coach</th>
                            <th rowspan="2" width="18%">Total Coaching</th>
                            <th rowspan="2" class="pr-1" width="4%">Opsi</th>
                          </tr>
                          <tr>
                            <th class="pl-1" width="10%">Pengaju</th>
                            <th width="10%">Proses</th>
                            <th class="pr-1" width="10%">Selesai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);

                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dosen_wali WHERE nip_dosen_wali='$data[id]'";
                            $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];
                            
                            $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE nip_dosen_wali='$data[id]' AND cek='1' AND status='1'";
                            $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                            $jumlahData2 = $dataku2['jumData'];
                            
                            $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE nip_dosen_wali='$data[id]' AND cek='2' AND status='1'";
                            $result3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
                            $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($con));
                            $jumlahData3 = $dataku3['jumData'];
                            
                            $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE nip_dosen_wali='$data[id]' AND cek='2' AND status='2'";
                            $result4 =  mysqli_query($con, $qry4) or die(mysqli_error($con));
                            $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($con));
                            $jumlahData4 = $dataku4['jumData'];
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $data['nama_tg'];?></td>
                            <td><?php echo $jumlahData2;?></td>
                            <td><?php echo $jumlahData3?></td>
                            <td><?php echo $jumlahData4?></td>
                            <td><?php echo $jumlahData1?></td>
                            <td class="pr-1"><a class="btn btn-outline-success btn-xs btn-block" title="Detail Aktivitas Academic Coach" href="magAktivitasAcPerPersonalAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>"><i class="fas fa-expand"></i></a></td>
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