<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page_a = mysqli_real_escape_string($con,  $_GET[ 'page_a' ] );
  $tahun = mysqli_real_escape_string($con,  $_GET[ 'tahun' ] );
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
                <h4 class="mb-0">Rekap Data</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dataSuratMahasiswaAdm.php">Permohonan Surat</a></li>
                  <li class="breadcrumb-item small"><a href="dataIpitsAdm.php?page=<?php echo $page_a;?>">Izin Praktikum Individu Testee Siswa</a></li>
                  <li class="breadcrumb-item active small"><a href="dataIpitsPertahunAdm.php?page_a=<?php echo $page_a;?>&tahun=<?php echo $tahun;?>&page=<?php echo $page;?>">Tahun <?php echo $tahun;?></a></li>
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
                    <form action="updateDataIpitsPertahunAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="id" value="<?php echo $id;?>" readonly required>
                      <input type="text" class="sr-only" name="page_a" value="<?php echo $page_a;?>" readonly required>
                      <input type="text" class="sr-only" name="tahun" value="<?php echo $tahun;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
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
                        <div class="form-group col-4">
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
                        <div class="form-group col-4">
                          <label>Nama Testee</label>
                          <input type="text" name="nama_testee" class="form-control form-control-sm" value="<?php echo $dSurat['nama_testee'];?>" required>
                        </div>
                        <div class="form-group col-4">
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
                      <div class="form-row">
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