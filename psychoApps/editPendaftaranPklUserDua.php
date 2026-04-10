<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM peserta_pkl WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  $nim = $dataku['nim'];
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?>
  <form action="updatePendaftaranPklUserDua.php" method="post" enctype="multipart/form-data">
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
                  <h1 class="m-0 float-left">Pendaftaran</h1>
                </div>
                <div class="col-sm-8">
                  <ol class="mt-2 breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Praktik Kerja Lapangan (PKL)</li>
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
                          <a class="nav-link" href="prePendaftaranPklUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatPendaftaranPklUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="detailRiwayatPendaftaranPklUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Pendaftaran</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editPendaftaranPklUserDua.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Lampiran Berkas</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-group">
                        <label for="file_transkrip">Upload file transkrip nilai (PDF)</label>
                        <input type="file" class="form-control form-control-sm" name="file_transkrip" value="<?php echo $dataku['file_transkrip'];?>">
                      </div>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
                      <input type="text" name="id_pkl" class="sr-only" value="<?php echo $dataku['id_pkl'];?>" required readonly>
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