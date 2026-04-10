<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con, $_GET['id']);
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarUserS1.php" );
        ?> 
      <div class="content-wrapper">
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-4">
                <h1 class="m-0 float-left">Pendaftaran</h1>
              </div>
              <div class="col-sm-8">
                <ol class="mt-2 breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Praktik Kerja Lapangan (PKL)</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm">
                <div class="card card-success card-outline card-outline-tabs">
                  <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link" href="prePendaftaranPklUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="riwayatPendaftaranPklUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="detailRiwayatPendaftaranPklUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Pendaftaran</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="card mb-3">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Informasi Pendaftaran</h3>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table m-0 text-center table-sm custom">
                            <thead>
                              <tr>
                                <th width="14%" class="pl-1">Tgl. pendaftaran</th>
                                <th width="12%">Jenis PKL</th>
                                <th width="20%">SKS yang diambil</th>
                                <th width="20%">Kontak yang lain</th>
                                <th width="28%">Riwayat penyakit</th>
                                <th width="6%" class="pr-1">Opsi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $qry = "SELECT * FROM peserta_pkl WHERE nim='$dataku[nim]' AND id='$id'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                WHILE($md = mysqli_fetch_assoc( $has )) {
                                $id=$md['id'];
                                
                                $qjenispkl = "SELECT * FROM opsi_jenis_pkl WHERE id='$md[jenis_pkl]'";
                                $rjenispkl = mysqli_query($con, $qjenispkl) or die(mysqli_error($con));
                                $djenispkl = mysqli_fetch_assoc($rjenispkl);
                                
                                $qdpllok = "SELECT * FROM dpl_pkl WHERE id='$md[id_dpl]'";
                                $rdpllok = mysqli_query($con, $qdpllok) or die(mysqli_error($con));
                                $ddpllok = mysqli_fetch_assoc($rdpllok);
                                
                                $myquery = "SELECT * FROM dt_pegawai WHERE id='$ddpllok[nip]'";
                                $res = mysqli_query($con,  $myquery )or die( mysql_erdror() );
                                $dt = mysqli_fetch_assoc( $res );
                                ?> 
                              <tr>
                                <td class="text-center pl-1"><?php echo $md['tgl_pengajuan'];?></td>
                                <td class="text-center"><?php echo $djenispkl['nm'];?></td>
                                <td class="text-center"><?php echo $md['sks_diambil'];?></td>
                                <td class="text-center"><?php echo $md['kontak_lain'];?></td>
                                <td class="text-center"><?php echo $md['riwayat_penyakit'];?></td>
                                <td class="text-center pr-1">
                                  <?php 
                                    if($md['val_adm']==2) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima." disabled><i class="far fa-edit"></i></a>';}
                                    else if($md['val_adm']==3) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima." disabled><i class="far fa-edit"></i></a>';}
                                    else { echo 
                                      '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPendaftaranPklUserSatu.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                </td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-3">
                        <div class="card mb-0">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Lampiran Berkas</h3>
                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0 text-center table-sm custom">
                                <thead>
                                  <tr>
                                    <th width="76%" class="pl-1">Transkrip</th>
                                    <th width="24%" class="pr-1">Opsi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $qry = "SELECT * FROM peserta_pkl WHERE nim='$dataku[nim]' AND id='$id'";
                                    $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                    WHILE($md = mysqli_fetch_assoc( $has )) {
                                    $id=$md['id'];
                                    
                                    $qjenispkl = "SELECT * FROM opsi_jenis_pkl WHERE id='$md[jenis_pkl]'";
                                    $rjenispkl = mysqli_query($con, $qjenispkl) or die(mysqli_error($con));
                                    $djenispkl = mysqli_fetch_assoc($rjenispkl);
                                    ?>
                                  <tr>
                                    <td class="text-center pl-1"><?php if(empty($md['file_transkrip'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada file" disabled><i class="fas fa-folder-minus"></i> Tidak ada file</a>';} else { echo '<a class="btn btn-outline-primary btn-xs btn-block" title="Lihat/download" href="'.$md['file_transkrip'].'" target="_blank"><i class="fas fa-file-download"></i> Lihat/download</a>';}?></td>
                                    <td class="text-center pr-1">
                                      <?php 
                                        if($md['val_adm']==2) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                        else if($md['val_adm']==3) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                        else { echo 
                                          '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPendaftaranPklUserDua.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                    </td>
                                  </tr>
                                  <?php }?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-sm-9">
                        <div class="card mb-0">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Pilihan Lokasi PKL</h3>
                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0 text-center table-sm custom">
                                <thead>
                                  <tr>
                                    <th width="60%" class="pl-1">Lokasi PKL</th>
                                    <th width="32%">DPL</th>
                                    <th width="8%" class="pr-1">Opsi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $qry = "SELECT * FROM peserta_pkl WHERE nim='$dataku[nim]' AND id='$id'";
                                    $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                    WHILE($md = mysqli_fetch_assoc( $has )) {
                                    $id=$md['id'];
                                    
                                    $qdpllok = "SELECT * FROM dpl_pkl WHERE id='$md[id_dpl]'";
                                    $rdpllok = mysqli_query($con, $qdpllok) or die(mysqli_error($con));
                                    $ddpllok = mysqli_fetch_assoc($rdpllok);
                                    
                                    $myquery = "SELECT * FROM dt_pegawai WHERE id='$ddpllok[nip]'";
                                    $res = mysqli_query($con,  $myquery )or die( mysql_erdror() );
                                    $dt = mysqli_fetch_assoc( $res );
                                    ?> 
                                  <tr>
                                    <td class="text-center pl-1"><?php echo $ddpllok['lokasi'];?></td>
                                    <td class="text-center"><?php echo $dt['nama'];?></td>
                                    <td class="text-center pr-1">
                                      <?php 
                                        if($md['val_adm']==2) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                        else if($md['val_adm']==3) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                        else { echo 
                                          '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPendaftaranPklUserTiga.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                    </td>
                                  </tr>
                                  <?php }?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>