<?php 
  include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
  $qry = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE nip_dosen_wali='$id'";
  $has = mysqli_query($con,  $qry)or die(mysqli_error($con));
  $data = mysqli_fetch_assoc($has);
  
  $qdp = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $rdp = mysqli_query($con, $qdp)or die( mysqli_error($con));
  $ddp = mysqli_fetch_assoc($rdp);   
  ?>
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
                <h4 class="m-0">Pengajuan Academic Coach</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magAktivitasAcAdm.php?page=<?php echo $page;?>">Aktivitas Academic Coach</a></li>
                  <li class="breadcrumb-item active">Detail Aktivitas Academic Coach</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination1.php';
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload1 = "magAktivitasAcPerPersonalAdm.php?id=$id&page=$page&keyword=$keyword";
          
          $sql1 = "SELECT
          mag_pengelompokan_dosen_wali.id AS idPersonal,
          mag_pengelompokan_dosen_wali.id_periode,
          mag_pengelompokan_dosen_wali.nim,
          mag_pengelompokan_dosen_wali.dosen_wali,
          mag_pengelompokan_dosen_wali.tgl_pengajuan,
          mag_pengelompokan_dosen_wali.thn_pengajuan,
          mag_pengelompokan_dosen_wali.cek,
          mag_pengelompokan_dosen_wali.tgl_cek,
          mag_pengelompokan_dosen_wali.thn_cek,
          mag_pengelompokan_dosen_wali.catatan,
          mag_pengelompokan_dosen_wali.tgl_selesai,
          mag_pengelompokan_dosen_wali.thn_selesai,
          mag_pengelompokan_dosen_wali.status,
          mag_dt_mhssw_pasca.nim,
          mag_dt_mhssw_pasca.nama
          
          FROM mag_pengelompokan_dosen_wali 
          LEFT JOIN mag_dt_mhssw_pasca
          ON mag_pengelompokan_dosen_wali.nim=mag_dt_mhssw_pasca.nim
          
          WHERE (mag_pengelompokan_dosen_wali.nip_dosen_wali = '$id') AND (mag_dt_mhssw_pasca.nim LIKE '%$keyword%' OR mag_pengelompokan_dosen_wali.tgl_pengajuan LIKE '%$keyword%' OR mag_pengelompokan_dosen_wali.thn_pengajuan LIKE '%$keyword%' OR mag_dt_mhssw_pasca.nim LIKE '%$keyword%' OR mag_dt_mhssw_pasca.nama LIKE '%$keyword%') ORDER BY mag_pengelompokan_dosen_wali.tgl_selesai ASC";

          $result1 = mysqli_query($con, $sql1);
          }else{
          $reload1 = "magAktivitasAcPerPersonalAdm.php?id=$id&page=$page";
          $sql1 = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE nip_dosen_wali='$id' ORDER BY tgl_selesai ASC";
          $result1 = mysqli_query($con, $sql1);
          }

          $rpp1 = 10;
          $page1 = isset($_GET["page1"]) ? (intval($_GET["page1"])) : 1;
          $tcount1 = mysqli_num_rows($result1);
          $tpages1 = ($tcount1) ? ceil($tcount1/$rpp1) : 1;
          $count1 = 0;
          $i1 = ($page1-1)*$rpp1;
          $no_urut = ($page1-1)*$rpp1;
          ?>                
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm mb-2">
                <form method="post" action="magAktivitasAcPerPersonalAdm.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>">
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
                      <a class="btn btn-sm btn-warning" title="Refresh" href="magAktivitasAcPerPersonalAdm.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>&page1=<?php echo "$page1";?>"><i class="fas fa-sync"></i> Refresh</a>
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
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Detail Aktivitas Academic Coach</h3>
                      <span><span class="text-danger">Academic Coach:</span> <?php echo $ddp['nama_tg'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th class="pl-1" width="4%">No.</th>
                            <th width="48%">Nama</th>
                            <th width="16%">Tanggal Pengajuan</th>
                            <th width="16%">Tanggal Verifikasi</th>
                            <th class="pr-1" width="16%">Tanggal Selesai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count1<$rpp1) && ($i1<$tcount1)) {
                            mysqli_data_seek($result1, $i1);
                            $data = mysqli_fetch_array($result1);
                            
                            $qm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                            $rm = mysqli_query($con, $qm)or die( mysqli_error($con));
                            $dm = mysqli_fetch_assoc($rm);
                            ?>
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dm['nama'].' ['.$dm['nim'].']';?></td>
                            <td><?php echo $data['tgl_pengajuan'];?></td>
                            <td><?php echo $data['tgl_cek'];?></td>
                            <td class="pr-1"><?php echo $data['tgl_selesai'];?></td>
                          </tr>
                          <?php
                            $i1++; 
                            $count1++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one1($reload1, $page1, $tpages1);?></div>
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
