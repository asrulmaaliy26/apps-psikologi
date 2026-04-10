<?php 
  include( "contentsConAdm.php" );
  $angkatan = mysqli_real_escape_string($con, $_GET[ 'angkatan' ] );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  $page1 = mysqli_real_escape_string($con, $_GET[ 'page1' ] );
  
  $q = "SELECT * FROM mag_pengelompokan_rumpun WHERE id='$id'";
  $r = mysqli_query($con,  $q )or DIE( mysqli_error($con) );
  $d = mysqli_fetch_assoc( $r );
  
  $q_nim = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$d[nim]'";
  $r_nim = mysqli_query($con,  $q_nim )or DIE( mysqli_error($con) );
  $d_nim = mysqli_fetch_assoc( $r_nim );
  
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
                <h4 class="m-0">Pengajuan Peminatan Rumpun Psikologi</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magEditPprpAdm.php?page=<?php echo $page;?>">Edit Pengajuan</a></li>
                  <li class="breadcrumb-item"><a href="magEditPprpPerAngkatanAdm.php?id=<?php echo $angkatan;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>">Angkatan <?php echo $angkatan;?></a></li>
                  <li class="breadcrumb-item active">Per Mahasiswa</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <form action="magUpdatePprpPerIdAdm.php" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Per Mahasiswa</h3>
                        <span><?php echo $d_nim['nama'].' ['.$d_nim['nim'].']';?></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="angkatan" class="sr-only" value="<?php echo $d['angkatan'];?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="page1" class="sr-only" value="<?php echo $page1;?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                      <div class="form-group">
                        <label for="nm">Rumpun Psikologi <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='rumpun' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM mag_opsi_rumpun ORDER BY nm DESC" );
                          WHILE ( $w = mysqli_fetch_array( $tampil ) ) {
                            IF ( $d['rumpun'] == $w[ 'id' ] ) {
                               echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } ELSE {
                               echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          echo "</select>";
                          ?>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-outline-success btn-sm float-left">Update</button>
                      <a href="magEditPprpPerAngkatanAdm.php?id=<?php echo "$angkatan";?>&page=<?php echo "$page";?>&page1=<?php echo "$page1";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
                    </div>
                  </form>
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