<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updateProfilOrtuUser.php" method="post" enctype="multipart/form-data">
    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
        <?php 
          include( "navtopAdm.php" );
          include( "navSideBarUserS1.php" );
          ?> 
        <div class="content-wrapper">
          <?php include( "alertUser.php" );?>
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Profil</h1>
                </div>
              </div>
            </div>
          </div>
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-3">
                  <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                      <div class="text-center">
                        <?php include("fotoUser.php");?>
                      </div>
                      <h3 class="profile-username text-center"><?php echo $dataku['nama'];?></h3>
                      <p class="text-muted text-center"><?php echo $dataku['nim'];?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="card card-success card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link" href="profilAkademikUser.php" role="tab" aria-selected="true">Data akademik</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="profilPribadiUser.php" role="tab" aria-selected="true">Data pribadi</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="profilOrtuUser.php" role="tab" aria-selected="true">Data orangtua</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="profilFotoUser.php" role="tab" aria-selected="true">File foto</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-group">
                        <label for="nama_ayah">Nama ayah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="nama_ayah" placeholder="Nama lengkap ayah" value="<?php echo $dataku['nama_ayah'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="pekerjaan_ayah">Pekerjaan ayah <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='pekerjaan_ayah' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM jns_pkrjn ORDER BY id ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['pekerjaan_ayah'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <div class="form-group">
                        <label for="alamat_ayah">Alamat ayah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="alamat_ayah" placeholder="Alamat ayah" value="<?php echo $dataku['alamat_ayah'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="telepon_ayah">Kontak handphone ayah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="telepon_ayah" placeholder="Kontak handphone ayah" value="<?php echo $dataku['telepon_ayah'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="nama_ibu">Nama ibu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="nama_ibu" placeholder="Nama lengkap ibu" value="<?php echo $dataku['nama_ibu'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="pekerjaan_ibu">Pekerjaan ibu <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='pekerjaan_ibu' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM jns_pkrjn ORDER BY id ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['pekerjaan_ibu'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <div class="form-group">
                        <label for="alamat_ibu">Alamat ibu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="alamat_ibu" placeholder="Alamat ibu" value="<?php echo $dataku['alamat_ibu'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="telepon_ibu">Kontak handphone ibu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="telepon_ibu" placeholder="Kontak handphone ibu" value="<?php echo $dataku['telepon_ibu'];?>" required>
                      </div>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" readonly required>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-outline-warning">Update data orangtua</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <?php include( "footerAdm.php" );?>
      <?php include( "jsAdm.php" );?>
    </body>
  </form>
</html>