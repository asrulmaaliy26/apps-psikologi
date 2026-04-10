<?php include( "contentsConAdm.php" );
  $qta = "SELECT * FROM dt_ta WHERE status='1'";
  $rta = mysqli_query($con, $qta)or die( mysqli_error($con));
  $dta = mysqli_fetch_assoc($rta);   
   
  $qwd1 = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '47'";
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
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifSama') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Submit Gagal! Periode sudah ada!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifTa') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Submit Gagal! Tahun Akademik tidak ada yang aktif! Aktifkan terlebih dahulu!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifSetengah') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Update gagal. Ada tahap yang sama dalam satu Periode Tahun Akademik. Hanya durasi pendaftaran, sks disyaratkan, grade nilai dan ketua PKL yang berhasil diupdate.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Submit berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Edit berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Delete berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifUpdateStatus') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Periode berhasil diaktifkan!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pendaftaran PKL</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Periode Pendaftaran</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "pndftrnPklAdm.php?pagination=true";
           $sql = "SELECT * FROM pendaftaran_pkl ORDER BY status ASC, start_datetime DESC";
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
                      <h4 class="card-title float-left">Periode Pendaftaran</h4>
                      <button type="button" class="btn btn-outline-danger btn-flat btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="fas fa-calendar-plus"></i> Input Periode Baru</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="16%" rowspan="2">Periode Pendaftaran</td>
                            <td class="border-bottom-0" rowspan="2" colspan="2">Durasi Pendaftaran</td>
                            <td colspan="3" class="border-bottom-0">Verifikasi</td>
                            <td colspan="2" class="border-bottom-0">DPL dan Lokasi</td>
                            <td colspan="2" class="border-bottom-0">Nilai</td>
                            <td width="5%" rowspan="2">Total</td>
                            <td class="pr-1" rowspan="2" colspan="5">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="5%" class="border-bottom-0 pl-1">Pending</td>
                            <td width="5%" class="border-bottom-0">Diterima</td>
                            <td width="5%" class="border-bottom-0">Ditolak</td>
                            <td width="5%" class="border-bottom-0">Pending</td>
                            <td width="5%" class="border-bottom-0">Selesai</td>
                            <td width="4%" class="border-bottom-0">Lulus</td>
                            <td width="4%" class="border-bottom-0 pr-1">Gagal</td>
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
                            
                            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$id'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE val_adm = '1' AND id_pkl='$id'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                              
                            $qry2 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE val_adm = '2' AND id_pkl='$id'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                              
                            $qry3 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE val_adm = '3' AND id_pkl='$id'";
                            $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
                            $data3 = mysqli_fetch_assoc( $has3 );
                              
                            $qry4 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE statusform = '1' AND id_pkl='$id'";
                            $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
                            $data4 = mysqli_fetch_assoc( $has4 );
                              
                            $qry5 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE statusform = '2' AND id_pkl='$id'";
                            $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
                            $data5 = mysqli_fetch_assoc( $has5 );
                            
                            $qry6 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE (nilai <= '$dt_grade[at]' AND nilai >= '$dt_grade[cb]') AND (id_pkl='$id')";
                            $has6 = mysqli_query($con,  $qry6 )or DIE( mysqli_error($con) );
                            $data6 = mysqli_fetch_assoc( $has6 );
                              
                            $qry7 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE (nilai <= '$dt_grade[dt]' AND nilai >= '$dt_grade[db]') AND (id_pkl='$id')";
                            $has7 = mysqli_query($con,  $qry7 )or DIE( mysqli_error($con) );
                            $data7 = mysqli_fetch_assoc( $has7 );
                            
                            $qry8 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE id_pkl = '$id'";
                            $has8 = mysqli_query($con,  $qry8 )or DIE( mysqli_error($con) );
                            $data8 = mysqli_fetch_assoc( $has8 );

                            $qry9 = "SELECT COUNT(id) AS jumData FROM dpl_pkl WHERE id_pkl = '$id'";
                            $has9 = mysqli_query($con,  $qry9 )or DIE( mysqli_error($con) );
                            $data9 = mysqli_fetch_assoc( $has9 );
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td width="12%" class="text-center"> <?php echo $data['start_datetime'];?> </td>
                            <td width="12%" class="text-center"> <?php echo $data['end_datetime'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data1['jumData'].'</a>';} else { echo '<a href="verPklPendingAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data2['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data2['jumData'].'</a>';} else { echo '<a href="verPklTerimaAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data2['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data3['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data3['jumData'].'</a>';} else { echo '<a href="verPklTolakAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data3['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data4['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data4['jumData'].'</a>';} else { echo '<a href="dplPendingAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data4['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data5['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data5['jumData'].'</a>';} else { echo '<a href="dplSelesaiAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data5['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data6['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data6['jumData'].'</a>';} else { echo '<a href="peslulusPklAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data6['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data7['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data7['jumData'].'</a>';} else { echo '<a href="pesgagalPklAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data7['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data8['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data8['jumData'].'</a>';} else { echo '<a href="allPesPklPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data8['jumData'].'</a>';} ?> </td>
                            <td width="4%" class="text-center pr-1"> <?php if($data['status']==1) { echo "<button class='btn btn-outline-primary btn-flat btn-xs btn-block' title='Sedang aktif'><i class='fas fa-calendar-check'></i></button>";} else { echo "<a class='btn btn-outline-secondary btn-flat btn-xs btn-block' title='Tidak aktif' href='updateStatusPeriodePkl.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin periode pendaftaran ini diaktifkan?\")'><i class='far fa-calendar-times'></i></a>";}?> </td>
                            <td class="text-center" width="4%"> <a href="dplPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>" class="btn btn-outline-info btn-flat btn-xs btn-block" title="Lihat, input dan edit dosen pembimbing lapangan"><i class="fas fa-user-graduate"></i></a> </td>
                            <td class="text-center" width="4%"> <?php if($data8['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada peserta\')" title="Tidak ada peserta"><i class="fas fa-user-edit"></i></a>';} else { echo '<a href="verpesPklPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-danger btn-flat btn-xs btn-block" title="Verifikasi pendaftaran"><i class="fas fa-user-edit"></i></a>';} ?> </td>
                            <td class="text-center" width="4%"> <a href="editPeriodePendPklAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Edit periode"><i class="far fa-edit"></i></a> </td>
                            <td class="text-center pr-1" width="4%">
                              <div class="btn-group">
                                <a type="button" title="Opsi lainnya" class="btn btn-outline-info btn-flat btn-xs btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-expand"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                  <?php if($data8['jumData']==0) { echo '<a class="dropdown-item text-success text-center small" onclick="return confirm(\'Tidak ada peserta\')" title="Tidak ada peserta"><i class="fas fa-house-user"></i> Pendistribusian DPL</a>';} else { echo '<a class="dropdown-item text-success text-center small" href="pengelompokanPesPerDplPerPeriodeAdm.php?id='.$id.'&page='.$page.'" title="Lihat, input dan edit pendistribusian DPL"><i class="fas fa-house-user"></i> Pendistribusian DPL</a>';} ?>
                                  <div class="dropdown-divider"></div>
                                  <?php if($data8['jumData']==0) { echo '<a class="dropdown-item text-success text-center small" onclick="return confirm(\'Tidak ada peserta\')" title="Tidak ada peserta"><i class="fas fa-sort-numeric-up-alt"></i> Kelola Nilai</a>';} elseif($data9['jumData']==0) { echo '<a class="dropdown-item text-success text-center small" onclick="return confirm(\'Tentukan/Distribusikan/kelola DPL terlebih dahulu!\')" title="Tentukan/Distribusikan/kelola DPL terlebih dahulu!"><i class="fas fa-sort-numeric-up-alt"></i> Kelola Nilai</a>';} else { echo '<a class="dropdown-item text-success text-center small" href="nilaiPklPerPeriodeAdm.php?id='.$id.'&page='.$page.'" title="Lihat, input dan edit nilai PKL"><i class="fas fa-sort-numeric-up-alt"></i> Kelola Nilai</a>';} ?>
                                  <div class="dropdown-divider"></div>
                                  <?php if($data8['jumData']==0) { echo '<a class="dropdown-item text-info text-center small" onclick="return confirm(\'Tidak ada peserta\')" title="Tidak ada peserta"><i class="fas fa-print"></i> Cetak Data</a>';} else { echo '<a class="dropdown-item text-info text-center small" href="cetakPendaftarPklPerPeriode.php?id='.$id.'" title="Cetak data" target="_blank"><i class="fas fa-print"></i> Cetak Data</a>';} ?>
                                  <div class="dropdown-divider"></div>
                                  <?php if($data8['jumData']==0) { echo '<a class="dropdown-item text-info text-center small" onclick="return confirm(\'Tidak ada peserta\')" title="Tidak ada peserta"><i class="fas fa-download"></i> Ekspor Data</a>';} else { echo '<a class="dropdown-item text-info text-center small" href="eksporPendaftarPklPerPeriodeAdm.php?id='.$id.'" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i> Ekspor Data</a>';} ?>
                                  <div class="dropdown-divider"></div>
                                  <?php if(($data8['jumData'] > 0)) { echo "<a class='dropdown-item text-danger text-center small' onclick='return confirm(\"Tidak bisa dihapus! Sudah ada peserta\")' title='Tidak bisa dihapus! Sudah ada peserta' disabled><i class='far fa-trash-alt'></i> Hapus</a>";} else { echo "<a class='dropdown-item text-danger text-center small' href='deletePeriodePkl.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='far fa-trash-alt'></i> Hapus</a>";}?>
                                </div>
                              </div>
                            </td>
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
          </div>
        </section>
      </div>
      <form action="spndftrnPklAdm.php" method="post">
        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered modal-lg">
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
                  <label for="start_datetime">Waktu Awal Pendaftaran</label>
                  <div class="input-group date" id="start_datetime_input" data-target-input="nearest">
                    <input type="text" name="start_datetime" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#start_datetime_input" required/>
                    <div class="input-group-append" data-target="#start_datetime_input" data-toggle="datetimepicker">
                      <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="end_datetime">Waktu Akhir Pendaftaran</label>
                  <div class="input-group date" id="end_datetime_input" data-target-input="nearest">
                    <input type="text" name="end_datetime" class="form-control form-control-sm datetimepicker-input bg-transparent text-white" data-target="#end_datetime_input" required/>
                    <div class="input-group-append" data-target="#end_datetime_input" data-toggle="datetimepicker">
                      <div class="input-group-text bg-transparent text-white"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="syarat_sks">Syarat SKS yang Harus Ditempuh</label>
                  <input type="number" name="syarat_sks" class="form-control form-control-sm bg-transparent text-white" required>
                </div>
                <div class="form-group">
                  <label for="ketua">Ketua PKL</label>
                  <select name="ketua" class="form-control form-control-sm bg-secondary text-white" id="ketua" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE jenis_pegawai='1' ORDER BY nama_tg ASC");
                      while ($tampil = mysqli_fetch_array($q)){
                        echo "<option value='$tampil[id]'>$tampil[nama_tg]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="at">Batas Atas Grade A</label>
                    <input type="number" max="100" step=".0001" name="at" class="form-control form-control-sm bg-transparent text-white" value="100" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="ab">Batas Bawah Grade A</label>
                    <input type="number" step=".0001" name="ab" class="form-control form-control-sm bg-transparent text-white" value="85" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="bplust">Batas Atas Grade B+</label>
                    <input type="number" step=".0001" name="bplust" class="form-control form-control-sm bg-transparent text-white" value="84.9999" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="bplusb">Batas Bawah Grade B+</label>
                    <input type="number" step=".0001" name="bplusb" class="form-control form-control-sm bg-transparent text-white" value="75" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="bt">Batas Atas Grade B</label>
                    <input type="number" step=".0001" name="bt" class="form-control form-control-sm bg-transparent text-white" value="74.9999" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="bb">Batas Bawah Grade B</label>
                    <input type="number" step=".0001" name="bb" class="form-control form-control-sm bg-transparent text-white" value="70" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="cplust">Batas Atas Grade C+</label>
                    <input type="number" step=".0001" name="cplust" class="form-control form-control-sm bg-transparent text-white" value="69.9999" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="cplusb">Batas Bawah Grade C+</label>
                    <input type="number" step=".0001" name="cplusb" class="form-control form-control-sm bg-transparent text-white" value="65" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="ct">Batas Atas Grade C</label>
                    <input type="number" step=".0001" name="ct" class="form-control form-control-sm bg-transparent text-white" value="64.9999" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="cb">Batas Bawah Grade C</label>
                    <input type="number" step=".0001" name="cb" class="form-control form-control-sm bg-transparent text-white" value="60" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="dt">Batas Atas Grade D</label>
                    <input type="number" step=".0001" name="dt" class="form-control form-control-sm bg-transparent text-white" value="59.9999" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="db">Batas Bawah Grade D</label>
                    <input type="number" min="1" step=".0001" name="db" class="form-control form-control-sm bg-transparent text-white" value="1" required>
                  </div>
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
      
      $('.table-responsive').on('show.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "inherit" );
      });
      
      $('.table-responsive').on('hide.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "auto" );
      })
    </script>
  </body>
</html>