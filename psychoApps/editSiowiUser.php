<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM siow_individu WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updateSiowiUser.php" method="post" enctype="multipart/form-data">
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
                <div class="col-sm-4">
                  <h1 class="m-0 float-left">Permohonan Surat</h1>
                </div>
                <div class="col-sm-8">
                  <ol class="mt-2 breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Izin Observasi dan Wawancara (Matkul) Individu</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm">
                  <div class="card card-success card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link" href="formSiowiUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatSiowiUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editSiowiUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="lembaga_tujuan_surat">Instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="lembaga_tujuan_surat" placeholder="Contoh 1: Fakultas Psikologi UIN Maulana Malik Ibrahim Malang; Contoh 2: PT. Bahagia Selalu; Contoh 3: Desa Sidorejo, dst." value="<?php echo $dataku['lembaga_tujuan_surat'];?>" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="alamat_lengkap_lts">Alamat lengkap instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="alamat_lengkap_lts" placeholder="Alamat harus ditulis lengkap. Misal: Jalan, Nomor/Blok, RT., RW., Desa/Kelurahan, Kecamatan dan Kabupaten." value="<?php echo $dataku['alamat_lengkap_lts'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="sebutan_pimpinan">Sebutan pimpinan untuk instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='sebutan_pimpinan' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_sebutan_pimpinan ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['sebutan_pimpinan'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="kota_penelitian">Kota instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='kota_penelitian' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['kota_penelitian'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm_kota]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="tempat_ow">Tempat observasi dan wawancara <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_ow" class="form-control form-control-sm" placeholder="Contoh 1: Fakultas Psikologi UIN Maulana Malik Ibrahim Malang; Contoh 2: PT. Bahagia Selalu; Contoh 3: Desa Sidorejo, dst." value="<?php echo $dataku['tempat_ow'];?>" required>
                        <p class="help-block small"><strong><input type="checkbox" name="bilasama" onClick="IsiSama(this.form)"> Silahkan checklist jika tempat observasi dan wawancara sama dengan Instansi/lembaga tujuan surat.</strong></p>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="matkul">Tugas matakuliah <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='matkul' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_matkul ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['matkul'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="dosen_pembimbing">Dosen pengampu matakuliah <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='dosen_pembimbing' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' AND status = '1' ORDER BY nama ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['dosen_pembimbing'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nama]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nama]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="tgl_awal_pelaksanaan">Tanggal mulai observasi dan wawancara <span class="text-danger">*</span></label>
                        <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                          <input type="text" name="tgl_awal_pelaksanaan" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" value="<?php echo $dataku['tgl_awal_pelaksanaan'];?>" required/>
                          <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="tgl_akhir_pelaksanaan">Tanggal selesai observasi dan wawancara <span class="text-danger">*</span></label>
                        <div class="input-group date" id="tgl_dmy_two" data-target-input="nearest">
                          <input type="text" name="tgl_akhir_pelaksanaan" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_two" value="<?php echo $dataku['tgl_akhir_pelaksanaan'];?>" required/>
                          <div class="input-group-append" data-target="#tgl_dmy_two" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="model_pelaksanaan">Observasi dan wawancara dilakukan secara <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='model_pelaksanaan' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_model_ow_penel ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['model_pelaksanaan'] == $w[ 'id' ] ) {
                          echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                          echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                        </div>
                      </div>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                      <input type="text" name="statusform" class="sr-only" value="1" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Update permohonan surat</button>
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