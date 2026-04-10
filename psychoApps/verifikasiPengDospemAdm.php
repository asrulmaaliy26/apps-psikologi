<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $myquery = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  $id_periode=$dataku['id_periode'];
  
  $qdt_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
  $hdt_mhssw = mysqli_query($con, $qdt_mhssw);
  $dmhssw = mysqli_fetch_assoc($hdt_mhssw);
  
  $qdt_dospem1 = "SELECT * FROM dt_pegawai WHERE id='$dataku[dospem_skripsi1]'";
  $hdt_dospem1 = mysqli_query($con, $qdt_dospem1);
  $ddospem1 = mysqli_fetch_assoc($hdt_dospem1);
                            
  $qdt_dospem2 = "SELECT * FROM dt_pegawai WHERE id='$dataku[dospem_skripsi2]'";
  $hdt_dospem2 = mysqli_query($con, $qdt_dospem2);
  $ddospem2 = mysqli_fetch_assoc($hdt_dospem2);
  
  $qidper = "SELECT * FROM pengajuan_dospem WHERE id='$id_periode'";
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
            <?php 
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Edit berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifBelum') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Pilihan Dosen Pembimbing atau judul skripsi belum diproses!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifTolak') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Pilihan Dosen Pembimbing atau judul skripsi ada yang ditolak!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDospem1') {
              echo '
              <div class="modal fade" id="modalAlert">
              <div class="modal-dialog">
              <div class="modal-content bg-danger">
              <div class="modal-header">
              <h4 class="modal-title">Peringatan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
              <p>Kuota Dosen pembimbing skripsi 1 yang dipilih sudah penuh. Silahkan pilih Dosen pembimbing skripsi 1 yang belum penuh kuotanya.</p>
              </div>
              </div>
              </div>
              </div>';
              }
              
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDospem2') {
              echo '
              <div class="modal fade" id="modalAlert">
              <div class="modal-dialog">
              <div class="modal-content bg-danger">
              <div class="modal-header">
              <h4 class="modal-title">Peringatan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
              <p>Kuota Dosen pembimbing skripsi 2 yang dipilih sudah penuh. Silahkan pilih Dosen pembimbing skripsi 2 yang belum penuh kuotanya.</p>
              </div>
              </div>
              </div>
              </div>';
              }
              
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDospem12') {
              echo '
              <div class="modal fade" id="modalAlert">
              <div class="modal-dialog">
              <div class="modal-content bg-danger">
              <div class="modal-header">
              <h4 class="modal-title">Peringatan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
              <p>Kuota Dosen pembimbing skripsi 1 dan 2 yang dipilih sudah penuh. Silahkan pilih Dosen pembimbing skripsi yang belum penuh kuotanya.</p>
              </div>
              </div>
              </div>
              </div>';
              }
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalSama') {
              echo '
              <div class="modal fade" id="modalAlert">
              <div class="modal-dialog">
              <div class="modal-content bg-danger">
              <div class="modal-header">
              <h4 class="modal-title">Peringatan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
              <h4>Note!</h4>
              <p>Pilihan Dosen pembimbing skripsi tidak boleh sama. Silahkan pilih Dosen pembimbing skripsi yang berbeda.</p>
              </div>
              </div>
              </div>
              </div>';
              }            ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pengajuan Dospem Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pngjnDospemAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
                  <li class="breadcrumb-item small"><a class="text-info" href="pngjnDospemPerPeriodeAdm.php?id=<?php echo $id_periode;?>&page=<?php echo $page;?>">Verifikasi Pengajuan</a></li>
                  <li class="breadcrumb-item active small"><?php echo $dmhssw['nama'].' ['.$dmhssw['nim'].']';?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-6 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h4 class="card-title">Lampiran Pengajuan</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered m-0 text-center table-sm small custom">
                        <tbody>
                          <tr>
                            <td width="50%" class="pl-1 border-top-0">
                              <?php if(empty($dataku['file_prop'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada file" disabled>Proposal</a>';} else { echo '<a class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat/download" href="'.$dataku['file_prop'].'" target="_blank">Proposal</a>';}?>
                            </td>
                            <td width="50%" class="pr-1 border-top-0">
                              <form action="updateVerBerkas1PengDospemAdm.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <select name='cekberkas1' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $dataku['cekberkas1'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                          </tr>
                          <tr>
                            <td width="50%" class="pl-1">
                              <?php if(empty($dataku['file_transkrip'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada file" disabled>Transkrip</a>';} else { echo '<a class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat/download" href="'.$dataku['file_transkrip'].'" target="_blank">Transkrip</a>';}?>
                            </td>
                            <td width="50%" class="pr-1">
                              <form action="updateVerBerkas2PengDospemAdm.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <select name='cekberkas2' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $dataku['cekberkas2'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                          </tr>
                          <tr>
                            <td width="50%" class="pl-1">
                              <?php if(empty($dataku['file_toefl_toafl'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada file" disabled>Toefl/Toafl</a>';} else { echo '<a class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat/download" href="'.$dataku['file_toefl_toafl'].'" target="_blank">Toefl/Toafl</a>';}?>
                            </td>
                            <td width="50%" class="pr-1">
                              <form action="updateVerBerkas3PengDospemAdm.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <select name='cekberkas3' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $dataku['cekberkas3'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                            </td>
                          <tr>
                            <td width="50%" class="pl-1">
                              <?php if(empty($dataku['file_tashih'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada file" disabled>Tashih</a>';} else { echo '<a class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat/download" href="'.$dataku['file_tashih'].'" target="_blank">Tashih</a>';}?>
                            </td>
                            <td width="50%" class="pr-1">
                              <form action="updateVerBerkas4PengDospemAdm.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <select name='cekberkas4' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $dataku['cekberkas4'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                          </tr>
                          <tr>
                            <td width="50%" class="pl-1">
                              <?php if(empty($dataku['file_ukt'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada file" disabled>Bukti UKT</a>';} else { echo '<a class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat/download" href="'.$dataku['file_ukt'].'" target="_blank">Bukti UKT</a>';}?>
                            </td>
                            <td width="50%" class="pr-1">
                              <form action="updateVerBerkas5PengDospemAdm.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <select name='cekberkas5' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $dataku['cekberkas5'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                          </tr>
                          </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
              <section class="col-md-6 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h4 class="card-title">Judul Skripsi</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $dataku['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dataku['judul_skripsi']);?>
                  </div>
                  <div class="card-footer">
                    <form action="updateVerJudPengDospemAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <select name='cekjudul' class='form-control form-control-sm' onchange='this.form.submit();' required>
                      <?php
                        $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi_pengajuan_dospem ORDER BY nm ASC" );
                        while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['cekjudul'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                        }
                        ?>
                      </select>
                    </form>
                  </div>
                </div>
              </section>
              <section class="col-md-6 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h4 class="card-title">Pilihan Dosen Pembimbing Skripsi I</h4>
                  </div>
                  <div class="card-body">
                    <form action="updateVerPengDospem1Adm.php" method="post" enctype="multipart/form-data">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
                      <div class="form-group m-0">
                        <?php
                          echo "<select name='dospem_skripsi1' class='form-control form-control-sm' onchange='this.form.submit();' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con, "SELECT dospem_skripsi.nip FROM dospem_skripsi INNER JOIN dt_pegawai ON dospem_skripsi.nip=dt_pegawai.id WHERE dospem_skripsi.id_periode='$dataku[id_periode]' ORDER BY dt_pegawai.nama_tg ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          $mqry = "SELECT * FROM dt_pegawai WHERE id='$w[nip]'";
                          $rq = mysqli_query($con, $mqry)or die( mysqli_error($con));
                          $dq = mysqli_fetch_array($rq);
                          
                          if ( $dataku['dospem_skripsi1'] == $w[ 'nip' ] ) {
                          echo "<option value='$w[nip]' selected>$dq[nama]</option>";
                          } else {
                          echo "<option value='$w[nip]'>$dq[nama_tg]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer">
                    <form action="updateVer2PengDospem1Adm.php" method="post" enctype="multipart/form-data">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
                      <select name='cek1' class='form-control form-control-sm' onchange='this.form.submit();' required>
                      <?php
                        $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi_pengajuan_dospem ORDER BY nm ASC" );
                        while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['cek1'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                        }
                        ?>
                      </select>
                    </form>
                  </div>
                </div>
              </section>
              <section class="col-md-6 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h4 class="card-title">Pilihan Dosen Pembimbing Skripsi II</h4>
                  </div>
                  <div class="card-body">
                    <form action="updateVerPengDospem2Adm.php" method="post" enctype="multipart/form-data">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
                      <div class="form-group m-0">
                        <?php
                          echo "<select name='dospem_skripsi2' class='form-control form-control-sm' onchange='this.form.submit();' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con, "SELECT dospem_skripsi.nip FROM dospem_skripsi INNER JOIN dt_pegawai ON dospem_skripsi.nip=dt_pegawai.id WHERE dospem_skripsi.id_periode='$dataku[id_periode]' ORDER BY dt_pegawai.nama_tg ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                          $mqry = "SELECT * FROM dt_pegawai WHERE id='$w[nip]'";
                          $rq = mysqli_query($con, $mqry)or die( mysqli_error($con));
                          $dq = mysqli_fetch_array($rq);
                          
                          if ( $dataku['dospem_skripsi2'] == $w[ 'nip' ] ) {
                          echo "<option value='$w[nip]' selected>$dq[nama]</option>";
                          } else {
                          echo "<option value='$w[nip]'>$dq[nama_tg]</option>";
                          }
                          }
                          echo "</select>";
                          ?>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer">
                    <form action="updateVer2PengDospem2Adm.php" method="post" enctype="multipart/form-data">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
                      <select name='cek2' class='form-control form-control-sm' onchange='this.form.submit();' required>
                      <?php
                        $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi_pengajuan_dospem ORDER BY nm ASC" );
                        while ( $w = mysqli_fetch_array( $tampil ) ) {
                          if ( $dataku['cek2'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm]</option>";
                          } else {
                            echo "<option value='$w[id]'>$w[nm]</option>";
                          }
                        }
                        ?>
                      </select>
                    </form>
                  </div>
                </div>
              </section>
              <section class="col-md-6 connectedSortable">
                <form action="updateVerTglMulaiPengDospemAdm.php" method="post" enctype="multipart/form-data">
                  <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <h4 class="card-title">Tanggal Mulai Pembimbingan</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group m-0">
                        <div class="input-group date" id="tgl_mulai" data-target-input="nearest">
                          <input type="text" name="tgl_mulai" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_mulai" value="<?php echo $dataku['tgl_mulai'];?>" required/>
                          <div class="input-group-append" data-target="#tgl_mulai" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer clearfix">
                      <button type="submit" class="btn btn-outline-info btn-flat btn-sm float-left">Update Mulai Tanggal Pembimbingan</button>
                    </div>
                  </div>
                </form>
              </section>
              <section class="col-md-6 connectedSortable">
                <form action="updateVerCatatanPengDospemAdm.php" method="post" enctype="multipart/form-data">
                  <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <h4 class="card-title">Catatan Pengajuan</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group m-0">
                        <textarea id="catatan" name="catatan" class="form-control form-control-sm"><?php echo $dataku['catatan'];?></textarea>
                      </div>
                    </div>
                    <div class="card-footer clearfix">
                      <button type="submit" class="btn btn-outline-info btn-flat btn-sm float-left">Kirim Catatan Pengajuan</button>
                    </div>
                  </div>
                </form>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(function () {
          $('#tgl_mulai').datetimepicker({
              format: 'YYYY-MM-DD',
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
      
       tinymce.init({
       selector: "textarea#catatan",
       theme: "modern",    
       plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor","autoresize"
      ],
      content_css: "css/content.css",
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons", 
      style_formats: [
           {title: 'Bold text', inline: 'b'},
           {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
           {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
           {title: 'Example 1', inline: 'span', classes: 'example1'},
           {title: 'Example 2', inline: 'span', classes: 'example2'},
           {title: 'Table styles'},
           {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
       ]
      });
    </script>
  </body>
</html>