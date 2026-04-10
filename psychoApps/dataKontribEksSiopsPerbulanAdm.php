<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $page= mysqli_real_escape_string($con, $_GET['page']);
  $tahun= mysqli_real_escape_string($con, $_GET['tahun']);
  $bulan= mysqli_real_escape_string($con, $_GET['bulan']);
  
  $month = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
  
  $myquery = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dAdm = mysqli_fetch_assoc($d);
  ?>
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
              <div class="col-sm-4">
                <h4 class="mb-0">Kontribusi Saya</h4>
              </div>
              <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dataKontribEksekutorAdm.php">Sebagai Eksekutor</a></li>
                  <li class="breadcrumb-item small"><a href="dataKontribEksSiopsAdm.php?page=<?php echo $page;?>">Permohonan Surat Izin Observasi Pra Skripsi</a></li>
                  <li class="breadcrumb-item small"><a href="dataKontribEksSiopsPertahunAdm.php?page=<?php echo $page;?>&tahun=<?php echo $tahun;?>">Tahun <?php echo $tahun;?></a></li>
                  <li class="breadcrumb-item active small">Bulan <?php echo $month[(int)$bulan];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Bulan <?php echo $month[(int)$bulan];?></h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead class="thead-light">
                          <th scope="col" width="4%" class="text-center">No.</th>
                          <th scope="col" width="10%" class="text-center">Tgl. Pengajuan</th>
                          <th scope="col" width="30%" class="text-left">Pemohon</th>
                          <th scope="col" width="44%" class="text-left">Tempat Observasi</th>
                          <th scope="col" width="12%" class="text-center">Status</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM prasips WHERE thn_pengajuan = '$tahun' AND bln_pengajuan = '$bulan' AND executor = '$username' ORDER BY id DESC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            $no++;
                            
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
                            <td class="text-center"><?php echo $no;?></td>
                            <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                            <td class="text-left"><?php $allowedlimit = 24; if(mb_strlen($dMhssw['nama'])>$allowedlimit) { echo mb_substr($dMhssw['nama'],0,$allowedlimit)."...".' ['.$dMhssw['nim'].']';} else {echo  $dMhssw['nama'].' ['.$dMhssw['nim'].']';}?></td>
                            <td class="text-left"><?php $allowedlimit = 44; if(mb_strlen($data['nama_obyek'])>$allowedlimit) { echo mb_substr($data['nama_obyek'],0,$allowedlimit)."...";} else {echo $data['nama_obyek'];}?></td>
                            <td class="text-center"><?php echo $dOsps['nm'];?></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="5">
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
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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