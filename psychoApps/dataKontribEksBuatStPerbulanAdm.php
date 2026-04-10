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
                  <li class="breadcrumb-item small"><a href="dataKontribEksBuatStAdm.php?page=<?php echo $page;?>">Buat Surat Tugas</a></li>
                  <li class="breadcrumb-item small"><a href="dataKontribEksBuatStPertahunAdm.php?page=<?php echo $page;?>&tahun=<?php echo $tahun;?>">Tahun <?php echo $tahun;?></a></li>
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
                          <th scope="col" width="56%" class="text-left">Perihal Tugas yang Diberikan</th>
                          <th scope="col" width="10%" class="text-left">Jenis ST</th>
                          <th scope="col" width="16%" class="text-center">Tgl. Berlaku</th>
                          <th scope="col" width="14%" class="text-center">Tgl. Ditetapkan</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM st WHERE tahun = '$tahun' AND bulan = '$bulan' AND executor = '$username' ORDER BY tgl_ditetapkan DESC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            $no++;
                            
                            $qryJenisSt = "SELECT * FROM opsi_jenis_st WHERE id='$data[jenis_st]'";
                            $rJenisSt = mysqli_query($con, $qryJenisSt);
                            $dJenisSt = mysqli_fetch_assoc($rJenisSt);
                            
                            $qryTtd = "SELECT * FROM dt_pegawai WHERE id='$data[dekan]'";
                            $rTtd = mysqli_query($con, $qryTtd);
                            $dTtd = mysqli_fetch_assoc($rTtd);
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center"><?php echo $no;?></td>
                            <td class="text-left"><?php echo  $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);?></td>
                            <td class="text-left"><?php echo $dJenisSt['nm'];?></td>
                            <td class="text-center"><?php echo $data['awal_berlaku'].'-'.$data['akhir_berlaku'];?></td>
                            <td class="text-center"><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="5">
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
                                        <th class="pl-1">Perihal Tugas yang Diberikan</th>
                                        <td>:</td>
                                        <td><?php echo $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tgl. Berlaku</th>
                                        <td>:</td>
                                        <td><?php echo $data['awal_berlaku'].'-'.$data['akhir_berlaku'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Ditetapkan</th>
                                        <td>:</td>
                                        <td><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Jenis Surat Tugas</th>
                                        <td>:</td>
                                        <td><?php echo $dJenisSt['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Nama-nama yang Diberi Tugas</th>
                                        <td>:</td>
                                        <td>
                                          <?php 
                                            $qPersonil="SELECT * FROM personil_st WHERE id_st='$data[id]' AND nama<>'' ORDER BY urutan_jabatan";
                                            $rPersonil=mysqli_query($con, $qPersonil) or die (mysqli_error($con));
                                            while($dPersonil=mysqli_fetch_assoc($rPersonil)) {
                                            
                                            $qNamaPersonil="SELECT * FROM dt_pegawai WHERE id='$dPersonil[nama]'";
                                            $rNamaPersonil=mysqli_query($con, $qNamaPersonil) or die (mysqli_error($con));
                                            $dNamaPersonil=mysqli_fetch_assoc($rNamaPersonil);
                                            
                                            if($dPersonil['nama'] == $dNamaPersonil['id']) { echo $dNamaPersonil['nama'];} else { echo $dPersonil['nama'];} echo "<br/>";
                                            }
                                            ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Pejabat Penandatangan</th>
                                        <td>:</td>
                                        <td><?php echo $dTtd['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Eksekutor</th>
                                        <td>:</td>
                                        <td><?php echo $dEksekutor['nm_person'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Editor</th>
                                        <td>:</td>
                                        <td><?php echo $dEditor['nm_person'];?></td>
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