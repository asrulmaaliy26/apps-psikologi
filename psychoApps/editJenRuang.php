<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q_barang = "SELECT * FROM opsi_model_ruang WHERE id='$id'";
  $r_barang = mysqli_query($con, $q_barang)or die( mysqli_error($con));
  $d_barang = mysqli_fetch_assoc($r_barang);
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
                <h4 class="mb-0">Konfigurasi Jenis Ruang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="opsiJenRuang.php?page=<?php echo $page;?>">Konfigurasi Jenis Ruang</a></li>
                  <li class="breadcrumb-item active small">Edit Jenis Ruang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Edit Jenis Ruang</h4>
                      <span class="float-right"><strong><?php echo $d_barang['nm'];?></strong></span>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="updateJenRuang.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                    <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                    <label for="nm">Jenis Ruang</label>
                    <div class="form-group">
                      <input name="nm" class="form-control form-control-sm" value="<?php echo $d_barang['nm'];?>" required>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm float-left">Update</button>
                    <a href="opsiJenRuang.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
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