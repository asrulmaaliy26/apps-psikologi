<?php include( "contentsConAdm.php" );
  $qry_jum = "SELECT COUNT(id) AS jumData FROM opsi_merk_barang";
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
                <h4 class="mb-0">Konfigurasi Merk Barang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Konfigurasi Merk Barang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "opsiMerkBarang.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT * FROM opsi_merk_barang WHERE id LIKE '%$keyword%' OR nm LIKE '%$keyword%' ORDER BY id ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "opsiMerkBarang.php?pagination=true";
          $sql = "SELECT * FROM opsi_merk_barang ORDER BY id ASC";
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
                <form method="post" action="opsiMerkBarang.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="opsiMerkBarang.php"><i class="fas fa-sync"></i> Kembali</a>
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
                      <h4 class="card-title float-left">Merk Barang (<?php echo $d_jum['jumData']?>)</h4>
                      <button type="button" class="btn btn-outline-primary btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="far fa-plus-square"></i> Input Merk Barang</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="8%">Kode</th>
                          <th width="80%">Merk Barang</th>
                          <th class="pr-1 text-center" colspan="2">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);

                            $qry_jum_kat = "SELECT COUNT(id) AS jumData FROM dt_inventaris_barang WHERE merk=$data[id]";
                            $r_jum_kat = mysqli_query($con,  $qry_jum_kat )or DIE( mysqli_error($con) );
                            $d_jum_kat = mysqli_fetch_assoc( $r_jum_kat );
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo $data['id'];?> </td>
                            <td class="text-left"> <?php echo $data['nm'];?> </td>
                            <td class="text-center" width="4%"> <a href="editMerkBarang.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" class="btn btn-outline-primary btn-xs btn-block" title="Edit data"><i class="far fa-edit"></i></a> </td>
                            <td class="text-center pr-1" width="4%"> <?php if($d_jum_kat['jumData'] > 0) { echo "<a  class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Merk ini telah dipakai.\")' title='Tidak bisa dihapus! Merk ini telah dipakai.' disabled><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-xs btn-block' href='deleteMerkBarang.php?id=".$data['id']."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='far fa-trash-alt'></i></a>";}?> </td>
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
    <form action="sMerkBarang.php" method="post">
      <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="inputModalLabel">Input Merk Barang</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label for="nm">Merk Barang</label>
              <div class="form-group">
                <input name="nm" class="form-control form-control-sm" required>
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