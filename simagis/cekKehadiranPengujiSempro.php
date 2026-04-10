<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
        
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  
  $jdwl = "select * from mag_jadwal_sempro WHERE id='$id'";
  $rjdwl = mysqli_query($GLOBALS["___mysqli_ston"],  $jdwl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djdwl = mysqli_fetch_assoc( $rjdwl );
  
  $qmhssw = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$djdwl[nim]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qmhssw )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dtmhssw = mysqli_fetch_array( $resp );
  
  $qp1 = "select * from dt_pegawai WHERE id='$djdwl[penguji1]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp1 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp1 = mysqli_fetch_assoc( $resp );
     
  $qp2 = "select * from dt_pegawai WHERE id='$djdwl[penguji2]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp2 = mysqli_fetch_assoc( $resp );
  
  $qp3 = "select * from dt_pegawai WHERE id='$djdwl[penguji3]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp3 = mysqli_fetch_assoc( $resp );
  
  $qp4 = "select * from dt_pegawai WHERE id='$djdwl[penguji4]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp4 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp4 = mysqli_fetch_assoc( $resp );
  
  $qry_moment = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$djdwl[id_sempro]'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_sempro=$data['id'];
  $thp=$data['tahap'];
  $ta=$data['ta'];
  
  $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$thp'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
  $dthp = mysqli_fetch_assoc($hasil);
    
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qruang = "select * from dt_ruang WHERE id='$djdwl[ruang]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qruang )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $druang = mysqli_fetch_assoc( $resp );
  
  $tanggal=date("d-m-Y", strtotime($djdwl['tgl_seminar']));
  $day = date('D', strtotime($tanggal));
  $dayList = array(
  'Sun' => 'Minggu',
  'Mon' => 'Senin',
  'Tue' => 'Selasa',
  'Wed' => 'Rabu',
  
  'Thu' => 'Kamis',
  'Fri' => "Jum'at",
  'Sat' => 'Sabtu'
  );
  
  function bulanIndo($tanggal)
  {
  $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
  'September','Oktober','Nopember','Desember');
  $split = explode('-', $tanggal);
  return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
  }
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPendAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                     echo '<div class="alert alert-success custom-alert" role="alert">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}
                       ?>
        <h3 class="text-center text-warning">Seminar Proposal Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Jadwal Seminar Proposal Tesis <?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan tekan button print untuk mencetak jadwal dan berita acara.</li>
              <li>Silahkan tekan button ceklis untuk memverifikasi kehadiran penguji.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPendSemproAdm.php">Periode Pendaftaran</a></li>
                  <li role="presentation"><a href="jadSemproPerPeriode.php?id=<?php echo "$id_sempro";?>">Jadwal Seminar</a></li>
                  <li role="presentation" class="active"><a>Cek Kehadiran Penguji</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table width="100%" style="font-size:13px;" class="table table-condensed table-bordered custom">
                    <tr>
                      <td width="10%">Nama Lengkap</td>
                      <td width="2%" align="center">:</td>
                      <td width="38%"><?php echo $dtmhssw['nama'];?></td>
                      <td width="10%">Hari, Tanggal</td>
                      <td width="2%" align="center">:</td>
                      <td width="38%"><?php if(empty($djdwl['tgl_seminar']))  { echo "";} else { echo $dayList[$day].', '.bulanIndo($djdwl['tgl_seminar']);}?></td>
                    </tr>
                    <tr>
                      <td>NIM</td>
                      <td align="center">:</td>
                      <td><?php echo $dtmhssw['nim'];?></td>
                      <td>Ruang</td>
                      <td align="center">:</td>
                      <td><?php if(empty($djdwl['ruang']))  { echo "";} else { echo $druang['nm'];}?></td>
                    </tr>
                  </table>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-condensed table-bordered custom">
                    <thead>
                      <tr>
                        <th width="30%" class="text-center">Susunan Penguji</th>
                        <th width="40%" class="text-center">Nama</th>
                        <th width="30%" class="text-center">Cek Kehadiran</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted" style="font-size:13px;">
                      <tr>
                        <td>Penguji Utama</td>
                        <td><?php echo $dp3['nama'];?></td>
                        <td class="text-center" style="padding-bottom:2px; padding-top:2px;">
                          <label for="" class="sr-only">Cek Hadir</label>
                          <form class="" style="margin-bottom:0px;" action="updateCekKehadiranPengujiUtamaSempro.php" method="post">
                            <input type="text" class="sr-only" name="id" value="<?php echo $id;?>">
                            <select name='cekhadir3' class='form-control input-sm' onchange='this.form.submit();' required>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_cek_kehadiran_penguji ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $djdwl['cekhadir3'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                            </select>
                          </form>
                        </td>
                      </tr>
                      <tr>
                        <td>Ketua Penguji</td>
                        <td><?php echo $dp4['nama'];?></td>
                        <td class="text-center" style="padding-bottom:2px; padding-top:2px;">
                          <label for="" class="sr-only">Cek Hadir</label>
                          <form class="" style="margin-bottom:0px;" action="updateCekKehadiranKetuaPengujiSempro.php" method="post">
                            <input type="text" class="sr-only" name="id" value="<?php echo $id;?>">
                            <select name='cekhadir4' class='form-control input-sm' onchange='this.form.submit();' required>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_cek_kehadiran_penguji ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $djdwl['cekhadir4'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                            </select>
                          </form>
                        </td>
                      </tr>
                      <tr>
                        <td>Pembimbing I</td>
                        <td><?php echo $dp1['nama'];?></td>
                        <td class="text-center" style="padding-bottom:2px; padding-top:2px;">
                          <label for="" class="sr-only">Cek Hadir</label>
                          <form class="" style="margin-bottom:0px;" action="updateCekKehadiranPembimbing1Sempro.php" method="post">
                            <input type="text" class="sr-only" name="id" value="<?php echo $id;?>">
                            <select name='cekhadir1' class='form-control input-sm' onchange='this.form.submit();' required>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_cek_kehadiran_penguji ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $djdwl['cekhadir1'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                            </select>
                          </form>
                        </td>
                      </tr>
                      <tr>
                        <td>Pembimbing II</td>
                        <td><?php echo $dp2['nama'];?></td>
                        <td class="text-center" style="padding-bottom:2px; padding-top:2px;">
                          <label for="" class="sr-only">Cek Hadir</label>
                          <form class="" style="margin-bottom:0px;" action="updateCekKehadiranPembimbing2Sempro.php" method="post">
                            <input type="text" class="sr-only" name="id" value="<?php echo $id;?>">
                            <select name='cekhadir2' class='form-control input-sm' onchange='this.form.submit();' required>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_cek_kehadiran_penguji ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $djdwl['cekhadir2'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                            </select>
                          </form>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerAdm.php";?>
    <?php include "jsSourceAdm.php";?>
  </body>
</html>