<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry1 = "SELECT COUNT(id) AS jumData FROM siow_individu WHERE nim = '$dataku[nim]'";
  $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
  $data1 = mysqli_fetch_assoc( $has1 );
  
  $qry2 = "SELECT COUNT(id) AS jumData FROM siow_kelompok WHERE nim = '$dataku[nim]'";
  $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
  $data2 = mysqli_fetch_assoc( $has2 );
                            
  $qry3 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE nim = '$dataku[nim]' AND jenis_praktikum = '1'";
  $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
  $data3 = mysqli_fetch_assoc( $has3 );

  $qry4 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE nim = '$dataku[nim]' AND jenis_praktikum = '1'";
  $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
  $data4 = mysqli_fetch_assoc( $has4 );
                            
  $qry5 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE nim = '$dataku[nim]' AND jenis_praktikum = '2'";
  $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
  $data5 = mysqli_fetch_assoc( $has5 );

  $qry6 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE nim = '$dataku[nim]' AND jenis_praktikum = '2'";
  $has6 = mysqli_query($con,  $qry6 )or DIE( mysqli_error($con) );
  $data6 = mysqli_fetch_assoc( $has6 );

  $qry7 = "SELECT COUNT(id) AS jumData FROM magang WHERE nim = '$dataku[nim]' AND jenis_magang = '1'";
  $has7 = mysqli_query($con,  $qry7 )or DIE( mysqli_error($con) );
  $data7 = mysqli_fetch_assoc( $has7 );

  $qry8 = "SELECT COUNT(id) AS jumData FROM magang WHERE nim = '$dataku[nim]' AND jenis_magang = '2'";
  $has8 = mysqli_query($con,  $qry8 )or DIE( mysqli_error($con) );
  $data8 = mysqli_fetch_assoc( $has8 );

  $qry9 = "SELECT COUNT(id) AS jumData FROM sitp WHERE nim = '$dataku[nim]'";
  $has9 = mysqli_query($con,  $qry9 )or DIE( mysqli_error($con) );
  $data9 = mysqli_fetch_assoc( $has9 );

  $qry10 = "SELECT COUNT(id) AS jumData FROM prasips WHERE nim = '$dataku[nim]'";
  $has10 = mysqli_query($con,  $qry10 )or DIE( mysqli_error($con) );
  $data10 = mysqli_fetch_assoc( $has10 );
  
  $qry11 = "SELECT COUNT(id) AS jumData FROM sips WHERE nim = '$dataku[nim]'";
  $has11 = mysqli_query($con,  $qry11 )or DIE( mysqli_error($con) );
  $data11 = mysqli_fetch_assoc( $has11 );
                            
  $qry12 = "SELECT COUNT(id) AS jumData FROM skkb WHERE nim = '$dataku[nim]'";
  $has12 = mysqli_query($con,  $qry12 )or DIE( mysqli_error($con) );
  $data12 = mysqli_fetch_assoc( $has12 );
  ?>
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
                <h1 class="m-0">Permohonan Surat</h1>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6 col-12">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $data1['jumData'];?></h3>
                    <p>Izin Observasi dan Wawancara (Matkul) Individu</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSiowiUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-purple">
                  <div class="inner">
                    <h3><?php echo $data2['jumData'];?></h3>
                    <p>Izin Observasi dan Wawancara (Matkul) Kelompok</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSiowkUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $data3['jumData'];?></h3>
                    <p>Izin Praktikum Individu Testee Mahasiswa</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSiprakimUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-purple">
                  <div class="inner">
                    <h3><?php echo $data4['jumData'];?></h3>
                    <p>Izin Praktikum Individu Testee Siswa</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSiprakisUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $data5['jumData'];?></h3>
                    <p>Izin Praktikum Kelompok Testee Mahasiswa</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSiprakkmUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-purple">
                  <div class="inner">
                    <h3><?php echo $data6['jumData'];?></h3>
                    <p>Izin Praktikum Kelompok Testee Siswa</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSiprakksUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $data7['jumData'];?></h3>
                    <p>Izin Magang Mandiri Individu</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSimagiUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-purple">
                  <div class="inner">
                    <h3><?php echo $data8['jumData'];?></h3>
                    <p>Izin Magang Mandiri Kelompok</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSimagkUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $data9['jumData'];?></h3>
                    <p>Izin Tempat PKL</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSitpUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-purple">
                  <div class="inner">
                    <h3><?php echo $data10['jumData'];?></h3>
                    <p>Izin Observasi Pra Skripsi</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formPraSipsUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $data11['jumData'];?></h3>
                    <p>Izin Penelitian Skripsi</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSipsUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="small-box bg-purple">
                  <div class="inner">
                    <h3><?php echo $data12['jumData'];?></h3>
                    <p>Keterangan Kelakuan Baik</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-envelope"></i>
                  </div>
                  <a href="formSkkbUser.php" class="small-box-footer">
                  Buat surat <i class="fas fa-arrow-circle-right"></i>
                  </a>
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
</html>