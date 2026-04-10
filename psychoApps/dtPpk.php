<?php include("contentsConAdm.php");
  $qry_jum = "SELECT COUNT(id) AS jumData FROM ppk";
  $r_jum = mysqli_query($con, $qry_jum);
  $d_jum = mysqli_fetch_assoc($r_jum);
  
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmKepeg.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                  echo '
                  <div class="alert alert-danger d-none" role="alert" id="alert">
                  <span>Input data gagal! PPK Sudah Ada!</span>
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
                <h4 class="mb-0">Konfigurasi</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">PPK</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dtPpk.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT 
          d.id,
          d.nm,
          d.jabatan_instansi,
          dp.id,
          oji.id
                              
          FROM ppk d
          LEFT JOIN dt_pegawai dp
          on d.nm = dp.id
          LEFT JOIN opsi_jabatan_instansi oji
          on d.jabatan_instansi = oji.id
                    
          WHERE d.id LIKE '%$keyword%' OR d.nm LIKE '%$keyword%' OR d.jabatan_instansi LIKE '%$keyword%' OR dp.nama LIKE '%$keyword%' OR oji.nm_panjang LIKE '%$keyword%' ORDER BY dp.nama ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dtPpk.php?pagination=true";
          $sql = "SELECT * FROM ppk ORDER BY nm ASC";
          $result = mysqli_query($con, $sql);
          }
          
          $rpp = 100;
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
                <form method="post" action="dtPpk.php">
                  <?php error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){
                        ?>
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dtPpk.php"><i class="fas fa-sync"></i> Kembali</a>
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
                      <h4 class="card-title float-left">PPK: <span class="badge badge-success"><?php echo $d_jum['jumData'];?> Item</span></h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="22%">Nama</th>
                          <th width="70%">Jabatan Instansi</th>
                          <th class="pr-1 text-center" width="4%">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id= $data['id'];

                            $qkatpegawai =  "SELECT * FROM dt_pegawai WHERE id='$data[nm]'";
                            $rkatpegawai = mysqli_query($con, $qkatpegawai);
                            $dkatpegawai = mysqli_fetch_array($rkatpegawai);

                            $qjabataninstansi =  "SELECT * FROM opsi_jabatan_instansi WHERE id='$data[jabatan_instansi]'";
                            $rjabataninstansi = mysqli_query($con, $qjabataninstansi);
                            $djabataninstansi = mysqli_fetch_array($rjabataninstansi);
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class=""> <?php echo $dkatpegawai['nama_tg'];?> </td>
                            <td class=""> <?php echo $djabataninstansi['nm'];?> </td>
                            <td class="text-center pr-1"> <a class="btn btn-outline-success btn-xs btn-block" href="editDtPpk.php?id=<?php echo $data['id'].'&page='.$page;?>" title="Edit data"><i class="far fa-edit"></i></a> </td>
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