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
                  <li class="breadcrumb-item active small">Ujian Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dashboardBeritaAcaraUjskrip.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT ju.id
          , ju.id_ujskrip
          , ju.id_pendaftaran
          , ju.sekretaris_penguji
          , ju.penguji_utama
          , ju.ketua_penguji
          , ju.tgl_ujian
          , ju.jam_mulai
          , ju.jam_selesai
          , ju.ruang
          
          FROM jadwal_ujskrip ju
          INNER JOIN peserta_ujskrip pu
          on ju.id_pendaftaran = pu.id
          INNER JOIN dt_mhssw dm
          on pu.nim = dm.nim
          LEFT JOIN dt_pegawai sekretaris_penguji
          on ju.sekretaris_penguji = sekretaris_penguji.id
          LEFT JOIN dt_pegawai penguji_utama
          on ju.penguji_utama = penguji_utama.id
          LEFT JOIN dt_pegawai ketua_penguji
          on ju.ketua_penguji = ketua_penguji.id
          LEFT JOIN dt_pegawai pembimbing1
          on pu.pembimbing1 = pembimbing1.id
          LEFT JOIN dt_pegawai pembimbing2
          on pu.pembimbing2 = pembimbing2.id
          INNER JOIN dt_ruang dr
          on ju.ruang = dr.id
          INNER JOIN nilai_ujskrip nu
          on ju.id_pendaftaran = nu.id_pendaftaran

          WHERE (ju.id_ujskrip LIKE '%$keyword%' OR ju.id_pendaftaran LIKE '%$keyword%' OR dm.nim LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR sekretaris_penguji.nama LIKE '%$keyword%' OR penguji_utama.nama LIKE '%$keyword%' OR ketua_penguji.nama LIKE '%$keyword%' OR pembimbing1.nama LIKE '%$keyword%' OR pembimbing2.nama LIKE '%$keyword%' OR dr.nm LIKE '%$keyword%' OR nu.catatan_sekretaris LIKE '%$keyword%' OR nu.catatan_ketua LIKE '%$keyword%' OR nu.catatan_utama LIKE '%$keyword%' OR nu.nilai_sekretaris LIKE '%$keyword%' OR nu.nilai_ketua LIKE '%$keyword%' OR nu.nilai_utama LIKE '%$keyword%') AND (ju.sekretaris_penguji=$dtDosen[id] OR ju.ketua_penguji=$dtDosen[id] OR ju.penguji_utama=$dtDosen[id]) GROUP BY ju.id ORDER BY ju.id DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dashboardBeritaAcaraUjskrip.php?pagination=true";
          $sql = "SELECT * FROM jadwal_ujskrip WHERE sekretaris_penguji='$dtDosen[id]' OR ketua_penguji='$dtDosen[id]' OR penguji_utama='$dtDosen[id]' ORDER BY id DESC";
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
                <form method="post" action="dashboardBeritaAcaraUjskrip.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dashboardBeritaAcaraUjskrip.php"><i class="fas fa-sync"></i> Kembali</a>
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
                    <h4 class="card-title">Ujian Skripsi</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td scope="col" rowspan="2" width="4%" class="text-center pl-1">No.</td>
                            <td scope="col" rowspan="2" width="8%" class="text-center">Tgl. Ujian</td>
                            <td scope="col" rowspan="2" width="30%" class="text-center">Nama Mahasiswa</td>
                            <td scope="col" colspan="3" class="text-center border-bottom-0">Nilai</td>
                            <td scope="col" rowspan="2" width="10%" class="text-center">Nilai Akhir</td>
                            <td scope="col" rowspan="2" width="10%" class="text-center pr-1">Opsi</td>
                          </tr>
                          <tr class="text-left bg-success">
                            <td scope="col" width="12%" class="text-center pl-1">Sekretaris Penguji</td>
                            <td scope="col" width="12%" class="text-center">Ketua Penguji</td>
                            <td scope="col" width="12%" class="text-center pr-1">Penguji Utama</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id = $data['id'];
                            
                            $qpend =  "SELECT * FROM peserta_ujskrip WHERE id='$data[id_pendaftaran]'";
                            $rpend = mysqli_query($con, $qpend);
                            $dpend = mysqli_fetch_array($rpend);
                            
                            $qryperiod = "SELECT * from pendaftaran_skripsi WHERE id='$dpend[id_ujskrip]'";
                            $res = mysqli_query($con,  $qryperiod )or die( mysqli_error($con) );
                            $dperiod = mysqli_fetch_assoc( $res );
                            $id_ujskrip=$dperiod['id'];
                            $thp=$dperiod['tahap'];
                            $ta=$dperiod['ta'];
                            
                            $qry_pemb1 = "SELECT * FROM dt_pegawai WHERE id='$dpend[pembimbing1]'";
                            $res_pemb1 = mysqli_query($con, $qry_pemb1);
                            $dt_pemb1 = mysqli_fetch_array($res_pemb1);

                            $qry_pemb2 = "SELECT * FROM dt_pegawai WHERE id='$dpend[pembimbing2]'";
                            $res_pemb2 = mysqli_query($con, $qry_pemb2);
                            $dt_pemb2 = mysqli_fetch_array($res_pemb2);

                            $qry_grade = "SELECT * FROM grade_ujskrip WHERE id_ujskrip='$dpend[id_ujskrip]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);
                            
                            $sqlmhssw =  "SELECT * FROM dt_mhssw WHERE nim='$dpend[nim]'";
                            $rmhssw = mysqli_query($con, $sqlmhssw);
                            $dmhssw = mysqli_fetch_array($rmhssw);
                            
                            $qketua =  "SELECT * FROM dt_pegawai WHERE id='$data[ketua_penguji]'";
                            $rketua = mysqli_query($con, $qketua);
                            $dketua = mysqli_fetch_array($rketua);

                            $qsekretaris =  "SELECT * FROM dt_pegawai WHERE id='$data[sekretaris_penguji]'";
                            $rsekretaris = mysqli_query($con, $qsekretaris);
                            $dsekretaris = mysqli_fetch_array($rsekretaris);

                            $qutama =  "SELECT * FROM dt_pegawai WHERE id='$data[penguji_utama]'";
                            $rutama = mysqli_query($con, $qutama);
                            $dutama = mysqli_fetch_array($rutama);

                            $qruang = "SELECT * from dt_ruang WHERE id='$data[ruang]'";
                            $resp = mysqli_query($con,  $qruang )or die( mysqli_error($con) );
                            $druang = mysqli_fetch_assoc( $resp );

                            $tanggal=date("d-m-Y", strtotime($djdwl['tgl_ujian']));
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
                            include_once("month_function.php");
                            
                            $qnilai =  "SELECT * FROM nilai_ujskrip WHERE id_pendaftaran='$data[id_pendaftaran]'";
                            $rnilai = mysqli_query($con, $qnilai);
                            $dnilai = mysqli_fetch_array($rnilai);
                            
                            if($dnilai['nilai_ketua']=='0' && $dnilai['nilai_sekretaris']!='0' && $dnilai['nilai_utama']!='0') {
                            $nilaiakhir = ($dnilai['nilai_sekretaris'] + $dnilai['nilai_utama']) / 2;}
                            elseif($dnilai['nilai_ketua']=='0' && $dnilai['nilai_sekretaris']=='0' && $dnilai['nilai_utama']!='0') {
                            $nilaiakhir = ($dnilai['nilai_utama']) / 1;}
                            elseif($dnilai['nilai_ketua']!='0' && $dnilai['nilai_sekretaris']=='0' && $dnilai['nilai_utama']=='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua']) / 1;}
                            elseif($dnilai['nilai_ketua']!='0' && $dnilai['nilai_sekretaris']!='0' && $dnilai['nilai_utama']=='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua'] + $dnilai['nilai_sekretaris']) / 2;}
                            elseif($dnilai['nilai_ketua']!='0' && $dnilai['nilai_sekretaris']=='0' && $dnilai['nilai_utama']!='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua'] + $dnilai['nilai_utama']) / 2;}
                            elseif($dnilai['nilai_ketua']!='0' && $dnilai['nilai_sekretaris']!='0' && $dnilai['nilai_utama']=='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua'] + $dnilai['nilai_sekretaris']) / 2;}
                            elseif($dnilai['nilai_ketua']!='0' && $dnilai['nilai_sekretaris']=='0' && $dnilai['nilai_utama']=='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua']) / 1;}
                            elseif($dnilai['nilai_ketua']=='0' && $dnilai['nilai_sekretaris']!='0' && $dnilai['nilai_utama']!='0') {
                            $nilaiakhir = ($dnilai['nilai_sekretaris'] + $dnilai['nilai_utama']) / 2;}
                            elseif($dnilai['nilai_ketua']!='0' && $dnilai['nilai_sekretaris']=='0' && $dnilai['nilai_utama']!='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua'] + $dnilai['nilai_utama']) / 2;}
                            elseif($dnilai['nilai_ketua']=='0' && $dnilai['nilai_sekretaris']!='0' && $dnilai['nilai_utama']=='0') {
                            $nilaiakhir = ($dnilai['nilai_sekretaris']) / 1;}
                            elseif($dnilai['nilai_ketua']!='0' && $dnilai['nilai_sekretaris']=='0' && $dnilai['nilai_utama']=='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua']) / 1;}
                            elseif($dnilai['nilai_ketua']=='0' && $dnilai['nilai_sekretaris']=='0' && $dnilai['nilai_utama']=='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua'] + $dnilai['nilai_sekretaris'] + $dnilai['nilai_utama']) / 3;}
                            elseif($dnilai['nilai_ketua']!='0' && $dnilai['nilai_sekretaris']!='0' && $dnilai['nilai_utama']!='0') {
                            $nilaiakhir = ($dnilai['nilai_ketua'] + $dnilai['nilai_sekretaris'] + $dnilai['nilai_utama']) / 3;}
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-center"><?php echo $data['tgl_ujian'];?></td>
                            <td class="text-left"><?php $allowedlimit = 20; if(mb_strlen($dmhssw['nama'])>$allowedlimit) { echo mb_substr($dmhssw['nama'],0,$allowedlimit)."...".' ['.$dmhssw['nim'].']';} else {echo  $dmhssw['nama'].' ['.$dmhssw['nim'].']';}?></td>
                            <td <?php if($dtDosen['id'] == $data['sekretaris_penguji']) {echo 'class="text-center pl-1 bg-light"';} else {echo 'class="text-center pl-1"';}?>><?php include ("meanNilaiSekretarisUjskrip.php");?>
                            </td>
                            <td <?php if($dtDosen['id'] == $data['ketua_penguji']) {echo 'class="text-center bg-light"';} else {echo 'class="text-center"';}?>><?php include ("meanNilaiKetuaUjskrip.php");?>
                            </td>
                             <td <?php if($dtDosen['id'] == $data['penguji_utama']) {echo 'class="text-center pr-1 bg-light"';} else {echo 'class="text-center pr-1"';}?>><?php include ("meanNilaiUtamaUjskrip.php");?></td>
                            <td class="text-center"><?php include ("meanNilaiUjskrip.php");?></td>
                            <td class="text-center pr-1">
                              <?php 
                                if (empty($data['tgl_ujian']) && empty($data['jam_mulai']) && empty($data['jam_selesai']) && empty($data['ruang'])) { echo "<button role='button' class='btn btn-outline-secondary btn-xs btn-block' title='Belum terjadwal' disabled><span class='glyphicon glyphicon-ban-circle'></span> Belum Terjadwal</button>";}
                                else if($dnilai['validasi']==1 && $data['sekretaris_penguji'] == $dtDosen['id']) { echo "<a href='baUjskripSekretaris.php?page=$page&id=$data[id]' role='button' class='btn btn-outline-secondary btn-xs btn-block'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else if($dnilai['validasi']==1 && $data['ketua_penguji'] == $dtDosen['id']) { echo "<a href='baUjskripKetua.php?page=$page&id=$data[id]' class='btn btn-outline-secondary btn-block btn-xs' title='Isi atau edit berita acara'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else if($dnilai['validasi']==1 && $data['penguji_utama'] == $dtDosen['id']) { echo "<a href='baUjskripUtama.php?page=$page&id=$data[id]' class='btn btn-outline-secondary btn-block btn-xs' title='Isi atau edit berita acara'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else { echo "<button class='btn btn-success btn-block btn-xs' title='Tervalidasi' disabled><span class='glyphicon glyphicon-check'></span> Tervalidasi</button>";}
                                ?>                              
                            </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="8">
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
                                        <th class="pl-1">Judul Skripsi</th>
                                        <td>:</td>
                                        <td><?php echo $dpend['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dpend['judul_skripsi']);?></td>
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
                                        <td><?php echo $dayList[$day].', '.bulanIndo($data['tgl_ujian']).', '.$data['jam_mulai'].' - '.$data['jam_selesai'].' WIB.';?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Sekretaris Penguji</th>
                                        <td>:</td>
                                        <td><?php echo $dsekretaris['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Ketua Penguji</th>
                                        <td>:</td>
                                        <td><?php echo $dketua['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Penguji Utama</th>
                                        <td>:</td>
                                        <td><?php echo $dutama['nama'];?></td>
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