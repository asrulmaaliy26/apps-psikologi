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
                <h4 class="mb-0">Surat Tugas</h4>
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
                    <form action="updateStPenunjukanAdm.php" method="post" enctype="multipart/form-data">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                      </div>
                      <span class="text-info"><strong>Nama-nama yang Ditugaskan dalam ST (Pihak Eksternal)</strong></span>
                      <div class="form-row mt-2">
                        <?php
                          $qa56 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '56'";
                          $ra56 = mysqli_query($con, $qa56);
                          $da56 = mysqli_fetch_array($ra56);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 13</label>
                          <input type="text" name="nama56" class="form-control form-control-sm"  value="<?php echo $da56['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan56" class="form-control form-control-sm" value="<?php echo $da56['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa57 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '57'";
                          $ra57 = mysqli_query($con, $qa57);
                          $da57 = mysqli_fetch_array($ra57);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 14</label>
                          <input type="text" name="nama57" class="form-control form-control-sm"  value="<?php echo $da57['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan57" class="form-control form-control-sm" value="<?php echo $da57['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa58 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '58'";
                          $ra58 = mysqli_query($con, $qa58);
                          $da58 = mysqli_fetch_array($ra58);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 15</label>
                          <input type="text" name="nama58" class="form-control form-control-sm" value="<?php echo $da58['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan58" class="form-control form-control-sm" value="<?php echo $da58['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa59 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '59'";
                          $ra59 = mysqli_query($con, $qa59);
                          $da59 = mysqli_fetch_array($ra59);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 16</label>
                          <input type="text" name="nama59" class="form-control form-control-sm" value="<?php echo $da59['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan59" class="form-control form-control-sm" value="<?php echo $da59['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa60 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '60'";
                          $ra60 = mysqli_query($con, $qa60);
                          $da60 = mysqli_fetch_array($ra60);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 17</label>
                          <input type="text" name="nama60" class="form-control form-control-sm" value="<?php echo $da60['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan60" class="form-control form-control-sm" value="<?php echo $da60['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa61 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '61'";
                          $ra61 = mysqli_query($con, $qa61);
                          $da61 = mysqli_fetch_array($ra61);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 18</label>
                          <input type="text" name="nama61" class="form-control form-control-sm" value="<?php echo $da61['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan61" class="form-control form-control-sm" value="<?php echo $da61['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa62 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '62'";
                          $ra62 = mysqli_query($con, $qa62);
                          $da62 = mysqli_fetch_array($ra62);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 19</label>
                          <input type="text" name="nama62" class="form-control form-control-sm" value="<?php echo $da62['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan62" class="form-control form-control-sm" value="<?php echo $da62['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa63 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '63'";
                          $ra63 = mysqli_query($con, $qa63);
                          $da63 = mysqli_fetch_array($ra63);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 20</label>
                          <input type="text" name="nama63" class="form-control form-control-sm" value="<?php echo $da63['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan63" class="form-control form-control-sm" value="<?php echo $da63['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa64 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '64'";
                          $ra64 = mysqli_query($con, $qa64);
                          $da64 = mysqli_fetch_array($ra64);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 21</label>
                          <input type="text" name="nama64" class="form-control form-control-sm" value="<?php echo $da64['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan64" class="form-control form-control-sm" value="<?php echo $da64['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa65 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '65'";
                          $ra65 = mysqli_query($con, $qa65);
                          $da65 = mysqli_fetch_array($ra65);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 22</label>
                          <input type="text" name="nama65" class="form-control form-control-sm" value="<?php echo $da65['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan65" class="form-control form-control-sm" value="<?php echo $da65['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa66 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '66'";
                          $ra66 = mysqli_query($con, $qa66);
                          $da66 = mysqli_fetch_array($ra66);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 23</label>
                          <input type="text" name="nama66" class="form-control form-control-sm" value="<?php echo $da66['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan66" class="form-control form-control-sm" value="<?php echo $da66['jabatan_st'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <?php
                          $qa67 = "SELECT * FROM personil_st WHERE id_st = '$dt[id]' AND urutan = '67'";
                          $ra67 = mysqli_query($con, $qa67);
                          $da67 = mysqli_fetch_array($ra67);
                          ?>
                        <div class="form-group col-md-6">
                          <label>Nama 24</label>
                          <input type="text" name="nama67" class="form-control form-control-sm" value="<?php echo $da67['nama'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan</label>
                          <input type="text" name="jabatan67" class="form-control form-control-sm" value="<?php echo $da67['jabatan_st'];?>">
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
