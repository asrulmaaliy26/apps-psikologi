<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $myquery = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dAdm = mysqli_fetch_assoc($d);
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
                <h4 class="mb-0">Kontribusi Saya</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Sebagai Eksekutor</li>
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
                    <h4 class="card-title">Sebagai Eksekutor</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead class="thead-light">
                          <th scope="col" width="86%" class="">Sebagai Eksekutor</th>
                          <th scope="col" width="10%" class="text-center">Total</th>
                          <th scope="col" width="4%" class="text-center">Opsi</th>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Agenda Surat Keluar</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM surat_keluar WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksAskAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Agenda Surat Masuk</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM surat_masuk WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksAsmAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Buat Surat Keputusan</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM sk WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksBuatSkAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Buat Surat Tugas</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM st WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksBuatStAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Buat Surat Perjalanan Dinas</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM spd WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksBuatSpdAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Kirim File Surat Keputusan</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM sending_surat WHERE jenis_surat = '1' AND executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksKirimSkAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Kirim File Surat Tugas</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM sending_surat WHERE jenis_surat = '2' AND executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksKirimStAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Kirim File Surat Undangan</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM sending_surat WHERE jenis_surat = '3' AND executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksKirimSuAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Observasi dan Wawancara (Matkul) Individu</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM siow_individu WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksSiowiAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Observasi dan Wawancara (Matkul) Kelompok</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM siow_kelompok WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksSiowkAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Tempat (Lokasi) PKL</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM sitp WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksSitpAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Observasi Pra Skripsi</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM prasips WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksSiopsAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Penelitian Skripsi</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM sips WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksSipsAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Praktikum Individu <span class="text-info">Testee Siswa</span></td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '1' AND executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            <td class="text-center">
                              <a href="dataKontribEksSipitsAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Praktikum Kelompok <span class="text-info">Testee Siswa</span></td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '2' AND executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            <td class="text-center">
                              <a href="dataKontribEksSipktsAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Praktikum Individu <span class="text-success">Testee Mahasiswa</span></td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '1' AND executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            <td class="text-center">
                              <a href="dataKontribEksSipitmAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Izin Praktikum Kelompok <span class="text-success">Testee Mahasiswa</span></td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE jenis_praktikum = '2' AND executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksSipktmAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>Permohonan Surat Keterangan Kelakuan Baik</td>
                            <td class="text-center">
                              <?php
                                $qry = "SELECT COUNT(id) AS jumData FROM skkb WHERE executor = '$dAdm[username]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                $data = mysqli_fetch_assoc( $has );
                                echo $data['jumData'];?>
                            </td>
                            <td class="text-center">
                              <a href="dataKontribEksSkkbAdm.php" role="button" class="btn btn-warning btn-block btn-xs" title="Buka"><i class="bi bi-folder2-open"></i></a>
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