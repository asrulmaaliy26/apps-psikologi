<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id=mysqli_real_escape_string($con, $_GET['id']);
  $username = $_SESSION['username'];
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $queryAdm = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $rAdm = mysqli_query($con, $queryAdm) or die( mysqli_error($con));
  $dAdm = mysqli_fetch_assoc($rAdm);
  $idAdm = $dAdm['username'];
  $tahun = date("Y");
  
  $qNoAsk ="SELECT * FROM surat_keluar WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC LIMIT 1";
  $rNoAsk = mysqli_query($con, $qNoAsk) or die('Error');
  $dNoAsk = mysqli_fetch_assoc($rNoAsk);
                        
  $qNoAsm ="SELECT * FROM surat_masuk WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC LIMIT 1";
  $rNoAsm = mysqli_query($con, $qNoAsm) or die('Error');
  $dNoAsm = mysqli_fetch_assoc($rNoAsm);
  
  $myquery="SELECT * FROM st WHERE id='$id'";
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
                <h4 class="mb-0">Buat Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small"><a href="rekapSuratTugasAdm.php?page=<?php echo $page;?>">Surat Tugas</a></li>
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
                    <form action="updateStKepanitiaanAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="id" value="<?php echo $id;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <input type="text" class="sr-only" name="editor" value="<?php echo $idAdm;?>" readonly required>
                      <div class="form-group">
                        <label>Nomor Agenda Berkas Surat</label>
                        <input type="text" name="no_agenda_surat" class="form-control form-control-sm" value="<?php echo $dt['no_agenda_surat'];?>">
                        <small class="form-text text-muted">Nomor agenda berkas surat terakhir: Surat Masuk: <strong class="text-success"><?php echo $dNoAsm['no_berkas'];?></strong>. Surat Keluar: <strong class="text-success"><?php echo $dNoAsk['no_berkas'];?></strong>.</small>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Perihal Tugas yang Diberikan</label>
                          <textarea id="textarea-custom-one" name="perihal" class="form-control form-control-sm" style="height: 300px;" required><?php echo $dt['perihal'];?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Dasar Penerbitan Surat Tugas</label>
                          <textarea id="textarea-custom-two" name="dasar" class="form-control form-control-sm" style="height: 300px;"><?php echo $dt['dasar'];?></textarea>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Tanggal Awal Berlaku ST</label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="awal_berlaku" class="form-control form-control-sm" data-target="#tgl_dmy_one" data-toggle="datetimepicker" value="<?php echo $dt['awal_berlaku'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tanggal Akhir Berlaku ST</label>
                          <div class="input-group date" id="tgl_dmy_two" data-target-input="nearest">
                            <input type="text" name="akhir_berlaku" class="form-control form-control-sm" data-target="#tgl_dmy_two" data-toggle="datetimepicker" value="<?php echo $dt['akhir_berlaku'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tanggal Ditetapkan ST</label>
                          <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                            <input type="text" name="tgl_ditetapkan" class="form-control form-control-sm" data-target="#tgl_ymd_one" data-toggle="datetimepicker" value="<?php echo $dt['tgl_ditetapkan'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <span class="text-info"><strong>Nama-nama yang Ditugaskan dalam ST (Pihak Internal)</strong></span>
                      <div class="form-row mt-2">
                        <div class="form-group col-md-6">
                          <label>Nama 1</label>
                          <?php
                            $qa1 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '1'";
                            $ra1 = mysqli_query($con, $qa1);
                            $da1 = mysqli_fetch_array($ra1);
                            
                            echo "<select name='nama1' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da1['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan1' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da1['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 2</label>
                          <?php
                            $qa2 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '2'";
                            $ra2 = mysqli_query($con, $qa2);
                            $da2 = mysqli_fetch_array($ra2);
                            
                            echo "<select name='nama2' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da2['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan2' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da2['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 3</label>
                          <?php
                            $qa3 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '3'";
                            $ra3 = mysqli_query($con, $qa3);
                            $da3 = mysqli_fetch_array($ra3);
                            
                            echo "<select name='nama3' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da3['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan3' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da3['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 4</label>
                          <?php
                            $qa4 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '4'";
                            $ra4 = mysqli_query($con, $qa4);
                            $da4 = mysqli_fetch_array($ra4);
                            
                            echo "<select name='nama4' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da4['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan4' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da4['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 5</label>
                          <?php
                            $qa5 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '5'";
                            $ra5 = mysqli_query($con, $qa5);
                            $da5 = mysqli_fetch_array($ra5);
                            
                            echo "<select name='nama5' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da5['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan5' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da5['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 6</label>
                          <?php
                            $qa6 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '6'";
                            $ra6 = mysqli_query($con, $qa6);
                            $da6 = mysqli_fetch_array($ra6);
                            
                            echo "<select name='nama6' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da6['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan6' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da6['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 7</label>
                          <?php
                            $qa7 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '7'";
                            $ra7 = mysqli_query($con, $qa7);
                            $da7 = mysqli_fetch_array($ra7);
                            
                            echo "<select name='nama7' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da7['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan7' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da7['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 8</label>
                          <?php
                            $qa8 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '8'";
                            $ra8 = mysqli_query($con, $qa8);
                            $da8 = mysqli_fetch_array($ra8);
                            
                            echo "<select name='nama8' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da8['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan8' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da8['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 9</label>
                          <?php
                            $qa9 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '9'";
                            $ra9 = mysqli_query($con, $qa9);
                            $da9 = mysqli_fetch_array($ra9);
                            
                            echo "<select name='nama9' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da9['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan9' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da9['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 10</label>
                          <?php
                            $qa10 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '10'";
                            $ra10 = mysqli_query($con, $qa10);
                            $da10 = mysqli_fetch_array($ra10);
                            
                            echo "<select name='nama10' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da10['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan10' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da10['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 11</label>
                          <?php
                            $qa11 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '11'";
                            $ra11 = mysqli_query($con, $qa11);
                            $da11 = mysqli_fetch_array($ra11);
                            
                            echo "<select name='nama11' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da11['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan11' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da11['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 12</label>
                          <?php
                            $qa12 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '12'";
                            $ra12 = mysqli_query($con, $qa12);
                            $da12 = mysqli_fetch_array($ra12);
                            
                            echo "<select name='nama12' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da12['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan12' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da12['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 13</label>
                          <?php
                            $qa13 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '13'";
                            $ra13 = mysqli_query($con, $qa13);
                            $da13 = mysqli_fetch_array($ra13);
                            
                            echo "<select name='nama13' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da13['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan13' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da13['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 12</label>
                          <?php echo "<select name='nama12' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan12' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Nama 13</label>
                          <?php echo "<select name='nama13' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan13' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Nama 14</label>
                          <?php
                            $qa14 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '14'";
                            $ra14 = mysqli_query($con, $qa14);
                            $da14 = mysqli_fetch_array($ra14);
                            
                            echo "<select name='nama14' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da14['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan14' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da14['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 15</label>
                          <?php
                            $qa15 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '15'";
                            $ra15 = mysqli_query($con, $qa15);
                            $da15 = mysqli_fetch_array($ra15);
                            
                            echo "<select name='nama15' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da15['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan15' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da15['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 16</label>
                          <?php
                            $qa16 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '16'";
                            $ra16 = mysqli_query($con, $qa16);
                            $da16 = mysqli_fetch_array($ra16);
                            
                            echo "<select name='nama16' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da16['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan16' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da16['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 17</label>
                          <?php
                            $qa17 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '17'";
                            $ra17 = mysqli_query($con, $qa17);
                            $da17 = mysqli_fetch_array($ra17);
                            
                            echo "<select name='nama17' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da17['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan17' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da17['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 18</label>
                          <?php
                            $qa18 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '18'";
                            $ra18 = mysqli_query($con, $qa18);
                            $da18 = mysqli_fetch_array($ra18);
                            
                            echo "<select name='nama18' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da18['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan18' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da18['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 19</label>
                          <?php
                            $qa19 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '19'";
                            $ra19 = mysqli_query($con, $qa19);
                            $da19 = mysqli_fetch_array($ra19);
                            
                            echo "<select name='nama19' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da19['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan19' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da19['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 20</label>
                          <?php
                            $qa20 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '20'";
                            $ra20 = mysqli_query($con, $qa20);
                            $da20 = mysqli_fetch_array($ra20);
                            
                            echo "<select name='nama20' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da20['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan20' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da20['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 21</label>
                          <?php
                            $qa21 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '21'";
                            $ra21 = mysqli_query($con, $qa21);
                            $da21 = mysqli_fetch_array($ra21);
                            
                            echo "<select name='nama21' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da21['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan21' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da21['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 22</label>
                          <?php
                            $qa22 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '22'";
                            $ra22 = mysqli_query($con, $qa22);
                            $da22 = mysqli_fetch_array($ra22);
                            
                            echo "<select name='nama22' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da22['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan22' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da22['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 23</label>
                          <?php
                            $qa23 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '23'";
                            $ra23 = mysqli_query($con, $qa23);
                            $da23 = mysqli_fetch_array($ra23);
                            
                            echo "<select name='nama23' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da23['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan23' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da23['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 24</label>
                          <?php
                            $qa24 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '24'";
                            $ra24 = mysqli_query($con, $qa24);
                            $da24 = mysqli_fetch_array($ra24);
                            
                            echo "<select name='nama24' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da24['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan24' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da24['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 25</label>
                          <?php
                            $qa25 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '25'";
                            $ra25 = mysqli_query($con, $qa25);
                            $da25 = mysqli_fetch_array($ra25);
                            
                            echo "<select name='nama25' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da25['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan25' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da25['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 26</label>
                          <?php
                            $qa26 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '26'";
                            $ra26 = mysqli_query($con, $qa26);
                            $da26 = mysqli_fetch_array($ra26);
                            
                            echo "<select name='nama26' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da26['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan26' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da26['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 27</label>
                          <?php
                            $qa27 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '27'";
                            $ra27 = mysqli_query($con, $qa27);
                            $da27 = mysqli_fetch_array($ra27);
                            
                            echo "<select name='nama27' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da27['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan27' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da27['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 28</label>
                          <?php
                            $qa28 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '28'";
                            $ra28 = mysqli_query($con, $qa28);
                            $da28 = mysqli_fetch_array($ra28);
                            
                            echo "<select name='nama28' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da28['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan28' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da28['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 29</label>
                          <?php
                            $qa29 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '29'";
                            $ra29 = mysqli_query($con, $qa29);
                            $da29 = mysqli_fetch_array($ra29);
                            
                            echo "<select name='nama29' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da29['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan29' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da29['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 30</label>
                          <?php
                            $qa30 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '30'";
                            $ra30 = mysqli_query($con, $qa30);
                            $da30 = mysqli_fetch_array($ra30);
                            
                            echo "<select name='nama30' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da30['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan30' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da30['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 31</label>
                          <?php
                            $qa31 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '31'";
                            $ra31 = mysqli_query($con, $qa31);
                            $da31 = mysqli_fetch_array($ra31);
                            
                            echo "<select name='nama31' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da31['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan31' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da31['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 32</label>
                          <?php
                            $qa32 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '32'";
                            $ra32 = mysqli_query($con, $qa32);
                            $da32 = mysqli_fetch_array($ra32);
                            
                            echo "<select name='nama32' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da32['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan32' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da32['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 33</label>
                          <?php
                            $qa33 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '33'";
                            $ra33 = mysqli_query($con, $qa33);
                            $da33 = mysqli_fetch_array($ra33);
                            
                            echo "<select name='nama33' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da33['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan33' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da33['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 34</label>
                          <?php
                            $qa34 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '34'";
                            $ra34 = mysqli_query($con, $qa34);
                            $da34 = mysqli_fetch_array($ra34);
                            
                            echo "<select name='nama34' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da34['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan34' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da34['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 35</label>
                          <?php
                            $qa35 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '35'";
                            $ra35 = mysqli_query($con, $qa35);
                            $da35 = mysqli_fetch_array($ra35);
                            
                            echo "<select name='nama35' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da35['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan35' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da35['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 36</label>
                          <?php
                            $qa36 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '36'";
                            $ra36 = mysqli_query($con, $qa36);
                            $da36 = mysqli_fetch_array($ra36);
                            
                            echo "<select name='nama36' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da36['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan36' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da36['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 37</label>
                          <?php
                            $qa37 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '37'";
                            $ra37 = mysqli_query($con, $qa37);
                            $da37 = mysqli_fetch_array($ra37);
                            
                            echo "<select name='nama37' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da37['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan37' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da37['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 38</label>
                          <?php
                            $qa38 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '38'";
                            $ra38 = mysqli_query($con, $qa38);
                            $da38 = mysqli_fetch_array($ra38);
                            
                            echo "<select name='nama38' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da38['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan38' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da38['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 39</label>
                          <?php
                            $qa39 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '39'";
                            $ra39 = mysqli_query($con, $qa39);
                            $da39 = mysqli_fetch_array($ra39);
                            
                            echo "<select name='nama39' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da39['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan39' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da39['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 40</label>
                          <?php
                            $qa40 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '40'";
                            $ra40 = mysqli_query($con, $qa40);
                            $da40 = mysqli_fetch_array($ra40);
                            
                            echo "<select name='nama40' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da40['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan40' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da40['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 41</label>
                          <?php
                            $qa41 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '41'";
                            $ra41 = mysqli_query($con, $qa41);
                            $da41 = mysqli_fetch_array($ra41);
                            
                            echo "<select name='nama41' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da41['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan41' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da41['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 42</label>
                          <?php
                            $qa42 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '42'";
                            $ra42 = mysqli_query($con, $qa42);
                            $da42 = mysqli_fetch_array($ra42);
                            
                            echo "<select name='nama42' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da42['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan42' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da42['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 43</label>
                          <?php
                            $qa43 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '43'";
                            $ra43 = mysqli_query($con, $qa43);
                            $da43 = mysqli_fetch_array($ra43);
                            
                            echo "<select name='nama43' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da43['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan43' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da43['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 44</label>
                          <?php
                            $qa44 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '44'";
                            $ra44 = mysqli_query($con, $qa44);
                            $da44 = mysqli_fetch_array($ra44);
                            
                            echo "<select name='nama44' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da44['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan44' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da44['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 45</label>
                          <?php
                            $qa45 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '45'";
                            $ra45 = mysqli_query($con, $qa45);
                            $da45 = mysqli_fetch_array($ra45);
                            
                            echo "<select name='nama45' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da45['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan45' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da45['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 46</label>
                          <?php
                            $qa46 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '46'";
                            $ra46 = mysqli_query($con, $qa46);
                            $da46 = mysqli_fetch_array($ra46);
                            
                            echo "<select name='nama46' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da46['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan46' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da46['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 47</label>
                          <?php
                            $qa47 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '47'";
                            $ra47 = mysqli_query($con, $qa47);
                            $da47 = mysqli_fetch_array($ra47);
                            
                            echo "<select name='nama47' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da47['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan47' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da47['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 48</label>
                          <?php
                            $qa48 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '48'";
                            $ra48 = mysqli_query($con, $qa48);
                            $da48 = mysqli_fetch_array($ra48);
                            
                            echo "<select name='nama48' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da48['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan48' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da48['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 49</label>
                          <?php
                            $qa49 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '49'";
                            $ra49 = mysqli_query($con, $qa49);
                            $da49 = mysqli_fetch_array($ra49);
                            
                            echo "<select name='nama49' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da49['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan49' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da49['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 50</label>
                          <?php
                            $qa50 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '50'";
                            $ra50 = mysqli_query($con, $qa50);
                            $da50 = mysqli_fetch_array($ra50);
                            
                            echo "<select name='nama50' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da50['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan50' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da50['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 51</label>
                          <?php
                            $qa51 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '51'";
                            $ra51 = mysqli_query($con, $qa51);
                            $da51 = mysqli_fetch_array($ra51);
                            
                            echo "<select name='nama51' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da51['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan51' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da51['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 52</label>
                          <?php
                            $qa52 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '52'";
                            $ra52 = mysqli_query($con, $qa52);
                            $da52 = mysqli_fetch_array($ra52);
                            
                            echo "<select name='nama52' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da52['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan52' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da52['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 53</label>
                          <?php
                            $qa53 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '53'";
                            $ra53 = mysqli_query($con, $qa53);
                            $da53 = mysqli_fetch_array($ra53);
                            
                            echo "<select name='nama53' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da53['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan53' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da53['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 54</label>
                          <?php
                            $qa54 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '54'";
                            $ra54 = mysqli_query($con, $qa54);
                            $da54 = mysqli_fetch_array($ra54);
                            
                            echo "<select name='nama54' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da54['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan54' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da54['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 55</label>
                          <?php
                            $qa55 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '55'";
                            $ra55 = mysqli_query($con, $qa55);
                            $da55 = mysqli_fetch_array($ra55);
                            
                            echo "<select name='nama55' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE status='1' ORDER BY nama ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da55['nama'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan55' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da55['jabatan_st'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nama]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <span class="text-info"><strong>Nama-nama yang Ditugaskan dalam ST (Pihak Eksternal)</strong></span>
                      <div class="form-row mt-2">
                        <div class="form-group col-md-6">
                          <label>Nama 56</label>
                          <?php
                            $qa56 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '56'";
                            $ra56 = mysqli_query($con, $qa56);
                            $da56 = mysqli_fetch_array($ra56);
                            ?>
                          <input type="text" name="nama56" class="form-control form-control-sm" value="<?php echo $da56['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan56' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da56['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 57</label>
                          <?php
                            $qa57 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '57'";
                            $ra57 = mysqli_query($con, $qa57);
                            $da57 = mysqli_fetch_array($ra57);
                            ?>
                          <input type="text" name="nama57" class="form-control form-control-sm" value="<?php echo $da57['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan57' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da57['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 58</label>
                          <?php
                            $qa58 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '58'";
                            $ra58 = mysqli_query($con, $qa58);
                            $da58 = mysqli_fetch_array($ra58);
                            ?>
                          <input type="text" name="nama58" class="form-control form-control-sm" value="<?php echo $da58['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan58' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da58['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 59</label>
                          <?php
                            $qa59 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '59'";
                            $ra59 = mysqli_query($con, $qa59);
                            $da59 = mysqli_fetch_array($ra59);
                            ?>
                          <input type="text" name="nama59" class="form-control form-control-sm" value="<?php echo $da59['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan59' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da59['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 60</label>
                          <?php
                            $qa60 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '60'";
                            $ra60 = mysqli_query($con, $qa60);
                            $da60 = mysqli_fetch_array($ra60);
                            ?>
                          <input type="text" name="nama60" class="form-control form-control-sm" value="<?php echo $da60['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan60' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da60['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 61</label>
                          <?php
                            $qa61 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '61'";
                            $ra61 = mysqli_query($con, $qa61);
                            $da61 = mysqli_fetch_array($ra61);
                            ?>
                          <input type="text" name="nama61" class="form-control form-control-sm" value="<?php echo $da61['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan61' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da61['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 62</label>
                          <?php
                            $qa62 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '62'";
                            $ra62 = mysqli_query($con, $qa62);
                            $da62 = mysqli_fetch_array($ra62);
                            ?>
                          <input type="text" name="nama62" class="form-control form-control-sm" value="<?php echo $da62['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan62' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da62['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 63</label>
                          <?php
                            $qa63 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '63'";
                            $ra63 = mysqli_query($con, $qa63);
                            $da63 = mysqli_fetch_array($ra63);
                            ?>
                          <input type="text" name="nama63" class="form-control form-control-sm" value="<?php echo $da63['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan63' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da63['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 64</label>
                          <?php
                            $qa64 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '64'";
                            $ra64 = mysqli_query($con, $qa64);
                            $da64 = mysqli_fetch_array($ra64);
                            ?>
                          <input type="text" name="nama64" class="form-control form-control-sm" value="<?php echo $da64['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan64' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da64['jabatan_st'] == $w[ 'id' ] ) {
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
                        <div class="form-group col-md-6">
                          <label>Nama 65</label>
                          <?php
                            $qa65 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '65'";
                            $ra65 = mysqli_query($con, $qa65);
                            $da65 = mysqli_fetch_array($ra65);
                            ?>
                          <input type="text" name="nama65" class="form-control form-control-sm" value="<?php echo $da65['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan65' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            if ( $da65['jabatan_st'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nama]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
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