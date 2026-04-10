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
                  <li class="breadcrumb-item active">Proses Coaching Mahasiswa</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "magProsesPacAdm.php?pagination=true";
          $sql = "SELECT
           mag_pengelompokan_dosen_wali.id AS idPac,
           mag_pengelompokan_dosen_wali.nip_dosen_wali,
           mag_pengelompokan_dosen_wali.cek,
           mag_pengelompokan_dosen_wali.status,
           dt_pegawai.id,
           dt_pegawai.nama_tg,
           mag_dt_mhssw_pasca.nim,
           mag_dt_mhssw_pasca.nama

           FROM mag_pengelompokan_dosen_wali
           LEFT JOIN dt_pegawai
           ON mag_pengelompokan_dosen_wali.nip_dosen_wali=dt_pegawai.id
           LEFT JOIN mag_dt_mhssw_pasca
           ON mag_pengelompokan_dosen_wali.nim=mag_dt_mhssw_pasca.nim
           WHERE mag_pengelompokan_dosen_wali.nim LIKE '%$keyword%' OR mag_pengelompokan_dosen_wali.nip_dosen_wali LIKE '%$keyword%' OR mag_dt_mhssw_pasca.nim LIKE '%$keyword%' OR mag_dt_mhssw_pasca.nama LIKE '%$keyword%' OR dt_pegawai.id LIKE '%$keyword%' OR dt_pegawai.nama LIKE '%$keyword%' OR dt_pegawai.nama_tg LIKE '%$keyword%'
           ORDER BY mag_dt_mhssw_pasca.nama ASC";
           $result = mysqli_query($con, $sql);
           }else{
           $reload = "magProsesPacAdm.php?pagination=true";
           $sql = "SELECT
           mag_pengelompokan_dosen_wali.id AS idPac,
           mag_pengelompokan_dosen_wali.nip_dosen_wali,
           mag_pengelompokan_dosen_wali.cek,
           mag_pengelompokan_dosen_wali.status,
           dt_pegawai.id,
           dt_pegawai.nama_tg,
           mag_dt_mhssw_pasca.nim,
           mag_dt_mhssw_pasca.nama

           FROM mag_pengelompokan_dosen_wali
           LEFT JOIN dt_pegawai
           ON mag_pengelompokan_dosen_wali.nip_dosen_wali=dt_pegawai.id
           LEFT JOIN mag_dt_mhssw_pasca
           ON mag_pengelompokan_dosen_wali.nim=mag_dt_mhssw_pasca.nim
           ORDER BY mag_dt_mhssw_pasca.nama ASC";
           $result = mysqli_query($con, $sql);
           }
           
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
              <div class="col-sm mb-2">
                <form method="post" action="magProsesPacAdm.php">
                  <?php  error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default" title="Cari">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){
                        ?>
                      <a class="btn btn-sm btn-warning" title="Refresh" href="magProsesPacAdm.php"><i class="fas fa-sync"></i> Refresh</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Proses Coaching Mahasiswa</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th class="pl-1" width="4%">No.</th>
                            <th width="46%">Nama</th>
                            <th width="26%">Academic Coach</th>
                            <th class="pr-1" width="20%">Proses Coaching Mahasiswa</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            if($data['cek']=='1' && $data['status']=='1') {echo
                              '<tr>
                                 <td class="pl-1">'.++$no_urut.'</td>
                                 <td class="text-left">'.$data['nama'].' ['.$data['nim'].']'.'</td>
                                 <td class="text-left">'.$data['nama_tg'].'</td>
                                 <td class="pr-1">Pengajuan</td>
                               </tr>';}
                            elseif($data['cek']=='2' && $data['status']=='1') {echo 
                              '<tr>
                                 <td class="pl-1">'.++$no_urut.'</td>
                                 <td class="text-left">'.$data['nama'].' ['.$data['nim'].']'.'</td>
                                 <td class="text-left">'.$data['nama_tg'].'</td>
                                 <td class="pr-1">Proses</td>
                               </tr>';}
                            elseif($data['cek']=='2' && $data['status']=='2') {echo 
                              '<tr>
                                 <td class="pl-1">'.++$no_urut.'</td>
                                 <td class="text-left">'.$data['nama'].' ['.$data['nim'].']'.'</td>
                                 <td class="text-left">'.$data['nama_tg'].'</td>
                                 <td class="pr-1">Selesai</td>
                               </tr>';}
                            ?> 
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