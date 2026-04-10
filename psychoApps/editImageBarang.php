<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q_barang = "SELECT * FROM dt_inventaris_barang WHERE id='$id'";
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
                <h4 class="mb-0">Data Barang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dtBarang.php?page=<?php echo $page;?>">Data Barang</a></li>
                  <li class="breadcrumb-item active small">Edit Gambar Barang</li>
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
                      <h4 class="card-title float-left">Edit Gambar Barang</h4>
                      <span class="float-right"><strong><?php echo $d_barang['nm'];?></strong></span>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="updateImageBarang.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                    <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                    <label for="image">Gambar Barang</label>
                    <div class="form-group">
                      <input type="file" name="image" class="form-control form-control-sm" value="<?php echo $d_barang['image'];?>">
                      <small id="" class="form-text text-muted">File jpeg, jpg dan png.</small>
                    </div>
                    <img src="<?php echo $d_barang['image'];?>" class="img-fluid rounded mx-auto d-block" width="20%" onError="this.onerror=null;this.src='images/image_none.jpg'">
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm float-left">Update</button>
                    <a href="dtBarang.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
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