<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
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
                  <li class="breadcrumb-item active small">Form Input</li>
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
                    <h4 class="card-title">Form Input</h4>
                  </div>
                  <div class="card-body">
                    <form action="sinputStKepanitiaanAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="executor" value="<?php echo $idAdm;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <div class="form-group">
                        <label>Nomor Agenda Berkas Surat</label>
                        <input type="text" name="no_agenda_surat" class="form-control form-control-sm">
                        <small class="form-text text-muted">Nomor agenda berkas surat terakhir: Surat Masuk: <strong class="text-success"><?php echo $dNoAsm['no_berkas'];?></strong>. Surat Keluar: <strong class="text-success"><?php echo $dNoAsk['no_berkas'];?></strong>.</small>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Perihal Tugas yang Diberikan</label>
                          <textarea id="textarea-custom-one" name="perihal" class="form-control form-control-sm" style="height: 300px;" required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Dasar Penerbitan Surat Tugas</label>
                          <textarea id="textarea-custom-two" name="dasar" class="form-control form-control-sm" style="height: 300px;"></textarea>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Tanggal Awal Berlaku ST</label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="awal_berlaku" class="form-control form-control-sm" data-target="#tgl_dmy_one" data-toggle="datetimepicker" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tanggal Akhir Berlaku ST</label>
                          <div class="input-group date" id="tgl_dmy_two" data-target-input="nearest">
                            <input type="text" name="akhir_berlaku" class="form-control form-control-sm" data-target="#tgl_dmy_two" data-toggle="datetimepicker" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tanggal Ditetapkan ST</label>
                          <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                            <input type="text" name="tgl_ditetapkan" class="form-control form-control-sm" data-target="#tgl_ymd_one" data-toggle="datetimepicker" required/>
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
                          <?php echo "<select name='nama1' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan1' class='form-control form-control-sm'>";
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
                          <label>Nama 2</label>
                          <?php echo "<select name='nama2' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan2' class='form-control form-control-sm'>";
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
                          <label>Nama 3</label>
                          <?php echo "<select name='nama3' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan3' class='form-control form-control-sm'>";
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
                          <label>Nama 4</label>
                          <?php echo "<select name='nama4' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan4' class='form-control form-control-sm'>";
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
                          <label>Nama 5</label>
                          <?php echo "<select name='nama5' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan5' class='form-control form-control-sm'>";
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
                          <label>Nama 6</label>
                          <?php echo "<select name='nama6' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan6' class='form-control form-control-sm'>";
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
                          <label>Nama 7</label>
                          <?php echo "<select name='nama7' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan7' class='form-control form-control-sm'>";
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
                          <label>Nama 8</label>
                          <?php echo "<select name='nama8' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan8' class='form-control form-control-sm'>";
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
                          <label>Nama 9</label>
                          <?php echo "<select name='nama9' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan9' class='form-control form-control-sm'>";
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
                          <label>Nama 10</label>
                          <?php echo "<select name='nama10' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan10' class='form-control form-control-sm'>";
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
                          <label>Nama 11</label>
                          <?php echo "<select name='nama11' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan11' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='nama14' class='form-control form-control-sm'>";
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
                          <label>Nama 15</label>
                          <?php echo "<select name='nama15' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan15' class='form-control form-control-sm'>";
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
                          <label>Nama 16</label>
                          <?php echo "<select name='nama16' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan16' class='form-control form-control-sm'>";
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
                          <label>Nama 17</label>
                          <?php echo "<select name='nama17' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan17' class='form-control form-control-sm'>";
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
                          <label>Nama 18</label>
                          <?php echo "<select name='nama18' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan18' class='form-control form-control-sm'>";
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
                          <label>Nama 19</label>
                          <?php echo "<select name='nama19' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan19' class='form-control form-control-sm'>";
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
                          <label>Nama 20</label>
                          <?php echo "<select name='nama20' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan20' class='form-control form-control-sm'>";
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
                          <label>Nama 21</label>
                          <?php echo "<select name='nama21' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan21' class='form-control form-control-sm'>";
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
                          <label>Nama 22</label>
                          <?php echo "<select name='nama22' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan22' class='form-control form-control-sm'>";
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
                          <label>Nama 23</label>
                          <?php echo "<select name='nama23' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan23' class='form-control form-control-sm'>";
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
                          <label>Nama 24</label>
                          <?php echo "<select name='nama24' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan24' class='form-control form-control-sm'>";
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
                          <label>Nama 25</label>
                          <?php echo "<select name='nama25' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan25' class='form-control form-control-sm'>";
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
                          <label>Nama 26</label>
                          <?php echo "<select name='nama26' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan26' class='form-control form-control-sm'>";
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
                          <label>Nama 27</label>
                          <?php echo "<select name='nama27' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan27' class='form-control form-control-sm'>";
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
                          <label>Nama 28</label>
                          <?php echo "<select name='nama28' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan28' class='form-control form-control-sm'>";
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
                          <label>Nama 29</label>
                          <?php echo "<select name='nama29' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan29' class='form-control form-control-sm'>";
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
                          <label>Nama 30</label>
                          <?php echo "<select name='nama30' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan30' class='form-control form-control-sm'>";
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
                          <label>Nama 31</label>
                          <?php echo "<select name='nama31' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan31' class='form-control form-control-sm'>";
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
                          <label>Nama 32</label>
                          <?php echo "<select name='nama32' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan32' class='form-control form-control-sm'>";
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
                          <label>Nama 33</label>
                          <?php echo "<select name='nama33' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan33' class='form-control form-control-sm'>";
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
                          <label>Nama 34</label>
                          <?php echo "<select name='nama34' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan34' class='form-control form-control-sm'>";
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
                          <label>Nama 35</label>
                          <?php echo "<select name='nama35' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan35' class='form-control form-control-sm'>";
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
                          <label>Nama 36</label>
                          <?php echo "<select name='nama36' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan36' class='form-control form-control-sm'>";
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
                          <label>Nama 37</label>
                          <?php echo "<select name='nama37' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan37' class='form-control form-control-sm'>";
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
                          <label>Nama 38</label>
                          <?php echo "<select name='nama38' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan38' class='form-control form-control-sm'>";
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
                          <label>Nama 39</label>
                          <?php echo "<select name='nama39' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan39' class='form-control form-control-sm'>";
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
                          <label>Nama 40</label>
                          <?php echo "<select name='nama40' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan40' class='form-control form-control-sm'>";
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
                          <label>Nama 41</label>
                          <?php echo "<select name='nama41' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan41' class='form-control form-control-sm'>";
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
                          <label>Nama 42</label>
                          <?php echo "<select name='nama42' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan42' class='form-control form-control-sm'>";
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
                          <label>Nama 43</label>
                          <?php echo "<select name='nama43' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan43' class='form-control form-control-sm'>";
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
                          <label>Nama 44</label>
                          <?php echo "<select name='nama44' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan44' class='form-control form-control-sm'>";
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
                          <label>Nama 45</label>
                          <?php echo "<select name='nama45' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan45' class='form-control form-control-sm'>";
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
                          <label>Nama 46</label>
                          <?php echo "<select name='nama46' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan46' class='form-control form-control-sm'>";
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
                          <label>Nama 47</label>
                          <?php echo "<select name='nama47' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan47' class='form-control form-control-sm'>";
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
                          <label>Nama 48</label>
                          <?php echo "<select name='nama48' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan48' class='form-control form-control-sm'>";
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
                          <label>Nama 49</label>
                          <?php echo "<select name='nama49' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan49' class='form-control form-control-sm'>";
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
                          <label>Nama 50</label>
                          <?php echo "<select name='nama50' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan50' class='form-control form-control-sm'>";
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
                          <label>Nama 51</label>
                          <?php echo "<select name='nama51' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan51' class='form-control form-control-sm'>";
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
                          <label>Nama 52</label>
                          <?php echo "<select name='nama52' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan52' class='form-control form-control-sm'>";
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
                          <label>Nama 53</label>
                          <?php echo "<select name='nama53' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan53' class='form-control form-control-sm'>";
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
                          <label>Nama 54</label>
                          <?php echo "<select name='nama54' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan54' class='form-control form-control-sm'>";
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
                          <label>Nama 55</label>
                          <?php echo "<select name='nama55' class='form-control form-control-sm'>";
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
                          <?php echo "<select name='jabatan55' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                      </div>
                      <span class="text-info"><strong>Nama-nama yang Ditugaskan dalam ST (Pihak Eksternal)</strong></span>
                      <div class="form-row mt-2">
                        <div class="form-group col-md-6">
                          <label>Nama 56</label>
                          <input type="text" name="nama56" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan56' class='form-control form-control-sm'>";
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
                          <label>Nama 57</label>
                          <input type="text" name="nama57" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan57' class='form-control form-control-sm'>";
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
                          <label>Nama 58</label>
                          <input type="text" name="nama58" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan58' class='form-control form-control-sm'>";
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
                          <label>Nama 59</label>
                          <input type="text" name="nama59" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan59' class='form-control form-control-sm'>";
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
                          <label>Nama 60</label>
                          <input type="text" name="nama60" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan60' class='form-control form-control-sm'>";
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
                          <label>Nama 61</label>
                          <input type="text" name="nama61" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan61' class='form-control form-control-sm'>";
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
                          <label>Nama 62</label>
                          <input type="text" name="nama62" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan62' class='form-control form-control-sm'>";
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
                          <label>Nama 63</label>
                          <input type="text" name="nama63" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan63' class='form-control form-control-sm'>";
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
                          <label>Nama 64</label>
                          <input type="text" name="nama64" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan64' class='form-control form-control-sm'>";
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
                          <label>Nama 65</label>
                          <input type="text" name="nama65" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Jabatan dalam ST</label>
                          <?php echo "<select name='jabatan65' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM opsi_jabatan_st_kepanitiaan ORDER BY id ASC");
                            while($w=mysqli_fetch_array($tampil)){
                            echo "<option value='$w[id]'>$w[nama]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-sm btn-success">Submit</button>
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