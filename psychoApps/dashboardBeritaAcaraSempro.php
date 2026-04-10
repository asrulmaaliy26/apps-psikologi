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
                  <li class="breadcrumb-item active small">Seminar Proposal Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dashboardBeritaAcaraSempro.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT ju.id
          , ju.id_sempro
          , ju.id_pendaftaran
          , ju.penguji1
          , ju.penguji2
          , ju.tgl_seminar
          , ju.jam_mulai
          , ju.jam_selesai
          , ju.ruang
          
          FROM jadwal_sempro ju
          INNER JOIN peserta_sempro ps
          on ju.id_pendaftaran = ps.id
          INNER JOIN dt_mhssw dm
          on ps.nim = dm.nim
          LEFT JOIN dt_pegawai penguji1
          on ju.penguji1 = penguji1.id
          LEFT JOIN dt_pegawai penguji2
          on ju.penguji2 = penguji2.id
          LEFT JOIN dt_pegawai pembimbing1
          on ps.pembimbing1 = pembimbing1.id
          LEFT JOIN dt_pegawai pembimbing2
          on ps.pembimbing2 = pembimbing2.id
          INNER JOIN dt_ruang dr
          on ju.ruang = dr.id
          INNER JOIN nilai_sempro ns
          on ju.id_pendaftaran = ns.id_pendaftaran

          WHERE (ju.id_sempro LIKE '%$keyword%' OR ju.id_pendaftaran LIKE '%$keyword%' OR dm.nim LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR penguji1.nama LIKE '%$keyword%' OR penguji2.nama LIKE '%$keyword%' OR pembimbing1.nama LIKE '%$keyword%' OR pembimbing2.nama LIKE '%$keyword%' OR dr.nm LIKE '%$keyword%' OR ns.catatan_narsum1 LIKE '%$keyword%' OR ns.catatan_narsum2 LIKE '%$keyword%' OR ns.nilai_narsum1 LIKE '%$keyword%' OR ns.nilai_narsum2 LIKE '%$keyword%') AND (ju.penguji1=$dtDosen[id] OR ju.penguji2=$dtDosen[id]) GROUP BY ju.id ORDER BY ju.id DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dashboardBeritaAcaraSempro.php?pagination=true";
          $sql = "SELECT * FROM jadwal_sempro WHERE penguji1='$dtDosen[id]' OR penguji2='$dtDosen[id]' ORDER BY id DESC";
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
                <form method="post" action="dashboardBeritaAcaraSempro.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dashboardBeritaAcaraSempro.php"><i class="fas fa-sync"></i> Kembali</a>
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
                    <h4 class="card-title">Seminar Proposal Skripsi</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td scope="col" rowspan="2" width="4%" class="text-center pl-1">No.</td>
                            <td scope="col" rowspan="2" width="8%" class="text-center">Tgl. Seminar</td>
                            <td scope="col" rowspan="2" width="30%" class="text-center">Nama Mahasiswa</td>
                            <td scope="col" colspan="2" class="text-center border-bottom-0">Nilai</td>
                            <td scope="col" rowspan="2" width="16%" class="text-center">Rekom</td>
                            <td scope="col" rowspan="2" width="10%" class="text-center pr-1">Opsi</td>
                          </tr>
                          <tr class="text-left bg-success">
                            <td scope="col" width="16%" class="text-center pl-1">Narasumber 1</td>
                            <td scope="col" width="16%" class="text-center pr-1">Narasumber 2</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id = $data['id'];
                            
                            $qpend =  "SELECT * FROM peserta_sempro WHERE id='$data[id_pendaftaran]'";
                            $rpend = mysqli_query($con, $qpend);
                            $dpend = mysqli_fetch_array($rpend);
                            
                            $qryperiod = "SELECT * from pendaftaran_sempro WHERE id='$dpend[id_sempro]'";
                            $res = mysqli_query($con,  $qryperiod )or die( mysqli_error($con) );
                            $dperiod = mysqli_fetch_assoc( $res );
                            $id_sempro=$dperiod['id'];
                            $thp=$dperiod['tahap'];
                            $ta=$dperiod['ta'];
                            
                            $qry_pemb1 = "SELECT * FROM dt_pegawai WHERE id='$dpend[pembimbing1]'";
                            $res_pemb1 = mysqli_query($con, $qry_pemb1);
                            $dt_pemb1 = mysqli_fetch_array($res_pemb1);

                            $qry_pemb2 = "SELECT * FROM dt_pegawai WHERE id='$dpend[pembimbing2]'";
                            $res_pemb2 = mysqli_query($con, $qry_pemb2);
                            $dt_pemb2 = mysqli_fetch_array($res_pemb2);

                            $qry_grade = "SELECT * FROM grade_sempro WHERE id_sempro='$dpend[id_sempro]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);
                            
                            $sqlmhssw =  "SELECT * FROM dt_mhssw WHERE nim='$dpend[nim]'";
                            $rmhssw = mysqli_query($con, $sqlmhssw);
                            $dmhssw = mysqli_fetch_array($rmhssw);
                            
                            $qnarsum1 =  "SELECT * FROM dt_pegawai WHERE id='$data[penguji1]'";
                            $rnarsum1 = mysqli_query($con, $qnarsum1);
                            $dnarsum1 = mysqli_fetch_array($rnarsum1);                        
                            
                            $qnarsum2 =  "SELECT * FROM dt_pegawai WHERE id='$data[penguji2]'";
                            $rnarsum2 = mysqli_query($con, $qnarsum2);
                            $dnarsum2 = mysqli_fetch_array($rnarsum2);

                            $qruang = "SELECT * from dt_ruang WHERE id='$data[ruang]'";
                            $resp = mysqli_query($con,  $qruang )or die( mysqli_error($con) );
                            $druang = mysqli_fetch_assoc( $resp );

                            $tanggal=date("d-m-Y", strtotime($data['tgl_seminar']));
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
                            
                            $qnilai =  "SELECT * FROM nilai_sempro WHERE id_pendaftaran='$data[id_pendaftaran]'";
                            $rnilai = mysqli_query($con, $qnilai);
                            $dnilai = mysqli_fetch_array($rnilai);
                            
                            if($dnilai['nilai_narsum1']=='0' && $dnilai['nilai_narsum2']!='0') {$nilaiakhir = $dnilai['nilai_narsum2'] / 1;}
                            elseif($dnilai['nilai_narsum1']!='0' && $dnilai['nilai_narsum2']=='0') {$nilaiakhir = $dnilai['nilai_narsum1'] / 1;}
                            elseif($dnilai['nilai_narsum1']=='0' && $dnilai['nilai_narsum2']=='0') {$nilaiakhir = ($dnilai['nilai_narsum1'] + $dnilai['nilai_narsum2']) / 2;}
                            elseif($dnilai['nilai_narsum1']!='0' && $dnilai['nilai_narsum2']!='0') {$nilaiakhir = ($dnilai['nilai_narsum1'] + $dnilai['nilai_narsum2']) / 2;}
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-center"><?php echo $data['tgl_seminar'];?></td>
                            <td class="text-left"><?php $allowedlimit = 25; if(mb_strlen($dmhssw['nama'])>$allowedlimit) { echo mb_substr($dmhssw['nama'],0,$allowedlimit)."...".' ['.$dmhssw['nim'].']';} else {echo  $dmhssw['nama'].' ['.$dmhssw['nim'].']';}?></td>
                            <td <?php if($dtDosen['id'] == $data['penguji1']) {echo 'class="text-center pl-1 bg-light"';} else {echo 'class="text-center pl-1"';}?>><?php include ("meanNilaiNarsum1Sempro.php");?></td>
                            <td <?php if($dtDosen['id'] == $data['penguji2']) {echo 'class="text-center pr-1 bg-light"';} else {echo 'class="text-center pr-1"';}?>><?php include ("meanNilaiNarsum2Sempro.php");?>
                            </td>
                            <td class="text-center"><?php include ("meanNilaiSempro.php");?></td>
                            <td class="text-center pr-1">
                              <?php 
                                if(empty($data['tgl_seminar']) && empty($data['jam_mulai']) && empty($data['jam_selesai']) && empty($data['ruang'])) { echo "<button role='button' class='btn btn-outline-secondary btn-xs btn-block' title='Belum terjadwal' disabled><span class='glyphicon glyphicon-ban-circle'></span> Belum Terjadwal</button>";}
                                else if($dnilai['validasi']==1 && $data['penguji1'] == $dtDosen['id']) { echo "<a href='baSemproSkripsiPenguji1.php?page=$page&id=$data[id]' role='button' class='btn btn-outline-secondary btn-xs btn-block'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else if($dnilai['validasi']==1 && $data['penguji2'] == $dtDosen['id']) { echo "<a href='baSemproSkripsiPenguji2.php?page=$page&id=$data[id]' class='btn btn-outline-secondary btn-block btn-xs' title='Isi atau edit berita acara'><span class='glyphicon glyphicon-list-alt'></span> Isi atau Edit</a>";}
                                else { echo "<button class='btn btn-success btn-block btn-xs' title='Tervalidasi' disabled><span class='glyphicon glyphicon-check'></span> Tervalidasi</button>";}
                                ?>                              
                            </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="7">
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
                                        <th class="pl-1">Judul Proposal Skripsi</th>
                                        <td>:</td>
                                        <td><?php echo $dpend['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dpend['judul_prop']);?></td>
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
                                        <th class="pl-1">Hari, Tanggal dan Pukul Seminar</th>
                                        <td>:</td>
                                        <td><?php echo $dayList[$day].', '.bulanIndo($data['tgl_seminar']).', '.$data['jam_mulai'].' - '.$data['jam_selesai'].' WIB.';?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Narasumber 1</th>
                                        <td>:</td>
                                        <td><?php echo $dnarsum1['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Narasumber 2</th>
                                        <td>:</td>
                                        <td><?php echo $dnarsum2['nama'];?></td>
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