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
                  <li class="breadcrumb-item small"><a href="dataKontribEksAsmAdm.php?page=<?php echo $page;?>">Agenda Surat Masuk</a></li>
                  <li class="breadcrumb-item small"><a href="dataKontribEksAsmPertahunAdm.php?page=<?php echo $page;?>&tahun=<?php echo $tahun;?>">Tahun <?php echo $tahun;?></a></li>
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
                          <th scope="col" width="8%" class="text-center">No. Berkas</th>
                          <th scope="col" width="40%" class="text-left">Alamat Tujuan</th>
                          <th scope="col" width="40%" class="text-left">Perihal</th>
                          <th scope="col" width="8%" class="text-center">Tgl. Surat</th>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM surat_masuk WHERE tahun = '$tahun' AND bulan = '$bulan' AND executor = '$username' ORDER BY ABS(no_berkas) DESC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            $no++;
                            
                            $qryOrdner = "SELECT * FROM ordner WHERE id='$data[ordner]'";
                            $rOrdner = mysqli_query($con, $qryOrdner);
                            $dOrdner = mysqli_fetch_assoc($rOrdner);
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center"><?php echo $no;?></td>
                            <td class="text-center"><?php echo $data['no_berkas'];?></td>
                            <td class="text-left"><?php echo $data['pengirim'];?></td>
                            <td class="text-left"><?php echo  $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);?></td>
                            <td class="text-center"><?php echo $data['tgl_surat'];?></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="5">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="20%" class="pl-1">Tanggal Diterima</th>
                                        <td width="4%">:</td>
                                        <td width="76%"><?php echo $data['tgl_terima'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Nomor Agenda Berkas Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['no_berkas'];?></td>
                                      </tr>
                                      <tr>
                                        <th colspan="3" class="pl-1 text-danger">KETERANGAN DARI SURAT MASUK</th>
                                      </tr>                                      
                                      <tr>
                                        <th class="pl-1">Pengirim Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['pengirim'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['tgl_surat'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">No. Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['no_surat'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Jumlah Berkas Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['jml_berkas'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Perihal Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Ordner Surat</th>
                                        <td>:</td>
                                        <td><?php echo $dOrdner['nm_ordner'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">File Surat</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['berkas'])) { echo "Tidak ada";} else { echo '<a href="'.$data['berkas'].'" target="_blank">Unduh</a>';}?></td>
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