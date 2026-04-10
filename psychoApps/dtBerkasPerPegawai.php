<?php include("contentsConAdm.php");
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );

  $q = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $r = mysqli_query($con, $q);
  $dt = mysqli_fetch_assoc($r);

  $qry_jum = "SELECT COUNT(id) AS jumData FROM berkas_pegawai WHERE id_pegawai='$id'";
  $r_jum = mysqli_query($con, $qry_jum);
  $d_jum = mysqli_fetch_assoc($r_jum);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmKepeg.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Input data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalImage') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Edit data gagal! Pastikan file yang diupload berekstensi .pdf!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Edit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Direktori</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small"><a class="text-info" href="dtBerkasPegawai.php?page=<?php echo $page;?>">Berkas Pegawai</a></li>
                  <li class="breadcrumb-item active small"><?php echo $dt['nama_tg'];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $reload = "dtBerkasPegawai.php?pagination=true";
          $sql = "SELECT * FROM kategori_berkas_pegawai ORDER BY nm ASC";
          $result = mysqli_query($con, $sql);
          
          $rpp = 100;
          $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
          $tcount = mysqli_num_rows($result);
          $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
          $count = 0;
          $i = ($page-1)*$rpp;
          $no_urut = ($page-1)*$rpp;
          ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Berkas Pegawai</h4>
                      <span class="float-right"><strong><?php echo $dt['nama_tg'];?></strong></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="76%">Nama Berkas</th>
                          <th class="pr-1 text-center" colspan="2">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);

                            $qidberkas =  "SELECT * FROM berkas_pegawai WHERE id_pegawai='$id' AND kat_berkas='".$data['id']."'";
                            $ridberkas = mysqli_query($con, $qidberkas);
                            $didberkas = mysqli_fetch_array($ridberkas);

                            $qjumberkas =  "SELECT COUNT(id) AS jumData FROM berkas_pegawai WHERE id_pegawai='$id' AND kat_berkas='".$data['id']."'";
                            $rjumberkas = mysqli_query($con, $qjumberkas);
                            $djumberkas = mysqli_fetch_array($rjumberkas);
                            ?>
                          <tr>
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class=""><?php echo $data['nm'];?></td>
                            <td width="10%" class="text-center"><?php if($djumberkas['jumData']>0) {echo '<a class="btn btn-outline-success btn-xs btn-block" href="editDtBerkasPegawai.php?id='.$didberkas['id'].'&nip='.$id.'&id_berkas='.$data['id'].'&page='.$page.'" title="Edit data"><i class="fas fa-file-upload"></i> Ganti Berkas</a>';} else {echo '<a class="btn btn-outline-primary btn-xs btn-block" href="inputDtBerkasPegawai.php?id='.$id.'&id_berkas='.$data['id'].'&page='.$page.'" title="Input data"><i class="fas fa-file-upload"></i> Unggah Berkas</a>';}?></td>
                            <td width="10%" class="text-center pr-1"><?php if($djumberkas['jumData']>0) {echo '<a class="btn btn-outline-danger btn-xs btn-block" target="_blank" href="'.$didberkas['berkas'].'" title="Unduh data"><i class="fas fa-file-download"></i> Unduh Berkas</a>';} else {echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Belum ada data" disabled><i class="fas fa-file-download"></i> Unduh Berkas</a>';}?></td>
                          </tr>
                          <?php
                            $i++; 
                            $count++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages);?></div>
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