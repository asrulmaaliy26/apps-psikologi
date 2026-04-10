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
                <h4 class="mb-0">Download Berkas</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Seminar Proposal Tesis</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "berkasSemproTes.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT ju.id
          , ju.id_sempro
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
          , ju.tgl_seminar
          , ju.jam_mulai
          , ju.jam_selesai
          , ju.ruang
          
          FROM mag_jadwal_sempro ju
          INNER JOIN mag_peserta_sempro pu
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
          INNER JOIN mag_nilai_sempro nu
          on ju.id_pendaftaran = nu.id_pendaftaran

          WHERE (ju.id_sempro LIKE '%$keyword%' OR ju.nim LIKE '%$keyword%' OR ju.id_pendaftaran LIKE '%$keyword%' OR dm.nim LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR penguji1.nama LIKE '%$keyword%' OR penguji2.nama LIKE '%$keyword%' OR penguji3.nama LIKE '%$keyword%' OR penguji4.nama LIKE '%$keyword%' OR cekhadir1.nm LIKE '%$keyword%' OR cekhadir2.nm LIKE '%$keyword%' OR cekhadir3.nm LIKE '%$keyword%' OR cekhadir4.nm LIKE '%$keyword%' OR dospem_tesis1.nama LIKE '%$keyword%' OR dospem_tesis2.nama LIKE '%$keyword%' OR dr.nm LIKE '%$keyword%' OR nu.catatan_penguji1 LIKE '%$keyword%' OR nu.catatan_penguji2 LIKE '%$keyword%' OR nu.catatan_penguji3 LIKE '%$keyword%' OR nu.catatan_penguji4 LIKE '%$keyword%' OR nu.nilai_penguji1 LIKE '%$keyword%' OR nu.nilai_penguji2 LIKE '%$keyword%' OR nu.nilai_penguji3 LIKE '%$keyword%' OR nu.nilai_penguji4 LIKE '%$keyword%') AND (ju.penguji1=$dtDosen[id] OR ju.penguji2=$dtDosen[id] OR ju.penguji3=$dtDosen[id] OR ju.penguji4=$dtDosen[id]) GROUP BY ju.id ORDER BY ju.id DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "berkasSemproTes.php?pagination=true";
          $sql = "SELECT * FROM mag_jadwal_sempro WHERE penguji1='$dtDosen[id]' OR penguji2='$dtDosen[id]' OR penguji3='$dtDosen[id]' OR penguji4='$dtDosen[id]' ORDER BY id DESC";
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
                <form method="post" action="berkasSemproTes.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="berkasSemproTes.php"><i class="fas fa-sync"></i> Kembali</a>
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
                    <h4 class="card-title">Seminar Proposal Tesis</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td scope="col" width="4%" class="text-center pl-1">No.</td>
                            <td scope="col" width="86%" class="text-center">Nama Mahasiswa</td>
                            <td scope="col" width="10%" class="text-center pr-1">Berkas</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id = $data['id'];
                            
                            $qpend =  "SELECT * FROM mag_peserta_sempro WHERE id='$data[id_pendaftaran]'";
                            $rpend = mysqli_query($con, $qpend);
                            $dpend = mysqli_fetch_array($rpend);
                            
                            $qryperiod = "SELECT * from mag_periode_pendaftaran_sempro WHERE id='$dpend[id_sempro]'";
                            $res = mysqli_query($con,  $qryperiod )or die( mysqli_error($con) );
                            $dperiod = mysqli_fetch_assoc( $res );
                            $id_sempro=$dperiod['id'];
                            $thp=$dperiod['tahap'];
                            $ta=$dperiod['ta'];
                            
                            $qry_pemb1 = "SELECT * FROM dt_pegawai WHERE id='$dpend[dospem_tesis1]'";
                            $res_pemb1 = mysqli_query($con, $qry_pemb1);
                            $dt_pemb1 = mysqli_fetch_array($res_pemb1);

                            $qry_pemb2 = "SELECT * FROM dt_pegawai WHERE id='$dpend[dospem_tesis2]'";
                            $res_pemb2 = mysqli_query($con, $qry_pemb2);
                            $dt_pemb2 = mysqli_fetch_array($res_pemb2);

                            $qry_grade = "SELECT * FROM mag_grade_sempro WHERE id_sempro='$dpend[id_sempro]'";
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
                            include_once("month_function_2.php");
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dmhssw['nama'].' ['.$dmhssw['nim'].']';?></td>
                            <td class="text-center pr-1"> <?php if(empty($dpend['file_prop'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada file!\')" title="Tidak ada file" disabled><i class="fas fa-download"></i></a>';} else { echo '<a class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Lihat/download" href="'.$dpend['file_prop'].'" target="_blank"><i class="fas fa-download"></i></a>';}?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="3">
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
                                        <td><?php if(empty($data['tgl_seminar'])) { echo "";} else {echo $dayList[$day].', '.bulanIndo($data['tgl_seminar']).', '.$data['jam_mulai'].' - '.$data['jam_selesai'].' WIB.';}?></td>
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