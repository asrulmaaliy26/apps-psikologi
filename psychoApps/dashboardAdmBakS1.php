<?php include( "contentsConAdm.php" );?>
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
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
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
                  <h3 class="card-title">Pengajuan Dospem Skripsi</h3>
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
                    <table class="table m-0 table-bordered text-center table-sm small">
                      <thead>
                        <tr>
                          <td class="border-bottom-0 pl-1" colspan="2">Verifikasi Dospem I</td>
                          <td class="border-bottom-0" colspan="2">Verifikasi Dospem II</td>
                          <td class="border-bottom-0" colspan="2">Verifikasi Judul</td>
                          <td width="10%" class="align-middle pr-1" rowspan="2">Total</td>
                        </tr>
                        <tr>
                          <td width="15%" class="pl-1">Pending</td>
                          <td width="15%">Selesai</td>
                          <td width="15%">Pending</td>
                          <td width="15%">Selesai</td>
                          <td width="15%">Pending</td>
                          <td width="15%" class="pr-1">Selesai</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $qry1 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE cek1 = '1'";
                          $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                          $data1 = mysqli_fetch_assoc( $has1 );
                          
                          $qry2 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE cek1 = '2'";
                          $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                          $data2 = mysqli_fetch_assoc( $has2 );
                          
                          $qry3 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE cek2 = '1'";
                          $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                          $data3 = mysqli_fetch_assoc( $has3 );
                          
                          $qry4 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE cek2 = '2'";
                          $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                          $data4 = mysqli_fetch_assoc( $has4 );
                          
                          $qry5 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE cekjudul = '1'";
                          $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
                          $data5 = mysqli_fetch_assoc( $has5 );
                          
                          $qry6 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE cekjudul = '2'";
                          $has6 = mysqli_query($con,  $qry6 )or DIE( mysqli_error($con) );
                          $data6 = mysqli_fetch_assoc( $has6 );
                          
                          $qry7 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi";
                          $has7 = mysqli_query($con,  $qry7 )or DIE( mysqli_error($con) );
                          $data7 = mysqli_fetch_assoc( $has7 );                                     
                          ?> 
                        <tr>
                          <td class="pl-1"> <?php echo "$data1[jumData]";?> </td>
                          <td> <?php echo "$data2[jumData]";?> </td>
                          <td> <?php echo "$data3[jumData]";?> </td>
                          <td> <?php echo "$data4[jumData]";?> </td>
                          <td> <?php echo "$data5[jumData]";?> </td>
                          <td> <?php echo "$data6[jumData]";?> </td>
                          <td class="pr-1"> <?php echo "$data7[jumData]";?> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer clearfix">
                  <a href="pngjnDospemAdm.php" class="btn btn-outline-info btn-sm btn-flat float-right">
                  <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                </div>
              </div>
            </section>
          </div>
          <div class="row">
            <section class="col-md-12 connectedSortable">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">Pendaftaran Kompre</h3>
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
                    <table class="table m-0 table-bordered text-center table-sm small">
                      <thead>
                        <tr>
                          <td class="border-bottom-0 pl-1" colspan="3">Kelengkapan Administrasi</td>
                          <td class="border-bottom-0" colspan="2">Penjadwalan</td>
                          <td class="border-bottom-0" colspan="3">Hasil Ujian</td>
                          <td width="10%" class="align-middle text-center pr-1" rowspan="2">Total</td>
                        </tr>
                        <tr>
                          <td width="11%" class="pl-1">Pending</td>
                          <td width="11%">Kurang</td>
                          <td width="11%">Lengkap</td>
                          <td width="12%">Pending</td>
                          <td width="12%">Selesai</td>
                          <td width="11%">Pending</td>
                          <td width="11%">Tidak Lulus</td>
                          <td width="11%" class="pr-1">Lulus</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $q1 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE val_adm = ''";
                          $h1 = mysqli_query($con,  $q1 )or DIE( mysqli_error($con) );
                          $dt1 = mysqli_fetch_assoc( $h1 );
                          
                          $q2 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE val_adm = '2'";
                          $h2 = mysqli_query($con,  $q2 )or DIE( mysqli_error($con) );
                          $dt2 = mysqli_fetch_assoc( $h2 );
                          
                          $q3 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE val_adm = '1'";
                          $h3 = mysqli_query($con,  $q3 )or DIE( mysqli_error($con) );
                          $dt3 = mysqli_fetch_assoc( $h3 );
                          
                          $q4 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE statusform = '1'";
                          $h4 = mysqli_query($con,  $q4 )or DIE( mysqli_error($con) );
                          $dt4 = mysqli_fetch_assoc( $h4 );
                          
                          $q5 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE statusform = '2'";
                          $h5 = mysqli_query($con,  $q5 )or DIE( mysqli_error($con) );
                          $dt5 = mysqli_fetch_assoc( $h5 );
                          
                          $q6 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE hasil_ujian = ''";
                          $h6 = mysqli_query($con,  $q6 )or DIE( mysqli_error($con) );
                          $dt6 = mysqli_fetch_assoc( $h6 );
                          
                          $q7 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE hasil_ujian = '2'";
                          $h7 = mysqli_query($con,  $q7 )or DIE( mysqli_error($con) );
                          $dt7 = mysqli_fetch_assoc( $h7 );
                          
                          
                          $q8 = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE hasil_ujian = '1'";
                          $h8 = mysqli_query($con,  $q8 )or DIE( mysqli_error($con) );
                          $dt8 = mysqli_fetch_assoc( $h8 );
                          
                          $q9 = "SELECT COUNT(id) AS jumData FROM peserta_kompre";
                          $h9 = mysqli_query($con,  $q9 )or DIE( mysqli_error($con) );
                          $dt9 = mysqli_fetch_assoc( $h9 );                                     
                          ?> 
                        <tr>
                          <td class="pl-1"> <?php echo "$dt1[jumData]";?> </td>
                          <td> <?php echo "$dt2[jumData]";?> </td>
                          <td> <?php echo "$dt3[jumData]";?> </td>
                          <td> <?php echo "$dt4[jumData]";?> </td>
                          <td> <?php echo "$dt5[jumData]";?> </td>
                          <td> <?php echo "$dt6[jumData]";?> </td>
                          <td> <?php echo "$dt7[jumData]";?> </td>
                          <td> <?php echo "$dt8[jumData]";?> </td>
                          <td class="pr-1"> <?php echo "$dt9[jumData]";?> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer clearfix">
                  <a href="javascript:void(0)" class="btn btn-outline-info btn-sm btn-flat float-right">
                  <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                </div>
              </div>
            </section>
          </div>
          <div class="row">
            <section class="col-md-12 connectedSortable">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">Pendaftaran PKL</h3>
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
                    <table class="table m-0 table-bordered text-center table-sm small">
                      <thead>
                        <tr>
                          <td class="border-bottom-0 pl-1" colspan="3">Kelengkapan Administrasi</td>
                          <td class="border-bottom-0" colspan="2">DPL</td>
                          <td class="border-bottom-0" colspan="3">Nilai</td>
                          <td width="10%" class="align-middle text-center pr-1" rowspan="2">Total</td>
                        </tr>
                        <tr>
                          <td width="11%" class="pl-1">Pending</td>
                          <td width="11%">Kurang</td>
                          <td width="11%">Lengkap</td>
                          <td width="12%">Belum Ada</td>
                          <td width="12%">Telah Ada</td>
                          <td width="11%">Pending</td>
                          <td width="11%">Tidak Lulus</td>
                          <td width="11%" class="pr-1">Lulus</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $q1 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE statusform = '1'";
                          $h1 = mysqli_query($con,  $q1 )or DIE( mysqli_error($con) );
                          $dt1 = mysqli_fetch_assoc( $h1 );
                          
                          $q2 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE statusform = '2'";
                          $h2 = mysqli_query($con,  $q2 )or DIE( mysqli_error($con) );
                          $dt2 = mysqli_fetch_assoc( $h2 );
                          
                          $q3 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE statusform = '1'";
                          $h3 = mysqli_query($con,  $q3 )or DIE( mysqli_error($con) );
                          $dt3 = mysqli_fetch_assoc( $h3 );
                          
                          $q4 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl = ''";
                          $h4 = mysqli_query($con,  $q4 )or DIE( mysqli_error($con) );
                          $dt4 = mysqli_fetch_assoc( $h4 );
                          
                          $q5 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl != ''";
                          $h5 = mysqli_query($con,  $q5 )or DIE( mysqli_error($con) );
                          $dt5 = mysqli_fetch_assoc( $h5 );
                          
                          $q6 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nilai = ''";
                          $h6 = mysqli_query($con,  $q6 )or DIE( mysqli_error($con) );
                          $dt6 = mysqli_fetch_assoc( $h6 );
                          
                          $q7 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nilai = '
                              <60'";
                          $h7 = mysqli_query($con,  $q7 )or DIE( mysqli_error($con) );
                          $dt7 = mysqli_fetch_assoc( $h7 );
                          
                          
                          $q8 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nilai = '=>10'";
                          $h8 = mysqli_query($con,  $q8 )or DIE( mysqli_error($con) );
                          $dt8 = mysqli_fetch_assoc( $h8 );
                          
                          $q9 = "SELECT COUNT(id) AS jumData FROM peserta_pkl";
                          $h9 = mysqli_query($con,  $q9 )or DIE( mysqli_error($con) );
                          $dt9 = mysqli_fetch_assoc( $h9 );                                     
                          ?> 
                        <tr>
                          <td class="pl-1"> <?php echo "$dt1[jumData]";?> </td>
                          <td> <?php echo "$dt2[jumData]";?> </td>
                          <td> <?php echo "$dt3[jumData]";?> </td>
                          <td> <?php echo "$dt4[jumData]";?> </td>
                          <td> <?php echo "$dt5[jumData]";?> </td>
                          <td> <?php echo "$dt6[jumData]";?> </td>
                          <td> <?php echo "$dt7[jumData]";?> </td>
                          <td> <?php echo "$dt8[jumData]";?> </td>
                          <td class="pr-1"> <?php echo "$dt9[jumData]";?> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer clearfix">
                  <a href="javascript:void(0)" class="btn btn-outline-info btn-sm btn-flat float-right">
                  <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                </div>
              </div>
            </section>
          </div>
          <div class="row">
            <section class="col-md-12 connectedSortable">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">Pendaftaran Seminar Proposal Skripsi</h3>
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
                    <table class="table m-0 table-bordered text-center table-sm small">
                      <thead>
                        <tr>
                          <td class="border-bottom-0 pl-1" colspan="2">Kelengkapan Administrasi</td>
                          <td class="border-bottom-0" colspan="2">Penjadwalan</td>
                          <td class="border-bottom-0" colspan="4">Hasil Seminar</td>
                          <td width="10%" class="align-middle text-center pr-1" rowspan="2">Total</td>
                        </tr>
                        <tr>
                          <td width="11%" class="pl-1">Kurang</td>
                          <td width="11%">Lengkap</td>
                          <td width="12%">Pending</td>
                          <td width="12%">Selesai</td>
                          <td width="11%">Pending</td>
                          <td width="11%">Seminar Ulang</td>
                          <td width="11%">Lanjut dg Catatan</td>
                          <td width="11%" class="pr-1">Lanjut</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $q1 = "SELECT COUNT(id) AS jumData FROM peserta_sempro WHERE file_skkm = '' AND file_prop = ''";
                          $h1 = mysqli_query($con,  $q1 )or DIE( mysqli_error($con) );
                          $dt1 = mysqli_fetch_assoc( $h1 );
                          
                          $q2 = "SELECT COUNT(id) AS jumData FROM peserta_sempro WHERE file_skkm != '' AND file_prop != ''";
                          $h2 = mysqli_query($con,  $q2 )or DIE( mysqli_error($con) );
                          $dt2 = mysqli_fetch_assoc( $h2 );
                          
                          $q3 = "SELECT COUNT(id) AS jumData FROM jadwal_sempro WHERE tgl_seminar = ''";
                          $h3 = mysqli_query($con,  $q3 )or DIE( mysqli_error($con) );
                          $dt3 = mysqli_fetch_assoc( $h3 );
                          
                          $q4 = "SELECT COUNT(id) AS jumData FROM jadwal_sempro WHERE tgl_seminar != ''";
                          $h4 = mysqli_query($con,  $q4 )or DIE( mysqli_error($con) );
                          $dt4 = mysqli_fetch_assoc( $h4 );
                          
                          $q5 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE rekom = ''";
                          $h5 = mysqli_query($con,  $q5 )or DIE( mysqli_error($con) );
                          $dt5 = mysqli_fetch_assoc( $h5 );
                          
                          $q6 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE rekom = '3'";
                          $h6 = mysqli_query($con,  $q6 )or DIE( mysqli_error($con) );
                          $dt6 = mysqli_fetch_assoc( $h6 );
                          
                          $q7 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE rekom = '2'";
                          $h7 = mysqli_query($con,  $q7 )or DIE( mysqli_error($con) );
                          $dt7 = mysqli_fetch_assoc( $h7 );
                          
                          
                          $q8 = "SELECT COUNT(id) AS jumData FROM nilai_sempro WHERE rekom = '1'";
                          $h8 = mysqli_query($con,  $q8 )or DIE( mysqli_error($con) );
                          $dt8 = mysqli_fetch_assoc( $h8 );
                          
                          $q9 = "SELECT COUNT(id) AS jumData FROM peserta_sempro";
                          $h9 = mysqli_query($con,  $q9 )or DIE( mysqli_error($con) );
                          $dt9 = mysqli_fetch_assoc( $h9 );                                     
                          ?> 
                        <tr>
                          <td class="pl-1"> <?php echo "$dt1[jumData]";?> </td>
                          <td> <?php echo "$dt2[jumData]";?> </td>
                          <td> <?php echo "$dt3[jumData]";?> </td>
                          <td> <?php echo "$dt4[jumData]";?> </td>
                          <td> <?php echo "$dt5[jumData]";?> </td>
                          <td> <?php echo "$dt6[jumData]";?> </td>
                          <td> <?php echo "$dt7[jumData]";?> </td>
                          <td> <?php echo "$dt8[jumData]";?> </td>
                          <td class="pr-1"> <?php echo "$dt9[jumData]";?> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer clearfix">
                  <a href="javascript:void(0)" class="btn btn-outline-info btn-sm btn-flat float-right">
                  <i class="fas fa-caret-square-right"></i> Lebih detail </a>
                </div>
              </div>
            </section>
          </div>
          <div class="row">
            <section class="col-md-12 connectedSortable">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">Pendaftaran Ujian/Sidang Skripsi</h3>
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
                    <table class="table m-0 table-bordered text-center table-sm small">
                      <thead>
                        <tr>
                          <td class="border-bottom-0 pl-1" colspan="2">Kelengkapan Administrasi</td>
                          <td class="border-bottom-0" colspan="2">Penjadwalan</td>
                          <td class="border-bottom-0" colspan="7">Hasil Ujian/Sidang</td>
                          <td width="9%" class="align-middle text-center pr-1" rowspan="2">Total</td>
                        </tr>
                        <tr>
                          <td width="8%" class="pl-1">Kurang</td>
                          <td width="8%">Lengkap</td>
                          <td width="9%">Pending</td>
                          <td width="9%">Selesai</td>
                          <td width="9%">Pending</td>
                          <td width="8%">A</td>
                          <td width="8%">B+</td>
                          <td width="8%">B</td>
                          <td width="8%">C+</td>
                          <td width="8%">C</td>
                          <td width="8%" class="pr-1">D</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          /* $q1 = "SELECT COUNT(id) AS jumData FROM peserta_ujskrip WHERE file_skripsi = '' AND file_transkrip = '' AND file_acc = ''";
                          $h1 = mysqli_query($con,  $q1 )or DIE( mysqli_error($con) );
                          $dt1 = mysqli_fetch_assoc( $h1 );
                          
                          $q2 = "SELECT COUNT(id) AS jumData FROM peserta_ujskrip WHERE file_skripsi != '' AND file_transkrip != '' AND file_acc != ''";
                          $h2 = mysqli_query($con,  $q2 )or DIE( mysqli_error($con) );
                          $dt2 = mysqli_fetch_assoc( $h2 ); */
                          
                          $q3 = "SELECT COUNT(id) AS jumData FROM jadwal_ujskrip WHERE tgl_ujian = ''";
                          $h3 = mysqli_query($con,  $q3 )or DIE( mysqli_error($con) );
                          $dt3 = mysqli_fetch_assoc( $h3 );
                          
                          $q4 = "SELECT COUNT(id) AS jumData FROM jadwal_ujskrip WHERE tgl_ujian != ''";
                          $h4 = mysqli_query($con,  $q4 )or DIE( mysqli_error($con) );
                          $dt4 = mysqli_fetch_assoc( $h4 );
                          
                          $q5 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE nilai_ketua = '' OR nilai_sekretaris = '' OR nilai_utama = ''";
                          $h5 = mysqli_query($con,  $q5 )or DIE( mysqli_error($con) );
                          $dt5 = mysqli_fetch_assoc( $h5 );
                          
                          $q6 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE (nilai_ketua + nilai_sekretaris + nilai_utama / 3) >= '85' AND (nilai_ketua + nilai_sekretaris + nilai_utama / 3) <= '100'";
                          $h6 = mysqli_query($con,  $q6 )or DIE( mysqli_error($con) );
                          $dt6 = mysqli_fetch_assoc( $h6 );
                          
                          $q7 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE (nilai_ketua + nilai_sekretaris + nilai_utama / 3) >= '75' AND (nilai_ketua + nilai_sekretaris + nilai_utama / 3) <= '84'";
                          $h7 = mysqli_query($con,  $q7 )or DIE( mysqli_error($con) );
                          $dt7 = mysqli_fetch_assoc( $h7 );
                          
                          $q8 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE (nilai_ketua + nilai_sekretaris + nilai_utama / 3) >= '70' AND (nilai_ketua + nilai_sekretaris + nilai_utama / 3) <= '64'";
                          $h8 = mysqli_query($con,  $q8 )or DIE( mysqli_error($con) );
                          $dt8 = mysqli_fetch_assoc( $h8 );
                          
                          $q9 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE (nilai_ketua + nilai_sekretaris + nilai_utama / 3) >= '65' AND (nilai_ketua + nilai_sekretaris + nilai_utama / 3) <= '69'";
                          $h9 = mysqli_query($con,  $q9 )or DIE( mysqli_error($con) );
                          $dt9 = mysqli_fetch_assoc( $h9 );
                          
                          $q10 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE (nilai_ketua + nilai_sekretaris + nilai_utama / 3) >= '60' AND (nilai_ketua + nilai_sekretaris + nilai_utama / 3) <= '64'";
                          $h10 = mysqli_query($con,  $q10 )or DIE( mysqli_error($con) );
                          $dt10 = mysqli_fetch_assoc( $h10 );
                          
                          $q11 = "SELECT COUNT(id) AS jumData FROM nilai_ujskrip WHERE (nilai_ketua + nilai_sekretaris + nilai_utama / 3) < '60'";
                          $h11 = mysqli_query($con,  $q11 )or DIE( mysqli_error($con) );
                          $dt11 = mysqli_fetch_assoc( $h11 );
                          
                          $q12 = "SELECT COUNT(id) AS jumData FROM peserta_ujskrip";
                          $h12 = mysqli_query($con,  $q12 )or DIE( mysqli_error($con) );
                          $dt12 = mysqli_fetch_assoc( $h12 );                                                    
                          ?> 
                        <tr>
                          <td class="pl-1"> <?php echo "$dt1[jumData]";?> </td>
                          <td> <?php echo "$dt2[jumData]";?> </td>
                          <td> <?php echo "$dt3[jumData]";?> </td>
                          <td> <?php echo "$dt4[jumData]";?> </td>
                          <td> <?php echo "$dt5[jumData]";?> </td>
                          <td> <?php echo "$dt6[jumData]";?> </td>
                          <td> <?php echo "$dt7[jumData]";?> </td>
                          <td> <?php echo "$dt8[jumData]";?> </td>
                          <td> <?php echo "$dt9[jumData]";?> </td>
                          <td> <?php echo "$dt10[jumData]";?> </td>
                          <td> <?php echo "$dt11[jumData]";?> </td>
                          <td class="pr-1"> <?php echo "$dt12[jumData]";?> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer clearfix">
                  <a href="javascript:void(0)" class="btn btn-outline-info btn-sm btn-flat float-right">
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