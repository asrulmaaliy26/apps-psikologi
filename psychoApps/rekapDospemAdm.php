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
                <h6 class="m-0">Rekap Dospem Skripsi</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Rekap Dospem Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "rekapDospemAdm.php?pagination=true";
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
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Rekap Dospem Skripsi Per Periode</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="50%" rowspan="2">Periode Pengajuan</td>
                            <td class="border-bottom-0" colspan="2">Durasi Pengajuan</td>
                            <td width="10%" rowspan="2">Total Dospem</td>
                            <td rowspan="2" colspan="2" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td class="pl-1" width="14%">Mulai</td>
                            <td class="pr-1" width="14%">Akhir</td>
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

                            $qryjumdospem = "SELECT COUNT(id) AS jumData FROM dospem_skripsi WHERE id_periode='$id'";
                            $resjumdospem = mysqli_query($con,  $qryjumdospem )or DIE( mysqli_error($con) );
                            $dtjumDospem = mysqli_fetch_array( $resjumdospem );
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php echo $data['start_datetime'];?> </td>
                            <td class="text-center"> <?php echo $data['end_datetime'];?> </td>
                            <td class="text-center"> <?php if($dtjumDospem['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$dtjumDospem['jumData'].'</a>';} else { echo '<a href="rekapDospemPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$dtjumDospem['jumData'].'</a>';} ?> </td>
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
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                      <h4 class="card-title float-left">Rekap Semua Dospem Skripsi</h4>
                      <div class="card-tools">
                  <a href="cetakAllDataDospemAdm.php" type="button" class="btn btn-outline-success btn-flat btn-xs datarange" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a>
                  <a href="eksporAllDataDospemAdm.php" type="button" class="btn btn-outline-success btn-flat btn-xs" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a>
                </div>
               
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="31%" rowspan="2">Nama</td>
                            <td class="border-bottom-0" colspan="2">Pengajuan</td>
                            <td class="border-bottom-0" colspan="2">Proses</td>
                            <td class="border-bottom-0" colspan="2">Selesai</td>
                            <td class="border-bottom-0" colspan="2">Total</td>
                            <td class="pr-1" rowspan="2" width="9%">Total<br> Dospem I & II</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td class="pl-1" width="7%">Dospem I</td>
                            <td width="7%">Dospem II</td>
                            <td width="7%">Dospem I</td>
                            <td width="7%">Dospem II</td>
                            <td width="7%">Dospem I</td>
                            <td width="7%">Dospem II</td>
                            <td width="7%">Dospem I</td>
                            <td class="pr-1" width="7%">Dospem II</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sqlall = "SELECT * FROM dospem_skripsi INNER JOIN dt_pegawai ON dospem_skripsi.nip=dt_pegawai.id GROUP BY dospem_skripsi.nip ORDER BY dt_pegawai.nama_tg ASC";
                            $resultall = mysqli_query($con, $sqlall);
                            while($dataall = mysqli_fetch_array($resultall)) {
                            $nip=$dataall['nip'];
                            
                            $qdt_dospem = "SELECT * FROM dt_pegawai WHERE id='$nip'";
                            $hdt_dospem = mysqli_query($con, $qdt_dospem);
                            $ddospem = mysqli_fetch_array($hdt_dospem);
                            
                            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddospem[kepakaran_mayor]'";
                            $rr = mysqli_query($con, $qr)or die( mysqli_error($con));
                            $dr = mysqli_fetch_assoc($rr);
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataall[nip]' AND cek1 = '1' AND status='1'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_array( $has1 );
                              
                            $qry2 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataall[nip]' AND cek2 = '1' AND status='1'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_array( $has2 );
                              
                            $qry3 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataall[nip]' AND (cek1='2' OR cek1='3') AND status='2'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_array( $has3 );
                              
                            $qry4 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataall[nip]' AND (cek2='2' OR cek2='3') AND status='2'";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_array( $has4 );
                              
                            $qry5 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataall[nip]' AND (cek1='2' OR cek1='3') AND status='3'";
                            $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
                            $data5 = mysqli_fetch_array( $has5 );
                              
                            $qry6 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataall[nip]' AND (cek2='2' OR cek2='3') AND status='3'";
                            $has6 = mysqli_query($con,  $qry6 )or DIE( mysqli_error($con) );
                            $data6 = mysqli_fetch_array( $has6 );
                              
                            $qry7 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataall[nip]' AND (cek1='2' OR cek1='3')";
                            $has7 = mysqli_query($con,  $qry7 )or DIE( mysqli_error($con) );
                            $data7 = mysqli_fetch_array( $has7 );
                            
                            $qry8 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataall[nip]' AND (cek2='2' OR cek2='3')";
                            $has8 = mysqli_query($con,  $qry8 )or DIE( mysqli_error($con) );
                            $data8 = mysqli_fetch_array( $has8 );
                            
                            $totalsatudua = ($data7['jumData'] + $data8['jumData']);
                            $no++;
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $ddospem['nama_tg'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data1['jumData'].'</a>';} else { echo '<a href="perDospemSatuPendingAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data2['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data2['jumData'].'</a>';} else { echo '<a href="perDospemDuaPendingAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data2['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data3['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data3['jumData'].'</a>';} else { echo '<a href="perDospemSatuProsesAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data3['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data4['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data4['jumData'].'</a>';} else { echo '<a href="perDospemDuaProsesAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data4['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data5['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data5['jumData'].'</a>';} else { echo '<a href="perDospemSatuSelesaiAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data5['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data6['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data6['jumData'].'</a>';} else { echo '<a href="perDospemDuaSelesaiAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data6['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data7['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data7['jumData'].'</a>';} else { echo '<a href="totalDospemSatuAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data7['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data8['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data8['jumData'].'</a>';} else { echo '<a href="totalDospemDuaAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data8['jumData'].'</a>';} ?> </td>
                            <td class="text-center pr-1"> <?php if($totalsatudua==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$totalsatudua.'</a>';} else { echo '<a href="totalDospemSatuDuaAdm.php?id='.$nip.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$totalsatudua.'</a>';} ?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="11">
                              <section class="content pt-2">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                          <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                              src="<?php echo '/sikep/'.$ddospem['photo'];?>" onError="this.onerror=null;this.src='<?php if($ddospem['jenis_kelamin']==1){echo "/sikep/images/cewek.png";} else {echo "/sikep/images/cowok.png";}?>';" alt="">
                                          </div>
                                          <h3 class="profile-username text-center"><?php echo $ddospem['nama'];?></h3>
                                          <p class="text-muted text-center"><?php echo $ddospem['id'];?></p>
                                          <ul class="list-group list-group-unbordered mb-3 text-left">
                                            <li class="list-group-item">
                                              <b>Kontak</b> <a class="float-right"><?php echo $ddospem['kntk1'];?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Email</b> <a class="float-right"><?php echo $ddospem['email1'];?></a>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="card">
                                        <div class="card-header">
                                          <h3 class="card-title">Profil</h3>
                                        </div>
                                        <div class="card-body text-left pb-0">
                                          <strong><i class="fas fa-user-graduate mr-1"></i> Kepakaran Mayor</strong>
                                          <p class="text-muted"><?php echo $dr['nm'];?></p>
                                          <hr>
                                          <strong><i class="fas fa-user-graduate mr-1"></i> Kepakaran Minor</strong>
                                          <p class="text-muted"><?php echo $ddospem['kepakaran_minor'];?></p>
                                          <hr>
                                          <strong><i class="fas fa-user-graduate mr-1"></i> Tren Riset</strong>
                                          <p class="text-muted"><?php echo $ddospem['trend_riset']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $ddospem['trend_riset']);?></p>
                                          <hr>
                                          <strong><i class="fas fa-user-graduate mr-1"></i> Riset Terkini</strong>
                                          <p class="text-muted"><?php echo $ddospem['profil_riset_terkini']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $ddospem['profil_riset_terkini']);?></p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </section>
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