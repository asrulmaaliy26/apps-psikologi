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
  
  $querySurat = "SELECT * FROM sitp WHERE id='$id'";
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
                  <li class="breadcrumb-item small"><a href="dataItpAdm.php?page=<?php echo $page_a;?>">Izin Tempat (Lokasi) PKL</a></li>
                  <li class="breadcrumb-item active small"><a href="dataItpPertahunAdm.php?page_a=<?php echo $page_a;?>&tahun=<?php echo $tahun;?>&page=<?php echo $page;?>">Tahun <?php echo $tahun;?></a></li>
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
                    <form action="updateDataItpPertahunAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="id" value="<?php echo $id;?>" readonly required>
                      <input type="text" class="sr-only" name="page_a" value="<?php echo $page_a;?>" readonly required>
                      <input type="text" class="sr-only" name="tahun" value="<?php echo $tahun;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <input type="text" class="sr-only" name="anggota1" value="<?php echo $nim;?>" readonly required>
                      <input type="text" class="sr-only" name="executor" value="<?php echo $idAdm;?>" readonly required>
                      <?php if($dSurat['tgl_dikeluarkan']=='0000-00-00') { echo '<input type="text" name="tgl_dikeluarkan" class="sr-only" value="'.date("Y-m-d").'" readonly required>';} else { echo '<input type="text" name="tgl_dikeluarkan" class="sr-only" value="'.$dSurat['tgl_dikeluarkan'].'" readonly required>';}?>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Nomor Agenda Berkas Surat</label>
                          <input type="text" name="no_agenda_surat" class="form-control form-control-sm" value="<?php echo $dSurat['no_agenda_surat'];?>">
                          <small class="form-text text-muted">Nomor agenda berkas surat terakhir: Surat Masuk: <strong class="text-success"><?php echo $dNoAsm['no_berkas'];?></strong>. Surat Keluar: <strong class="text-success"><?php echo $dNoAsk['no_berkas'];?></strong>.</small>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Anggota 1</label>
                          <input type="text" name="anggota1" class="form-control form-control-sm" value="<?php echo $dMhssw['nama']."&nbsp;[".$dMhssw['nim']."]";?>" disabled required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label>Anggota 2</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='2'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota2' class='form-control form-control-sm' required>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Anggota 3</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='3'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota3' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Anggota 4</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='4'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota4' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label>Anggota 5</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='5'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota5' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Anggota 6</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='6'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota6' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Anggota 7</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='7'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota7' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label>Anggota 8</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='8'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota8' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Anggota 9</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='9'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota9' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Anggota 10</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='10'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota10' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label>Anggota 11</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='11'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota11' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-6">
                          <label>Anggota 12</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$id' AND urutan='12'");
                            $select = mysqli_fetch_array($tampil);
                            $data = $select['nim_anggota'];
                              echo "<select name='anggota12' class='form-control form-control-sm'>";
                              echo "<option value=''>-Pilih-</option>";
                            
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC");
                            while ($w = mysqli_fetch_array($tampil)) {
                              if($data == $w['nim']) {
                                echo "<option value='$w[nim]' selected>$w[nama] [$w[nim]]</option>";
                              }
                              else {
                                echo "<option value='$w[nim]'>$w[nama] [$w[nim]]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Instansi/Lembaga Tujuan Surat</label>
                          <input type="text" name="lembaga_tujuan_surat" class="form-control form-control-sm" value="<?php echo $dSurat['lembaga_tujuan_surat'];?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Alamat Lengkap Instansi/Lembaga Tujuan Surat</label>
                          <input type="text" name="alamat_lengkap_lts" class="form-control form-control-sm" value="<?php echo $dSurat['alamat_lengkap_lts'];?>" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-5">
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
                        <div class="form-group col-md-4">
                          <label>Kota Instansi/Lembaga Tujuan Surat</label>
                          <?php
                            echo "<select name='kota_lts' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $dSurat['kota_lts'] == $w[ 'id' ] ) {
                                 echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                              } else {
                                 echo "<option value='$w[id]'>$w[nm_kota]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-3">
                          <label>Jenis PKL yang Akan Diikuti</label>
                          <?php
                            echo "<select name='jenis_pkl' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_jenis_pkl ORDER BY nm ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $dSurat['jenis_pkl'] == $w[ 'id' ] ) {
                                 echo "<option value='$w[id]' selected>$w[nm]</option>";
                              } else {
                                 echo "<option value='$w[id]'>$w[nm]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
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