<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id=mysqli_real_escape_string($con, $_GET['id']);
  $page_a= mysqli_real_escape_string($con, $_GET['page_a']);
  $tahun= mysqli_real_escape_string($con, $_GET['tahun']);
  $page= mysqli_real_escape_string($con, $_GET['page']);
  
  $sql = "SELECT * FROM siprak_mahasiswa WHERE id='$id'";
  $result = mysqli_query($con, $sql);
  $data = mysqli_fetch_array($result);
  
  $qPem = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
  $rPem = mysqli_query($con, $qPem)or die( mysqli_error($con));
  $dPem = mysqli_fetch_assoc($rPem);
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
                <h4 class="m-0">Rekap Data</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dataSuratMahasiswaAdm.php">Permohonan Surat</a></li>
                  <li class="breadcrumb-item small"><a href="dataIpktmAdm.php?page=<?php echo $page_a;?>">Izin Praktikum Kelompok...</a></li>
                  <li class="breadcrumb-item small"><a href="dataIpktmPertahunAdm.php?page_a=<?php echo $page_a;?>&tahun=<?php echo $tahun;?>&page=<?php echo $page;?>">Tahun <?php echo $tahun;?></a></li>
                  <li class="breadcrumb-item active small">Form Catatan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updateCatatanDataIpktmPertahunAdm.php" method="post" enctype="multipart/form-data">
                  <input type="text" class="sr-only" name="id" value="<?php echo $id;?>" readonly required>
                  <input type="text" class="sr-only" name="page_a" value="<?php echo $page_a;?>" readonly required>
                  <input type="text" class="sr-only" name="tahun" value="<?php echo $tahun;?>" readonly required>
                  <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Form Catatan</h4>
                        <span class="small float-right"> <?php echo $dPem['nama'].' ['.$dPem['nim'].']';?></span>
                      </div>
                    </div>
                    <div class="card-body p-0">
                      <div class="form-group m-0">
                        <textarea id="textarea-custom-one" name="catatan" class="form-control form-control-sm"><?php echo $data['catatan'];?></textarea>
                      </div>
                    </div>
                    <div class="card-footer clearfix">
                      <button type="submit" class="btn btn-outline-info btn-flat btn-sm float-left">Kirim Catatan untuk Pemohon</button>
                    </div>
                  </div>
                </form>
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