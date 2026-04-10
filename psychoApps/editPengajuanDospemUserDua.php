<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updatePengajuanDospemUserDua.php" method="post" enctype="multipart/form-data">
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
                          <a class="nav-link active" href="editPengajuanDospemUserDua.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Lampiran Berkas</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="file_prop">Upload file proposal skripsi (PDF)</label>
                          <input type="file" class="form-control form-control-sm" name="file_prop" value="<?php echo $dt['file_prop'];?>">
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="file_transkrip">Upload file transkrip nilai sementara (PDF)</label>
                          <input type="file" class="form-control form-control-sm" name="file_transkrip" value="<?php echo $dt['file_transkrip'];?>">
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="file_toefl_toafl">Upload file TOEFL/TOAFL (PDF)</label>
                          <input type="file" class="form-control form-control-sm" name="file_toefl_toafl" value="<?php echo $dt['file_toefl_toafl'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="file_tashih">Upload file tashih al-Quran (PDF)</label>
                          <input type="file" class="form-control form-control-sm" name="file_tashih" value="<?php echo $dt['file_tashih'];?>">
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="file_ukt">Upload file bukti pembayaran UKT semester ini (PDF)</label>
                          <input type="file" class="form-control form-control-sm" name="file_ukt" value="<?php echo $dt['file_ukt'];?>">
                        </div>
                      </div>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
                      <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
                      <input type="text" name="cekberkas" class="sr-only" value="<?php echo $dataku['cekberkas'];?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Update lampiran berkas</button>
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