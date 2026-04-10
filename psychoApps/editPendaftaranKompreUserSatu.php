<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM peserta_kompre WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $q = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $r = mysqli_query($con, $q)or die( mysqli_error($con));
  $dt = mysqli_fetch_assoc($r);
  $nim = $dt['nim'];
  $oldDate = $dt['tanggal_lahir'];
  $newDate = date("d-m-Y", strtotime($oldDate));
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updatePendaftaranKompreUserSatu.php" method="post" enctype="multipart/form-data">
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
                    <li class="breadcrumb-item active">Ujian Komprehensif</li>
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
                          <a class="nav-link" href="prePendaftaranKompreUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatPendaftaranUjianKompreUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="detailRiwayatPendaftaranKompreUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Pendaftaran</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editPendaftaranKompreUserSatu.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Informasi Pendaftaran</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-group">
                        <label for="sks_ditempuh">SKS yang telah ditempuh <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="sks_ditempuh" id="sks_ditempuh" value="<?php echo $dataku['sks_ditempuh'];?>"required>
                      </div>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
                      <input type="text" name="id_kompre" class="sr-only" value="<?php echo $dataku['id_kompre'];?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Update informasi pendaftaran</button>
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