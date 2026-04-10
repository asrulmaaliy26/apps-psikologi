<?php include( "contentsConAdm.php" );
  $tahun = date("Y");?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmTaper.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Permohonan Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small"><a href="rekapSuratMahasiswaAdm.php?date=<?php echo $tahun;?>">Dari Mahasiswa</a></li>
                  <li class="breadcrumb-item small">Izin Observasi Pra Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "rekapPrasipsAdm.php?pagination=true&date=$tahun&keyword=$keyword";
          
          $sql = "SELECT p.id
          , p.nim
          , p.lembaga_tujuan_surat
          , p.alamat_lengkap_lts
          , p.nama_obyek
          , p.sebutan_pimpinan
          , p.kota_observasi
          , p.judul_prop
          , p.dosen_pembimbing1
          , p.dosen_pembimbing2
          , p.tgl_awal_pelaksanaan
          , p.tgl_akhir_pelaksanaan
          , p.model_pelaksanaan
          , p.tgl_pengajuan
          , p.thn_pengajuan
          , p.tgl_dikeluarkan
          , p.wd1
          , p.tembusan
          , p.statusform
          , p.catatan
          , p.executor
          , p.editor
          FROM prasips p
          INNER JOIN opsi_sebutan_pimpinan osp
          ON osp.id = p.sebutan_pimpinan
          INNER JOIN dt_mhssw dm
          ON dm.nim = p.nim
          INNER JOIN dt_kota dk
          ON dk.id = p.kota_observasi
          LEFT JOIN dt_pegawai dp1
          ON dp1.id = p.dosen_pembimbing1
          LEFT JOIN dt_pegawai dp2
          ON dp2.id = p.dosen_pembimbing2
          INNER JOIN dt_pegawai dp_pejabat
          ON dp_pejabat.id = p.wd1
          INNER JOIN opsi_model_ow_penel omop
          ON omop.id = p.model_pelaksanaan
          INNER JOIN opsi_status_pengajuan_surat osps
          ON osps.id = p.statusform
          LEFT JOIN dt_all_adm ab1
          ON ab1.username = p.executor
          LEFT JOIN dt_all_adm ab2
          ON ab2.username = p.editor
          
          WHERE (p.nim LIKE '%$keyword%' OR p.lembaga_tujuan_surat LIKE '%$keyword%' OR p.alamat_lengkap_lts LIKE '%$keyword%' OR p.nama_obyek LIKE '%$keyword%' OR p.judul_prop LIKE '%$keyword%' OR p.tgl_awal_pelaksanaan LIKE '%$keyword%' OR p.tgl_akhir_pelaksanaan LIKE '%$keyword%' OR p.tgl_pengajuan LIKE '%$keyword%' OR p.thn_pengajuan LIKE '%$keyword%' OR p.tgl_dikeluarkan LIKE '%$keyword%' OR p.tembusan LIKE '%$keyword%' OR p.catatan LIKE '%$keyword%' OR osp.nm LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR dk.nm_kota LIKE '%$keyword%' OR dp1.nama LIKE '%$keyword%' OR dp2.nama LIKE '%$keyword%' OR dp_pejabat.nama LIKE '%$keyword%' OR omop.nm LIKE '%$keyword%' OR osps.nm LIKE '%$keyword%' OR ab1.nm_person LIKE '%$keyword%' OR ab2.nm_person LIKE '%$keyword%') AND (p.thn_pengajuan='$tahun') GROUP BY p.id ORDER BY  p.statusform ASC,ABS(p.tgl_pengajuan) DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "rekapPrasipsAdm.php?pagination=true";
          $sql = "SELECT * FROM prasips WHERE thn_pengajuan='$tahun' ORDER BY statusform ASC,ABS(tgl_pengajuan) DESC";
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
                <?php  error_reporting(E_ALL & ~E_NOTICE);?>
                <form method="post" action="rekapPrasipsAdm.php?date=<?php echo $tahun;?>&page=<?php echo $page;?>">
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){ echo
                        '<a class="btn btn-sm btn-warning" title="Kembali" href="rekapPrasipsAdm.php?date='.$tahun.'&page='.$page.'"><i class="fas fa-sync"></i> Kembali</a>';}
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
                    <h4 class="card-title">Tahun <?php echo $tahun;?></h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead class="thead-light">
                          <th scope="col" width="4%" class="text-center">No.</th>
                          <th scope="col" width="10%" class="text-center">Tgl. Pengajuan</th>
                          <th scope="col" width="27%" class="text-left">Pemohon</th>
                          <th scope="col" width="27%" class="text-left">Tempat Observasi</th>
                          <th scope="col" colspan="4" class="text-center">Opsi</th>
                          <th scope="col" width="10%" class="text-center">Status</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qryMhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rMhssw = mysqli_query($con, $qryMhssw);
                            $dMhssw = mysqli_fetch_assoc($rMhssw);
                            
                            $qryOsp = "SELECT * FROM opsi_sebutan_pimpinan WHERE id='$data[sebutan_pimpinan]'";
                            $rOsp = mysqli_query($con, $qryOsp);
                            $dOsp = mysqli_fetch_assoc($rOsp);
                            
                            $qryDk = "SELECT * FROM dt_kota WHERE id='$data[kota_observasi]'";
                            $rDk = mysqli_query($con, $qryDk);
                            $dDk = mysqli_fetch_assoc($rDk);
                            
                            $qryDp1 = "SELECT * FROM dt_pegawai WHERE id='$data[dosen_pembimbing1]'";
                            $rDp1 = mysqli_query($con, $qryDp1);
                            $dDp1 = mysqli_fetch_assoc($rDp1);
                            
                            $qryDp2 = "SELECT * FROM dt_pegawai WHERE id='$data[dosen_pembimbing2]'";
                            $rDp2 = mysqli_query($con, $qryDp2);
                            $dDp2 = mysqli_fetch_assoc($rDp2);
                            
                            $qryOmop = "SELECT * FROM opsi_model_ow_penel WHERE id='$data[model_pelaksanaan]'";
                            $rOmop = mysqli_query($con, $qryOmop);
                            $dOmop = mysqli_fetch_assoc($rOmop);
                            
                            $qryDpPejabat = "SELECT * FROM dt_pegawai WHERE id='$data[wd1]'";
                            $rDpPejabat = mysqli_query($con, $qryDpPejabat);
                            $dDpPejabat = mysqli_fetch_assoc($rDpPejabat);
                            
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
                            <td class="text-left"><?php $allowedlimit = 14; if(mb_strlen($dMhssw['nama'])>$allowedlimit) { echo mb_substr($dMhssw['nama'],0,$allowedlimit)."...".' ['.$dMhssw['nim'].']';} else {echo  $dMhssw['nama'].' ['.$dMhssw['nim'].']';}?></td>
                            <td class="text-left"><?php $allowedlimit = 34; if(mb_strlen($data['nama_obyek'])>$allowedlimit) { echo mb_substr($data['nama_obyek'],0,$allowedlimit)."...";} else {echo $data['nama_obyek'];}?></td>
                            <?php if($data['statusform']=='3') { echo '<td class="text-center" width="4%"><a role="button" class="btn btn-block btn-outline-warning btn-xs" onclick="return confirm(\'Status surat telah selesai!\')" title="Status surat telah selesai!" disabled><i class="bi bi-pencil-square"></i></a></td>';} else { echo '<td class="text-center" width="4%"><a href="editPrasipsAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn btn-block btn-outline-warning btn-xs" title="Proses surat!"><i class="bi bi-pencil-square"></i></a></td>';}?>
                            <?php if($data['statusform']=='1' OR $data['statusform']=='4') { echo '<td class="text-center" width="4%"><a role="button" class="btn btn-block btn-outline-secondary btn-xs" onclick="return confirm(\'Status surat masih pengajuan atau ditolak!\')" title="Status surat masih pengajuan atau ditolak!" disabled><i class="bi bi-printer"></i></a></td>';} else { echo '<td class="text-center" width="4%"><a href="cetakPrasipsAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn btn-block btn-outline-secondary btn-xs" target="_blank" title="Cetak surat!"><i class="bi bi-printer"></i></a></td>';}?>
                            <?php if($data['statusform']=='2' OR $data['statusform']=='3') { echo '<td class="text-center" width="4%"><a role="button" class="btn btn-block btn-outline-danger btn-xs" onclick="return confirm(\'Status surat masih proses atau telah selesai!\')" title="Status surat masih proses atau telah selesai!" disabled><i class="bi bi-trash"></i></a></td>';} else { echo '<td class="text-center" width="4%"><a href="deletePrasipsAdm.php?id='.$data['id'].'&date='.$tahun.'&page='.$page.'" role="button" class="btn btn-block btn-outline-danger btn-xs" onClick="return confirm(\'Yakin data ini dihapus?\')" title="Hapus surat!"><i class="bi bi-trash"></i></a></td>';}?>
                            <td width="10%" class="text-center"><?php if($data['statusform']=='1' OR $data['statusform']=='4') {  echo '<a href="catatanPrasipsAdm.php?id='.$data['id'].'&date='.$tahun.'&page='.$page.'" type="button" class="btn btn-outline-success btn-xs btn-block" title="Beri catatan"><i class="far fa-comment-alt"></i> Beri Catatan</a>';} else { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-xs btn-block" onclick="return confirm(\'Catatan hanya diberikan jika status surat: pengajuan atau ditolak!\')" title="Catatan hanya diberikan jika status surat: pengajuan atau ditolak!"><i class="far fa-comment-alt"></i> Beri Catatan</a>';}?></td>
                            <td class="text-center p-2">
                              <form action="updateStatusformPrasipsAdm.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
                                <input type="text" name="date" class="sr-only" value="<?php echo $tahun;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <select name='statusform' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM opsi_status_pengajuan_surat ORDER BY id ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                  if ( $data['statusform'] == $w[ 'id' ] ) {
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
                          <tr class="expandable-body">
                            <td colspan="9">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
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
                                        <td><?php echo $dMhssw['nama'].' ['.$dMhssw['nim'].']';?></td>
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
                                        <th scope="col">Tanggal Observasi</th>
                                        <td>:</td>
                                        <td><?php echo $data['tgl_awal_pelaksanaan'].' s.d '.$data['tgl_akhir_pelaksanaan'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Model Pelaksanaan Kegiatan</th>
                                        <td>:</td>
                                        <td><?php echo $dOmop['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Judul Proposal Skripsi</th>
                                        <td>:</td>
                                        <td><?php echo $data['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_prop']);?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Dospem Skripsi I</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['dosen_pembimbing1'])) {echo "-";} else {echo $dDp1['nama'].' ['.$dDp1['id'].']';}?></td>
                                      </tr>
                                      <tr>
                                        <th scope="col">Dospem Skripsi II</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['dosen_pembimbing2'])) {echo "-";} else {echo $dDp2['nama'].' ['.$dDp2['id'].']';}?></td>
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