<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
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
              <div class="col-sm-6">
                <h1 class="m-0">Profil</h1>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="card card-success card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <?php include("fotoUser.php");?>
                    </div>
                    <h3 class="profile-username text-center"><?php echo $dataku['nama'];?></h3>
                    <p class="text-muted text-center"><?php echo $dataku['nim'];?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-9">
                <form action="updateProfilFotoUser.php" method="post" enctype="multipart/form-data">
                  <div class="card card-success card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link" href="profilAkademikUser.php" role="tab" aria-selected="true">Data akademik</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="profilPribadiUser.php" role="tab" aria-selected="true">Data pribadi</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="profilOrtuUser.php" role="tab" aria-selected="true">Data orangtua</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="profilFotoUser.php" role="tab" aria-selected="true">File foto</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-group">
                        <label for="photo">File foto <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <input type="file" name="photo" class="form-control form-control-sm" required>
                        </div>
                        <span class="help-block small">Ukuran file maksimal 20 kb</span>
                      </div>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" readonly required>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-outline-warning">Update file foto</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>