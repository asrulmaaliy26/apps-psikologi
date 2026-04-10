<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qry_peminjam = "SELECT * FROM dt_peminjam_ruang WHERE id='$id'";
  $r_peminjam = mysqli_query($con, $qry_peminjam);
  $d_peminjam = mysqli_fetch_assoc($r_peminjam);
  
  $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_pinjam_ruang WHERE peminjam='$id'";
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
                <h4 class="mb-0">Data Peminjaman Ruang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dtPinjamRuang.php?page=<?php echo $page;?>">Data Peminjam Ruang</a></li>
                  <li class="breadcrumb-item active small">Item Data Pengembalian Ruang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination0.php';
          $reload0 = "kembaliPeminjamanDtRuang.php?pagination=true&id=$id&page=$page";
          $sql = "SELECT dpr.id AS id_pinjam,dpr.id_ruang,dpr.peminjam,dpr.status_peminjaman AS status_peminjaman_ruang,dpr.tgl_kembali,dr.nm,dr.kategori,dr.model,dr.status_peminjaman FROM dt_pinjam_ruang dpr JOIN dt_ruang dr ON dpr.id_ruang=dr.id WHERE dpr.peminjam='$id' AND dpr.status_peminjaman='2'";
          $result = mysqli_query($con, $sql);
          $rpp0 = 20;
          $page0 = isset($_GET["page0"]) ? (intval($_GET["page0"])) : 1;
          $tcount0 = mysqli_num_rows($result);
          $tpages0 = ($tcount0) ? ceil($tcount0/$rpp0) : 1;
          $count0 = 0;
          $i = ($page0-1)*$rpp0;
          $no_urut = ($page0-1)*$rpp0;
          ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Item Data Pengembalian Ruang (<?php echo $d_jum['jumData'];?>)</h4>
                      <span class="float-right"><strong><?php echo $d_peminjam['nm'];?></strong></span>
                    </div>
                  </div>
                  <div class="card-body pt-0 pb-0 pl-0 pr-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="44%">Nama Ruang</th>
                          <th width="20%">Kategori</th>
                          <th width="12%">Jenis</th>
                          <th width="20%" class="pr-1">Status</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count0<$rpp0) && ($i<$tcount0)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry_kat = "SELECT * FROM opsi_kat_ruang WHERE id='$data[kategori]'";
                            $r_kat = mysqli_query($con, $qry_kat);
                            $d_kat = mysqli_fetch_assoc($r_kat);
                            
                            $qry_jenis = "SELECT * FROM opsi_model_ruang WHERE id='$data[model]'";
                            $r_jenis = mysqli_query($con, $qry_jenis);
                            $d_jenis = mysqli_fetch_assoc($r_jenis);
                            
                            $qry_status = "SELECT * FROM opsi_status_peminjaman WHERE id='$data[status_peminjaman_ruang]'";
                            $r_status = mysqli_query($con, $qry_status);
                            $d_status = mysqli_fetch_assoc($r_status);
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo $data['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_kat['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_jenis['nm'];?> </td>
                            <td class="pr-1"> <?php echo $d_status['nm'].' ['.$data['tgl_kembali'].']';?> </td>
                          </tr>
                          <?php
                            $i++; 
                            $count0++;
                            }
                            ?>                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one0($reload0, $page0, $tpages0);?></div>
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