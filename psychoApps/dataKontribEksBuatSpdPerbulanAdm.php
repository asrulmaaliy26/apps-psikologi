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
                  <li class="breadcrumb-item small"><a href="dataKontribEksBuatSpdAdm.php?page=<?php echo $page;?>">Buat Surat Perjalanan Dinas</a></li>
                  <li class="breadcrumb-item small"><a href="dataKontribEksBuatSpdPertahunAdm.php?page=<?php echo $page;?>&tahun=<?php echo $tahun;?>">Tahun <?php echo $tahun;?></a></li>
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
                          <th scope="col" width="26%" class="text-left">Penerima SPD</th>
                          <th scope="col" width="38%" class="text-left">Maksud SPD</th>
                          <th scope="col" width="10%" class="text-center">Tgl. Berangkat</th>
                          <th scope="col" width="10%" class="text-center">Tgl. Kembali</th>
                          <th scope="col" width="12%" class="text-center">Tgl. Ditetapkan</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM spd WHERE tahun = '$tahun' AND bulan = '$bulan' AND executor = '$username' ORDER BY tgl_ditetapkan DESC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            $no++;
                            
                            $qryPenerima = "SELECT * FROM dt_pegawai WHERE id='$data[penerima]'";
                            $rPenerima = mysqli_query($con, $qryPenerima);
                            $dPenerima = mysqli_fetch_assoc($rPenerima);
                            
                            $qryPangkatPenerima = "SELECT * FROM opsi_jabatan_instansi WHERE id='$dPenerima[jabatan_instansi]'";
                            $rPangkatPenerima = mysqli_query($con, $qryPangkatPenerima);
                            $dPangkatPenerima = mysqli_fetch_assoc($rPangkatPenerima);
                            
                            $qryKotaBerangkat = "SELECT * FROM dt_kota WHERE id='$data[tempat_berangkat]'";
                            $rKotaBerangkat = mysqli_query($con, $qryKotaBerangkat);
                            $dKotaBerangkat = mysqli_fetch_assoc($rKotaBerangkat);
                            
                            $qTtujuan="SELECT * FROM dt_kota WHERE id='$data[tempat_tujuan]'";
                            $resTtujuan=mysqli_query($con, $qTtujuan) or die (mysqli_error($con));
                            $dTtujuan=mysqli_fetch_assoc($resTtujuan);
                            
                            $qTtujuan2="SELECT * FROM dt_kota WHERE id='$data[tempat_tujuan2]'";
                            $resTtujuan2=mysqli_query($con, $qTtujuan2) or die (mysqli_error($con));
                            $dTtujuan2=mysqli_fetch_assoc($resTtujuan2);
                            
                            $qTtujuan3="SELECT * FROM dt_kota WHERE id='$data[tempat_tujuan3]'";
                            $resTtujuan3=mysqli_query($con, $qTtujuan3) or die (mysqli_error($con));
                            $dTtujuan3=mysqli_fetch_assoc($resTtujuan3);
                            
                            $qnmppk="SELECT * FROM dt_pegawai WHERE id='$data[ppk]'";
                            $resnmppk=mysqli_query($con, $qnmppk) or die (mysqli_error($con));
                            $dnmppk=mysqli_fetch_assoc($resnmppk);
                            
                            $qjabataninstppk="SELECT * FROM opsi_jabatan_instansi WHERE id='$data[jabatan_ppk]'";
                            $resjabataninstppk=mysqli_query($con, $qjabataninstppk) or die (mysqli_error($con));
                            $djabataninstppk=mysqli_fetch_assoc($resjabataninstppk);
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dPenerima['nama_tg'];?></td>
                            <td class="text-left"><?php echo  $data['maksud_spd']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['maksud_spd']);?></td>
                            </td>
                            <td class="text-center"><?php echo $data['tanggal_berangkat'];?></td>
                            <td class="text-center"><?php echo $data['tanggal_kembali'];?></td>
                            <td class="text-center"><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="6">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="20%" class="pl-1">Nomor Agenda Berkas Surat</th>
                                        <td width="4%">:</td>
                                        <td width="76%"><?php if($data['no_agenda_surat']=='') {echo "-";} else {echo $data['no_agenda_surat'];}?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Penerima</th>
                                        <td>:</td>
                                        <td><?php echo $dPenerima['nama'].' / '.$dPangkatPenerima['nm_panjang'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Maksud SPD</th>
                                        <td>:</td>
                                        <td><?php echo $data['maksud_spd']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['maksud_spd']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tempat Berangkat</th>
                                        <td>:</td>
                                        <td><?php echo $dKotaBerangkat['nm_kota'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tempat Tujuan</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['tempat_tujuan2']) && empty($data['tempat_tujuan3'])) { echo "$dTtujuan[nm_kota]";} else if(!empty($data['tempat_tujuan2']) && empty($data['tempat_tujuan3'])) { echo "$dTtujuan[nm_kota]".", ". "$dTtujuan2[nm_kota]";} else if(!empty($data['tempat_tujuan2']) && !empty($data['tempat_tujuan3'])) { echo "$dTtujuan[nm_kota]".", "."$dTtujuan2[nm_kota]".", ". "$dTtujuan3[nm_kota]";}?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Berangkat</th>
                                        <td>:</td>
                                        <td><?php echo $data['tanggal_berangkat'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Kembali</th>
                                        <td>:</td>
                                        <td><?php echo $data['tanggal_kembali'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Lama Perjalanan Dinas</th>
                                        <td>:</td>
                                        <td><?php echo $data['durasi_spd'];?> hari</td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Ditetapkan</th>
                                        <td>:</td>
                                        <td><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Pejabat Penandatangan</th>
                                        <td>:</td>
                                        <td><?php echo $dnmppk['nama'].' / '.$djabataninstppk['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Eksekutor</th>
                                        <td>:</td>
                                        <td><?php if($data['executor']=='') { echo '-';} else { echo $dEksekutor['nm_person'];}?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Editor</th>
                                        <td>:</td>
                                        <td><?php if($data['editor']=='') { echo '-';} else { echo $dEditor['nm_person'];}?></td>
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