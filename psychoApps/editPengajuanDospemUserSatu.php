<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  $nim = $dataku['nim'];
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updatePengajuanDospemUserSatu.php" method="post" enctype="multipart/form-data">
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
                  <h1 class="m-0 float-left">Pengajuan Dospem Skripsi</h1>
                </div>
                <div class="col-sm-8">
                  <ol class="mt-2 breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Pengajuan Dospem Skripsi</li>
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
                          <a class="nav-link" href="prePengajuanDospemUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatPengajuanDospemUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editPengajuanDospemUserSatu.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Informasi Pengajuan</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-2">
                          <label for="">IPK <span class="text-danger">*</span></label>
                          <div class="input-group input-group-sm">
                            <input type="number" name="digit_ipk1" class="form-control" min="1" max="3" value="<?php echo $dataku['digit_ipk1'];?>" required>
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">,</span>
                            </div>
                            <input type="number" name="digit_ipk2" class="form-control" min="0" max="99" value="<?php echo $dataku['digit_ipk2'];?>" required>
                          </div>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="sks_ditempuh">SKS yang telah ditempuh <span class="text-danger">*</span></label>
                          <input type="number" class="form-control form-control-sm" name="sks_ditempuh" min="120" value="<?php echo $dataku['sks_ditempuh'];?>" required>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="jenis_skripsi">Jenis skripsi <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='jenis_skripsi' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_jenis_skripsi ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dataku['jenis_skripsi'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="bidang_skripsi">Peminatan bidang psikologi dalam skripsi <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='bidang_skripsi' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_bidang_skripsi ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dataku['bidang_skripsi'] == $w[ 'id' ] ) {
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
                        <label for="judul_skripsi">Judul skripsi yang diajukan <span class="text-danger">*</span></label>
                        <textarea id="textarea-custom-one" name="judul_skripsi" class="form-control form-control-sm" style="height: 300px;" required><?php echo $dataku['judul_skripsi'];?></textarea>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <label for="metode_riset">Metode riset <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='metode_riset' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_jenis_penelitian ORDER BY id ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dataku['metode_riset'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[opsi]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[opsi]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="var_1">Variabel 1 <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="var_1" value="<?php echo $dataku['var_1'];?>" required>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="var_2">Variabel 2</label>
                          <input type="text" class="form-control form-control-sm" name="var_2" value="<?php echo $dataku['var_2'];?>">
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="var_3">Variabel 3</label>
                          <input type="text" class="form-control form-control-sm" name="var_3" value="<?php echo $dataku['var_3'];?>">
                        </div>
                      </div>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
                      <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Update informasi pengajuan</button>
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