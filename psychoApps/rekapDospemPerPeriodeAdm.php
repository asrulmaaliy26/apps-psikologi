<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qidper = "SELECT * FROM pengajuan_dospem WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
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
                <h6 class="m-0">Rekap Dospem Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapDospemAdm.php?page=<?php echo $page;?>">Rekap Dospem Skripsi Per Periode</a></li>
                  <li class="breadcrumb-item active small">List Dospem Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">List Dospem Skripsi</h4>
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
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM dospem_skripsi INNER JOIN dt_pegawai ON dospem_skripsi.nip=dt_pegawai.id WHERE dospem_skripsi.id_periode='$id' GROUP BY dospem_skripsi.nip ORDER BY dt_pegawai.nama_tg ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $qdt_dospem = "SELECT * FROM dt_pegawai WHERE id='$data[nip]'";
                            $hdt_dospem = mysqli_query($con, $qdt_dospem);
                            $ddospem = mysqli_fetch_array($hdt_dospem);
                            
                            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddospem[kepakaran_mayor]'";
                            $rr = mysqli_query($con, $qr)or die( mysqli_error($con));
                            $dr = mysqli_fetch_assoc($rr);
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND cek1 = '1' AND status='1' AND id_periode='$id'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_array( $has1 );
                              
                            $qry2 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND cek2 = '1' AND status='1' AND id_periode='$id'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_array( $has2 );
                              
                            $qry3 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND (cek1='2' OR cek1='3') AND status='2' AND id_periode='$id'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_array( $has3 );
                              
                            $qry4 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND (cek2='2' OR cek2='3') AND status='2' AND id_periode='$id'";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_array( $has4 );
                              
                            $qry5 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND (cek1='2' OR cek1='3') AND status='3' AND id_periode='$id'";
                            $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
                            $data5 = mysqli_fetch_array( $has5 );
                              
                            $qry6 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND (cek2='2' OR cek2='3') AND status='3' AND id_periode='$id'";
                            $has6 = mysqli_query($con,  $qry6 )or DIE( mysqli_error($con) );
                            $data6 = mysqli_fetch_array( $has6 );
                              
                            $qry7 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND (cek1='2' OR cek1='3') AND id_periode='$id'";
                            $has7 = mysqli_query($con,  $qry7 )or DIE( mysqli_error($con) );
                            $data7 = mysqli_fetch_array( $has7 );
                            
                            $qry8 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND (cek2='2' OR cek2='3') AND id_periode='$id'";
                            $has8 = mysqli_query($con,  $qry8 )or DIE( mysqli_error($con) );
                            $data8 = mysqli_fetch_array( $has8 );
                            
                            $totalsatudua = ($data7['jumData'] + $data8['jumData']);
                            $no++;
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $ddospem['nama_tg'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data1['jumData'].'</a>';} else { echo '<a href="perDospemSatuPendingPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data2['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data2['jumData'].'</a>';} else { echo '<a href="perDospemDuaPendingPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data2['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data3['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data3['jumData'].'</a>';} else { echo '<a href="perDospemSatuProsesPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data3['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data4['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data4['jumData'].'</a>';} else { echo '<a href="perDospemDuaProsesPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data4['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data5['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data5['jumData'].'</a>';} else { echo '<a href="perDospemSatuSelesaiPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data5['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data6['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data6['jumData'].'</a>';} else { echo '<a href="perDospemDuaSelesaiPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data6['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data7['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data7['jumData'].'</a>';} else { echo '<a href="totalDospemSatuPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data7['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data8['jumData']==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$data8['jumData'].'</a>';} else { echo '<a href="totalDospemDuaPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data8['jumData'].'</a>';} ?> </td>
                            <td class="text-center pr-1"> <?php if($totalsatudua==0) { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data">'.$totalsatudua.'</a>';} else { echo '<a href="totalDospemSatuDuaPerPeriodeAdm.php?nip='.$data['nip'].'&id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$totalsatudua.'</a>';} ?> </td>
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