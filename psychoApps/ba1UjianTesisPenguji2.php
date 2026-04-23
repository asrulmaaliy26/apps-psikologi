<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $myquery = "SELECT * from dt_pegawai WHERE id='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dtDosen = mysqli_fetch_assoc($d);
  
  $myquery = "SELECT * from mag_peserta_ujtes WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qformnilai = "SELECT * from mag_nilai_ujtes WHERE id_pendaftaran='$dt[id]'";
  $rfn = mysqli_query($con,  $qformnilai )or die( mysqli_error($con) );
  $dfn = mysqli_fetch_assoc( $rfn );
  
  $qry_grade = "SELECT * FROM mag_grade_ujtes WHERE id_ujtes='$dt[id_ujtes]'";
  $res_grade = mysqli_query($con, $qry_grade);
  $dt_grade = mysqli_fetch_array($res_grade);
  
  $sqlmhssw =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$dt[nim]'";
  $rmhssw = mysqli_query($con, $sqlmhssw);
  $dmhssw = mysqli_fetch_array($rmhssw);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarDosen.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Penilaian</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dashboardBeritaAcaraUjTes.php?page=<?php echo $page;?>">Ujian Tesis</a></li>
                  <li class="breadcrumb-item active small">Form Berita Acara</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Form Berita Acara</h4>
                    <span class="small float-right"> <?php echo $dmhssw['nama'].' ['.$dmhssw['nim'].']';?></span>
                  </div>
                                      <div class="card-body">
                      <?php include("petunjukPengisianBaUjtes.php");?>
                      <?php 
                        $penguji_idx = 2; // Penguji 2
                        include("tablePenilaianConsolidated.php"); 
                      ?>
                    </div>

          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>