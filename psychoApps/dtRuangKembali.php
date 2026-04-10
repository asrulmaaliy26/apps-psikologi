<?php include( "contentsConAdm.php" );
  $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_pinjam_ruang WHERE status_peminjaman='2'";
  $r_jum = mysqli_query($con,  $qry_jum )or DIE( mysqli_error($con) );
  $d_jum = mysqli_fetch_assoc( $r_jum );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBmn.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Data Ruang Kembali</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Data Ruang Kembali</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dtRuangKembali.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT dpr.id
          , dpr.id_ruang
          , dpr.peminjam
          , dpr.tgl_awal_pinjam
          , dpr.tgl_akhir_pinjam
          , dpr.status_peminjaman
          , dpr.tgl_kembali
          
          FROM dt_pinjam_ruang dpr
          LEFT JOIN dt_ruang dr
          on dpr.id_ruang = dr.id
          LEFT JOIN opsi_kat_ruang okr
          on dr.kategori = okr.id
          LEFT JOIN opsi_model_ruang omr
          on dr.model = omr.id
          LEFT JOIN opsi_status_peminjaman_barang ospb
          on dr.status_peminjaman = ospb.id
          LEFT JOIN dt_peminjam_ruang dtpr
          on dpr.peminjam = dtpr.id
          LEFT JOIN opsi_status_peminjaman osp
          on dpr.status_peminjaman = osp.id
          
          WHERE (dpr.tgl_awal_pinjam LIKE '%$keyword%' OR dpr.tgl_akhir_pinjam LIKE '%$keyword%' OR dpr.tgl_kembali LIKE '%$keyword%' OR dr.nm LIKE '%$keyword%' OR okr.nm LIKE '%$keyword%' OR omr.nm LIKE '%$keyword%' OR ospb.nm LIKE '%$keyword%' OR dtpr.nm LIKE '%$keyword%' OR osp.nm LIKE '%$keyword%') AND dpr.status_peminjaman='2' ORDER BY dpr.id DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dtRuangKembali.php?pagination=true";
          $sql = "SELECT * FROM dt_pinjam_ruang WHERE status_peminjaman='2' ORDER BY id DESC";
          $result = mysqli_query($con, $sql);
          }
          
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
              <div class="col-sm mb-2">
                <form method="post" action="dtRuangKembali.php">
                  <?php  error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){
                        ?>
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dtRuangKembali.php"><i class="fas fa-sync"></i> Kembali</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Data Ruang Kembali (<?php echo $d_jum['jumData'];?>)</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="22%">Nama Ruang</th>
                          <th width="12%">Kategori</th>
                          <th width="12%">Jenis</th>
                          <th width="20%">Peminjam</th>
                          <th width="20%">Tanggal Pinjam</th>
                          <th class="pr-1" width="10%">Tgl. Kembali</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry_inv = "SELECT * FROM dt_ruang WHERE id='$data[id_ruang]'";
                            $r_inv = mysqli_query($con, $qry_inv);
                            $d_inv = mysqli_fetch_assoc($r_inv);

                            $qry_kat = "SELECT * FROM opsi_kat_ruang WHERE id='$d_inv[kategori]'";
                            $r_kat = mysqli_query($con, $qry_kat);
                            $d_kat = mysqli_fetch_assoc($r_kat);
                            
                            $qry_model = "SELECT * FROM opsi_model_ruang WHERE id='$d_inv[model]'";
                            $r_model = mysqli_query($con, $qry_model);
                            $d_model = mysqli_fetch_assoc($r_model);
                            
                            $qry_osp = "SELECT * FROM opsi_status_peminjaman WHERE id='$data[status_peminjaman]'";
                            $r_osp = mysqli_query($con, $qry_osp);
                            $d_osp = mysqli_fetch_assoc($r_osp);

                            $qry_peminjam = "SELECT * FROM dt_peminjam_ruang WHERE id='$data[peminjam]'";
                            $r_peminjam = mysqli_query($con, $qry_peminjam);
                            $d_peminjam = mysqli_fetch_assoc($r_peminjam);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo $d_inv['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_kat['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_model['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_peminjam['nm'];?> </td>
                            <td class="text-left"> <?php echo $data['tgl_awal_pinjam'].' - '.$data['tgl_akhir_pinjam'];?> </td>
                            <td class="text-left pr-1"> <?php echo $data['tgl_kembali'];?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="7">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="22%">Nama Ruang</th>
                                        <td width="4%">:</td>
                                        <td width="74%"><?php echo $d_inv['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Kategori Ruang</th>
                                        <td>:</td>
                                        <td><?php echo $d_kat['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Jenis Ruang</th>
                                        <td>:</td>
                                        <td><?php echo $d_model['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Peminjam Ruang</th>
                                        <td>:</td>
                                        <td><?php echo $d_peminjam['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Status Pinjam</th>
                                        <td>:</td>
                                        <td><?php echo $d_osp['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal Kembali</th>
                                        <td>:</td>
                                        <td><?php echo $data['tgl_kembali'];?></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
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
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages);?></div>
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