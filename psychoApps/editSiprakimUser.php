<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM siprak_mahasiswa WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updateSiprakimUser.php" method="post" enctype="multipart/form-data">
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
                    <li class="breadcrumb-item active">Izin Praktikum Individu Testee Mahasiswa</li>
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
                          <a class="nav-link" href="formSiprakimUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatSiprakimUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editSiprakimUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="nama_testee">Nama lengkap testee <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="nama_testee" value="<?php echo $dataku['nama_testee'];?>" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="nim_testee">NIM testee <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="nim_testee" value="<?php echo $dataku['nim_testee'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="matkul_testee">Matakuliah testee <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="matkul_testee" value="<?php echo $dataku['matkul_testee'];?>" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="dosen_testee">Nama dosen matakuliah testee (dengan gelar) <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="dosen_testee" value="<?php echo $dataku['dosen_testee'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="matkul">Praktikum untuk matakuliah <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='matkul' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM matkul_praktikum ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dataku['matkul'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nama]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="waktu">Tanggal praktikum <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="waktu" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" value="<?php echo $dataku['waktu'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="jam">Jam mulai praktikum <span class="text-danger">*</span></label>
                          <div class="input-group date" id="jam_one" data-target-input="nearest">
                            <input type="text" name="jam" class="form-control form-control-sm datetimepicker-input" data-target="#jam_one" value="<?php echo $dataku['jam'];?>" required/>
                            <div class="input-group-append" data-target="#jam_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-clock"></i></div>
                            </div>
                          </div>
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