<?php include( "contentsConAdm.php" );
  $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_ruang";
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
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Edit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Delete data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}                  
              ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Data Ruang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Data Ruang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dtRuang.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT r.id
          , r.nm
          , r.kategori
          , r.model
          
          FROM dt_ruang r
          LEFT JOIN opsi_kat_ruang okr
          on r.kategori = okr.id
          LEFT JOIN opsi_model_ruang omr
          on r.model = omr.id
          
          WHERE r.id LIKE '%$keyword%' OR r.nm LIKE '%$keyword%' OR r.kategori LIKE '%$keyword%' OR r.model LIKE '%$keyword%' OR okr.nm LIKE '%$keyword%' OR omr.nm LIKE '%$keyword%' ORDER BY r.nm ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dtRuang.php?pagination=true";
          $sql = "SELECT * FROM dt_ruang ORDER BY nm ASC";
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
                <form method="post" action="dtRuang.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dtRuang.php"><i class="fas fa-sync"></i> Kembali</a>
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
                      <h4 class="card-title float-left">Data Ruang (<?php echo $d_jum['jumData']?>)</h4>
                      <button type="button" class="btn btn-outline-primary btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="far fa-plus-square"></i> Input Data Ruang</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="32%">Nama Ruang</th>
                          <th width="22%">Kategori</th>
                          <th width="18%">Jenis</th>
                          <th width="16%">Status</th>
                          <th class="pr-1 text-center" colspan="2">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry_kat = "SELECT * FROM opsi_kat_ruang WHERE id='$data[kategori]'";
                            $r_kat = mysqli_query($con, $qry_kat);
                            $d_kat = mysqli_fetch_assoc($r_kat);
                            
                            $qry_model = "SELECT * FROM opsi_model_ruang WHERE id='$data[model]'";
                            $r_model = mysqli_query($con, $qry_model);
                            $d_model = mysqli_fetch_assoc($r_model);

                            $qry_ospb = "SELECT * FROM opsi_status_peminjaman_barang WHERE id='$data[status_peminjaman]'";
                            $r_ospb = mysqli_query($con, $qry_ospb);
                            $d_ospb = mysqli_fetch_assoc($r_ospb);
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo $data['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_kat['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_model['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_ospb['nm'];?> </td>
                            <td class="text-center" width="4%"> <?php if($data['status_peminjaman']==2) { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa diedit! Data masih dalam peminjaman\")' title='Tidak bisa diedit! Data masih dalam peminjaman' disabled><i class='far far fa-edit'></i></a>";} else { echo "<a class='btn btn-outline-primary btn-xs btn-block' href='editDtRuang.php?id=".$data['id']."&page=".$page."' title='Edit data'><i class='far fa-edit'></i></a>";}?> </td>
                            <td class="text-center pr-1" width="4%"> <?php if($data['status_peminjaman']==2) { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Data masih dalam peminjaman\")' title='Tidak bisa dihapus! Data masih dalam peminjaman' disabled><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-xs btn-block' href='deleteDtRuang.php?id=".$data['id']."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus data'><i class='far fa-trash-alt'></i></a>";}?> </td>
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
    <form action="sDtRuang.php" method="post">
      <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="inputModalLabel">Input Data Ruang</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label for="nm">Nama Ruang</label>
              <div class="form-group">
                <input name="nm" class="form-control form-control-sm" required>
              </div>
              <div class="form-group">
                <label for="kategori">Kategori Ruang</label>
                <select name="kategori" class="form-control form-control-sm" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($con, "SELECT * FROM opsi_kat_ruang ORDER BY nm ASC");
                    while ($c = mysqli_fetch_array($q)){
                      echo "<option value='$c[id]'>$c[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="model">Jenis Ruang</label>
                <select name="model" class="form-control form-control-sm" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($con, "SELECT * FROM opsi_model_ruang ORDER BY nm ASC");
                    while ($c = mysqli_fetch_array($q)){
                      echo "<option value='$c[id]'>$c[nm]</option>";
                    }
                    ?>
                </select>
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