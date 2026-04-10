<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $myquery = "SELECT * FROM dt_pegawai WHERE id='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dtDosen = mysqli_fetch_assoc($d);
  
  $qNim = "SELECT nim FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dtDosen[id]'";
  $dNim = mysqli_query($con, $qNim)or die( mysqli_error($con));
  $dtNim = mysqli_fetch_assoc($dNim);

  $qJml = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dtDosen[id]'";
  $rJml =  mysqli_query($con, $qJml) or die(mysqli_error($con));
  $dJml = mysqli_fetch_assoc($rJml) or die(mysqli_error($con));
  $jData = $dJml['jumData'];

  $qJmlProses = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dtDosen[id]' AND nim IN(SELECT nim FROM peserta_ujskrip WHERE nim='$dtNim[nim]')";
  $rJmlProses =  mysqli_query($con, $qJmlProses) or die(mysqli_error($con));
  $dJmlProses = mysqli_fetch_assoc($rJmlProses) or die(mysqli_error($con));
  $jDataProses = $dJmlProses['jumData'];

  $qJmlUjskrip = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dtDosen[id]' AND nim NOT IN(SELECT nim FROM peserta_ujskrip WHERE nim='$dtNim[nim]')";
  $rJmlUjskrip =  mysqli_query($con, $qJmlUjskrip) or die(mysqli_error($con));
  $dJmlUjskrip = mysqli_fetch_assoc($rJmlUjskrip) or die(mysqli_error($con));
  $jDataUjskrip = $dJmlUjskrip['jumData'];
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
                <h4 class="mb-0">Rekap Pembimbingan</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Pembimbing II Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "pembimbingSkripsi2.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT pds.id
          , pds.nim
          , pds.dospem_skripsi1
          , pds.dospem_skripsi2
          
          FROM pengelompokan_dospem_skripsi pds
          LEFT JOIN peserta_sempro ps
          on pds.nim = ps.nim
          LEFT JOIN dt_mhssw dm
          on pds.nim = dm.nim
          LEFT JOIN dt_pegawai dospem_skripsi1
          on pds.dospem_skripsi1 = dospem_skripsi1.id
          LEFT JOIN dt_pegawai dospem_skripsi2
          on pds.dospem_skripsi2 = dospem_skripsi2.id
          
          WHERE (pds.nim LIKE '%$keyword%' OR dm.nim LIKE '%$keyword%' OR ps.nim LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR dospem_skripsi2.nama LIKE '%$keyword%') AND (pds.dospem_skripsi2=$dtDosen[id]) ORDER BY dm.nama ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "pembimbingSkripsi2.php?pagination=true";
          $sql = "SELECT * FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dtDosen[id]' ORDER BY id DESC";
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
                <form method="post" action="pembimbingSkripsi2.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="pembimbingSkripsi2.php"><i class="fas fa-sync"></i> Kembali</a>
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
                    <h4 class="card-title">Pembimbing II Skripsi</h4>
                    <div class="card-tools">
                      <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                          <a class="nav-link active" href="">Semua (<?php echo $jData;?>)</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="pembimbingSkripsi2Proses.php">Proses (<?php echo $jDataProses;?>)</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="pembimbingSkripsi2Selesai.php">Selesai (<?php echo $jDataUjskrip;?>)</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td scope="col" width="4%" class="text-center pl-1">No.</td>
                            <td scope="col" width="96%" class="text-center pr-1">Nama Mahasiswa</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id = $data['id'];
                            
                            $qpend =  "SELECT * FROM peserta_sempro WHERE nim='$data[nim]'";
                            $rpend = mysqli_query($con, $qpend);
                            $dpend = mysqli_fetch_array($rpend);
                            
                            $qjdwl =  "SELECT * FROM jadwal_sempro WHERE id_pendaftaran='$dpend[id]'";
                            $rjdwl = mysqli_query($con, $qjdwl);
                            $djdwl = mysqli_fetch_array($rjdwl);
                            
                            $qryperiod = "SELECT * from pendaftaran_sempro WHERE id='$dpend[id_sempro]'";
                            $res = mysqli_query($con,  $qryperiod )or die( mysqli_error($con) );
                            $dperiod = mysqli_fetch_assoc( $res );
                            $id_sempro=$dperiod['id'];
                            $thp=$dperiod['tahap'];
                            $ta=$dperiod['ta'];
                            
                            $qry_pemb1 = "SELECT * FROM dt_pegawai WHERE id='$data[dospem_skripsi1]'";
                            $res_pemb1 = mysqli_query($con, $qry_pemb1);
                            $dt_pemb1 = mysqli_fetch_array($res_pemb1);
                            
                            $qry_pemb2 = "SELECT * FROM dt_pegawai WHERE id='$data[dospem_skripsi2]'";
                            $res_pemb2 = mysqli_query($con, $qry_pemb2);
                            $dt_pemb2 = mysqli_fetch_array($res_pemb2);
                            
                            $qry_grade = "SELECT * FROM grade_sempro WHERE id_sempro='$dpend[id_sempro]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);
                            
                            $sqlmhssw =  "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rmhssw = mysqli_query($con, $sqlmhssw);
                            $dmhssw = mysqli_fetch_array($rmhssw);
                            
                            $qnarsum1 =  "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji1]'";
                            $rnarsum1 = mysqli_query($con, $qnarsum1);
                            $dnarsum1 = mysqli_fetch_array($rnarsum1);                        
                            
                            $qnarsum2 =  "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji2]'";
                            $rnarsum2 = mysqli_query($con, $qnarsum2);
                            $dnarsum2 = mysqli_fetch_array($rnarsum2);
                            
                            $qruang = "SELECT * from dt_ruang WHERE id='$djdwl[ruang]'";
                            $resp = mysqli_query($con,  $qruang )or die( mysqli_error($con) );
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
                            include_once("month_function.php");
                            
                            $qnilai =  "SELECT * FROM nilai_sempro WHERE id_pendaftaran='$dpend[id]'";
                            $rnilai = mysqli_query($con, $qnilai);
                            $dnilai = mysqli_fetch_array($rnilai);
                            
                            if($dnilai['nilai_narsum1']=='0' && $dnilai['nilai_narsum2']!='0') {$nilaiakhir = $dnilai['nilai_narsum2'] / 1;}
                            elseif($dnilai['nilai_narsum1']!='0' && $dnilai['nilai_narsum2']=='0') {$nilaiakhir = $dnilai['nilai_narsum1'] / 1;}
                            elseif($dnilai['nilai_narsum1']=='0' && $dnilai['nilai_narsum2']=='0') {$nilaiakhir = ($dnilai['nilai_narsum1'] + $dnilai['nilai_narsum2']) / 2;}
                            elseif($dnilai['nilai_narsum1']!='0' && $dnilai['nilai_narsum2']!='0') {$nilaiakhir = ($dnilai['nilai_narsum1'] + $dnilai['nilai_narsum2']) / 2;}
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left pr-1"><?php echo  $dmhssw['nama'].' ['.$dmhssw['nim'].']';?></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="2">
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
                                        <td><?php if(empty($djdwl['tgl_seminar']) && empty($djdwl['jam_mulai']) && empty($djdwl['jam_selesai']) && empty($djdwl['ruang'])) { echo "Belum terjadwal";} else { echo $dayList[$day].', '.bulanIndo($djdwl['tgl_seminar']).', '.$djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'].' WIB.';}?></td>
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
                                        <th class="pl-1">Ruang Seminar</th>
                                        <td>:</td>
                                        <td><?php echo $druang['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Nilai Seminar</th>
                                        <td>:</td>
                                        <td><?php include ("meanNilaiSempro.php");?></td>
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