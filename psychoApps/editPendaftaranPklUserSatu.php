<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM peserta_pkl WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $q = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $r = mysqli_query($con, $q)or die( mysqli_error($con));
  $dt = mysqli_fetch_assoc($r);
  $nim = $dt['nim'];
  $oldDate = $dt['tanggal_lahir'];
  $newDate = date("d-m-Y", strtotime($oldDate));
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updatePendaftaranPklUserSatu.php" method="post" enctype="multipart/form-data">
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
                  <h1 class="m-0 float-left">Pendaftaran</h1>
                </div>
                <div class="col-sm-8">
                  <ol class="mt-2 breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Praktik Kerja Lapangan (PKL)</li>
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
                          <a class="nav-link" href="prePendaftaranPklUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatPendaftaranPklUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="detailRiwayatPendaftaranPklUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Pendaftaran</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editPendaftaranPklUserSatu.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Informasi Pendaftaran</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-2">
                          <label for="jenis_pkl">Pilihan jenis PKL <span class="text-danger">*</span></label>
                          <?php
                            echo "<select class='form-control form-control-sm' name='jenis_pkl' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_jenis_pkl ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                               if ( $dataku['jenis_pkl'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                               } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                               }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="dosen_wali">Dosen wali <span class="text-danger">*</span></label>
                          <?php
                            echo "<select class='form-control form-control-sm' name='dosen_wali' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                               if ( $dt['dosen_wali'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nama]</option>";
                               } else {
                                  echo "<option value='$w[id]'>$w[nama]</option>";
                               }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-2">
                          <label for="tempat_lahir">Tempat lahir <span class="text-danger">*</span></label>
                          <?php
                            echo "<select class='form-control form-control-sm' name='tempat_lahir' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                               if ( $dt['tempat_lahir'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                               } else {
                                  echo "<option value='$w[id]'>$w[nm_kota]</option>";
                               }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-2">
                          <label for="tanggal_lahir">Tanggal lahir <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="tanggal_lahir" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" value="<?php echo $newDate;?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-2">
                          <label for="jenis_kelamin">Jenis kelamin <span class="text-danger">*</span></label>
                          <?php
                            echo "<select class='form-control form-control-sm' name='jenis_kelamin' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM jns_kelamin ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                               if ( $dt['jenis_kelamin'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                               } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                               }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-5">
                          <label for="alamat_ktp">Alamat asal <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="alamat_ktp" value="<?php echo $dt['alamat_ktp'];?>" required>
                        </div>
                        <div class="form-group col-sm-5">
                          <label for="alamat_malang">Alamat di Malang <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="alamat_malang" value="<?php echo $dt['alamat_malang'];?>" required>
                        </div>
                        <div class="form-group col-sm-2">
                          <label for="kntk">Kontak HP <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="kntk" value="<?php echo $dt['kntk'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="kontak_lain">Kontak HP orang terdekat <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="kontak_lain" value="<?php echo $dataku['kontak_lain'];?>" required>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="sks_diambil">Total SKS yang telah diambil + sks semester ini <span class="text-danger">*</span></label>
                          <input type="number" class="form-control form-control-sm" name="sks_diambil" value="<?php echo $dataku['sks_diambil'];?>"required>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="riwayat_penyakit">Riwayat penyakit</label>
                          <input type="text" class="form-control form-control-sm" name="riwayat_penyakit" value="<?php echo $dataku['riwayat_penyakit'];?>">
                        </div>
                      </div>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
                      <input type="text" name="id_pkl" class="sr-only" value="<?php echo $dataku['id_pkl'];?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Update informasi pendaftaran</button>
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