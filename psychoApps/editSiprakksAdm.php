<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $queryAdm = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $rAdm = mysqli_query($con, $queryAdm) or die( mysqli_error($con));
  $dAdm = mysqli_fetch_assoc($rAdm);
  $idAdm = $dAdm['username'];
  
  $querySurat = "SELECT * FROM siprak_siswa WHERE id='$id'";
  $rSurat = mysqli_query($con, $querySurat) or die( mysqli_error($con));
  $dSurat = mysqli_fetch_assoc($rSurat);
  
  $queryMhssw = "SELECT * FROM dt_mhssw WHERE nim='$dSurat[nim]'";
  $rMhssw = mysqli_query($con,  $queryMhssw )or die( mysqli_error($con) );
  $dMhssw = mysqli_fetch_assoc( $rMhssw );
  
  $queryTembusan = "SELECT * FROM tembusan_surat_ak LIMIT 1";
  $rTembusan = mysqli_query($con,  $queryTembusan )or die( mysqli_error($con) );
  $dTembusan = mysqli_fetch_assoc( $rTembusan );
  $tahun = date("Y");

  $qNoAsk ="SELECT * FROM surat_keluar WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC LIMIT 1";
  $rNoAsk = mysqli_query($con, $qNoAsk) or die('Error');
  $dNoAsk = mysqli_fetch_assoc($rNoAsk);
                        
  $qNoAsm ="SELECT * FROM surat_masuk WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC LIMIT 1";
  $rNoAsm = mysqli_query($con, $qNoAsm) or die('Error');
  $dNoAsm = mysqli_fetch_assoc($rNoAsm);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmTaper.php" );
        ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Permohonan Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small"><a href="rekapSuratMahasiswaAdm.php?date=<?php echo $tahun;?>">Dari Mahasiswa</a></li>
                  <li class="breadcrumb-item active small"><a href="rekapSiprakSiswaKelAdm.php?date=<?php echo $tahun;?>&page=<?php echo $page;?>">Izin Praktikum Kelompok...</a></li>
                  <li class="breadcrumb-item small">Form Edit</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Form Edit</h4>
                    <span class="small float-right"> <?php echo $dMhssw['nama'].' ['.$dMhssw['nim'].']';?></span>
                  </div>
                  <div class="card-body">
                    <form action="updateSiprakksAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="id" value="<?php echo $id;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <input type="text" class="sr-only" name="date" value="<?php echo $tahun;?>" readonly required>
                      <input type="text" class="sr-only" name="executor" value="<?php echo $idAdm;?>" readonly required>
                      <?php if($dSurat['tgl_dikeluarkan']=='0000-00-00') { echo '<input type="text" name="tgl_dikeluarkan" class="sr-only" value="'.date("Y-m-d").'" readonly required>';} else { echo '<input type="text" name="tgl_dikeluarkan" class="sr-only" value="'.$dSurat['tgl_dikeluarkan'].'" readonly required>';}?>
                      <div class="row">
                      <div class="form-group col-6">
                        <label>Nomor Agenda Berkas Surat</label>
                        <input type="text" name="no_agenda_surat" class="form-control form-control-sm" value="<?php echo $dSurat['no_agenda_surat'];?>">
                        <small class="form-text text-muted">Nomor agenda berkas surat terakhir: Surat Masuk: <strong class="text-success"><?php echo $dNoAsm['no_berkas'];?></strong>. Surat Keluar: <strong class="text-success"><?php echo $dNoAsk['no_berkas'];?></strong>.</small>
                      </div>
                      <div class="form-group col-6">
                        <label>Instansi/Lembaga Tujuan Surat</label>
                        <input type="text" name="tujuan_prak" class="form-control form-control-sm" value="<?php echo $dSurat['tujuan_prak'];?>" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label>Sebutan Pimpinan untuk Instansi/Lembaga Tujuan Surat</label>
                        <?php
                          echo "<select name='sebutan_pimpinan' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_sebutan_pimpinan ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dSurat['sebutan_pimpinan'] == $w[ 'id' ] ) {
                               echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                               echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <div class="form-group col-6">
                        <label>Kota Instansi/Lembaga Tujuan Surat</label>
                        <?php
                          echo "<select name='kota_prak' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dSurat['kota_prak'] == $w[ 'id' ] ) {
                               echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                               echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                          }
                          echo "</select>";
                          ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label>Sebutan/Jenis Testee</label>
                        <?php
                          echo "<select name='jenjang_testee' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM jenjang_testee ORDER BY nama ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dSurat['jenjang_testee'] == $w[ 'id' ] ) {
                               echo "<option value='$w[id]' selected>$w[nama]</option>";
                            } else {
                               echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                          }
                          echo "</select>";
                          ?>
                      </div>
                      <div class="form-group col-6">
                        <label>Matakuliah Praktikum</label>
                        <?php
                          echo "<select name='matkul' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM matkul_praktikum ORDER BY nama ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dSurat['matkul'] == $w[ 'id' ] ) {
                               echo "<option value='$w[id]' selected>$w[nama]</option>";
                            } else {
                               echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                          }
                          echo "</select>";
                          ?>
                      </div>
                    </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label>Tanggal Praktikum</label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="waktu" class="form-control form-control-sm" data-target="#tgl_dmy_one" data-toggle="datetimepicker" value="<?php echo $dSurat['waktu'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-6">
                          <label>Jam Praktikum</label>
                          <div class="input-group date" id="jam_one" data-target-input="nearest">
                            <input type="text" name="jam" class="form-control form-control-sm" data-target="#jam_one" data-toggle="datetimepicker" value="<?php echo $dSurat['jam'];?>" required/>
                            <div class="input-group-append" data-target="#jam_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-clock"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='1'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 1</label>
                          <input type="text" name="testee1" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>" required>
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='2'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 2</label>
                          <input type="text" name="testee2" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>" required>
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='3'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 3</label>
                          <input type="text" name="testee3" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='4'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 4</label>
                          <input type="text" name="testee4" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="row">
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='5'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-md-3">
                          <label>Testee 5</label>
                          <input type="text" name="testee5" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='6'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 6</label>
                          <input type="text" name="testee6" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='7'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 7</label>
                          <input type="text" name="testee7" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='8'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 8</label>
                          <input type="text" name="testee8" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="row">
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='9'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 9</label>
                          <input type="text" name="testee9" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='10'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 10</label>
                          <input type="text" name="testee10" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='11'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 11</label>
                          <input type="text" name="testee11" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='12'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 12</label>
                          <input type="text" name="testee12" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="row">
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='13'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 13</label>
                          <input type="text" name="testee13" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='14'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 14</label>
                          <input type="text" name="testee14" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='15'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 15</label>
                          <input type="text" name="testee15" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='16'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 16</label>
                          <input type="text" name="testee16" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="row">
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='17'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 17</label>
                          <input type="text" name="testee17" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='18'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 18</label>
                          <input type="text" name="testee18" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='19'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-md-3">
                          <label>Testee 19</label>
                          <input type="text" name="testee19" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                        <?php 
                          $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND urutan='20'";
                          $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                          $mydata = mysqli_fetch_assoc($hsl)
                          ?>
                        <div class="form-group col-3">
                          <label>Testee 20</label>
                          <input type="text" name="testee20" class="form-control form-control-sm" value="<?php echo $mydata['nama_testee'];?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Tembusan Surat</label>
                        <textarea name="tembusan" class="form-control form-control-sm" rows="4" required><?php if (empty($dSurat['tembusan'])) { echo $dTembusan['isi'];} else { echo $dSurat['tembusan'];}?></textarea>
                      </div>
                      <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </form>
                  </div>
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