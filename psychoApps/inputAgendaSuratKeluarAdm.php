<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $username = $_SESSION['username'];
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $queryAdm = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $rAdm = mysqli_query($con, $queryAdm) or die( mysqli_error($con));
  $dAdm = mysqli_fetch_assoc($rAdm);
  $idAdm = $dAdm['username'];
  $tahun = date("Y");
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
                <h4 class="mb-0">Agenda Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small"><a href="agendaSuratKeluarAdm.php?page=<?php echo $page;?>">Keluar</a></li>
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
                    <form action="sinputAgendaSuratKeluarAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="executor" value="<?php echo $idAdm;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <?php
                        $qNoAsk ="SELECT * FROM surat_keluar WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC LIMIT 1";
                        $rNoAsk = mysqli_query($con, $qNoAsk) or die('Error');
                        $dNoAsk = mysqli_fetch_assoc($rNoAsk);
                        
                        $qNoAsm ="SELECT * FROM surat_masuk WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC LIMIT 1";
                        $rNoAsm = mysqli_query($con, $qNoAsm) or die('Error');
                        $dNoAsm = mysqli_fetch_assoc($rNoAsm);
                        ?>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Nomor Agenda Berkas Surat</label>
                          <input type="text" name="no_berkas" class="form-control form-control-sm" required>
                          <small class="form-text text-muted">Nomor agenda berkas surat terakhir: Surat Masuk: <strong class="text-success"><?php echo $dNoAsm['no_berkas'];?></strong>. Surat Keluar: <strong class="text-success"><?php echo $dNoAsk['no_berkas'];?></strong>.</small>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Alamat Tujuan Surat</label>
                          <input type="text" name="tujuan" class="form-control form-control-sm" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label>Tanggal Berkas Surat</label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="tgl_surat" class="form-control form-control-sm" data-target="#tgl_dmy_one"  data-toggle="datetimepicker" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Jumlah Lembar Berkas Surat</label>
                          <input type="text" name="jml_berkas" inputmode="numeric" min="0" oninput="this.value = this.value.replace(/\D+/g, '')" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Ordner Berkas Surat</label>
                          <?php echo "<select name='ordner' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM ordner ORDER BY id DESC");
                            while($w=mysqli_fetch_array($tampil)){
                            echo "<option value='$w[id]'>$w[nm_ordner]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Perihal Berkas Surat</label>
                        <textarea id="textarea-custom-one" name="perihal" class="form-control form-control-sm" style="height: 300px;" required></textarea>
                      </div>
                      <div class="form-group">
                        <label>Upload Berkas Surat</label>
                        <input type="file" name="" class="form-control form-control-sm" disabled>
                        <small class="form-text text-muted">File harus pdf.</small>
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