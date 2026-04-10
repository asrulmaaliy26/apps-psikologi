<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $myquery = "SELECT * FROM dt_pegawai WHERE id='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dtDosen = mysqli_fetch_assoc($d);
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
                  <li class="breadcrumb-item active small">Ujian Tesis</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dashboardBeritaAcaraUjTes.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT ju.id
          , ju.id_ujtes
          , ju.nim
          , ju.id_pendaftaran
          , ju.penguji1
          , ju.penguji2
          , ju.penguji3
          , ju.penguji4
          , ju.cekhadir1
          , ju.cekhadir2
          , ju.cekhadir3
          , ju.cekhadir4
          , ju.tgl_ujian
          , ju.jam_mulai
          , ju.jam_selesai
          , ju.ruang
          
          FROM mag_jadwal_ujtes ju
          INNER JOIN mag_peserta_ujtes pu
          on ju.id_pendaftaran = pu.id
          INNER JOIN mag_dt_mhssw_pasca dm
          on pu.nim = dm.nim
          LEFT JOIN dt_pegawai penguji1
          on ju.penguji1 = penguji1.id
          LEFT JOIN dt_pegawai penguji2
          on ju.penguji2 = penguji2.id
          LEFT JOIN dt_pegawai penguji3
          on ju.penguji3 = penguji3.id
          LEFT JOIN dt_pegawai penguji4
          on ju.penguji4 = penguji4.id
          LEFT JOIN mag_opsi_cek_kehadiran_penguji cekhadir1
          on ju.cekhadir1 = cekhadir1.id
          LEFT JOIN mag_opsi_cek_kehadiran_penguji cekhadir2
          on ju.cekhadir2 = cekhadir2.id
          LEFT JOIN mag_opsi_cek_kehadiran_penguji cekhadir3
          on ju.cekhadir3 = cekhadir3.id
          LEFT JOIN mag_opsi_cek_kehadiran_penguji cekhadir4
          on ju.cekhadir4 = cekhadir4.id                          
          LEFT JOIN dt_pegawai dospem_tesis1
          on pu.dospem_tesis1 = dospem_tesis1.id
          LEFT JOIN dt_pegawai dospem_tesis2
          on pu.dospem_tesis2 = dospem_tesis2.id
          INNER JOIN dt_ruang dr
          on ju.ruang = dr.id
          INNER JOIN mag_nilai_ujtes nu
          on ju.id_pendaftaran = nu.id_pendaftaran

          WHERE (ju.id_ujtes LIKE '%$keyword%' OR ju.nim LIKE '%$keyword%' OR ju.id_pendaftaran LIKE '%$keyword%' OR dm.nim LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR penguji1.nama LIKE '%$keyword%' OR penguji2.nama LIKE '%$keyword%' OR penguji3.nama LIKE '%$keyword%' OR penguji4.nama LIKE '%$keyword%' OR cekhadir1.nm LIKE '%$keyword%' OR cekhadir2.nm LIKE '%$keyword%' OR cekhadir3.nm LIKE '%$keyword%' OR cekhadir4.nm LIKE '%$keyword%' OR dospem_tesis1.nama LIKE '%$keyword%' OR dospem_tesis2.nama LIKE '%$keyword%' OR dr.nm LIKE '%$keyword%' OR nu.catatan_penguji1_1 LIKE '%$keyword%' OR nu.catatan_penguji1_2 LIKE '%$keyword%' OR nu.catatan_penguji1_3 LIKE '%$keyword%' OR nu.catatan_penguji1_4 LIKE '%$keyword%' OR nu.catatan_penguji1_5 LIKE '%$keyword%' OR nu.catatan_penguji1_6 LIKE '%$keyword%' OR nu.catatan_penguji1_7 LIKE '%$keyword%' OR nu.catatan_penguji2_1 LIKE '%$keyword%' OR nu.catatan_penguji2_2 LIKE '%$keyword%' OR nu.catatan_penguji2_3 LIKE '%$keyword%' OR nu.catatan_penguji2_4 LIKE '%$keyword%' OR nu.catatan_penguji2_5 LIKE '%$keyword%' OR nu.catatan_penguji2_6 LIKE '%$keyword%' OR nu.catatan_penguji2_7 LIKE '%$keyword%' OR nu.catatan_penguji3_1 LIKE '%$keyword%' OR nu.catatan_penguji3_2 LIKE '%$keyword%' OR nu.catatan_penguji3_3 LIKE '%$keyword%' OR nu.catatan_penguji3_4 LIKE '%$keyword%' OR nu.catatan_penguji3_5 LIKE '%$keyword%' OR nu.catatan_penguji3_6 LIKE '%$keyword%' OR nu.catatan_penguji3_7 LIKE '%$keyword%' OR nu.catatan_penguji4_1 LIKE '%$keyword%' OR nu.catatan_penguji4_2 LIKE '%$keyword%' OR nu.catatan_penguji4_3 LIKE '%$keyword%' OR nu.catatan_penguji4_4 LIKE '%$keyword%' OR nu.catatan_penguji4_5 LIKE '%$keyword%' OR nu.catatan_penguji4_6 LIKE '%$keyword%' OR nu.catatan_penguji4_7 LIKE '%$keyword%' OR nu.mean_nilai_penguji1 LIKE '%$keyword%' OR nu.mean_nilai_penguji2 LIKE '%$keyword%' OR nu.mean_nilai_penguji3 LIKE '%$keyword%' OR nu.mean_nilai_penguji4 LIKE '%$keyword%') AND (ju.penguji1=$dtDosen[id] OR ju.penguji2=$dtDosen[id] OR ju.penguji3=$dtDosen[id] OR ju.penguji4=$dtDosen[id]) GROUP BY ju.id ORDER BY ju.id DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dashboardBeritaAcaraUjTes.php?pagination=true";
          $sql = "SELECT * FROM mag_jadwal_ujtes WHERE penguji1='$dtDosen[id]' OR penguji2='$dtDosen[id]' OR penguji3='$dtDosen[id]' OR penguji4='$dtDosen[id]' ORDER BY id DESC";
          $result = mysqli_query($con, $sql);
          }
          
          $rpp = 20;
          $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
          $tcount = mysqli_num_rows($result);
          $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
          $count = 0;
          $i = ($page-1)*$rpp;
          $no_urut = ($page-1)*$rpp;
          ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm mb-2">
                <form method="post" action="dashboardBeritaAcaraUjTes.php">
                  <?php  error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){
                        ?>
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dashboardBeritaAcaraUjTes.php"><i class="fas fa-sync"></i> Kembali</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Ujian Tesis</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td scope="col" rowspan="2" width="4%" class="text-center pl-1">No.</td>
                            <td scope="col" rowspan="2" width="8%" class="text-center">Tgl. Ujian</td>
                            <td scope="col" rowspan="2" width="23%" class="text-center">Nama Mahasiswa</td>
                            <td scope="col" colspan="4" class="text-center border-bottom-0">Nilai</td>
                            <td scope="col" rowspan="2" width="11%" class="text-center">Nilai Akhir</td>
                            <td scope="col" rowspan="2" width="10%" class="text-center pr-1">Opsi</td>
                          </tr>
                          <tr class="text-left bg-success">
                            <td scope="col" width="11%" class="text-center pl-1">Penguji Utama</td>
                            <td scope="col" width="11%" class="text-center">Ketua Penguji</td>
                            <td scope="col" width="11%" class="text-center"><small>Anggota Penguji I</small></td>
                            <td scope="col" width="11%" class="text-center pr-1"><small>Anggota Penguji II</small></td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id = $data['id'];
                            
                            $qpend =  "SELECT * FROM mag_peserta_ujtes WHERE id='$data[id_pendaftaran]'";
                            $rpend = mysqli_query($con, $qpend);
                            $dpend = mysqli_fetch_array($rpend);
                            
                            $qryperiod = "SELECT * from mag_periode_pendaftaran_ujtes WHERE id='$dpend[id_ujtes]'";
                            $res = mysqli_query($con,  $qryperiod )or die( mysqli_error($con) );
                            $dperiod = mysqli_fetch_assoc( $res );
                            $id_ujtes=$dperiod['id'];
                            $thp=$dperiod['tahap'];
                            $ta=$dperiod['ta'];
                            
                            $qry_pemb1 = "SELECT * FROM dt_pegawai WHERE id='$dpend[dospem_tesis1]'";
                            $res_pemb1 = mysqli_query($con, $qry_pemb1);
                            $dt_pemb1 = mysqli_fetch_array($res_pemb1);

                            $qry_pemb2 = "SELECT * FROM dt_pegawai WHERE id='$dpend[dospem_tesis2]'";
                            $res_pemb2 = mysqli_query($con, $qry_pemb2);
                            $dt_pemb2 = mysqli_fetch_array($res_pemb2);

                            $qry_grade = "SELECT * FROM mag_grade_ujtes WHERE id_ujtes='$dpend[id_ujtes]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);
                            
                            $sqlmhssw =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$dpend[nim]'";
                            $rmhssw = mysqli_query($con, $sqlmhssw);
                            $dmhssw = mysqli_fetch_array($rmhssw);
                            
                            $qpenguji1 =  "SELECT * FROM dt_pegawai WHERE id='$data[penguji1]'";
                            $rpenguji1 = mysqli_query($con, $qpenguji1);
                            $dpenguji1 = mysqli_fetch_array($rpenguji1);

                            $qpenguji2 =  "SELECT * FROM dt_pegawai WHERE id='$data[penguji2]'";
                            $rpenguji2 = mysqli_query($con, $qpenguji2);
                            $dpenguji2 = mysqli_fetch_array($rpenguji2);

                            $qpenguji3 =  "SELECT * FROM dt_pegawai WHERE id='$data[penguji3]'";
                            $rpenguji3 = mysqli_query($con, $qpenguji3);
                            $dpenguji3 = mysqli_fetch_array($rpenguji3);

                            $qpenguji4 =  "SELECT * FROM dt_pegawai WHERE id='$data[penguji4]'";
                            $rpenguji4 = mysqli_query($con, $qpenguji4);
                            $dpenguji4 = mysqli_fetch_array($rpenguji4);

                            $qruang = "SELECT * from dt_ruang WHERE id='$data[ruang]'";
                            $resp = mysqli_query($con,  $qruang )or die( mysqli_error($con) );
                            $druang = mysqli_fetch_assoc( $resp );

                            $tanggal=date("d-m-Y", strtotime($data['tgl_ujian']));
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
                            include_once("month_function_3.php");
                            
                            $qnilai =  "SELECT * FROM mag_nilai_ujtes WHERE id_pendaftaran='$data[id_pendaftaran]'";
                            $rnilai = mysqli_query($con, $qnilai);
                            $dnilai = mysqli_fetch_array($rnilai);
                            
                            if($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']!='0' && $dnilai['mean_nilai_penguji3']!='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji3'] + $dnilai['mean_nilai_penguji4']) / 3;}
                            elseif($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']!='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji3'] + $dnilai['mean_nilai_penguji4']) / 2;}
                            elseif($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji4']) / 1;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1']) / 1;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']!='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji2']) / 2;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']!='0' && $dnilai['mean_nilai_penguji3']!='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji3']) / 3;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']!='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji3'] + $dnilai['mean_nilai_penguji4']) / 3;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']!='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji4']) / 3;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji4']) / 2;}
                            elseif($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']!='0' && $dnilai['mean_nilai_penguji3']!='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji3']) / 2;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']!='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji3']) / 2;}
                            elseif($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']!='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji4']) / 2;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1']) / 1;}
                            elseif($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']!='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji2']) / 1;}
                            elseif($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']!='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji3']) / 1;}
                            elseif($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji4']) / 1;}
                            elseif($dnilai['mean_nilai_penguji1']=='0' && $dnilai['mean_nilai_penguji2']=='0' && $dnilai['mean_nilai_penguji3']=='0' && $dnilai['mean_nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji3'] + $dnilai['mean_nilai_penguji4']) / 4;}
                            elseif($dnilai['mean_nilai_penguji1']!='0' && $dnilai['mean_nilai_penguji2']!='0' && $dnilai['mean_nilai_penguji3']!='0' && $dnilai['mean_nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji3'] + $dnilai['mean_nilai_penguji4']) / 4;}
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-center"><?php echo $data['tgl_ujian'];?></td>
                            <td class="text-left"><?php $allowedlimit = 14; if(mb_strlen($dmhssw['nama'])>$allowedlimit) { echo mb_substr($dmhssw['nama'],0,$allowedlimit)."...".' ['.$dmhssw['nim'].']';} else {echo  $dmhssw['nama'].' ['.$dmhssw['nim'].']';}?></td>
                            <td <?php if($dtDosen['id'] == $data['penguji3']) {echo 'class="text-center pl-1 bg-light"';} else {echo 'class="text-center pl-1"';}?>><?php include ("meanNilaiPenguji3UjTes.php");?>
                            </td>
                            <td <?php if($dtDosen['id'] == $data['penguji4']) {echo 'class="text-center bg-light"';} else {echo 'class="text-center"';}?>><?php include ("meanNilaiPenguji4UjTes.php");?>
                            </td>
                            <td <?php if($dtDosen['id'] == $data['penguji1']) {echo 'class="text-center bg-light"';} else {echo 'class="text-center"';}?>><?php include ("meanNilaiPenguji1UjTes.php");?>
                            </td>
                            <td <?php if($dtDosen['id'] == $data['penguji2']) {echo 'class="text-center pr-1 bg-light"';} else {echo 'class="text-center pr-1"';}?>><?php include ("meanNilaiPenguji2UjTes.php");?>
                            </td>
                            <td class="text-center"><?php include ("meanNilaiUjTes.php");?></td>
                            <td class="text-center pr-1">
                              <?php
                                if($data['cekhadir1']==2 && $data['penguji1'] == $dtDosen['id']) { echo "<button class='btn btn-danger btn-block btn-sm' title='Anda tidak hadir dalam ujian ini' disabled><span class='glyphicon glyphicon-ban-circle'></span> Tidak Hadir</button>";}
                                else if($data['cekhadir2']==2 && $data['penguji2'] == $dtDosen['id']) { echo "<button class='btn btn-danger btn-block btn-sm' title='Anda tidak hadir dalam ujian ini' disabled><span class='glyphicon glyphicon-ban-circle'></span> Tidak Hadir</button>";}
                                else if($data['cekhadir3']==2 && $data['penguji3'] == $dtDosen['id']) { echo "<button class='btn btn-danger btn-block btn-sm' title='Anda tidak hadir dalam ujian ini' disabled><span class='glyphicon glyphicon-ban-circle'></span> Tidak Hadir</button>";}
                                else if($data['cekhadir4']==2 && $data['penguji4'] == $dtDosen['id']) { echo "<button class='btn btn-danger btn-block btn-sm' title='Anda tidak hadir dalam ujian ini' disabled><span class='glyphicon glyphicon-ban-circle'></span> Tidak Hadir</button>";}
                                else if (empty($data['tgl_ujian']) && empty($data['jam_mulai']) && empty($data['jam_selesai']) && empty($data['ruang'])) { echo "<button role='button' class='btn btn-outline-secondary btn-xs btn-block' title='Belum terjadwal' disabled><span class='glyphicon glyphicon-ban-circle'></span> Belum Terjadwal</button>";}
                                else if($dnilai['validasi']==1 && $data['penguji3'] == $dtDosen['id']) { echo "<a href='ba1UjianTesisPenguji3.php?page=$page&id=$data[id]' role='button' class='btn btn-outline-secondary btn-xs btn-block'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else if($dnilai['validasi']==1 && $data['penguji4'] == $dtDosen['id']) { echo "<a href='ba1UjianTesisPenguji4.php?page=$page&id=$data[id]' class='btn btn-outline-secondary btn-block btn-xs' title='Isi atau edit berita acara'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else if($dnilai['validasi']==1 && $data['penguji1'] == $dtDosen['id']) { echo "<a href='ba1UjianTesisPenguji1.php?page=$page&id=$data[id]' class='btn btn-outline-secondary btn-block btn-xs' title='Isi atau edit berita acara'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else if($dnilai['validasi']==1 && $data['penguji2'] == $dtDosen['id']) { echo "<a href='ba1UjianTesisPenguji2.php?page=$page&id=$data[id]' class='btn btn-outline-secondary btn-block btn-xs' title='Isi atau edit berita acara'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else { echo "<button class='btn btn-success btn-block btn-xs' title='Tervalidasi' disabled><span class='glyphicon glyphicon-check'></span> Tervalidasi</button>";}
                                ?>                              
                            </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="9">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table no-border rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="22%" class="pl-1">Nama Lengkap</th>
                                        <td width="4%">:</td>
                                        <td width="74%"><?php echo $dmhssw['nama'].' ['.$dmhssw['nim'].']';?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Judul Tesis</th>
                                        <td>:</td>
                                        <td><?php echo $dpend['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dpend['judul_tesis']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Pembimbing 1</th>
                                        <td>:</td>
                                        <td><?php echo $dt_pemb1['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Pembimbing 2</th>
                                        <td>:</td>
                                        <td><?php echo $dt_pemb2['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Hari, Tanggal dan Pukul Ujian</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['tgl_ujian'])) { echo "";} else {echo $dayList[$day].', '.bulanIndo($data['tgl_ujian']).', '.$data['jam_mulai'].' - '.$data['jam_selesai'].' WIB.';}?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Penguji Utama</th>
                                        <td>:</td>
                                        <td><?php echo $dpenguji3['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Ketua Penguji</th>
                                        <td>:</td>
                                        <td><?php echo $dpenguji4['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Anggota Penguji I</th>
                                        <td>:</td>
                                        <td><?php echo $dpenguji1['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Anggota Penguji II</th>
                                        <td>:</td>
                                        <td><?php echo $dpenguji2['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Ruang Ujian</th>
                                        <td>:</td>
                                        <td><?php echo $druang['nm'];?></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <?php
                            $i++; 
                            $count++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="float-right"><?php echo paginate_one($reload, $page, $tpages);?></div>
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