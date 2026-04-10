<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $id_periode = mysqli_real_escape_string($con,  $_GET[ 'id_periode' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qdt_dospem = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $hdt_dospem = mysqli_query($con, $qdt_dospem);
  $ddospem = mysqli_fetch_assoc($hdt_dospem);

  $myquery = "SELECT * FROM dospem_skripsi WHERE nip='$ddospem[id]' AND id_periode='$id_periode'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );

  $moment = "SELECT * FROM pengajuan_dospem WHERE id='$dataku[id_periode]'";
  $rmoment = mysqli_query($con,  $moment )or die( mysqli_error($con) );
  $dmoment = mysqli_fetch_assoc( $rmoment );

  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$dmoment[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$dmoment[ta]'";
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
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Edit Gagal! Kuota tidak boleh lebih kecil dari pengajuan yang telah masuk!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pengajuan Dospem Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pngjnDospemAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
                  <li class="breadcrumb-item small"><a class="text-info" href="dospemPerPeriodeAdm.php?id=<?php echo $dataku['id_periode'];?>&page=<?php echo $page;?>">Data Dospem Skripsi</a></li>
                  <li class="breadcrumb-item active small">Edit Kuota</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updateKuotaDospemAdm.php" method="post">
                  <input type="text" name="id" class="sr-only" value="<?php echo $dataku['id'];?>" required readonly>
                  <input type="text" name="id_periode" class="sr-only" value="<?php echo $dataku['id_periode'];?>" required readonly>
                  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Kuota</h4>
                        <span class="badge badge-info float-right"><?php echo $ddospem['nama'];?></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="kuota1">Kuota Dospem Skripsi I</label>
                          <input type="number" min="0" max="20" name="kuota1" class="form-control form-control-sm" value="<?php echo $dataku['kuota1'];?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="kuota2">Kuota Dospem Skripsi II</label>
                          <input type="number" min="0" max="20" name="kuota2" class="form-control form-control-sm" value="<?php echo $dataku['kuota2'];?>" required/>
                      </div>
                    <div class="card-footer">
                      <a href="dospemPerPeriodeAdm.php?id=<?php echo $dataku['id_periode'];?>&page=<?php echo "$page";?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
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
  </body>
</html>