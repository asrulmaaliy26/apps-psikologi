<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM siprak_siswa WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updateSiprakksUser.php" method="post" enctype="multipart/form-data">
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
                    <li class="breadcrumb-item active">Izin Praktikum Kelompok Testee Siswa</li>
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
                          <a class="nav-link" href="formSiprakksUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatSiprakksUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editSiprakksUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="tujuan_prak">Instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="tujuan_prak" placeholder="Nama lembaga yang siswa/santri/anak asuhnya akan Anda gunakan sebagai testee." value="<?php echo $dataku['tujuan_prak'];?>" required>
                        </div>
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
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="kota_prak">Kota instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='kota_prak' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dataku['kota_prak'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="jenjang_testee">Sebutan/jenis testee <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='jenjang_testee' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM jenjang_testee ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dataku['jenjang_testee'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nama]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
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
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="waktu">Tanggal praktikum <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="waktu" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" value="<?php echo $dataku['waktu'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="jam">Jam mulai praktikum <span class="text-danger">*</span></label>
                          <div class="input-group date" id="jam_one" data-target-input="nearest">
                            <input type="text" name="jam" class="form-control form-control-sm datetimepicker-input" data-target="#jam_one" value="<?php echo $dataku['jam'];?>" required/>
                            <div class="input-group-append" data-target="#jam_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-clock"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group mt-2">
                        <span class="d-block p-2 bg-info text-white">Nama-nama testee (Kosongkan kolom yang tidak diisi!)</span>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='1'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?> 
                          <label for="testee1">Testee 1 <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="testee1" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>" required>
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='2'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee2">Testee 2 <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="testee2" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>" required>
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='3'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee3">Testee 3</label>
                          <input type="text" class="form-control form-control-sm" name="testee3" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='4'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee4">Testee 4</label>
                          <input type="text" class="form-control form-control-sm" name="testee4" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='5'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?> 
                          <label for="testee5">Testee 5</label>
                          <input type="text" class="form-control form-control-sm" name="testee5" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='6'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee6">Testee 6</label>
                          <input type="text" class="form-control form-control-sm" name="testee6" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='7'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee7">Testee 7</label>
                          <input type="text" class="form-control form-control-sm" name="testee7" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='8'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee8">Testee 8</label>
                          <input type="text" class="form-control form-control-sm" name="testee8" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='9'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?> 
                          <label for="testee9">Testee 9</label>
                          <input type="text" class="form-control form-control-sm" name="testee9" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='10'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee10">Testee 10</label>
                          <input type="text" class="form-control form-control-sm" name="testee10" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='11'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee11">Testee 11</label>
                          <input type="text" class="form-control form-control-sm" name="testee11" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='12'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee12">Testee 12</label>
                          <input type="text" class="form-control form-control-sm" name="testee12" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='13'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?> 
                          <label for="testee13">Testee 13</label>
                          <input type="text" class="form-control form-control-sm" name="testee13" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='14'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee14">Testee 14</label>
                          <input type="text" class="form-control form-control-sm" name="testee14" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='15'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee15">Testee 15</label>
                          <input type="text" class="form-control form-control-sm" name="testee15" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='16'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee16">Testee 16</label>
                          <input type="text" class="form-control form-control-sm" name="testee16" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='17'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?> 
                          <label for="testee17">Testee 17</label>
                          <input type="text" class="form-control form-control-sm" name="testee17" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='18'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee18">Testee 18</label>
                          <input type="text" class="form-control form-control-sm" name="testee18" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='19'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee19">Testee 19</label>
                          <input type="text" class="form-control form-control-sm" name="testee19" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <?php 
                            $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='20'";
                            $r = mysqli_query($con, $q)or die( mysqli_error($con));
                            $dt = mysqli_fetch_assoc($r);
                            ?>
                          <label for="testee20">Testee 20</label>
                          <input type="text" class="form-control form-control-sm" name="testee20" placeholder="Satu nama per kolom." value="<?php echo $dt['nama_testee'];?>">
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