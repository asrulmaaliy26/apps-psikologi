<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM skkb WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );

  $qry = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $resp );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updateSkkbUser.php" method="post" enctype="multipart/form-data">
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
                    <li class="breadcrumb-item active">Keterangan Kelakuan Baik</li>
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
                          <a class="nav-link" href="formSkkbUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatSkkbUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editSkkbUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="tempat_lahir">Tempat lahir <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='tempat_lahir' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dt['tempat_lahir'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="tanggal_lahir">Tanggal lahir <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                            <input type="text" name="tanggal_lahir" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_one" value="<?php echo $dt['tanggal_lahir'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="alamat_ktp">Alamat asal <span class="text-danger">*</span></label>
                          <input type="text" name="alamat_ktp" class="form-control form-control-sm" value="<?php echo $dt['alamat_ktp'];?>" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="alamat_malang">Alamat di Malang <span class="text-danger">*</span></label>
                          <input type="text" name="alamat_malang" class="form-control form-control-sm" value="<?php echo $dt['alamat_malang'];?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="keperluan">SKKB untuk keperluan <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" class="form-control form-control-sm" value="<?php echo $dataku['keperluan'];?>" required>
                      </div>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="anggota1" class="sr-only" value="<?php echo $nim;?>" required readonly>
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