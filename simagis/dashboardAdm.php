<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
  $myquery = "select * from mag_dt_admin_bak WHERE username='$username'";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dadmin = mysqli_fetch_assoc($result);
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navDashAdm.php";?>
    <div class="container-fluid">
    <div class="row">
      <h3 class="text-center text-warning">Dashboard Admin</h3>
      <div class="panel panel-success">
        <div class="panel-heading">
          <ul class="list">
            <li>Berikut adalah dashboard admin.</li>
            <li>Silahkan tekan menu dan button yang dimaksud untuk melihat detail data dan konfigurasinya.</li>
          </ul>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-info">
                <div class="panel-heading text-center">Data Pengajuan Peminatan Rumpun Psikologi</div>
                <?php              		
                  $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun";
                     $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData0 = $dataku0['jumData'];
                  
                  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE cek='1'";
                     $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData1 = $dataku1['jumData'];
                  
                  $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE cek='2'";
                     $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData2 = $dataku2['jumData'];
                  ?>
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered custom">
                    <thead>
                      <tr>
                        <th width="30%" class="text-center">Pengajuan</th>
                        <th width="30%" class="text-center">Terverifikasi</th>
                        <th width="30%" class="text-center">Total</th>
                        <th width="10%" class="text-center">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-center"><?php echo $jumlahData1;?></td>
                        <td class="text-center"><?php echo $jumlahData2;?></td>
                        <td class="text-center"><?php echo $jumlahData0;?></td>
                        <td class="text-center"><a class="btn btn-sm btn-primary" href="rekapPprpAdm.php" title="Lihat detail" role="button"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="panel panel-info">
                <div class="panel-heading text-center">Data Pengajuan Academic Coach</div>
                <?php              		
                  $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali";
                     $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData0 = $dataku0['jumData'];
                  
                  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE cek='1'";
                     $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData1 = $dataku1['jumData'];
                  
                  $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE cek='2' AND status='1'";
                     $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData2 = $dataku2['jumData'];
                  
                  $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE cek='2' AND status='2'";
                     $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData3 = $dataku3['jumData'];
                  ?>
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered custom">
                    <thead>
                      <tr>
                        <th width="22.5%" class="text-center">Pengajuan</th>
                        <th width="22.5%" class="text-center">Proses</th>
                        <th width="22.5%" class="text-center">Selesai</th>
                        <th width="22.5%" class="text-center">Total</th>
                        <th width="10%" class="text-center">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-center"><?php echo $jumlahData1;?></td>
                        <td class="text-center"><?php echo $jumlahData2;?></td>
                        <td class="text-center"><?php echo $jumlahData3;?></td>
                        <td class="text-center"><?php echo $jumlahData0;?></td>
                        <td class="text-center"><a class="btn btn-sm btn-primary" href="rekapPacAdm.php" title="Lihat detail" role="button"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="panel panel-info">
                <div class="panel-heading text-center">Data Pengajuan Dosen Pembimbing Tesis</div>
                <?php              		
                  $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis";
                     $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData0 = $dataku0['jumData'];
                  
                  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE cek1='1' AND cek2='1'";
                     $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData1 = $dataku1['jumData'];
                  
                  $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE cek1='2' AND cek2='2' AND cekjudul='2' AND status='1'";
                     $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData2 = $dataku2['jumData'];
                  
                  $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE cek1='2' AND cek2='2' AND cekjudul='2' AND status='2'";
                     $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData3 = $dataku3['jumData'];
                  ?>
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered custom">
                    <thead>
                      <tr>
                        <th width="22.5%" class="text-center">Pengajuan</th>
                        <th width="22.5%" class="text-center">Proses</th>
                        <th width="22.5%" class="text-center">Selesai</th>
                        <th width="22.5%" class="text-center">Total</th>
                        <th width="10%" class="text-center">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-center"><?php echo $jumlahData1;?></td>
                        <td class="text-center"><?php echo $jumlahData2;?></td>
                        <td class="text-center"><?php echo $jumlahData3;?></td>
                        <td class="text-center"><?php echo $jumlahData0;?></td>
                        <td class="text-center"><a class="btn btn-sm btn-primary" href="rekapPptAdm.php" title="Lihat detail" role="button"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-warning">
                <div class="panel-heading text-center">Data Seminar Proposal Tesis</div>
                <?php              		
                  $qry0 = "SELECT COUNT(*) AS jumData FROM mag_peserta_sempro";
                     $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData0 = $dataku0['jumData'];
                  
                  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_peserta_sempro WHERE cek='1'";
                     $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData1 = $dataku1['jumData'];
                  
                  $qry2 = "SELECT COUNT(*) AS jumData FROM mag_peserta_sempro WHERE cek='2'";
                     $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData2 = $dataku2['jumData'];
                  ?>
                <div class="table-responsive">
                  <table class="table  table-condensed table-bordered custom">
                    <thead>
                      <tr>
                        <th width="30%" class="text-center">Belum Terjadwal</th>
                        <th width="30%" class="text-center">Telah Terjadwal</th>
                        <th width="30%" class="text-center">Total</th>
                        <th width="10%" class="text-center">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-center"><?php echo $jumlahData1;?></td>
                        <td class="text-center"><?php echo $jumlahData2;?></td>
                        <td class="text-center"><?php echo $jumlahData0;?></td>
                        <td class="text-center"><a class="btn btn-sm btn-primary" href="rekapPendSemproAdm.php" title="Lihat detail" role="button"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="panel panel-warning">
                <div class="panel-heading text-center">Data Ujian Tesis</div>
                <?php              		
                  $qry0 = "SELECT COUNT(*) AS jumData FROM mag_peserta_ujtes";
                     $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData0 = $dataku0['jumData'];
                  
                  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_peserta_ujtes WHERE cek='1'";
                     $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData1 = $dataku1['jumData'];
                  
                  $qry2 = "SELECT COUNT(*) AS jumData FROM mag_peserta_ujtes WHERE cek='2'";
                     $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     $jumlahData2 = $dataku2['jumData'];
                  ?>
                <div class="table-responsive">
                  <table class="table  table-condensed table-bordered custom">
                    <thead>
                      <tr>
                        <th width="30%" class="text-center">Belum Terjadwal</th>
                        <th width="30%" class="text-center">Telah Terjadwal</th>
                        <th width="30%" class="text-center">Total</th>
                        <th width="10%" class="text-center">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-center"><?php echo $jumlahData1;?></td>
                        <td class="text-center"><?php echo $jumlahData2;?></td>
                        <td class="text-center"><?php echo $jumlahData0;?></td>
                        <td class="text-center"><a class="btn btn-sm btn-primary" href="rekapPendUjtesAdm.php" title="Lihat detail" role="button"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include "footerAdm.php";?>
      <?php include "jsSourceAdm.php";?>
    </div>
  </body>
</html>