<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $queryAdm = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $rAdm = mysqli_query($con, $queryAdm) or die( mysqli_error($con));
  $dAdm = mysqli_fetch_assoc($rAdm);
  $idAdm = $dAdm['username'];
  
  $queryAgenda = "SELECT * FROM surat_masuk WHERE id='$id'";
  $rAgenda = mysqli_query($con, $queryAgenda) or die( mysqli_error($con));
  $dAgenda = mysqli_fetch_assoc($rAgenda);
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
                  <li class="breadcrumb-item active small"><a href="agendaSuratMasukAdm.php?page=<?php echo $page;?>">Masuk</a></li>
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
                    <form action="updateAgendaSuratMasukAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="id" value="<?php echo $id;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <input type="text" class="sr-only" name="editor" value="<?php echo $idAdm;?>" readonly required>
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
                          <input type="text" name="no_berkas" class="form-control form-control-sm" value="<?php echo $dAgenda['no_berkas'];?>" required>
                          <small class="form-text text-muted">Nomor agenda berkas surat terakhir: Surat Masuk: <strong class="text-success"><?php echo $dNoAsm['no_berkas'];?></strong>. Surat Keluar: <strong class="text-success"><?php echo $dNoAsk['no_berkas'];?></strong>.</small>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Tanggal Diterimanya Surat</label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="tgl_terima" class="form-control form-control-sm" data-target="#tgl_dmy_one"  data-toggle="datetimepicker" value="<?php echo $dAgenda['tgl_terima'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <label class="mb-0 text-danger">KETERANGAN DARI SURAT MASUK</label>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label>Pengirim Surat</label>
                          <input type="text" name="pengirim" class="form-control form-control-sm" value="<?php echo $dAgenda['pengirim'];?>" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Tanggal Berkas Surat</label>
                          <div class="input-group date" id="tgl_dmy_two" data-target-input="nearest">
                            <input type="text" name="tgl_surat" class="form-control form-control-sm" data-target="#tgl_dmy_two"  data-toggle="datetimepicker" value="<?php echo $dAgenda['tgl_surat'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Nomor Berkas Surat yang Dikirim</label>
                          <input type="text" name="no_surat" class="form-control form-control-sm" value="<?php echo $dAgenda['no_surat'];?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Perihal Berkas Surat</label>
                        <textarea id="textarea-custom-one" name="perihal" class="form-control form-control-sm" style="height: 300px;" required><?php echo $dAgenda['perihal'];?></textarea>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Jumlah Lembar Berkas Surat</label>
                          <input type="text" name="jml_berkas" inputmode="numeric" min="0" oninput="this.value = this.value.replace(/\D+/g, '')" class="form-control form-control-sm" value="<?php echo $dAgenda['jml_berkas'];?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Ordner Berkas Surat</label>
                          <?php
                            echo "<select name='ordner' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM ordner ORDER BY id DESC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $dAgenda['ordner'] == $w[ 'id' ] ) {
                                 echo "<option value='$w[id]' selected>$w[nm_ordner]</option>";
                              } else {
                                 echo "<option value='$w[id]'>$w[nm_ordner]</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label><?php if(empty($dAgenda['berkas'])) { echo 'Upload Berkas';} else { echo 'Ganti Berkas';}?></label>
                        <input type="file" name="" class="form-control form-control-sm" disabled>
                        <small class="form-text text-muted">File harus pdf. <?php if(empty($dAgenda['berkas'])) { echo "";} else { echo '<a href="'.$dAgenda['berkas'].'" target="_blank">Lihat Berkas Surat</a>';}?></small>
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