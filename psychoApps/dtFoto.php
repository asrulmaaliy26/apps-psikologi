<?php include("contentsConAdm.php");
  $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_pegawai";
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
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalImage') {
                  echo '
                  <div class="alert alert-danger d-none" role="alert" id="alert">
                  <span>Edit data gagal! Pastikan file yang diupload berekstensi .jpeg, .jpg, atau .png!</span>
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
                <h4 class="mb-0">Direktori</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Foto Pegawai</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dtFoto.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT 
          d.id,
          d.nama,
          d.nama_tg,
          d.photo
                              
          FROM dt_pegawai d
                    
          WHERE d.id LIKE '%$keyword%' OR d.nama LIKE '%$keyword%' OR d.nama_tg LIKE '%$keyword%' ORDER BY d.nama_tg ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dtFoto.php?pagination=true";
          $sql = "SELECT * FROM dt_pegawai ORDER BY nama_tg ASC";
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
                <form method="post" action="dtFoto.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dtFoto.php"><i class="fas fa-sync"></i> Kembali</a>
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
                      <h4 class="card-title float-left">Foto Pegawai: <span class="badge badge-success"><?php echo $d_jum['jumData'];?> Item</span></h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="40%">Nama</th>
                          <th width="30%">NIP/Id Lainnya</th>
                          <th width="22%" class="text-center">Foto Pegawai</th>
                          <th class="pr-1 text-center" width="4%">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id= $data['id'];
                            ?>
                          <tr>
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class=""><?php echo $data['nama_tg'];?></td>
                            <td class=""><?php echo $data['id'];?></td>
                            <td class=""><img class="profile-user-img img-fluid rounded mx-auto d-block" src="<?php echo $data['photo'];?>" onError="this.onerror=null;this.src='<?php if($data['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt=""></td>
                            <td class="text-center pr-1"><a class="btn btn-outline-success btn-xs btn-block" href="editDtFoto.php?id=<?php echo $data['id'].'&page='.$page;?>" title="Edit data"><i class="far fa-edit"></i></a></td>
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