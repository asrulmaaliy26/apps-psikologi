<?php include( "contentsConAdm.php" );
  $qta = "SELECT * FROM dt_ta WHERE status='1'";
  $rta = mysqli_query($con, $qta)or die( mysqli_error($con));
  $dta = mysqli_fetch_assoc($rta);   
   
  $qwd1 = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '36'";
  $rkaprodi = mysqli_query($con, $qkaprodi)or die( mysqli_error($con));
  $dkaprodi = mysqli_fetch_assoc($rkaprodi);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Rekap Pembimbingan Skripsi</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Rekap Pembimbingan Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
                <?php
                 include 'pagination.php';
                 $reload = "rekapPembimbinganAdm.php?pagination=true";
                 $sql = "SELECT * FROM pengajuan_dospem ORDER BY status ASC, start_datetime DESC";
                 $result = mysqli_query($con, $sql);
                 
                 $rpp = 10;
                 $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
                 $tcount = mysqli_num_rows($result);
                 $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
                 $count = 0;
                 $i = ($page-1)*$rpp;
                 $no_urut = ($page-1)*$rpp;
                ?>
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Rekap Pembimbingan Skripsi Per Periode</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="24%" rowspan="2">Periode Pengajuan</td>
                            <td class="border-bottom-0" colspan="2">Durasi Pengajuan</td>
                            <td class="border-bottom-0" colspan="3">Status Pembimbingan</td>
                            <td width="12%" rowspan="2">Total</td>
                            <td rowspan="2" colspan="2" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">                           
                            <td width="14%">Mulai</td>
                            <td width="14%">Akhir</td>
                            <td width="8%">Pengajuan</td>
                            <td width="8%">Proses</td>
                            <td width="8%" class="pr-1">Selesai</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $id = $data['id'];
                            $tahap = $data['tahap'];
                            
                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$tahap'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$data[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '1' AND id_periode='$id'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                              
                            $qry2 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '2' AND id_periode='$id'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                              
                            $qry3 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '3' AND id_periode='$id'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                              
                            $qry4 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE id_periode='$id'";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );                                    
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php echo $data['start_datetime'];?> </td>
                            <td class="text-center"> <?php echo $data['end_datetime'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data1['jumData'].'</a>';} else { echo '<a href="rekapPengPemPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data2['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data2['jumData'].'</a>';} else { echo '<a href="rekapProsPemPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data2['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data3['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data3['jumData'].'</a>';} else { echo '<a href="rekapSlsaiPemPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data3['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data4['jumData'].'</a>';} else { echo '<a href="allPembPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data4['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakAllDataPembPerPeriodeAdm.php?id=<?php echo "$id";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporAllDataPembPerPeriodeAdm.php?id=<?php echo "$id";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
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
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages); ?></div>
                  </div>
                </div>
              </section>
            </div>
            <div class="row">
              <?php
                include 'pagination0.php';
                $reload0 = "rekapPembimbinganAdm.php?pagination0=true";
                $sql0 = "SELECT * FROM pengelompokan_dospem_skripsi INNER JOIN dt_mhssw ON pengelompokan_dospem_skripsi.nim=dt_mhssw.nim GROUP BY pengelompokan_dospem_skripsi.angkatan ORDER BY pengelompokan_dospem_skripsi.angkatan DESC";
                $result0 = mysqli_query($con, $sql0);
               
                $rpp0 = 10;
                $page0 = isset($_GET["page0"]) ? (intval($_GET["page0"])) : 1;
                $tcount0 = mysqli_num_rows($result0);
                $tpages0 = ($tcount0) ? ceil($tcount0/$rpp0) : 1;
                $count0 = 0;
                $i0 = ($page0-1)*$rpp0;
                $no_urut0 = ($page0-1)*$rpp0;
              ?>
           <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Rekap Pembimbingan Skripsi Per Angkatan</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="2" class="pl-1">No.</td>
                            <td width="24%" rowspan="2">Angkatan</td>
                            <td class="border-bottom-0" colspan="3">Status Pembimbingan</td>
                            <td width="16%" rowspan="2">Total</td>
                            <td rowspan="2" colspan="2" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="16%">Pengajuan</td>
                            <td width="16%">Proses</td>
                            <td width="16%" class="pr-1">Selesai</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count0<$rpp0) && ($i0<$tcount0)) {
                            mysqli_data_seek($result0, $i0);
                            $data0 = mysqli_fetch_array($result0);
                            $angkatan=$data0['angkatan'];

                            $qry111 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '1' AND angkatan='$angkatan'";
                            $has111 = mysqli_query($con,  $qry111 )or DIE( mysqli_error($con) );
                            $data111 = mysqli_fetch_assoc( $has111 );
                              
                            $qry222 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '2' AND angkatan='$angkatan'";
                            $has222 = mysqli_query($con,  $qry222 )or DIE( mysqli_error($con) );
                            $data222 = mysqli_fetch_assoc( $has222 );
                              
                            $qry333 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '3' AND angkatan='$angkatan'";
                            $has333 = mysqli_query($con,  $qry333 )or DIE( mysqli_error($con) );
                            $data333 = mysqli_fetch_assoc( $has333 );
                              
                            $qry444 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE angkatan='$angkatan'";
                            $has444 = mysqli_query($con,  $qry444 )or DIE( mysqli_error($con) );
                            $data444 = mysqli_fetch_assoc( $has444 );                                    
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut0;?> </td>
                            <td class="text-center"> <?php echo $data0['angkatan'];?> </td>
                            <td class="text-center"> <?php if($data111['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data111['jumData'].'</a>';} else { echo '<a href="pengPembPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data111['jumData'].'</a>';} ?> </td>
                            <td class="text-left"> <?php if($data222['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data222['jumData'].'</a>';} else { echo '<a href="prosPembPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data222['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data333['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data333['jumData'].'</a>';} else { echo '<a href="slsaiPembPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data333['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data444['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data444['jumData'].'</a>';} else { echo '<a href="allPembPerAngkAdm.php?angkatan='.$angkatan.'&page0='.$page0.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data444['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakAllDataPembPerAngkAdm.php?angkatan=<?php echo $angkatan;?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporAllDataPembPerAngkAdm.php?angkatan=<?php echo $angkatan;?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
                          </tr>
                          <?php
                            $i0++; 
                            $count0++;
                            }
                            ?>                
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one0($reload0, $page0, $tpages0); ?></div>
                  </div>
                </div>
              </section>
            </div>            
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Rekap Semua Pembimbingan Skripsi</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td class="border-bottom-0" colspan="3">Status Pembimbingan</td>
                            <td width="23%" rowspan="2">Total</td>
                            <td rowspan="2" colspan="2" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="23%">Pengajuan</td>
                            <td width="23%">Proses</td>
                            <td width="23%" class="pr-1">Selesai</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qry11 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '1'";
                            $has11 = mysqli_query($con,  $qry11 )or DIE( mysqli_error($con) );
                            $data11 = mysqli_fetch_assoc( $has11 );
                              
                            $qry22 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '2'";
                            $has22 = mysqli_query($con,  $qry22 )or DIE( mysqli_error($con) );
                            $data22 = mysqli_fetch_assoc( $has22 );
                              
                            $qry33 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '3'";
                            $has33 = mysqli_query($con,  $qry33 )or DIE( mysqli_error($con) );
                            $data33 = mysqli_fetch_assoc( $has33 );
                              
                            $qry44 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi";
                            $has44 = mysqli_query($con,  $qry44 )or DIE( mysqli_error($con) );
                            $data44 = mysqli_fetch_assoc( $has44 );                                    
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php if($data11['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data11['jumData'].'</a>';} else { echo '<a href="allPengPembAdm.php" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data11['jumData'].'</a>';} ?> </td>
                            <td class="text-left"> <?php if($data22['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data22['jumData'].'</a>';} else { echo '<a href="allProsPembAdm.php" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data22['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data33['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data33['jumData'].'</a>';} else { echo '<a href="allSlsaiPembAdm.php" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data33['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data44['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$data44['jumData'].'</a>';} else { echo '<a href="allPembAdm.php" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data44['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakAllDataPembAdm.php" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporAllDataPembAdm.php" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
                          </tr>                   
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
      <form action="spngjnDospemAdm.php" method="post">
        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-secondary">
              <div class="modal-header">
                <h6 class="modal-title" id="inputModalLabel">Input Periode Baru</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
                <input type="text" name="kaprodi" class="sr-only" value="<?php echo $dkaprodi['id'];?>" required readonly>
                <input type="text" name="ta" class="sr-only" value="<?php echo $dta['id'];?>" required readonly>
                <div class="form-group">
                  <label for="tahap">Tahap</label>
                  <select name="tahap" class="form-control form-control-sm bg-secondary text-white" id="tahap" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_tahap_ujprop_ujskrip ORDER BY tahap ASC");
                      while ($tampil = mysqli_fetch_array($q)){
                        echo "<option value='$tampil[id]'>$tampil[tahap]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="start_datetime">Waktu Awal Pengajuan</label>
                  <div class="input-group date" id="start_datetime_input" data-target-input="nearest">
                    <input type="text" name="start_datetime" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#start_datetime_input" required/>
                    <div class="input-group-append" data-target="#start_datetime_input" data-toggle="datetimepicker">
                      <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="end_datetime">Waktu Akhir Pengajuan</label>
                  <div class="input-group date" id="end_datetime_input" data-target-input="nearest">
                    <input type="text" name="end_datetime" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#end_datetime_input" required/>
                    <div class="input-group-append" data-target="#end_datetime_input" data-toggle="datetimepicker">
                      <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="syarat_sks">Syarat SKS yang Telah Ditempuh</label>
                  <input type="number" name="syarat_sks" class="form-control form-control-sm bg-transparent text-white" required>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input name="status" type="radio" id="customRadioInline1" class="custom-control-input" value="1" checked>
                  <label class="custom-control-label" for="customRadioInline1">Aktifkan</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input name="status" type="radio" id="customRadioInline2" class="custom-control-input" value="2">
                  <label class="custom-control-label" for="customRadioInline2">Non Aktifkan</label>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-warning btn-flat btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary btn-flat btn-sm">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(function () {
          $('#start_datetime_input').datetimepicker({
              format: 'YYYY-MM-DD HH:mm:ss',
              icons: {
              time: "fas fa-clock",
              date: "fas fa-calendar-alt",
              up: "fas fa-chevron-up",
              down: "fas fa-chevron-down",
              previous: 'fas fa-chevron-left',
              next: 'fas fa-chevron-right'
          }
          });
      });
      $(function () {
          $('#end_datetime_input').datetimepicker({
              format: 'YYYY-MM-DD HH:mm:ss',
              icons: {
              time: "fas fa-clock",
              date: "fas fa-calendar-alt",
              up: "fas fa-chevron-up",
              down: "fas fa-chevron-down",
              previous: 'fas fa-chevron-left',
              next: 'fas fa-chevron-right'
          }
          });
      });
    </script>
  </body>
</html>