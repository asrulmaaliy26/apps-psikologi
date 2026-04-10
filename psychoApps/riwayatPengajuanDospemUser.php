<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
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
                <h1 class="m-0 float-left">Pengajuan Dospem Skripsi</h1>
              </div>
              <div class="col-sm-8">
                <ol class="mt-2 breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Pengajuan Dospem Skripsi</li>
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
                        <a class="nav-link" href="prePengajuanDospemUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="riwayatPengajuanDospemUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="card mb-3">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Informasi Pengajuan</h3>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table m-0 text-center table-sm custom">
                            <thead>
                              <tr>
                                <th width="12%" class="pl-1">Tgl. pengajuan</th>
                                <th width="10%">IPK</th>
                                <th width="24%">Judul skripsi</th>
                                <th width="12%">Jenis skripsi</th>
                                <th width="12%">Bidang skripsi</th>
                                <th width="12%">Metode riset</th>
                                <th width="10%">Status</th>
                                <th colspan="2" class="pr-1">Opsi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $qry = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                WHILE($md = mysqli_fetch_assoc( $has )) {
                                $id=$md['id'];
                                
                                $cekdata="SELECT nim FROM pengelompokan_dospem_skripsi WHERE nim='$username'";
                                $ada=mysqli_query($con, $cekdata)  or die(mysqli_error($con));
                                
                                $qvaljud = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$md[cekjudul]'";
                                $rvaljud = mysqli_query($con, $qvaljud) or die(mysqli_error($con));
                                $dvaljud = mysqli_fetch_assoc($rvaljud);
                                
                                $q1 = "SELECT * FROM opsi_jenis_skripsi WHERE id='$md[jenis_skripsi]'";
                                $t1 = mysqli_query($con, $q1) or die(mysqli_error($con));
                                $dtt1 = mysqli_fetch_assoc($t1);
                                
                                $q2 = "SELECT * FROM opsi_bidang_skripsi WHERE id='$md[bidang_skripsi]'";
                                $t2 = mysqli_query($con, $q2) or die(mysqli_error($con));
                                $dtt2 = mysqli_fetch_assoc($t2);
                                
                                $q3 = "SELECT * FROM opsi_jenis_penelitian WHERE id='$md[metode_riset]'";
                                $t3 = mysqli_query($con, $q3) or die(mysqli_error($con));
                                $dtt3 = mysqli_fetch_assoc($t3);
                                ?> 
                              <tr>
                                <td class="text-center pl-1"><?php echo $md['tgl_pengajuan'];?></td>
                                <td class="text-center"><?php echo $md['ipk'].' ('.$md['sks_ditempuh'].' '.'sks'.')';?></td>
                                <td class="text-center"><?php echo $md['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $md['judul_skripsi']);?></td>
                                <td class="text-center"><?php echo $dtt1['nm'];?></td>
                                <td class="text-center"><?php echo $dtt2['nm'];?></td>
                                <td class="text-center"><?php echo $dtt3['opsi'];?></td>
                                <td class="text-center"><?php echo $dvaljud['nm'];?></td>
                                <td width="4%" class="text-center">
                                  <?php 
                                    if($md['cekjudul']==2) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pembimbingan sedang berjalan." disabled><i class="far fa-edit"></i></a>';}
                                    else if($md['cekjudul']==3) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pembimbingan sedang berjalan." disabled><i class="far fa-edit"></i></a>';}
                                    else { echo 
                                      '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPengajuanDospemUserSatu.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                </td>
                                <td width="4%" class="text-center pr-1">
                                  <?php 
                                    if($md['cekjudul']==2) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa dihapus. Pembimbingan sedang berjalan." disabled><i class="far fa-trash-alt"></i></a>';}
                                    else if($md['cekjudul']==3) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa dihapus. Pembimbingan sedang berjalan." disabled><i class="far fa-trash-alt"></i></a>';}
                                    else { echo 
                                      '<a class="btn btn-outline-danger btn-xs btn-block" onclick="return confirm(\'Yakin data ini dihapus?\')" title="Yakin data ini dihapus?" href="deletePengajuanDospemUser.php?id='.$md['id'].'"><i class="far fa-trash-alt"></i></a>';}?>
                                </td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-3">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Lampiran Berkas</h3>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table m-0 text-center table-sm custom">
                            <thead>
                              <tr>
                                <th width="30%" class="pl-1">Berkas</th>
                                <th width="60%">Status</th>
                                <th width="10%" class="pr-1">Opsi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $qry = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
                                $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                WHILE($md = mysqli_fetch_assoc( $has )) {
                                $id=$md['id'];
                                
                                $cekdata="SELECT nim FROM pengelompokan_dospem_skripsi WHERE nim='$username'";
                                $ada=mysqli_query($con, $cekdata)  or die(mysqli_error($con));
                                
                                $qvalber1 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$md[cekberkas1]'";
                                $rvalber1 = mysqli_query($con, $qvalber1) or die(mysqli_error($con));
                                $dvalber1 = mysqli_fetch_assoc($rvalber1);
                                
                                $qvalber2 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$md[cekberkas2]'";
                                $rvalber2 = mysqli_query($con, $qvalber2) or die(mysqli_error($con));
                                $dvalber2 = mysqli_fetch_assoc($rvalber2);
                                
                                $qvalber3 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$md[cekberkas3]'";
                                $rvalber3 = mysqli_query($con, $qvalber3) or die(mysqli_error($con));
                                $dvalber3 = mysqli_fetch_assoc($rvalber3);
                                
                                $qvalber4 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$md[cekberkas4]'";
                                $rvalber4 = mysqli_query($con, $qvalber4) or die(mysqli_error($con));
                                $dvalber4 = mysqli_fetch_assoc($rvalber4);
                                
                                $qvalber5 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$md[cekberkas5]'";
                                $rvalber5 = mysqli_query($con, $qvalber5) or die(mysqli_error($con));
                                $dvalber5 = mysqli_fetch_assoc($rvalber5);
                                ?>
                              <tr>
                                <td class="text-center pl-1"><?php if(empty($ada)) { echo "&nbsp;";} else { if(empty($md['file_prop'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada file" disabled>Proposal</a>';} else { echo '<a class="btn btn-outline-primary btn-xs btn-block" title="Lihat/download" href="'.$md['file_prop'].'" target="_blank">Proposal</a>';}}?></td>
                                <td class="text-center"><?php echo $dvalber1['nm'];?></td>
                                <td class="text-center pr-1">
                                  <?php 
                                    if($md['cekberkas1']==2) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                    else if($md['cekberkas1']==3) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                    else { echo 
                                      '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPengajuanDospemUserDuaSatu.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                </td>
                              </tr>
                              <tr>
                                <td class="text-center pl-1"><?php if(empty($ada)) { echo "&nbsp;";} else { if(empty($md['file_transkrip'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada file" disabled>Transkrip</a>';} else { echo '<a class="btn btn-outline-primary btn-xs btn-block" title="Lihat/download" href="'.$md['file_transkrip'].'" target="_blank">Transkrip</a>';}}?></td>
                                <td class="text-center"><?php echo $dvalber2['nm'];?></td>
                                <td class="text-center pr-1">
                                  <?php 
                                    if($md['cekberkas2']==2) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                    else if($md['cekberkas2']==3) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                    else { echo 
                                      '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPengajuanDospemUserDuaDua.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                </td>
                              </tr>
                              <tr>
                                <td class="text-center pl-1"><?php if(empty($ada)) { echo "&nbsp;";} else { if(empty($md['file_toefl_toafl'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada file" disabled>Toefl/Toafl</a>';} else { echo '<a class="btn btn-outline-primary btn-xs btn-block" title="Lihat/download" href="'.$md['file_toefl_toafl'].'" target="_blank">Toefl/Toafl</a>';}}?></td>
                                <td class="text-center"><?php echo $dvalber3['nm'];?></td>
                                <td class="text-center pr-1">
                                  <?php 
                                    if($md['cekberkas3']==2) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                    else if($md['cekberkas3']==3) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                    else { echo 
                                      '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPengajuanDospemUserDuaTiga.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                </td>
                              </tr>
                              <tr>
                                <td class="text-center pl-1"><?php if(empty($ada)) { echo "&nbsp;";} else { if(empty($md['file_tashih'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada file" disabled>Tashih</a>';} else { echo '<a class="btn btn-outline-primary btn-xs btn-block" title="Lihat/download" href="'.$md['file_tashih'].'" target="_blank">Tashih</a>';}}?></td>
                                <td class="text-center"><?php echo $dvalber4['nm'];?></td>
                                <td class="text-center pr-1">
                                  <?php 
                                    if($md['cekberkas4']==2) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                    else if($md['cekberkas4']==3) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                    else { echo 
                                      '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPengajuanDospemUserDuaEmpat.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                </td>
                              </tr>
                              <tr>
                                <td class="text-center pl-1"><?php if(empty($ada)) { echo "&nbsp;";} else { if(empty($md['file_ukt'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada file" disabled>Bukti UKT</a>';} else { echo '<a class="btn btn-outline-primary btn-xs btn-block" title="Lihat/download" href="'.$md['file_ukt'].'" target="_blank">Bukti UKT</a>';}}?></td>
                                <td class="text-center"><?php echo $dvalber5['nm'];?></td>
                                <td class="text-center pr-1">
                                  <?php 
                                    if($md['cekberkas5']==2) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                    else if($md['cekberkas5']==3) { echo
                                      '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                    else { echo 
                                      '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPengajuanDospemUserDuaLima.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                </td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-6">
                        <div class="card mb-0">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Pilihan Dosen Pembimbing Skripsi 1</h3>
                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0 text-center table-sm custom">
                                <thead>
                                  <tr>
                                    <th width="71%" class="pl-1">Dosen Pembimbing Skripsi 1</th>
                                    <th width="12%">Status</th>
                                    <th width="17%" class="pr-1">Opsi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $qry = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
                                    $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                    WHILE($md = mysqli_fetch_assoc( $has )) {
                                    $id=$md['id'];
                                    
                                    $cekdata="SELECT nim FROM pengelompokan_dospem_skripsi WHERE nim='$username'";
                                    $ada=mysqli_query($con, $cekdata)  or die(mysqli_error($con));
                                    
                                    $qdp1 = "SELECT * FROM dt_pegawai WHERE id='$md[dospem_skripsi1]'";
                                    $rdp1 = mysqli_query($con, $qdp1) or die(mysqli_error($con));
                                    $ddp1 = mysqli_fetch_assoc($rdp1);
                                    
                                    $qvaldp1 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$md[cek1]'";
                                    $rvaldp1 = mysqli_query($con, $qvaldp1) or die(mysqli_error($con));
                                    $dvaldp1 = mysqli_fetch_assoc($rvaldp1);
                                    ?> 
                                  <tr>
                                    <td class="text-center pl-1"><?php echo $ddp1['nama'];?></td>
                                    <td class="text-center"><?php echo $dvaldp1['nm'];?></td>
                                    <td class="text-center pr-1">
                                      <?php 
                                        if($md['cek1']==2) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                        else if($md['cek1']==3) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                        else { echo 
                                          '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPengajuanDospemUserTigaSatu.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                    </td>
                                  </tr>
                                  <?php }?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-sm-6">
                        <div class="card mb-0">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Pilihan Dosen Pembimbing Skripsi 2</h3>
                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0 text-center table-sm custom">
                                <thead>
                                  <tr>
                                    <th width="71%" class="pl-1">Dosen Pembimbing Skripsi 2</th>
                                    <th width="12%">Status</th>
                                    <th width="17%" class="pr-1">Opsi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $qry = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
                                    $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                    WHILE($md = mysqli_fetch_assoc( $has )) {
                                    $id=$md['id'];
                                    
                                    $cekdata="SELECT nim FROM pengelompokan_dospem_skripsi WHERE nim='$username'";
                                    $ada=mysqli_query($con, $cekdata)  or die(mysqli_error($con));
                                    
                                    $qdp2 = "SELECT * FROM dt_pegawai WHERE id='$md[dospem_skripsi2]'";
                                    $rdp2 = mysqli_query($con, $qdp2) or die(mysqli_error($con));
                                    $ddp2 = mysqli_fetch_assoc($rdp2);
                                    
                                    $qvaldp2 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$md[cek2]'";
                                    $rvaldp2 = mysqli_query($con, $qvaldp2) or die(mysqli_error($con));
                                    $dvaldp2 = mysqli_fetch_assoc($rvaldp2);                                    
                                    ?> 
                                  <tr>
                                    <td class="text-center pl-1"><?php echo $ddp2['nama'];?></td>
                                    <td class="text-center"><?php echo $dvaldp2['nm'];?></td>
                                    <td class="text-center pr-1">
                                      <?php 
                                        if($md['cek2']==2) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                        else if($md['cek2']==3) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pengajuan telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                        else { echo 
                                          '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPengajuanDospemUserTigaDua.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
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
                    <div class="form-row">
                      <div class="form-group col-sm-6">
                        <div class="card mb-0">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Catatan Pengajuan</h3>
                          </div>
                          <div class="card-body pb-0">
                            <?php
                              $qry = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
                              $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                              WHILE($md = mysqli_fetch_assoc( $has )) {
                              echo nl2br($md['catatan']);}?>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-sm-6">
                        <div class="card mb-0">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Progres Pembimbingan</h3>
                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0 text-center table-sm custom">
                                <thead>
                                  <tr>
                                    <th width="30%" class="pl-1">Pengajuan</th>
                                    <th width="35%">Awal Pembimbingan</th>
                                    <th width="35%" class="pr-1">Akhir Pembimbingan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $qry = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
                                    $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                    WHILE($md = mysqli_fetch_assoc( $has )) {
                                    ?> 
                                  <tr>
                                    <td class="text-center pl-1"><?php echo $md['tgl_pengajuan'];?></td>
                                    <td class="text-center"><?php if(empty($md['tgl_mulai'])) { echo "";} else { echo date("d-m-Y",strtotime($md['tgl_mulai']));}?></td>
                                    <td class="text-center pr-1"><?php if(empty($md['tgl_akhir'])) { echo "";} else { echo date("d-m-Y",strtotime($md['tgl_akhir']));}?></td>
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