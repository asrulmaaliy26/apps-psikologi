<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
$nim = $dataku['nim'];
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
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col">
              <section class="connectedSortable">
                <div class="card card-success card-outline">
                  <div class="card-header">
                    <h3 class="card-title">Permohonan Surat</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <thead>
                          <th width="4%" class="">No.</th>
                          <th width="72%" class="text-left">Jenis Permohonan Surat</th>
                          <th width="10%">Jumlah</th>
                          <th width="14%" class="">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            $qry1 = "SELECT COUNT(id) AS jumData FROM siow_individu WHERE nim = '$nim'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );

                            $qry2 = "SELECT COUNT(id) AS jumData FROM siow_kelompok WHERE nim = '$nim'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE nim = '$nim' AND jenis_praktikum = '1'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            
                            $qry4 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE nim = '$nim' AND jenis_praktikum = '1'";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );

                            $qry5 = "SELECT COUNT(id) AS jumData FROM siprak_mahasiswa WHERE nim = '$nim' AND jenis_praktikum = '2'";
                            $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
                            $data5 = mysqli_fetch_assoc( $has5 );

                            $qry6 = "SELECT COUNT(id) AS jumData FROM siprak_siswa WHERE nim = '$nim' AND jenis_praktikum = '2'";
                            $has6 = mysqli_query($con,  $qry6 )or DIE( mysqli_error($con) );
                            $data6 = mysqli_fetch_assoc( $has6 );

                            $qry7 = "SELECT COUNT(id) AS jumData FROM magang WHERE nim = '$nim' AND jenis_magang = '1'";
                            $has7 = mysqli_query($con,  $qry7 )or DIE( mysqli_error($con) );
                            $data7 = mysqli_fetch_assoc( $has7 );

                            $qry8 = "SELECT COUNT(id) AS jumData FROM magang WHERE nim = '$nim' AND jenis_magang = '2'";
                            $has8 = mysqli_query($con,  $qry8 )or DIE( mysqli_error($con) );
                            $data8 = mysqli_fetch_assoc( $has8 );

                            $qry9 = "SELECT COUNT(id) AS jumData FROM sitp WHERE nim = '$nim'";
                            $has9 = mysqli_query($con,  $qry9 )or DIE( mysqli_error($con) );
                            $data9 = mysqli_fetch_assoc( $has9 );

                            $qry10 = "SELECT COUNT(id) AS jumData FROM prasips WHERE nim = '$nim'";
                            $has10 = mysqli_query($con,  $qry10 )or DIE( mysqli_error($con) );
                            $data10 = mysqli_fetch_assoc( $has10 );

                            $qry11 = "SELECT COUNT(id) AS jumData FROM sips WHERE nim = '$nim'";
                            $has11 = mysqli_query($con,  $qry11 )or DIE( mysqli_error($con) );
                            $data11 = mysqli_fetch_assoc( $has11 );
                                                        
                            $qry12 = "SELECT COUNT(id) AS jumData FROM skkb WHERE nim = '$nim'";
                            $has12 = mysqli_query($con,  $qry12 )or DIE( mysqli_error($con) );
                            $data12 = mysqli_fetch_assoc( $has12 ); 
                            ?> 
                          <tr>
                            <td class="">1</td>
                            <td class="text-left">Izin Observasi dan Wawancara (Matkul) Individu</td>
                            <td><?php echo $data1['jumData'];?></td>
                            <td class=""><?php if($data1['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSiowiUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">2</td>
                            <td class="text-left">Izin Observasi dan Wawancara (Matkul) Kelompok</td>
                            <td><?php echo $data2['jumData'];?></td>
                            <td class=""><?php if($data2['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSiowkUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">3</td>
                            <td class="text-left">Izin Praktikum Individu Testee Mahasiswa</td>
                            <td><?php echo $data3['jumData'];?></td>
                            <td class=""><?php if($data3['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSiprakimUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">4</td>
                            <td class="text-left">Izin Praktikum Individu Testee Siswa</td>
                            <td><?php echo $data4['jumData'];?></td>
                            <td class=""><?php if($data4['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSiprakisUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">5</td>
                            <td class="text-left">Izin Praktikum Kelompok Testee Mahasiswa</td>
                            <td><?php echo $data5['jumData'];?></td>
                            <td class=""><?php if($data5['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSiprakkmUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">6</td>
                            <td class="text-left">Izin Praktikum Kelompok Testee Siswa</td>
                            <td><?php echo $data6['jumData'];?></td>
                            <td class=""><?php if($data6['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSiprakksUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">7</td>
                            <td class="text-left">Izin Magang Mandiri Individu</td>
                            <td><?php echo $data7['jumData'];?></td>
                            <td class=""><?php if($data7['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSimagiUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">8</td>
                            <td class="text-left">Izin Magang Mandiri Kelompok</td>
                            <td><?php echo $data8['jumData'];?></td>
                            <td class=""><?php if($data8['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSimagkUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">9</td>
                            <td class="text-left">Izin Tempat PKL</td>
                            <td><?php echo $data9['jumData'];?></td>
                            <td class=""><?php if($data9['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSitpUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">10</td>
                            <td class="text-left">Izin Observasi Pra Skripsi</td>
                            <td><?php echo $data10['jumData'];?></td>
                            <td class=""><?php if($data10['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatPraSipsUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                          <tr>
                            <td class="">11</td>
                            <td class="text-left">Izin Penelitian Skripsi</td>
                            <td><?php echo $data11['jumData'];?></td>
                            <td class=""><?php if($data11['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSipsUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                           <tr>
                            <td class="">12</td>
                            <td class="text-left">Keterangan Kelakuan Baik</td>
                            <td><?php echo $data12['jumData'];?></td>
                            <td class=""><?php if($data12['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada data">Lihat data</a>';} else { echo '<a href="riwayatSkkbUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a>';} ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
              <section class="connectedSortable">
                <div class="card card-success card-outline">
                  <div class="card-header">
                    <h3 class="card-title">Pengajuan Dospem Skripsi</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <thead>
                          <th width="4%" class="">No.</th>
                          <th width="22%">Tgl. Pengajuan</th>
                          <th width="60%">Status</th>
                          <th width="14%" class="">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qdospem = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim = '$nim'";
                            $rdospem = mysqli_query($con,  $qdospem )or DIE( mysqli_error($con) );
                            while($ddospem = mysqli_fetch_assoc( $rdospem )) {
                              $no++;
                               $qvaldospem = "SELECT * FROM opsi_validasi WHERE id = '$ddospem[status]'";
                               $rvaldospem = mysqli_query($con,  $qvaldospem )or DIE( mysqli_error($con) );
                               $dvaldospem = mysqli_fetch_assoc( $rvaldospem );
                              ?>
                           <tr>
                            <td class=""><?php echo $no;?></td>
                            <td><?php echo $ddospem['tgl_pengajuan'];?></td>
                            <td><?php echo $dvaldospem['nm'];?></td>
                            <td class=""><a href="riwayatPengajuanDospemUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a></td>
                          </tr>
                        <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
              <section class="connectedSortable">
                <div class="card card-success card-outline">
                  <div class="card-header">
                    <h3 class="card-title">Pendaftaran Praktik Kerja Lapangan (PKL)</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <thead>
                          <th width="4%" class="">No.</th>
                          <th width="22%">Tgl. Pendaftaran</th>
                          <th width="60%">Status</th>
                          <th width="14%" class="">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qpkl = "SELECT * FROM peserta_pkl WHERE nim = '$nim'";
                            $rpkl = mysqli_query($con,  $qpkl )or DIE( mysqli_error($con) );
                            while($dpkl = mysqli_fetch_assoc( $rpkl )) {
                              $no++;
                               $qvalpkl = "SELECT * FROM opsi_validasi WHERE id = '$dpkl[val_adm]'";
                               $rvalpkl = mysqli_query($con,  $qvalpkl )or DIE( mysqli_error($con) );
                               $dvalpkl = mysqli_fetch_assoc( $rvalpkl );
                              ?>
                           <tr>
                            <td class=""><?php echo $no;?></td>
                            <td><?php echo $dpkl['tgl_pengajuan'];?></td>
                            <td><?php echo $dvalpkl['nm'];?></td>
                            <td class=""><a href="riwayatPendaftaranPklUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a></td>
                          </tr>
                        <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
              <section class="connectedSortable">
                <div class="card card-success card-outline">
                  <div class="card-header">
                    <h3 class="card-title">Pendaftaran Seminar Proposal Skripsi</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <thead>
                          <th width="4%" class="">No.</th>
                          <th width="22%">Tgl. Pendaftaran</th>
                          <th width="60%">Status</th>
                          <th width="14%" class="">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qsempro = "SELECT * FROM peserta_sempro WHERE nim = '$nim'";
                            $rsempro = mysqli_query($con,  $qsempro )or DIE( mysqli_error($con) );
                            while($dsempro = mysqli_fetch_assoc( $rsempro )) {
                              $no++;
                               $qvalsempro = "SELECT * FROM opsi_validasi WHERE id = '$dsempro[val_adm]'";
                               $rvalsempro = mysqli_query($con,  $qvalsempro )or DIE( mysqli_error($con) );
                               $dvalsempro = mysqli_fetch_assoc( $rvalsempro );
                              ?>
                           <tr>
                            <td class=""><?php echo $no;?></td>
                            <td><?php echo $dsempro['tgl_pengajuan'];?></td>
                            <td><?php echo $dvalsempro['nm'];?></td>
                            <td class=""><a href="riwayatPendaftaranSemproUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a></td>
                          </tr>
                        <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
              <section class="connectedSortable">
                <div class="card card-success card-outline">
                  <div class="card-header">
                    <h3 class="card-title">Pendaftaran Ujian Komprehensif</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <thead>
                          <th width="4%" class="">No.</th>
                          <th width="22%">Tgl. Pengajuan</th>
                          <th width="60%">Status</th>
                          <th width="14%" class="">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qkompre = "SELECT * FROM peserta_kompre WHERE nim = '$nim'";
                            $rkompre = mysqli_query($con,  $qkompre )or DIE( mysqli_error($con) );
                            while($dkompre = mysqli_fetch_assoc( $rkompre )) {
                              $no++;
                               $qvalkompre = "SELECT * FROM opsi_validasi WHERE id = '$dkompre[val_adm]'";
                               $rvalkompre = mysqli_query($con,  $qvalkompre )or DIE( mysqli_error($con) );
                               $dvalkompre = mysqli_fetch_assoc( $rvalkompre );
                              ?>
                           <tr>
                            <td class=""><?php echo $no;?></td>
                            <td><?php echo $dkompre['tgl_pengajuan'];?></td>
                            <td><?php echo $dvalkompre['nm'];?></td>
                            <td class=""><a href="riwayatPendaftaranKompreUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a></td>
                          </tr>
                        <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
              <section class="connectedSortable">
                <div class="card card-success card-outline">
                  <div class="card-header">
                    <h3 class="card-title">Pendaftaran Ujian Skripsi</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <thead>
                          <th width="4%" class="">No.</th>
                          <th width="22%">Tgl. Pengajuan</th>
                          <th width="60%">Status</th>
                          <th width="14%" class="">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qujskrip = "SELECT * FROM peserta_ujskrip WHERE nim = '$nim'";
                            $rujskrip = mysqli_query($con,  $qujskrip )or DIE( mysqli_error($con) );
                            while($dujskrip = mysqli_fetch_assoc( $rujskrip )) {
                              $no++;
                               $qvalujskrip = "SELECT * FROM opsi_validasi WHERE id = '$dujskrip[val_adm]'";
                               $rvalujskrip = mysqli_query($con,  $qvalujskrip )or DIE( mysqli_error($con) );
                               $dvalujskrip = mysqli_fetch_assoc( $rvalujskrip );
                              ?>
                           <tr>
                            <td class=""><?php echo $no;?></td>
                            <td><?php echo $dujskrip['tgl_pengajuan'];?></td>
                            <td><?php echo $dvalujskrip['nm'];?></td>
                            <td class=""><a href="riwayatPendaftaranUjianSkripsiUser.php" type="button" class="btn btn-outline-info btn-xs btn-block" title="Lihat data">Lihat data</a></td>
                          </tr>
                        <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
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
