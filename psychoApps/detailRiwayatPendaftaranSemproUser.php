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
                  <li class="breadcrumb-item active">Seminar Proposal Skripsi</li>
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
                        <a class="nav-link" href="prePendaftaranSemproUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="riwayatPendaftaranSemproUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="detailRiwayatPendaftaranSemproUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Pendaftaran</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="form-row">
                      <div class="form-group col-sm-10">
                        <div class="card mb-3">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Informasi Pendaftaran</h3>
                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0 text-center table-sm custom">
                                <thead>
                                  <tr>
                                    <th width="16%" class="pl-1">Tgl. pendaftaran</th>
                                    <th width="80%">Judul proposal skripsi</th>
                                    <th width="4%" class="pr-1">Opsi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $qry = "SELECT * FROM peserta_sempro WHERE nim='$dataku[nim]' AND id='$id'";
                                    $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                    WHILE($md = mysqli_fetch_assoc( $has )) {
                                    $id=$md['id'];
                                    ?> 
                                  <tr>
                                    <td class="text-center pl-1"><?php echo $md['tgl_pengajuan'];?></td>
                                    <td class="text-center"><?php echo $md['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $md['judul_prop']);?></td>
                                    <td class="text-center pr-1">
                                      <?php 
                                        if($md['val_adm']==2) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima." disabled><i class="far fa-edit"></i></a>';}
                                        else if($md['val_adm']==3) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima." disabled><i class="far fa-edit"></i></a>';}
                                        else { echo 
                                          '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPendaftaranSemproUserSatu.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
                                    </td>
                                  </tr>
                                  <?php }?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-sm-2">
                        <div class="card mb-0">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Lampiran Berkas</h3>
                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0 text-center table-sm custom">
                                <thead>
                                  <tr>
                                    <th width="76%" class="pl-1">Proposal skripsi</th>
                                    <th width="24%" class="pr-1">Opsi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $qry = "SELECT * FROM peserta_sempro WHERE nim='$dataku[nim]' AND id='$id'";
                                    $has = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                                    WHILE($md = mysqli_fetch_assoc( $has )) {
                                    $id=$md['id'];
                                    ?>
                                  <tr>
                                    <td class="text-center pl-1"><?php if(empty($md['file_prop'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada file" disabled><i class="fas fa-folder-minus"></i> Tidak ada file</a>';} else { echo '<a class="btn btn-outline-primary btn-xs btn-block" title="Lihat/download" href="'.$md['file_prop'].'" target="_blank"><i class="fas fa-file-download"></i> Lihat/download</a>';}?></td>
                                    <td class="text-center pr-1">
                                      <?php 
                                        if($md['val_adm']==2) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima" disabled><i class="far fa-edit"></i></a>';}
                                        else if($md['val_adm']==3) { echo
                                          '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa diedit. Pendaftaran telah diterima dengan catatan" disabled><i class="far fa-edit"></i></a>';}
                                        else { echo 
                                          '<a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm(\'Yakin data ini diedit?\')" title="Yakin data ini diedit?" href="editPendaftaranSemproUserDua.php?id='.$md['id'].'"><i class="far fa-edit"></i></a>';}?>
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