<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  $nim = $dataku['nim'];?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updateProfilAkademikUser.php" method="post" enctype="multipart/form-data">
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
                          <a class="nav-link active" href="profilAkademikUser.php" role="tab" aria-selected="true">Data akademik</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="profilPribadiUser.php" role="tab" aria-selected="true">Data pribadi</a>
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
                        <label for="nim">Nomor induk mahasiswa</label>
                        <input type="text" class="form-control form-control-sm" name="nim" placeholder="NIM" value="<?php echo $dataku['nim'];?>" disabled required>
                      </div>
                      <div class="form-group">
                        <label for="angkatan">Angkatan</label>
                        <input type="text" class="form-control form-control-sm" name="angkatan" placeholder="Angkatan" value="<?php echo $dataku['angkatan'];?>" disabled required>
                      </div>
                      <div class="form-group">
                        <label for="fakultas_pertama_daftar">Fakultas pertama daftar <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='fakultas_pertama_daftar' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM nm_fakultas ORDER BY id ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['fakultas_pertama_daftar'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <div class="form-group">
                        <label for="jurusan_pertama_daftar">Jurusan pertama daftar <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='jurusan_pertama_daftar' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM nm_fakultas ORDER BY id ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['jurusan_pertama_daftar'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <div class="form-group">
                        <label for="asal_sekolah">Asal SMA atau MA <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="asal_sekolah" placeholder="Asal SMA atau MA" value="<?php echo $dataku['asal_sekolah'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="pend_terakhir">Riwayat pendidikan terakhir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="pend_terakhir" placeholder="Riwayat pendidikan terakhir" value="<?php echo $dataku['pend_terakhir'];?>" required>
                      </div>
                      <div class="form-group">
                        <label for="dosen_wali">Dosen wali <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='dosen_wali' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' AND status = '1' ORDER BY nama_tg ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['dosen_wali'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nama]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nama]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" readonly required>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-outline-warning">Update data akademik</button>
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