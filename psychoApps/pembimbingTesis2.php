<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $myquery = "SELECT * FROM dt_pegawai WHERE id='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dtDosen = mysqli_fetch_assoc($d);
  
  $qNim = "SELECT nim FROM mag_pengelompokan_dospem_tesis WHERE nip_dospem_tesis2='$dtDosen[id]'";
  $dNim = mysqli_query($con, $qNim)or die( mysqli_error($con));
  $dtNim = mysqli_fetch_assoc($dNim);

  $qJml = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE nip_dospem_tesis2='$dtDosen[id]'";
  $rJml =  mysqli_query($con, $qJml) or die(mysqli_error($con));
  $dJml = mysqli_fetch_assoc($rJml) or die(mysqli_error($con));
  $jData = $dJml['jumData'];

  $qJmlProses = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE nip_dospem_tesis2='$dtDosen[id]' AND status='1'";
  $rJmlProses =  mysqli_query($con, $qJmlProses) or die(mysqli_error($con));
  $dJmlProses = mysqli_fetch_assoc($rJmlProses) or die(mysqli_error($con));
  $jDataProses = $dJmlProses['jumData'];

  $qJmlUjskrip = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE nip_dospem_tesis2='$dtDosen[id]' AND status='2'";
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
                  <li class="breadcrumb-item active small">Pembimbing II Tesis</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "pembimbingTesis2.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT pds.id
          , pds.nim
          , pds.nip_dospem_tesis1
          , pds.nip_dospem_tesis2
          
          FROM mag_pengelompokan_dospem_tesis pds
          LEFT JOIN mag_peserta_sempro ps
          on pds.nim = ps.nim
          LEFT JOIN mag_dt_mhssw_pasca dm
          on pds.nim = dm.nim
          LEFT JOIN dt_pegawai nip_dospem_tesis1
          on pds.nip_dospem_tesis1 = nip_dospem_tesis1.id
          LEFT JOIN dt_pegawai nip_dospem_tesis2
          on pds.nip_dospem_tesis2 = nip_dospem_tesis2.id
          
          WHERE (pds.nim LIKE '%$keyword%' OR dm.nim LIKE '%$keyword%' OR ps.nim LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR nip_dospem_tesis2.nama LIKE '%$keyword%') AND (pds.nip_dospem_tesis2=$dtDosen[id]) ORDER BY dm.nama ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "pembimbingTesis2.php?pagination=true";
          $sql = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE nip_dospem_tesis2='$dtDosen[id]' ORDER BY id DESC";
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
                <form method="post" action="pembimbingTesis2.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="pembimbingTesis2.php"><i class="fas fa-sync"></i> Kembali</a>
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
                    <h4 class="card-title">Pembimbing II Tesis</h4>
                    <div class="card-tools">
                      <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                          <a class="nav-link active" href="">Semua (<?php echo $jData;?>)</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="pembimbingTesis2Proses.php">Proses (<?php echo $jDataProses;?>)</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="pembimbingTesis2Selesai.php">Selesai (<?php echo $jDataUjskrip;?>)</a>
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
                            
                            $qpend =  "SELECT * FROM mag_peserta_sempro WHERE nim='$data[nim]'";
                            $rpend = mysqli_query($con, $qpend);
                            $dpend = mysqli_fetch_array($rpend);
                            
                            $qjdwl =  "SELECT * FROM mag_jadwal_sempro WHERE id_pendaftaran='$dpend[id]'";
                            $rjdwl = mysqli_query($con, $qjdwl);
                            $djdwl = mysqli_fetch_array($rjdwl);
                            
                            $qryperiod = "SELECT * from mag_periode_pendaftaran_sempro WHERE id='$dpend[id_sempro]'";
                            $res = mysqli_query($con,  $qryperiod )or die( mysqli_error($con) );
                            $dperiod = mysqli_fetch_assoc( $res );
                            $id_sempro=$dperiod['id'];
                            $thp=$dperiod['tahap'];
                            $ta=$dperiod['ta'];
                            
                            $qry_pemb1 = "SELECT * FROM dt_pegawai WHERE id='$data[nip_dospem_tesis1]'";
                            $res_pemb1 = mysqli_query($con, $qry_pemb1);
                            $dt_pemb1 = mysqli_fetch_array($res_pemb1);
                            
                            $qry_pemb2 = "SELECT * FROM dt_pegawai WHERE id='$data[nip_dospem_tesis2]'";
                            $res_pemb2 = mysqli_query($con, $qry_pemb2);
                            $dt_pemb2 = mysqli_fetch_array($res_pemb2);
                            
                            $qry_grade = "SELECT * FROM mag_grade_sempro WHERE id_sempro='$dpend[id_sempro]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);
                            
                            $sqlmhssw =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                            $rmhssw = mysqli_query($con, $sqlmhssw);
                            $dmhssw = mysqli_fetch_array($rmhssw);
                            
                            $qpenguji1 =  "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji3]'";
                            $rpenguji1 = mysqli_query($con, $qpenguji1);
                            $dpenguji1 = mysqli_fetch_array($rpenguji1);                        
                            
                            $qpenguji2 =  "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji4]'";
                            $rpenguji2 = mysqli_query($con, $qpenguji2);
                            $dpenguji2 = mysqli_fetch_array($rpenguji2);

                            $qpenguji3 =  "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji1]'";
                            $rpenguji3 = mysqli_query($con, $qpenguji3);
                            $dpenguji3 = mysqli_fetch_array($rpenguji3);

                            $qpenguji4 =  "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji2]'";
                            $rpenguji4 = mysqli_query($con, $qpenguji4);
                            $dpenguji4 = mysqli_fetch_array($rpenguji4);

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
                            
                            $qnilai =  "SELECT * FROM mag_nilai_sempro WHERE id_pendaftaran='$dpend[id]'";
                            $rnilai = mysqli_query($con, $qnilai);
                            $dnilai = mysqli_fetch_array($rnilai);
                            
                            if($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 3;}
                            elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 2;}
                            elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji4']) / 1;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1']) / 1;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2']) / 2;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3']) / 3;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 3;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2'] + $dnilai['nilai_penguji4']) / 3;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji4']) / 2;}
                            elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3']) / 2;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji3']) / 2;}
                            elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji2'] + $dnilai['nilai_penguji4']) / 2;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1']) / 1;}
                            elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji2']) / 1;}
                            elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji3']) / 1;}
                            elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji4']) / 1;}
                            elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 4;}
                            elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']!='0') {
                            $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 4;}
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
                                        <th class="pl-1">Judul Proposal Tesis</th>
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
                                        <th class="pl-1">Penguji Utama</th>
                                        <td>:</td>
                                        <td><?php echo $dpenguji1['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Ketua Penguji</th>
                                        <td>:</td>
                                        <td><?php echo $dpenguji2['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Penguji Pembimbing 1</th>
                                        <td>:</td>
                                        <td><?php echo $dpenguji3['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Penguji Pembimbing 2</th>
                                        <td>:</td>
                                        <td><?php echo $dpenguji4['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Ruang Seminar</th>
                                        <td>:</td>
                                        <td><?php echo $druang['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Nilai Seminar</th>
                                        <td>:</td>
                                        <td><?php include ("meanNilaiSemproTes.php");?></td>
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