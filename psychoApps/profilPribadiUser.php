<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  $oldDate = $dataku['tanggal_lahir'];
  $newDate = date("d-m-Y", strtotime($oldDate));
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updateProfilPribadiUser.php" method="post" enctype="multipart/form-data">
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
                          <a class="nav-link active" href="profilPribadiUser.php" role="tab" aria-selected="true">Data pribadi</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="profilOrtuUser.php" role="tab" aria-selected="true">Data orangtua</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="profilFotoUser.php" role="tab" aria-selected="true">File foto</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-group">
                        <label for="nama">Nama lengkap sesuai KTP dan Ijazah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" placeholder="Nama lengkap sesuai KTP dan Ijazah" value="<?php echo $dataku['nama'];?>" required disabled>
                      </div>
                      <div class="form-group">
                        <label for="tempat_lahir">Tempat lahir <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='tempat_lahir' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY id ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['tempat_lahir'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm_kota]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <div class="form-group">
                        <label for="tanggal_lahir">Tanggal lahir <span class="text-danger">*</span></label>
                        <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                          <input type="text" name="tanggal_lahir" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" value="<?php echo $newDate;?>" required/>
                          <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="alamat_ktp">Alamat sesuai KTP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="alamat_ktp" placeholder="Alamat sesuai KTP" value="<?php echo $dataku['alamat_ktp'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="alamat_malang">Alamat di Malang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="alamat_malang" placeholder="Alamat di Malang" value="<?php echo $dataku['alamat_malang'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="jenis_kelamin">Jenis kelamin <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='jenis_kelamin' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM jns_kelamin ORDER BY id ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['jenis_kelamin'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <div class="form-group">
                        <label for="kntk">Kontak handphone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="kntk" placeholder="Kontak handphone" value="<?php echo $dataku['kntk'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="imel">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="imel" placeholder="Email" value="<?php echo $dataku['imel'];?>" required>
                      </div>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" readonly required>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-outline-warning">Update data pribadi</button>
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