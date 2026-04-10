<?php include( "contentsConAdm.php" );
  $tahun = date("Y");?>
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
                <h4 class="mb-0">Permohonan Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Dari Mahasiswa</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
            </div>
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Tahun <?php echo $tahun;?></h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead class="thead-light">
                          <th scope="col" width="56%" class="">Permohonan Surat</th>
                          <th scope="col" width="10%" class="text-center">Pengajuan</th>
                          <th scope="col" width="10%" class="text-center">Proses</th>
                          <th scope="col" width="10%" class="text-center">Selesai</th>
                          <th scope="col" width="10%" class="text-center">Ditolak</th>
                          <th scope="col" width="4%" class="text-center">Opsi</th>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Izin Observasi dan Wawancara (Matkul) Individu</td>
                            <td class="text-center">
                              <?php
                                $qry1 = "SELECT COUNT(id) AS jumData FROM siow_individu WHERE thn_pengajuan='$tahun' AND statusform = '1'";
                                $has1 = mysqli_query($con,  $qry1 )or die( mysqli_error($con) );
                                $data1 = mysqli_fetch_assoc( $has1 );
                                echo $data1['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry12 = "SELECT COUNT(id) AS jumData FROM siow_individu WHERE thn_pengajuan='$tahun' AND statusform = '2'";
                                $has12 = mysqli_query($con,  $qry12 )or die( mysqli_error($con) );
                                $data12 = mysqli_fetch_assoc( $has12 );
                                echo $data12['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry13 = "SELECT COUNT(id) AS jumData FROM siow_individu WHERE thn_pengajuan='$tahun' AND statusform = '3'";
                                $has13 = mysqli_query($con,  $qry13 )or die( mysqli_error($con) );
                                $data13 = mysqli_fetch_assoc( $has13 );
                                echo $data13['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry14 = "SELECT COUNT(id) AS jumData FROM siow_individu WHERE thn_pengajuan='$tahun' AND statusform = '4'";
                                $has14 = mysqli_query($con,  $qry14 )or die( mysqli_error($con) );
                                $data14 = mysqli_fetch_assoc( $has14 );
                                echo $data14['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSiowIndividuAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Observasi dan Wawancara (Matkul) Kelompok</td>
                            <td class="text-center">
                              <?php
                                $qry2 = "SELECT COUNT(id) AS jumData FROM siow_kelompok WHERE thn_pengajuan='$tahun' AND statusform = '1'";
                                $has2 = mysqli_query($con,  $qry2 )or die( mysqli_error($con) );
                                $data2 = mysqli_fetch_assoc( $has2 );
                                echo $data2['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry22 = "SELECT COUNT(id) AS jumData FROM siow_kelompok WHERE thn_pengajuan='$tahun' AND statusform = '2'";
                                $has22 = mysqli_query($con,  $qry22 )or die( mysqli_error($con) );
                                $data22 = mysqli_fetch_assoc( $has22 );
                                echo $data22['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry23 = "SELECT COUNT(id) AS jumData FROM siow_kelompok WHERE thn_pengajuan='$tahun' AND statusform = '3'";
                                $has23 = mysqli_query($con,  $qry23 )or die( mysqli_error($con) );
                                $data23 = mysqli_fetch_assoc( $has23 );
                                echo $data23['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry24 = "SELECT COUNT(id) AS jumData FROM siow_kelompok WHERE thn_pengajuan='$tahun' AND statusform = '4'";
                                $has24 = mysqli_query($con,  $qry24 )or die( mysqli_error($con) );
                                $data24 = mysqli_fetch_assoc( $has24 );
                                echo $data24['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSiowKelompokAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Magang Mandiri Individu</td>
                            <td class="text-center">
                              <?php
                                $qry111 = "SELECT COUNT(id) AS jumData FROM magang WHERE jenis_magang='1' AND thn_pengajuan='$tahun' AND statusform = '1'";
                                $has111 = mysqli_query($con,  $qry111 )or die( mysqli_error($con) );
                                $data111 = mysqli_fetch_assoc( $has111 );
                                echo $data111['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry112 = "SELECT COUNT(id) AS jumData FROM magang WHERE jenis_magang='1' AND thn_pengajuan='$tahun' AND statusform = '2'";
                                $has112 = mysqli_query($con,  $qry112 )or die( mysqli_error($con) );
                                $data112 = mysqli_fetch_assoc( $has112 );
                                echo $data112['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry113 = "SELECT COUNT(id) AS jumData FROM magang WHERE jenis_magang='1' AND thn_pengajuan='$tahun' AND statusform = '3'";
                                $has113 = mysqli_query($con,  $qry113 )or die( mysqli_error($con) );
                                $data113 = mysqli_fetch_assoc( $has113 );
                                echo $data113['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry114 = "SELECT COUNT(id) AS jumData FROM magang WHERE jenis_magang='1' AND thn_pengajuan='$tahun' AND statusform = '4'";
                                $has114 = mysqli_query($con,  $qry114 )or die( mysqli_error($con) );
                                $data114 = mysqli_fetch_assoc( $has114 );
                                echo $data114['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSimagIndividuAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Magang Mandiri Kelompok</td>
                            <td class="text-center">
                              <?php
                                $qry121 = "SELECT COUNT(id) AS jumData FROM magang WHERE jenis_magang='2' AND thn_pengajuan='$tahun' AND statusform = '1'";
                                $has121 = mysqli_query($con,  $qry121 )or die( mysqli_error($con) );
                                $data121 = mysqli_fetch_assoc( $has121 );
                                echo $data121['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry122 = "SELECT COUNT(id) AS jumData FROM magang WHERE jenis_magang='2' AND thn_pengajuan='$tahun' AND statusform = '2'";
                                $has122 = mysqli_query($con,  $qry122 )or die( mysqli_error($con) );
                                $data122 = mysqli_fetch_assoc( $has122 );
                                echo $data122['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry123 = "SELECT COUNT(id) AS jumData FROM magang WHERE jenis_magang='2' AND thn_pengajuan='$tahun' AND statusform = '3'";
                                $has123 = mysqli_query($con,  $qry123 )or die( mysqli_error($con) );
                                $data123 = mysqli_fetch_assoc( $has123 );
                                echo $data123['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry124 = "SELECT COUNT(id) AS jumData FROM magang WHERE jenis_magang='2' AND thn_pengajuan='$tahun' AND statusform = '4'";
                                $has124 = mysqli_query($con,  $qry124 )or die( mysqli_error($con) );
                                $data124 = mysqli_fetch_assoc( $has124 );
                                echo $data124['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSimagKelompokAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Tempat (Lokasi) PKL</td>
                            <td class="text-center">
                              <?php
                                $qry3 = "SELECT COUNT(id) AS jumData FROM sitp WHERE thn_pengajuan='$tahun' AND statusform = '1'";
                                $has3 = mysqli_query($con,  $qry3 )or die( mysqli_error($con) );
                                $data3 = mysqli_fetch_assoc( $has3 );
                                echo $data3['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry32 = "SELECT COUNT(id) AS jumData FROM sitp WHERE thn_pengajuan='$tahun' AND statusform = '2'";
                                $has32 = mysqli_query($con,  $qry32 )or die( mysqli_error($con) );
                                $data32 = mysqli_fetch_assoc( $has32 );
                                echo $data32['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry33 = "SELECT COUNT(id) AS jumData FROM sitp WHERE thn_pengajuan='$tahun' AND statusform = '3'";
                                $has33 = mysqli_query($con,  $qry33 )or die( mysqli_error($con) );
                                $data33 = mysqli_fetch_assoc( $has33 );
                                echo $data33['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry34 = "SELECT COUNT(id) AS jumData FROM sitp WHERE thn_pengajuan='$tahun' AND statusform = '4'";
                                $has34 = mysqli_query($con,  $qry34 )or die( mysqli_error($con) );
                                $data34 = mysqli_fetch_assoc( $has34 );
                                echo $data34['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSitpAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Observasi Pra Skripsi</td>
                            <td class="text-center">
                              <?php
                                $qry4 = "SELECT COUNT(id) AS jumData FROM prasips WHERE thn_pengajuan='$tahun' AND statusform = '1'";
                                $has4 = mysqli_query($con,  $qry4 )or die( mysqli_error($con) );
                                $data4 = mysqli_fetch_assoc( $has4 );
                                echo $data4['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry42 = "SELECT COUNT(id) AS jumData FROM prasips WHERE thn_pengajuan='$tahun' AND statusform = '2'";
                                $has42 = mysqli_query($con,  $qry42 )or die( mysqli_error($con) );
                                $data42 = mysqli_fetch_assoc( $has42 );
                                echo $data42['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry43 = "SELECT COUNT(id) AS jumData FROM prasips WHERE thn_pengajuan='$tahun' AND statusform = '3'";
                                $has43 = mysqli_query($con,  $qry43 )or die( mysqli_error($con) );
                                $data43 = mysqli_fetch_assoc( $has43 );
                                echo $data43['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry44 = "SELECT COUNT(id) AS jumData FROM prasips WHERE thn_pengajuan='$tahun' AND statusform = '4'";
                                $has44 = mysqli_query($con,  $qry44 )or die( mysqli_error($con) );
                                $data44 = mysqli_fetch_assoc( $has44 );
                                echo $data44['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapPrasipsAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Penelitian Skripsi</td>
                            <td class="text-center">
                              <?php
                                $qry5 = "SELECT COUNT(id) AS jumData FROM sips WHERE thn_pengajuan='$tahun' AND statusform = '1'";
                                $has5 = mysqli_query($con,  $qry5 )or die( mysqli_error($con) );
                                $data5 = mysqli_fetch_assoc( $has5 );
                                echo $data5['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry52 = "SELECT COUNT(id) AS jumData FROM sips WHERE thn_pengajuan='$tahun' AND statusform = '2'";
                                $has52 = mysqli_query($con,  $qry52 )or die( mysqli_error($con) );
                                $data52 = mysqli_fetch_assoc( $has52 );
                                echo $data52['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry53 = "SELECT COUNT(id) AS jumData FROM sips WHERE thn_pengajuan='$tahun' AND statusform = '3'";
                                $has53 = mysqli_query($con,  $qry53 )or die( mysqli_error($con) );
                                $data53 = mysqli_fetch_assoc( $has53 );
                                echo $data53['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry54 = "SELECT COUNT(id) AS jumData FROM sips WHERE thn_pengajuan='$tahun' AND statusform = '4'";
                                $has54 = mysqli_query($con,  $qry54 )or die( mysqli_error($con) );
                                $data54 = mysqli_fetch_assoc( $has54 );
                                echo $data54['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSipsAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Praktikum Individu <span class="text-info">Testee Siswa</span></td>
                            <td class="text-center">
                              <?php
                                $qry6 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '1' AND thn_pengajuan='$tahun' AND statusform = '1'";
                                $has6 = mysqli_query($con,  $qry6 )or die( mysqli_error($con) );
                                $data6 = mysqli_fetch_assoc( $has6 );
                                echo $data6['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry62 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '1' AND thn_pengajuan='$tahun' AND statusform = '2'";
                                $has62 = mysqli_query($con,  $qry62 )or die( mysqli_error($con) );
                                $data62 = mysqli_fetch_assoc( $has62 );
                                echo $data62['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry63 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '1' AND thn_pengajuan='$tahun' AND statusform = '3'";
                                $has63 = mysqli_query($con,  $qry63 )or die( mysqli_error($con) );
                                $data63 = mysqli_fetch_assoc( $has63 );
                                echo $data63['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry64 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '1' AND thn_pengajuan='$tahun' AND statusform = '4'";
                                $has64 = mysqli_query($con,  $qry64 )or die( mysqli_error($con) );
                                $data64 = mysqli_fetch_assoc( $has64 );
                                echo $data64['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSiprakSiswaIndAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Praktikum Kelompok <span class="text-info">Testee Siswa</span></td>
                            <td class="text-center">
                              <?php
                                $qry7 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$tahun' AND statusform = '1'";
                                $has7 = mysqli_query($con,  $qry7 )or die( mysqli_error($con) );
                                $data7 = mysqli_fetch_assoc( $has7 );
                                echo $data7['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry72 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$tahun' AND statusform = '2'";
                                $has72 = mysqli_query($con,  $qry72 )or die( mysqli_error($con) );
                                $data72 = mysqli_fetch_assoc( $has72 );
                                echo $data72['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry73 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$tahun' AND statusform = '3'";
                                $has73 = mysqli_query($con,  $qry73 )or die( mysqli_error($con) );
                                $data73 = mysqli_fetch_assoc( $has73 );
                                echo $data73['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry74 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$tahun' AND statusform = '4'";
                                $has74 = mysqli_query($con,  $qry74 )or die( mysqli_error($con) );
                                $data74 = mysqli_fetch_assoc( $has74 );
                                echo $data74['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSiprakSiswaKelAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Praktikum Individu <span class="text-success">Testee Mahasiswa</span></td>
                            <td class="text-center">
                              <?php
                                $qry8 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '1' AND thn_pengajuan='$tahun' AND statusform = '1'";
                                $has8 = mysqli_query($con,  $qry8 )or die( mysqli_error($con) );
                                $data8 = mysqli_fetch_assoc( $has8 );
                                echo $data8['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry82 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '1' AND thn_pengajuan='$tahun' AND statusform = '2'";
                                $has82 = mysqli_query($con,  $qry82 )or die( mysqli_error($con) );
                                $data82 = mysqli_fetch_assoc( $has82 );
                                echo $data82['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry83 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '1' AND thn_pengajuan='$tahun' AND statusform = '3'";
                                $has83 = mysqli_query($con,  $qry83 )or die( mysqli_error($con) );
                                $data83 = mysqli_fetch_assoc( $has83 );
                                echo $data83['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry84 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '1' AND thn_pengajuan='$tahun' AND statusform = '4'";
                                $has84 = mysqli_query($con,  $qry84 )or die( mysqli_error($con) );
                                $data84 = mysqli_fetch_assoc( $has84 );
                                echo $data84['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSiprakMhsswIndAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Izin Praktikum Kelompok <span class="text-success">Testee Mahasiswa</span></td>
                            <td class="text-center">
                              <?php
                                $qry9 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$tahun' AND statusform = '1'";
                                $has9 = mysqli_query($con,  $qry9 )or die( mysqli_error($con) );
                                $data9 = mysqli_fetch_assoc( $has9 );
                                echo $data9['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry92 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$tahun' AND statusform = '2'";
                                $has92 = mysqli_query($con,  $qry92 )or die( mysqli_error($con) );
                                $data92 = mysqli_fetch_assoc( $has92 );
                                echo $data92['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry93 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '2' AND  thn_pengajuan='$tahun' AND statusform = '3'";
                                $has93 = mysqli_query($con,  $qry93 )or die( mysqli_error($con) );
                                $data93 = mysqli_fetch_assoc( $has93 );
                                echo $data93['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry94 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$tahun' AND statusform = '4'";
                                $has94 = mysqli_query($con,  $qry94 )or die( mysqli_error($con) );
                                $data94 = mysqli_fetch_assoc( $has94 );
                                echo $data94['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSiprakMhsswKelAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Keterangan Kelakuan Baik</td>
                            <td class="text-center">
                              <?php
                                $qry10 = "SELECT COUNT(id) AS jumData FROM skkb WHERE thn_pengajuan='$tahun' AND statusform = '1'";
                                $has10 = mysqli_query($con,  $qry10 )or die( mysqli_error($con) );
                                $data10 = mysqli_fetch_assoc( $has10 );
                                echo $data10['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry102 = "SELECT COUNT(id) AS jumData FROM skkb WHERE thn_pengajuan='$tahun' AND statusform = '2'";
                                $has102 = mysqli_query($con,  $qry102 )or die( mysqli_error($con) );
                                $data102 = mysqli_fetch_assoc( $has102 );
                                echo $data102['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry103 = "SELECT COUNT(id) AS jumData FROM skkb WHERE thn_pengajuan='$tahun' AND statusform = '3'";
                                $has103 = mysqli_query($con,  $qry103 )or die( mysqli_error($con) );
                                $data103 = mysqli_fetch_assoc( $has103 );
                                echo $data103['jumData'];?>
                            </td>
                            <td class="text-center">
                              <?php
                                $qry104 = "SELECT COUNT(id) AS jumData FROM skkb WHERE thn_pengajuan='$tahun' AND statusform = '4'";
                                $has104 = mysqli_query($con,  $qry104 )or die( mysqli_error($con) );
                                $data104 = mysqli_fetch_assoc( $has104 );
                                echo $data104['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="rekapSkkbAdm.php?date=<?php echo $tahun;?>" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
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
