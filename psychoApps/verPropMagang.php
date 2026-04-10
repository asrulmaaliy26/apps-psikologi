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
      <?php include( "alertUser.php" );?>
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarDosen.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Verifikasi</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Proposal Magang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "verPropMagang.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT jesur.id
          , jesur.no_agenda_surat
          , jesur.nim
          , jesur.lembaga_tujuan_surat
          , jesur.alamat_lengkap_lts
          , jesur.nama_obyek
          , jesur.sebutan_pimpinan
          , jesur.kota_lts
          , jesur.tgl_awal_pelaksanaan
          , jesur.tgl_akhir_pelaksanaan
          , jesur.tgl_pengajuan
          , jesur.thn_pengajuan
          , jesur.tgl_dikeluarkan
          , jesur.wd1
          , jesur.tembusan
          , jesur.statusform
          , jesur.catatan
          , jesur.proposal
          , jesur.validasi_proposal
          , jesur.executor
          , jesur.editor
          FROM magang jesur
          INNER JOIN opsi_sebutan_pimpinan osp
          ON osp.id = jesur.sebutan_pimpinan
          INNER JOIN dt_mhssw dm
          ON dm.nim = jesur.nim
          INNER JOIN dt_kota dk
          ON dk.id = jesur.kota_lts
          INNER JOIN dt_pegawai dp_pejabat
          ON dp_pejabat.id = jesur.wd1
          INNER JOIN opsi_status_pengajuan_surat osps
          ON osps.id = jesur.statusform
          INNER JOIN opsi_validasi ov
          ON ov.id = jesur.validasi_proposal
          LEFT JOIN dt_all_adm ab1
          ON ab1.username = jesur.executor
          LEFT JOIN dt_all_adm ab2
          ON ab2.username = jesur.editor
          
          WHERE (jesur.nim LIKE '%$keyword%' OR jesur.lembaga_tujuan_surat LIKE '%$keyword%' OR jesur.alamat_lengkap_lts LIKE '%$keyword%' OR jesur.nama_obyek LIKE '%$keyword%' OR jesur.tgl_awal_pelaksanaan LIKE '%$keyword%' OR jesur.tgl_akhir_pelaksanaan LIKE '%$keyword%' OR jesur.tgl_pengajuan LIKE '%$keyword%' OR jesur.thn_pengajuan LIKE '%$keyword%' OR jesur.tgl_dikeluarkan LIKE '%$keyword%' OR jesur.tembusan LIKE '%$keyword%' OR jesur.catatan LIKE '%$keyword%' OR osp.nm LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR dk.nm_kota LIKE '%$keyword%' OR jesur.proposal LIKE '%$keyword%' OR dp_pejabat.nama LIKE '%$keyword%' OR ov.nm LIKE '%$keyword%' OR osps.nm LIKE '%$keyword%' OR ab1.nm_person LIKE '%$keyword%' OR ab2.nm_person LIKE '%$keyword%') AND (jesur.thn_pengajuan='$tahun') GROUP BY jesur.id ORDER BY jesur.validasi_proposal ASC,ABS(jesur.tgl_pengajuan) DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "rekapSimagIndividuAdm.php?pagination=true";
          $sql = "SELECT * FROM magang WHERE thn_pengajuan='$tahun' ORDER BY validasi_proposal ASC,ABS(tgl_pengajuan) DESC";
          $result = mysqli_query($con, $sql);
          }
          
          $rpp = 50;
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
                <form method="post" action="verPropMagang.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="verPropMagang.php"><i class="fas fa-sync"></i> Kembali</a>
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
                    <h4 class="card-title">Proposal Magang</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td scope="col" width="4%" class="text-center">No.</td>
                            <td scope="col" width="10%" class="text-center">Tgl. Pengajuan</td>
                            <td scope="col" width="32%" class="text-left">Pemohon</td>
                            <td scope="col" width="18%" class="text-center">Status Proposal</td>
                            <td scope="col" colspan="3" class="text-center">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id = $data['id'];
                            
                            $qryMhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rMhssw = mysqli_query($con, $qryMhssw);
                            $dMhssw = mysqli_fetch_assoc($rMhssw);
                            
                            $qryOsp = "SELECT * FROM opsi_sebutan_pimpinan WHERE id='$data[sebutan_pimpinan]'";
                            $rOsp = mysqli_query($con, $qryOsp);
                            $dOsp = mysqli_fetch_assoc($rOsp);
                            
                            $qryDk = "SELECT * FROM dt_kota WHERE id='$data[kota_lts]'";
                            $rDk = mysqli_query($con, $qryDk);
                            $dDk = mysqli_fetch_assoc($rDk);
                            
                            $qryDpPejabat = "SELECT * FROM dt_pegawai WHERE id='$data[wd1]'";
                            $rDpPejabat = mysqli_query($con, $qryDpPejabat);
                            $dDpPejabat = mysqli_fetch_assoc($rDpPejabat);
                            
                            $qryOv = "SELECT * FROM opsi_validasi WHERE id='$data[validasi_proposal]'";
                            $rOv = mysqli_query($con, $qryOv);
                            $dOv = mysqli_fetch_assoc($rOv);
                            
                            $qryOsps = "SELECT * FROM opsi_status_pengajuan_surat WHERE id='$data[statusform]'";
                            $rOsps = mysqli_query($con, $qryOsps);
                            $dOsps = mysqli_fetch_assoc($rOsps);
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center"><?php echo ++$no_urut;?></td>
                            <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                            <td class="text-left"><?php echo $dMhssw['nama'].' ['.$dMhssw['nim'].']';?></td>
                            <td class="text-center"><?php echo $dOv['nm'];?></td>
                            <?php if(empty($data['proposal'])) { echo '<td class="text-center" width="12%"><a role="button" class="btn btn-block btn-outline-info btn-xs" onclick="return confirm(\'Tidak ada file proposal.\')" title="Tidak ada file proposal" disabled><i class="fas fa-file-pdf"></i></a></td>';} else { echo '<td class="text-center" width="12%"><a href="'.$data['proposal'].'" target="_blank" role="button" class="btn btn-block btn-outline-info btn-xs" title="Lihat proposal."><i class="fas fa-file-pdf"></i> Lihat Proposal</a></td>';}?>
                            <td width="10%" class="text-center"><?php if($data['validasi_proposal']=='1' OR $data['validasi_proposal']=='4') {  echo '<a href="catatanPropSimagAdm.php?id='.$data['id'].'&page='.$page.'" type="button" class="btn btn-outline-success btn-xs btn-block" title="Beri catatan"><i class="far fa-comment-alt"></i> Beri Catatan</a>';} else { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" onclick="return confirm(\'Surat permohonan telah diterima!\')" title="Surat permohonan telah diterima!"><i class="far fa-comment-alt"></i> Beri Catatan</a>';}?>
                            </td>
                            <td class="text-center p-1" width="14%">
                              <?php if($data['statusform']=='2' OR $data['statusform']=='3') {
                                include ("statusPropMagangDisabledAdm.php");}
                                else {include ("statusPropMagangAdm.php");}?>
                            </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="7">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table no-border rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th scope="col" width="26%">Tanggal Pengajuan</th>
                                        <td width="4%">:</td>
                                        <td width="70%"><?php echo $data['tgl_pengajuan'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Tanggal Proses</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['tgl_proses'])) { echo "-";} else {echo $data['tgl_proses'];}?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Tanggal Selesai</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['tgl_selesai'])) { echo "-";} else {echo $data['tgl_selesai'];}?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Tanggal Dikeluarkan</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['tgl_dikeluarkan'])) { echo "-";} else {echo \DateTime::createFromFormat('Y-m-d', $data['tgl_dikeluarkan'])->format('d-m-Y');}?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Nomor Agenda Berkas Surat</th>
                                        <td>:</td>
                                        <td><?php if($data['no_agenda_surat']=='') {echo "-";} else {echo $data['no_agenda_surat'];}?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Pemohon</th>
                                        <td>:</td>
                                        <td><?php if($data['jenis_magang']=='1') { echo $dMhssw['nama'].' ['.$dMhssw['nim'].']';} else {
                                            $qryAnggota = "SELECT * FROM anggota_magang INNER JOIN dt_mhssw ON anggota_magang.nim_anggota=dt_mhssw.nim WHERE anggota_magang.id_magang='$id' AND anggota_magang.nim_anggota<>'' ORDER BY dt_mhssw.nama ASC";
                                            $rAnggota = mysqli_query($con, $qryAnggota);
                                            while($dAnggota = mysqli_fetch_assoc($rAnggota)) {
                                            echo $dAnggota['nama'].' ['.$dAnggota['nim'].']';
                                            echo '<br/>';}
                                            }?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Lembaga Tujuan Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['nama_obyek'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Tujuan Surat</th>
                                        <td>:</td>
                                        <td><?php echo $dOsp['nm'].' '.$data['lembaga_tujuan_surat'].' '.$data['alamat_lengkap_lts'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Tanggal Magang</th>
                                        <td>:</td>
                                        <td><?php echo $data['tgl_awal_pelaksanaan'].' s.d '.$data['tgl_akhir_pelaksanaan'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Penandatangan Surat</th>
                                        <td>:</td>
                                        <td><?php echo $dDpPejabat['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Tembusan</th>
                                        <td>:</td>
                                        <td><?php echo nl2br($data['tembusan']);?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Validasi Proposal</th>
                                        <td>:</td>
                                        <td><?php echo $dOv['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Status Surat</th>
                                        <td>:</td>
                                        <td><?php echo $dOsps['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Catatan Pengajuan</th>
                                        <td>:</td>
                                        <td><?php if($data['catatan']=='') { echo '-';} else { echo $data['catatan']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['catatan']);}?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Eksekutor</th>
                                        <td>:</td>
                                        <td><?php if($data['executor']=='') { echo '-';} else { echo $dEksekutor['nm_person'];}?></td>
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