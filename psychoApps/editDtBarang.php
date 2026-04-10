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
                  <li class="breadcrumb-item small"><a class="text-info" href="dtBarang.php?page=<?php echo $page;?>">Data Barang</a></li>
                  <li class="breadcrumb-item active small">Edit Data Barang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updateDtBarang.php" method="post" enctype="multipart/form-data">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Data Barang</h4>
                        <span class="float-right"><strong><?php echo $d_barang['nm'];?></strong></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <label for="nm">Nama Barang</label>
                      <div class="form-group">
                        <input name="nm" class="form-control form-control-sm" value="<?php echo $d_barang['nm'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="merk">Merk Barang</label>
                        <select name="merk" class="form-control form-control-sm" required>
                        <?php
                          echo '<option value="">-Pilih-</option>';
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_merk_barang ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $d_barang['merk'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="tgl_perolehan">Tanggal dan Tahun Perolehan Barang</label>
                        <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                          <input type="text" name="tgl_perolehan" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_one" value="<?php echo $d_barang['tgl_perolehan'];?>" required/>
                          <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="sumber_dana">Sumber Dana Perolehan Barang</label>
                        <select name="sumber_dana" class="form-control form-control-sm" required>
                        <?php
                          echo '<option value="">-Pilih-</option>';
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_sumber_dana_perolehan_barang ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $d_barang['sumber_dana'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="kategori">Kategori Barang</label>
                        <select name="kategori" class="form-control form-control-sm" required>
                        <?php
                          echo '<option value="">-Pilih-</option>';
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_kat_barang ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $d_barang['kategori'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="sub_kategori">Sub Kategori Barang</label>
                        <select name="sub_kategori" class="form-control form-control-sm" required>
                        <?php
                          echo '<option value="">-Pilih-</option>';
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_sub_kat_barang ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $d_barang['sub_kategori'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="kondisi">Kondisi Barang</label>
                        <select name="kondisi" class="form-control form-control-sm" required>
                        <?php
                          echo '<option value="">-Pilih-</option>';
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_kondisi_barang ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $d_barang['kondisi'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <label for="id_inventaris_pusat">Kode Barang Universitas</label>
                      <div class="form-group">
                        <input name="id_inventaris_pusat" class="form-control form-control-sm" value="<?php echo $d_barang['id_inventaris_pusat'];?>">
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-outline-primary btn-sm float-left">Update</button>
                      <a href="dtBarang.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
                    </div>
                  </div>
                </form>
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