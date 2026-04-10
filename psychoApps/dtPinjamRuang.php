<?php include( "contentsConAdm.php" );
  $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_peminjam_ruang";
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
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Submit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifKembali') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Data ruang telah selesai!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Edit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Data Peminjaman Ruang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Data Peminjam Ruang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dtPinjamRuang.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT id,nm,alasan_pinjam,tgl_awal_pinjam,tgl_akhir_pinjam FROM dt_peminjam_ruang WHERE id LIKE '%$keyword%' OR nm LIKE '%$keyword%' OR alasan_pinjam LIKE '%$keyword%' ORDER BY id DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dtPinjamRuang.php?pagination=true";
          $sql = "SELECT * FROM dt_peminjam_ruang ORDER BY id DESC";
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
                <form method="post" action="dtPinjamRuang.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dtPinjamRuang.php"><i class="fas fa-sync"></i> Kembali</a>
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
                      <h4 class="card-title float-left">Data Peminjam Ruang (<?php echo $d_jum['jumData'];?>)</h4>
                      <button type="button" class="btn btn-outline-primary btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="fas fa-user-plus"></i> Input Data Peminjam</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered m-0 table-sm custom">
                        <thead class="thead-light">
                          <tr>
                          <th width="4%" class="pl-1 text-center" rowspan="2">No.</th>
                          <th width="22%" rowspan="2">Nama Peminjam</th>
                          <th width="24%" rowspan="2">Alasan Peminjaman</th>
                          <th width="16%" class="text-center" rowspan="2">Tgl. Peminjaman</th>
                          <th class="text-center" colspan="2">Jumlah</th>
                          <th class="pr-1 text-center" rowspan="2" colspan="3">Opsi</th>
                        </tr>
                        <tr>
                          <th width="6%" class="pl-1 text-center">Pinjam</th>
                          <th width="6%" class="pr-1 text-center">Kembali</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry_jum_ruang1 = "SELECT COUNT(id) AS jumData FROM dt_pinjam_ruang WHERE peminjam='$data[id]' AND status_peminjaman='1'";
                            $r_jum_ruang1 = mysqli_query($con,  $qry_jum_ruang1 )or DIE( mysqli_error($con) );
                            $d_jum_ruang1 = mysqli_fetch_assoc( $r_jum_ruang1 );

                            $qry_jum_ruang2 = "SELECT COUNT(id) AS jumData FROM dt_pinjam_ruang WHERE peminjam='$data[id]' AND status_peminjaman='2'";
                            $r_jum_ruang2 = mysqli_query($con,  $qry_jum_ruang2 )or DIE( mysqli_error($con) );
                            $d_jum_ruang2 = mysqli_fetch_assoc( $r_jum_ruang2 );
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo $data['nm'];?> </td>
                            <td class="text-left"> <?php echo $data['alasan_pinjam'];?> </td>
                            <td class="text-center"> <?php echo $data['tgl_awal_pinjam'].' sd. '.$data['tgl_akhir_pinjam'];?> </td>
                            <td class="text-center"> <?php if($d_jum_ruang1['jumData'] < 1) { echo "<a  class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak ada data!\")' title='ada data!' disabled>".$d_jum_ruang1['jumData']."</a>";} else { echo "<a class='btn btn-outline-info btn-xs btn-block' href='kembaliPeminjamanDtRuang.php?id=".$data['id']."&page=".$page."')' title='Lihat atau kembalikan data'>".$d_jum_ruang1['jumData']."</a>";}?> </td>
                            <td class="text-center"> <?php if($d_jum_ruang2['jumData'] < 1) { echo "<a  class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak ada data!\")' title='ada data!' disabled>".$d_jum_ruang2['jumData']."</a>";} else { echo "<a class='btn btn-outline-info btn-xs btn-block' href='peminjamanDtRuangKembali.php?id=".$data['id']."&page=".$page."')' title='Lihat data barang yang kembali'>".$d_jum_ruang2['jumData']."</a>";}?> </td>
                            <td class="text-center" width="14%"> <a href="inputPeminjamanDtRuang.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" class="btn btn-outline-success btn-xs btn-block" title="Input data"><i class="fas fa-clipboard-list"></i> Input Ruang Dipinjam </a> </td>
                            <td class="text-center" width="4%"> <a href="editDtPeminjamRuang.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" class="btn btn-outline-primary btn-xs btn-block" title="Edit data"><i class="far fa-edit"></i></a> </td>
                            <td class="text-center pr-1" width="4%"> <?php if($d_jum_ruang1['jumData'] > 0) { echo "<a class='btn btn-outline-danger btn-xs btn-block' onclick='return confirm(\"Nama peminjam ini masih memiliki tanggungan peminjaman ruang! Yakin data ini dihapus?\")' title='Hapus data' href='deleteDtPeminjamRuang.php?id=".$data['id']."&page=".$page."')'><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-xs btn-block' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus data' href='deleteDtPeminjamRuang.php?id=".$data['id']."&page=".$page."')'><i class='far fa-trash-alt'></i></a>";}?> </td>
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
    <form action="sDtPinjamRuang.php" method="post">
      <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="inputModalLabel">Input Data Peminjam</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label for="nm">Nama Peminjam</label>
              <div class="form-group">
                <input name="nm" class="form-control form-control-sm" required>
              </div>
              <label for="alasan_pinjam">Alasan Peminjaman</label>
              <div class="form-group">
                <input name="alasan_pinjam" class="form-control form-control-sm" required>
              </div>
              <div class="form-group">
                <label for="tgl_awal_pinjam">Tanggal Mulai Peminjaman</label>
                <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                  <input type="text" name="tgl_awal_pinjam" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_one" required/>
                  <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="tgl_akhir_pinjam">Tanggal Akhir Peminjaman</label>
                <div class="input-group date" id="tgl_ymd_two" data-target-input="nearest">
                  <input type="text" name="tgl_akhir_pinjam" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_two" required/>
                  <div class="input-group-append" data-target="#tgl_ymd_two" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
              <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>