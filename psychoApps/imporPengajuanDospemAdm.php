<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $myquery = "SELECT * FROM pengajuan_dospem WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$dataku[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$dataku[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
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
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Impor berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Impor gagal!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pengajuan Dospem Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pngjnDospemAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
                  <li class="breadcrumb-item active small">Impor Data Pengajuan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="sformImportDataPengajuanDospemAdm.php" method="post" enctype="multipart/form-data">
                  <input type="text" name="id" class="sr-only" value="<?php echo $dataku['id'];?>" required readonly>
                  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Impor Data Pengajuan</h4>
                        <a href="../images/template-impor-data-pengajuan.xls" type="button" class="btn btn-outline-success btn-flat btn-xs float-right" title="Download Template Impor File"><i class="fas fa-download"></i> Download Template Impor File</a>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="info-box mb-3 bg-info">
                        <b>Petunjuk:</b>
                        <ul class="list">
                          <li>Form ini untuk import data pengajuan dospem baru yang belum terdaftar di database.</li>
                          <li>File yang akan diimport hanya berekstensi .xls (Excel 97-2003).</li>
                          <li>Silahkan download template file untuk import data pengajuan dospem baru, dan silahkan baca di sheet "baca petunjuk" untuk pengisian kolom yang tersedia.</li>
                        </ul>
                      </div>
                      <div class="form-group">
                        <label for="data_pengajuan">Pilih File yang Akan Diimpor</label>
                        <input type="file" name="data_pengajuan" class="form-control form-control-sm" required>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="pngjnDospemAdm.php?page=<?php echo "$page";?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
                      <button type="submit" class="btn btn-outline-primary btn-flat btn-sm float-right" data-dismiss="modal">Impor</button>
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
        $('#start_datetime_edit').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
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
        $('#end_datetime_edit').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
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
    </script>
  </body>
</html>