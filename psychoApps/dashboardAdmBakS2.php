<?php include( "contentsConAdm.php" );?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS2.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Dashboard</h4>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-6 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Pengajuan Peminatan Rumpun Psikologi</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0 table-bordered text-center table-sm">
                        <thead>
                          <tr>
                            <td width="30%" class="border-bottom-0 pl-1">Pengajuan</td>
                            <td width="30%" class="border-bottom-0">Terverifikasi</td>
                            <td width="40%" class="border-bottom-0 pr-1">Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_rumpun WHERE cek = '1'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qry2 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_rumpun WHERE cek = '2'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_rumpun";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            ?> 
                          <tr>
                            <td class="pl-1"> <?php echo "$data1[jumData]";?> </td>
                            <td> <?php echo "$data2[jumData]";?> </td>
                            <td class="pr-1"> <?php echo "$data3[jumData]";?> </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer clearfix">
                    <a href="magPprpAdm.php" class="btn btn-outline-success btn-sm float-right">
                    <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                  </div>
                </div>
              </section>
              <section class="col-md-6 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Pengajuan Academic Coach</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0 table-bordered text-center table-sm">
                        <thead>
                          <tr>
                            <td width="25%" class="border-bottom-0 pl-1">Pengajuan</td>
                            <td width="25%" class="border-bottom-0">Proses</td>
                            <td width="25%" class="border-bottom-0">Selesai</td>
                            <td width="25%" class="border-bottom-0 pr-1">Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dosen_wali WHERE cek = '1'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qry2 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dosen_wali WHERE cek = '2' AND status='1'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dosen_wali WHERE cek = '2' AND status='2'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            
                            $qry4 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dosen_wali";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );
                            ?> 
                          <tr>
                            <td class="pl-1"> <?php echo "$data1[jumData]";?> </td>
                            <td> <?php echo "$data2[jumData]";?> </td>
                            <td> <?php echo "$data3[jumData]";?> </td>
                            <td class="pr-1"> <?php echo "$data4[jumData]";?> </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer clearfix">
                    <a href="magRekapPacAdm.php" class="btn btn-outline-success btn-sm float-right">
                    <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                  </div>
                </div>
              </section>
            </div>
            <div class="row">
              <section class="col-md-4 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Pengajuan Dospem Tesis</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0 table-bordered text-center table-sm">
                        <thead>
                          <tr>
                            <td width="25%" class="border-bottom-0 pl-1">Pengajuan</td>
                            <td width="25%" class="border-bottom-0">Proses</td>
                            <td width="25%" class="border-bottom-0">Selesai</td>
                            <td width="25%" class="border-bottom-0 pr-1">Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE cek1='1' AND cek2='1'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qry2 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE cek1='2' AND cek2='2' AND cekjudul='2' AND status='1'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE cek1='2' AND cek2='2' AND cekjudul='2' AND status='2'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            
                            $qry4 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dospem_tesis";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );
                            ?> 
                          <tr>
                            <td class="pl-1"> <?php echo "$data1[jumData]";?> </td>
                            <td> <?php echo "$data2[jumData]";?> </td>
                            <td> <?php echo "$data3[jumData]";?> </td>
                            <td class="pr-1"> <?php echo "$data4[jumData]";?> </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer clearfix">
                    <a href="magRekapPptAdm.php" class="btn btn-outline-success btn-sm float-right">
                    <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                  </div>
                </div>
              </section>
              <section class="col-md-4 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Seminar Proposal Tesis</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0 table-bordered text-center table-sm">
                        <thead>
                          <tr>
                            <td width="40%" class="border-bottom-0 pl-1">Belum Terjadwal</td>
                            <td width="40%" class="border-bottom-0">Telah Terjadwal</td>
                            <td width="20%" class="border-bottom-0 pr-1">Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_peserta_sempro WHERE cek='1'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qry2 = "SELECT COUNT(id) AS jumData FROM mag_peserta_sempro WHERE cek='2'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM mag_peserta_sempro";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            ?> 
                          <tr>
                            <td class="pl-1"> <?php echo "$data1[jumData]";?> </td>
                            <td> <?php echo "$data2[jumData]";?> </td>
                            <td class="pr-1"> <?php echo "$data3[jumData]";?> </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer clearfix">
                    <a href="magRekapPendSemproAdm.php" class="btn btn-outline-success btn-sm float-right">
                    <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                  </div>
                </div>
              </section>
              <section class="col-md-4 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Ujian Tesis</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0 table-bordered text-center table-sm">
                        <thead>
                          <tr>
                            <td width="40%" class="border-bottom-0 pl-1">Belum Terjadwal</td>
                            <td width="40%" class="border-bottom-0">Telah Terjadwal</td>
                            <td width="20%" class="border-bottom-0 pr-1">Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_peserta_ujtes WHERE cek='1'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qry2 = "SELECT COUNT(id) AS jumData FROM mag_peserta_ujtes WHERE cek='2'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM mag_peserta_ujtes";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            ?> 
                          <tr>
                            <td class="pl-1"> <?php echo "$data1[jumData]";?> </td>
                            <td> <?php echo "$data2[jumData]";?> </td>
                            <td class="pr-1"> <?php echo "$data3[jumData]";?> </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer clearfix">
                    <a href="magRekapPendUjtesAdm.php" class="btn btn-outline-success btn-sm float-right">
                    <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                  </div>
                </div>
              </section>
            </div>
            <div class="row">
              <section class="col-md-6 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Revisi Seminar Proposal Tesis</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0 table-bordered text-center table-sm">
                        <thead>
                          <tr>
                            <td width="25%" class="border-bottom-0 pl-1">Belum Divalidasi</td>
                            <td width="25%" class="border-bottom-0">Diterima</td>
                            <td width="25%" class="border-bottom-0">Ditolak</td>
                            <td width="25%" class="border-bottom-0 pr-1">Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_revisi_sempro WHERE cek = '1'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qry2 = "SELECT COUNT(id) AS jumData FROM mag_revisi_sempro WHERE cek = '2'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM mag_revisi_sempro WHERE cek = '3'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            
                            $qry4 = "SELECT COUNT(id) AS jumData FROM mag_revisi_sempro";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );
                            ?> 
                          <tr>
                            <td class="pl-1"> <?php echo "$data1[jumData]";?> </td>
                            <td> <?php echo "$data2[jumData]";?> </td>
                            <td> <?php echo "$data3[jumData]";?> </td>
                            <td class="pr-1"> <?php echo "$data4[jumData]";?> </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer clearfix">
                    <a href="magRekapRevSemproTesAdm.php" class="btn btn-outline-success btn-sm float-right">
                    <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                  </div>
                </div>
              </section>
              <section class="col-md-6 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Revisi Ujian Tesis</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0 table-bordered text-center table-sm">
                        <thead>
                          <tr>
                            <td width="25%" class="border-bottom-0 pl-1">Belum Divalidasi</td>
                            <td width="25%" class="border-bottom-0">Diterima</td>
                            <td width="25%" class="border-bottom-0">Ditolak</td>
                            <td width="25%" class="border-bottom-0 pr-1">Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_revisi_tesis WHERE cek = '1'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qry2 = "SELECT COUNT(id) AS jumData FROM mag_revisi_tesis WHERE cek = '2'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                            
                            $qry3 = "SELECT COUNT(id) AS jumData FROM mag_revisi_tesis WHERE cek = '3'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                            
                            $qry4 = "SELECT COUNT(id) AS jumData FROM mag_revisi_tesis";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );
                            ?> 
                          <tr>
                            <td class="pl-1"> <?php echo "$data1[jumData]";?> </td>
                            <td> <?php echo "$data2[jumData]";?> </td>
                            <td> <?php echo "$data3[jumData]";?> </td>
                            <td class="pr-1"> <?php echo "$data4[jumData]";?> </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer clearfix">
                    <a href="magRekapRevUjtesAdm.php" class="btn btn-outline-success btn-sm float-right">
                    <i class="fas fa-caret-square-right"></i> Lebih detail </a>
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