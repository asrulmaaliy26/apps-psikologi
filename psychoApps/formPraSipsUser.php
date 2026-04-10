<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  $nim = $dataku['nim'];

  $qwd1 = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);
  
  $qnotif = "SELECT * FROM notif_submit_surat LIMIT 1";
  $rnotif = mysqli_query($con, $qnotif)or die( mysqli_error($con));
  $dnotif = mysqli_fetch_assoc($rnotif);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="sformPraSipsUser.php" method="post" enctype="multipart/form-data">
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
                    <li class="breadcrumb-item active">Izin Observasi Pra Skripsi</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="modal-info">
            <div class="modal-dialog">
              <div class="modal-content bg-info">
                <div class="modal-header">
                  <h4 class="modal-title"><?php echo $dnotif['judul'];?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p><?php echo nl2br($dnotif['isi']);?></p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-sm btn-outline-warning" data-dismiss="modal">OK, saya mengerti...</button>
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
                          <a class="nav-link active" href="formPraSipsUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatPraSipsUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="lembaga_tujuan_surat">Instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="lembaga_tujuan_surat" placeholder="Contoh 1: Fakultas Psikologi UIN Maulana Malik Ibrahim Malang; Contoh 2: PT. Bahagia Selalu; Contoh 3: Desa Sidorejo, dst." required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="alamat_lengkap_lts">Alamat lengkap instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="alamat_lengkap_lts" placeholder="Alamat harus ditulis lengkap. Misal: Jalan, Nomor/Blok, RT., RW., Desa/Kelurahan, Kecamatan dan Kabupaten." required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="sebutan_pimpinan">Sebutan pimpinan untuk instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <select name="sebutan_pimpinan" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <?php
                              $q = mysqli_query($con, "SELECT * FROM opsi_sebutan_pimpinan ORDER BY nm ASC");
                              while ($tampil = mysqli_fetch_array($q)){
                                echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                              }
                              ?>
                          </select>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="kota_observasi">Kota instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <select name="kota_observasi" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <?php
                              $q = mysqli_query($con, "SELECT * FROM dt_kota ORDER BY nm_kota ASC");
                              while ($tampil = mysqli_fetch_array($q)){
                                echo "<option value='$tampil[id]'>$tampil[nm_kota]</option>";
                              }
                              ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="nama_obyek">Tempat observasi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_obyek" class="form-control form-control-sm" placeholder="Contoh 1: Fakultas Psikologi UIN Maulana Malik Ibrahim Malang; Contoh 2: PT. Bahagia Selalu; Contoh 3: Desa Sidorejo, dst." required>
                        <p class="help-block small"><strong><input type="checkbox" name="bilasama" onClick="IsiSamaNamaObyek(this.form)"> Silahkan checklist jika tempat observasi sama dengan Instansi/lembaga tujuan surat.</strong></p>
                      </div>
                      <div class="form-group">
                        <label for="judul_prop">Judul proposal <span class="text-danger">*</span></label>
                        <textarea id="textarea-custom-one" name="judul_prop" class="form-control form-control-sm" style="height: 300px;" required></textarea>
                        <p class="help-block small"><strong>Judul proposal harus ditulis dengan benar atau permohonan surat ditolak.</strong></p>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="dosen_pembimbing1">Dosen pembimbing I <span class="text-danger">*</span></label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'");
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'dospem_skripsi1' ];
                            
                            echo "<select name='dosen_pembimbing1' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' AND status='1' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'id' ] ) {
                                echo "<option value='$w[id]' selected>$w[nama]</option>";
                              } else {
                                echo "<option value='$w[id]'>$w[nama]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="dosen_pembimbing2">Dosen pembimbing II <span class="text-danger">*</span></label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'" );
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'dospem_skripsi2' ];
                            
                            echo "<select name='dosen_pembimbing2' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' AND status='1' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'id' ] ) {
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
                          <label for="tgl_awal_pelaksanaan">Tanggal mulai observasi <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="tgl_awal_pelaksanaan" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="tgl_akhir_pelaksanaan">Tanggal selesai observasi <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_two" data-target-input="nearest">
                            <input type="text" name="tgl_akhir_pelaksanaan" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_two" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="model_pelaksanaan">Observasi dilakukan secara <span class="text-danger">*</span></label>
                          <select name="model_pelaksanaan" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <?php
                              $q = mysqli_query($con, "SELECT * FROM opsi_model_ow_penel ORDER BY nm ASC");
                              while ($tampil = mysqli_fetch_array($q)){
                                echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                              }
                              ?>
                          </select>
                        </div>
                      </div>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" required readonly>
                      <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                      <input type="text" name="statusform" class="sr-only" value="1" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Submit permohonan surat</button>
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