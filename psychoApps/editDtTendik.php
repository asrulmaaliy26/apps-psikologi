<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $r = mysqli_query($con, $q);
  $data = mysqli_fetch_assoc($r);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmKepeg.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Data Pegawai</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="dtTendik.php?page=<?php echo $page;?>">Data Tendik</a></li>
                  <li class="breadcrumb-item active small">Edit Data Tendik</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updateDtTendik.php" method="post" enctype="multipart/form-data">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Data Tendik</h4>
                        <span class="float-right"><strong><?php echo $data['nama_tg'];?></strong></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="nama">Nama dengan Gelar <span class="text-danger">*</span></label>
                          <input value="<?php echo $data['nama'];?>" type="text" name="nama" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group col-6">
                          <label for="nama_tg">Nama tanpa Gelar <span class="text-danger">*</span></label>
                          <input value="<?php echo $data['nama_tg'];?>" type="text" name="nama_tg" class="form-control form-control-sm" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-4">
                          <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                          <select name="tempat_lahir" class="form-control form-control-sm" required>
                          <?php
                            echo '<option value="">-Pilih-</option>';
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $data['tempat_lahir'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-4">
                          <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                            <input value="<?php echo $data['tanggal_lahir'];?>" type="text" name="tanggal_lahir" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_one" required>
                            <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-4">
                          <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                          <select name="jenis_kelamin" class="form-control form-control-sm" required>
                          <?php
                            echo '<option value="">-Pilih-</option>';
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_jenis_kelamin ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $data['jenis_kelamin'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-2">
                          <label for="kntk1">No. Kontak 1 <span class="text-danger">*</span></label>
                          <input value="<?php echo $data['kntk1'];?>" type="text" name="kntk1" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group col-2">
                          <label for="kntk2">No. Kontak 2</label>
                          <input value="<?php echo $data['kntk2'];?>" type="text" name="kntk2" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-4">
                          <label for="email1">Email 1 <span class="text-danger">*</span></label>
                          <input value="<?php echo $data['email1'];?>" type="text" name="email1" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group col-4">
                          <label for="email2">Email 2</label>
                          <input value="<?php echo $data['email2'];?>" type="text" name="email2" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="alamat_ktp">Alamat sesuai KTP <span class="text-danger">*</span></label>
                        <input value="<?php echo $data['alamat_ktp'];?>" type="text" name="alamat_ktp" class="form-control form-control-sm" required>
                      </div>
                      <div class="form-group">
                        <label for="alamat_rumah">Alamat Domisili Rumah <span class="text-danger">*</span></label>
                        <input value="<?php echo $data['alamat_rumah'];?>" type="text" name="alamat_rumah" class="form-control form-control-sm" required>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="id">NIP/Id Lainnya <span class="text-danger">*</span></label>
                          <input value="<?php echo $data['id'];?>" type="text" class="form-control form-control-sm" disabled readonly required>
                        </div>
                        <div class="form-group col-6">
                          <label for="kat_pegawai">Kategori Pegawai <span class="text-danger">*</span></label>
                          <select name="kat_pegawai" class="form-control form-control-sm" required>
                          <?php
                            echo '<option value="">-Pilih-</option>';
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_kat_pegawai ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $data['kat_pegawai'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-4">
                          <label for="pangkat">Pangkat <span class="text-danger">*</span></label>
                          <select name="pangkat" class="form-control form-control-sm" required>
                          <?php
                            echo '<option value="">-Pilih-</option>';
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_pangkat ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $data['pangkat'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm_pangkat]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm_pangkat]</option>";
                            }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-6">
                          <label for="jabatan_instansi">Jabatan Instansi <span class="text-danger">*</span></label>
                          <select name="jabatan_instansi" class="form-control form-control-sm" required>
                          <?php
                            echo '<option value="">-Pilih-</option>';
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_jabatan_instansi ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $data['jabatan_instansi'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-2">
                          <label for="status">Status Tendik <span class="text-danger">*</span></label>
                          <select name="status" class="form-control form-control-sm" required>
                          <?php
                            echo '<option value="">-Pilih-</option>';
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_status_pegawai ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $data['status'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="form-group col-3">
                          <label for="tgl_cpns">Tanggal CPNS</label>
                          <div class="input-group date" id="tgl_cpns" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_cpns'];?>" type="text" name="tgl_cpns" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_cpns">
                            <div class="input-group-append" data-target="#tgl_cpns" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tmt">TMT Kerja</label>
                          <div class="input-group date" id="tmt" data-target-input="nearest">
                            <input value="<?php echo $data['tmt'];?>" type="text" name="tmt" class="form-control form-control-sm datetimepicker-input" data-target="#tmt">
                            <div class="input-group-append" data-target="#tmt" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tgl_2a">Tanggal IIa</label>
                          <div class="input-group date" id="tgl_2a" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_2a'];?>" type="text" name="tgl_2a" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_2a">
                            <div class="input-group-append" data-target="#tgl_2a" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tgl_2b">Tanggal IIb</label>
                          <div class="input-group date" id="tgl_2b" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_2b'];?>" type="text" name="tgl_2b" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_2b">
                            <div class="input-group-append" data-target="#tgl_2b" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-3">
                          <label for="tgl_2c">Tanggal IIc</label>
                          <div class="input-group date" id="tgl_2c" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_2c'];?>" type="text" name="tgl_2c" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_2c">
                            <div class="input-group-append" data-target="#tgl_2c" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tgl_2d">Tanggal IId</label>
                          <div class="input-group date" id="tgl_2d" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_2d'];?>" type="text" name="tgl_2d" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_2d">
                            <div class="input-group-append" data-target="#tgl_2d" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tgl_3a">Tanggal IIIa</label>
                          <div class="input-group date" id="tgl_3a" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_3a'];?>" type="text" name="tgl_3a" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_3a">
                            <div class="input-group-append" data-target="#tgl_3a" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tgl_3b">Tanggal IIIb</label>
                          <div class="input-group date" id="tgl_3b" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_3b'];?>" type="text" name="tgl_3b" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_3b">
                            <div class="input-group-append" data-target="#tgl_3b" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-3">
                          <label for="tgl_3c">Tanggal IIIc</label>
                          <div class="input-group date" id="tgl_3c" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_3c'];?>" type="text" name="tgl_3c" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_3c">
                            <div class="input-group-append" data-target="#tgl_3c" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tgl_3d">Tanggal IIId</label>
                          <div class="input-group date" id="tgl_3d" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_3d'];?>" type="text" name="tgl_3d" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_3d">
                            <div class="input-group-append" data-target="#tgl_3d" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tgl_4a">Tanggal IVa</label>
                          <div class="input-group date" id="tgl_4a" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_4a'];?>" type="text" name="tgl_4a" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4a">
                            <div class="input-group-append" data-target="#tgl_4a" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-3">
                          <label for="tgl_4b">Tanggal IVb</label>
                          <div class="input-group date" id="tgl_4b" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_4b'];?>" type="text" name="tgl_4b" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4b">
                            <div class="input-group-append" data-target="#tgl_4b" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-4">
                          <label for="tgl_4c">Tanggal IVc</label>
                          <div class="input-group date" id="tgl_4c" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_4c'];?>" type="text" name="tgl_4c" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4c">
                            <div class="input-group-append" data-target="#tgl_4c" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-4">
                          <label for="tgl_4d">Tanggal IVd</label>
                          <div class="input-group date" id="tgl_4d" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_4d'];?>" type="text" name="tgl_4d" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4d">
                            <div class="input-group-append" data-target="#tgl_4d" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-4">
                          <label for="tgl_4e">Tanggal IVe</label>
                          <div class="input-group date" id="tgl_4e" data-target-input="nearest">
                            <input value="<?php echo $data['tgl_4e'];?>" type="text" name="tgl_4e" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4e">
                            <div class="input-group-append" data-target="#tgl_4e" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="form-group col-8">
                          <label for="sma">SMA/Sederajat</label>
                          <input value="<?php echo $data['sma'];?>" type="text" name="sma" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-4">
                          <label for="th_sma">Tanggal Lulus SMA/Sederajat</label>
                          <div class="input-group date" id="th_sma" data-target-input="nearest">
                            <input value="<?php echo $data['th_sma'];?>" type="text" name="th_sma" class="form-control form-control-sm datetimepicker-input" data-target="#th_sma">
                            <div class="input-group-append" data-target="#th_sma" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-8">
                          <label for="strata1">Prodi Fakultas PT Strata 1</label>
                          <input value="<?php echo $data['strata1'];?>" type="text" name="strata1" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-4">
                          <label for="th_s1">Tanggal Lulus Strata 1</label>
                          <div class="input-group date" id="th_s1" data-target-input="nearest">
                            <input value="<?php echo $data['th_s1'];?>" type="text" name="th_s1" class="form-control form-control-sm datetimepicker-input" data-target="#th_s1">
                            <div class="input-group-append" data-target="#th_s1" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-8">
                          <label for="strata2">Prodi Fakultas PT Strata 2</label>
                          <input value="<?php echo $data['strata2'];?>" type="text" name="strata2" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-4">
                          <label for="th_s2">Tanggal Lulus Strata 2</label>
                          <div class="input-group date" id="th_s2" data-target-input="nearest">
                            <input value="<?php echo $data['th_s2'];?>" type="text" name="th_s2" class="form-control form-control-sm datetimepicker-input" data-target="#th_s2">
                            <div class="input-group-append" data-target="#th_s2" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-8">
                          <label for="strata3">Prodi Fakultas PT Strata 3</label>
                          <input value="<?php echo $data['strata3'];?>" type="text" name="strata3" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-4">
                          <label for="th_s3">Tanggal Lulus Strata 3</label>
                          <div class="input-group date" id="th_s3" data-target-input="nearest">
                            <input value="<?php echo $data['th_s3'];?>" type="text" name="th_s3" class="form-control form-control-sm datetimepicker-input" data-target="#th_s3">
                            <div class="input-group-append" data-target="#th_s3" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <label for="password">Password Akun <span class="text-danger">*</span></label>
                        <input value="<?php echo $data['password'];?>" type="password" name="password" class="form-control form-control-sm" readonly disabled required>
                      </div>
                    </div>
                    <div class="card-footer justify-content-between">
                      <button type="submit" name="submit" class="btn btn-outline-success btn-sm">Update</button>
                      <a href="dtTendik.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm">Batal</a>
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