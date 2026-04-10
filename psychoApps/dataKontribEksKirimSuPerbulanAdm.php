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
                  <li class="breadcrumb-item small"><a href="dataKontribEksKirimSuAdm.php?page=<?php echo $page;?>">Kirim File Surat Undangan</a></li>
                  <li class="breadcrumb-item small"><a href="dataKontribEksKirimSuPertahunAdm.php?page=<?php echo $page;?>&tahun=<?php echo $tahun;?>">Tahun <?php echo $tahun;?></a></li>
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
                          <th scope="col" width="72%" class="text-left">Keterangan tentang File</th>
                          <th scope="col" width="8%" class="text-center">File</th>
                          <th scope="col" width="10%" class="text-center">Tgl. Upload</th>
                          <th scope="col" width="6%" class="text-center">Penerima</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM sending_surat WHERE jenis_surat = '3' AND thn_upload = '$tahun' AND bln_upload = '$bulan' AND executor = '$username' ORDER BY tgl_upload DESC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            $no++;
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM penerima_surat WHERE id_sending_surat='$data[id]'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $data['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskripsi']);?></td>
                            <td class="text-center"><?php if(empty($data['file_surat'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" onclick="return confirm(\'Tidak ada file!\')" title="Tidak ada file" disabled><i class="fas fa-download"></i></a>';} else { echo '<a class="btn btn-outline-warning btn-xs btn-block" title="Lihat/download" href="'.$data['file_surat'].'" target="_blank"><i class="fas fa-download"></i></a>';}?></td>
                            <td class="text-center"><?php echo date("d-m-Y", strtotime($data['tgl_upload']) );?></td>
                            <td class="text-center"><?php echo $data1['jumData'];?></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="5">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="20%" class="pl-1">Keterangan tentang File</th>
                                        <td width="4%">:</td>
                                        <td width="76%"><?php echo $data['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskripsi']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Upload File</th>
                                        <td>:</td>
                                        <td><?php echo date("d-m-Y", strtotime($data['tgl_upload']) );?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Penerima File</th>
                                        <td>:</td>
                                        <td>
                                          <?php 
                                            $qPenerima="SELECT penerima_surat.id,penerima_surat.id_sending_surat,penerima_surat.penerima,dt_pegawai.id AS id_pegawai,dt_pegawai.nama_tg FROM penerima_surat LEFT JOIN dt_pegawai ON penerima_surat.penerima=dt_pegawai.id WHERE penerima_surat.id_sending_surat='$data[id]' ORDER BY dt_pegawai.nama_tg ASC";
                                            $rPenerima=mysqli_query($con, $qPenerima) or die (mysqli_error($con));
                                            while($dPenerima=mysqli_fetch_assoc($rPenerima)) {
                                            echo $dPenerima['nama_tg'].' ['.$dPenerima['id_pegawai'].']'; echo "<br/>";}?>
                                        </td>
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