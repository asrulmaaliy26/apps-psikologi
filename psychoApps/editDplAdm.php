<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $myquery = "SELECT * FROM dpl_pkl WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$dataku[nip]'";
  $res_dpl = mysqli_query($con, $qry_dpl);
  $dt_dpl = mysqli_fetch_assoc($res_dpl);
  
  $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$dataku[id_pkl]'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
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
              <h6 class="m-0">Pendaftaran PKL <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="pndftrnPklAdm.php?page=<?php echo $page;?>">Periode Pendaftaran</a></li>
                <li class="breadcrumb-item small"><a class="text-info" href="dplPerPeriodeAdm.php?id=<?php echo $dataku['id_pkl'];?>&page=<?php echo $page;?>">Data DPL PKL</a></li>
                <li class="breadcrumb-item active small">Edit DPL PKL</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <section class="col-md-12 connectedSortable">
              <form action="updateDplAdm.php" method="post">
                <input type="text" name="id" class="sr-only" value="<?php echo $dataku['id'];?>" required readonly>
                <input type="text" name="id_pkl" class="sr-only" value="<?php echo $dataku['id_pkl'];?>" required readonly>
                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Edit DPL PKL</h4>
                      <span class="badge badge-info float-right"><?php echo $dt_dpl['nama'];?></span>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nip">Nama DPL PKL</label>
                      <select name="nip" class="form-control form-control-sm" id="nip" required>
                      <?php
                        $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai='1' AND status='1' ORDER BY nama_tg ASC" );
                        while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['nip'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                          } else {
                            echo "<option value='$w[id]'>$w[nama_tg]</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="lokasi">Lokasi PKL</label>
                      <input type="text" name="lokasi" class="form-control form-control-sm" value="<?php echo $dataku['lokasi'];?>" required/>
                    </div>
                    <div class="form-group">
                      <label for="kuota">Kuota</label>
                      <input type="number" name="kuota" class="form-control form-control-sm" value="<?php echo $dataku['kuota'];?>" required/>
                    </div>
                    <div class="card-footer">
                      <a href="dplPerPeriodeAdm.php?id=<?php echo $dataku['id_pkl'];?>&page=<?php echo "$page";?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
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