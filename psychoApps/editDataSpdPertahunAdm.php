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
  
  $qNoAsk ="SELECT * FROM surat_keluar WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC LIMIT 1";
  $rNoAsk = mysqli_query($con, $qNoAsk) or die('Error');
  $dNoAsk = mysqli_fetch_assoc($rNoAsk);
                        
  $qNoAsm ="SELECT * FROM surat_masuk WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC LIMIT 1";
  $rNoAsm = mysqli_query($con, $qNoAsm) or die('Error');
  $dNoAsm = mysqli_fetch_assoc($rNoAsm);
  
  $myquery="SELECT * FROM spd WHERE id='$id'";
  $result=mysqli_query($con, $myquery) or die (mysqli_error($con));
  $dt=mysqli_fetch_assoc($result);
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
                <h4 class="mb-0">Surat Perjalanan Dinas</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dataSpdAdm.php?page=<?php echo $page_a;?>">Surat Tugas</a></li>
                  <li class="breadcrumb-item small"><a href="dataSpdPertahunAdm.php?page_a=<?php echo $page_a;?>&tahun=<?php echo $tahun;?>&page=<?php echo $page;?>">Tahun <?php echo $tahun;?></a></li>
                  <li class="breadcrumb-item active small">Form Edit</li>
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
                  </div>
                  <div class="card-body">
                    <form action="updateDataSpdPertahunAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="id" value="<?php echo $id;?>" readonly required>
                      <input type="text" class="sr-only" name="page_a" value="<?php echo $page_a;?>" readonly required>
                      <input type="text" class="sr-only" name="tahun" value="<?php echo $tahun;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <input type="text" class="sr-only" name="editor" value="<?php echo $idAdm;?>" readonly required>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Nomor Agenda Berkas Surat</label>
                          <input type="text" name="no_agenda_surat" class="form-control form-control-sm" value="<?php echo $dt['no_agenda_surat'];?>">
                          <small class="form-text text-muted">Nomor agenda berkas surat terakhir: Surat Masuk: <strong class="text-success"><?php echo $dNoAsm['no_berkas'];?></strong>. Surat Keluar: <strong class="text-success"><?php echo $dNoAsk['no_berkas'];?></strong>.</small>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Nama Pegawai yang Diperintahkan</label>
                          <?php
                            echo "<select name='penerima' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $dt['penerima'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Maksud Perjalanan Dinas</label>
                        <textarea id="textarea-custom-one" name="maksud_spd" class="form-control form-control-sm" style="height: 300px;" required><?php echo $dt['maksud_spd'];?></textarea>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Tempat Berangkat</label>
                          <?php
                            echo "<select name='tempat_berangkat' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_kota ORDER BY nm_kota ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $dt['tempat_berangkat'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Lamanya Perjalanan Dinas</label>
                          <?php
                            echo "<select name='durasi_spd' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_durasi_spd ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $dt['durasi_spd'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[durasi]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[durasi]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Tempat Tujuan I</label>
                          <?php
                            echo "<select name='tempat_tujuan' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_kota ORDER BY nm_kota ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $dt['tempat_tujuan'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tempat Tujuan II</label>
                          <?php
                            echo "<select name='tempat_tujuan2' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_kota ORDER BY nm_kota ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $dt['tempat_tujuan2'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tempat Tujuan III</label>
                          <?php
                            echo "<select name='tempat_tujuan3' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_kota ORDER BY nm_kota ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $dt['tempat_tujuan3'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Tanggal Berangkat</label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="tanggal_berangkat" class="form-control form-control-sm" data-target="#tgl_dmy_one" data-toggle="datetimepicker" value="<?php echo $dt['tanggal_berangkat'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tanggal Kembali</label>
                          <div class="input-group date" id="tgl_dmy_two" data-target-input="nearest">
                            <input type="text" name="tanggal_kembali" class="form-control form-control-sm" data-target="#tgl_dmy_two" data-toggle="datetimepicker" value="<?php echo $dt['tanggal_kembali'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tanggal Ditetapkan SPD</label>
                          <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                            <input type="text" name="tgl_ditetapkan" class="form-control form-control-sm" data-target="#tgl_ymd_one" data-toggle="datetimepicker" value="<?php echo $dt['tgl_ditetapkan'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
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