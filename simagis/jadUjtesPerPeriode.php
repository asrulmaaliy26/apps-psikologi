<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  		  
   $id_ujtes = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
   $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 2;
   $qryperiod = "select * from mag_periode_pendaftaran_ujtes WHERE id='$id_ujtes'";
   $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dperiod = mysqli_fetch_assoc($rperiod);
   $tahap = $dperiod['tahap'];
   $ta = $dperiod['ta'];
   
   $qry_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$tahap'";
   $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_thp);
   $dthp = mysqli_fetch_assoc($hasil);
   
   $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
   $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
   $dnta = mysqli_fetch_assoc($hasil);
   
   $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
   $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
   $dsemester = mysqli_fetch_assoc($h); 
   
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
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                           echo '
                    <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Submit gagal</h4>
                    </div>
                    <div class="modal-body">
                    <p>Salah satu atau semua file yang diupload bukan berbentuk PDF (berekstensi .pdf).</p>
                    <p><strong>Note:</strong> Konversikan file ke PDF terlebih dahulu...</p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                    </div>
                    </div>';} 
          		  
          			 if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                         echo '<div class="alert alert-success custom-alert" role="alert">
                         <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}	
                         if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
                         echo '<div class="alert alert-success custom-alert" role="alert">
                         <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}		 
                           ?>
        <h3 class="text-center text-warning">Ujian Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Jadwal Ujian Tesis <?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan tekan button print untuk mencetak jadwal dan berita acara.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPendUjtesAdm.php?page=<?php echo "$page";?>">Periode Pendaftaran</a></li>
                  <li role="presentation" class="active"><a>Jadwal Ujian</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <?php
                  $sql =  "SELECT * FROM mag_jadwal_ujtes WHERE id_ujtes='$id_ujtes' GROUP BY tgl_ujian ORDER BY tgl_ujian ASC";
                  $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                  while($data = mysqli_fetch_array($result)) {
                  
                  $formatTgl=date("d-m-Y", strtotime($data['tgl_ujian']));
                  $day = date('D', strtotime($formatTgl));
                  $dayList = array(
                  'Sun' => 'Minggu',
                  'Mon' => 'Senin',
                  'Tue' => 'Selasa',
                  'Wed' => 'Rabu',
                  'Thu' => 'Kamis',
                  'Fri' => "Jum'at",
                  'Sat' => 'Sabtu'
                  );
                     $qruang = "select * from dt_ruang WHERE id='$data[ruang]'";
                     $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qruang )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                     $druang = mysqli_fetch_assoc( $resp );
                  include("tableHariRuangUjtes.php");
                  include("extConJadUjtes.php");'
                  ';}?>      
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