<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q_ruang = "SELECT * FROM dt_ruang WHERE id='$id'";
  $r_ruang = mysqli_query($con, $q_ruang)or die( mysqli_error($con));
  $d_ruang = mysqli_fetch_assoc($r_ruang);
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
                <h4 class="mb-0">Data Ruang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="dtRuang.php?page=<?php echo $page;?>">Data Ruang</a></li>
                  <li class="breadcrumb-item active small">Edit Data Ruang</li>
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
                      <h4 class="card-title float-left">Edit Data Ruang</h4>
                      <span class="float-right"><strong><?php echo $d_ruang['nm'];?></strong></span>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="updateDtRuang.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                    <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                    <label for="nm">Nama Ruang</label>
                    <div class="form-group">
                      <input name="nm" class="form-control form-control-sm" value="<?php echo $d_ruang['nm'];?>" required>
                    </div>
                    <div class="form-group">
                      <label for="kategori">Kategori Ruang</label>
                      <select name="kategori" class="form-control form-control-sm" required>
                      <?php
                        echo '<option value="">-Pilih-</option>';
                        $tampil = mysqli_query($con,  "SELECT * FROM opsi_kat_ruang ORDER BY nm ASC" );
                        while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $d_ruang['kategori'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="model">Jenis Ruang</label>
                      <select name="model" class="form-control form-control-sm" required>
                      <?php
                        echo '<option value="">-Pilih-</option>';
                        $tampil = mysqli_query($con,  "SELECT * FROM opsi_model_ruang ORDER BY nm ASC" );
                        while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $d_ruang['model'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm float-left">Update</button>
                    <a href="dtRuang.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
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