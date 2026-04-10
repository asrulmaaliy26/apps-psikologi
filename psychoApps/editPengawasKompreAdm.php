<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );

  $qdt_pengawas = "SELECT * FROM dt_pengawas_kompre WHERE id='$id'";
  $hdt_pengawas = mysqli_query($con, $qdt_pengawas);
  $dpengawas = mysqli_fetch_assoc($hdt_pengawas);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    <?php
      include( "navtopAdm.php" );
      include( "navSideBarAdmBakS1.php" );
      ?> 
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Rekap Pengawas Kompre</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="rekapPengawasKompreAdm.php?page=<?php echo $page;?>">Rekap Pengawas Kompre</a></li>
                  <li class="breadcrumb-item active small">Edit Pengawas</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updatePengawasKompreAdm.php" method="post">
                   <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                   <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Pengawas</h4>
                        <span class="badge badge-info float-right"> <?php echo $dpengawas['nm'];?></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="nm">Nama</label>
                        <input type="text" name="nm" class="form-control form-control-sm" id="nm" value="<?php echo $dpengawas['nm'];?>"required>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="rekapPengawasKompreAdm.php?page=<?php echo $page;?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
                      <button type="submit" class="btn btn-outline-primary btn-flat btn-sm float-right" data-dismiss="modal">Update</button>
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
    <script type="text/javascript">
      $(function () {
        $('#tgl_kompre').datetimepicker({
        format: 'YYYY-MM-DD',
        icons: {
        time: "fas fa-clock",
        date: "fas fa-calendar-alt",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down",
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
        }
        });
        });
      
      $(function () {
        $('#jam_mulai').datetimepicker({
        format: 'HH:mm',
        icons: {
        time: "fas fa-clock",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
        }
        });
        });

      $(function () {
        $('#jam_selesai').datetimepicker({
        format: 'HH:mm',
        icons: {
        time: "fas fa-clock",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
        }
        });
        });
    </script>
  </body>
</html>