<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $myquery = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE id='$id'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dt = mysqli_fetch_assoc($d);
  
  $qnm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$dt[nim]'";
  $res = mysqli_query($con, $qnm);
  $dnm =mysqli_fetch_assoc($res);
  
  $qdw1 = "SELECT * FROM mag_dospem_tesis WHERE id='$dt[dospem_tesis1]'";
  $rdw1 = mysqli_query($con, $qdw1) or die(mysqli_error($con));
  $ddw1 = mysqli_fetch_assoc($rdw1);
   
  $qdp1 = "SELECT * FROM dt_pegawai WHERE id='$ddw1[nip]'";
  $rdp1 = mysqli_query($con, $qdp1) or die(mysqli_error($con));
  $ddp1 = mysqli_fetch_assoc($rdp1);
   
  $qr1 = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp1[kepakaran_mayor]'";
  $rr1 = mysqli_query($con, $qr1) or die(mysqli_error($con));
  $dr1 = mysqli_fetch_assoc($rr1);
   
  $qdw2 = "SELECT * FROM mag_dospem_tesis WHERE id='$dt[dospem_tesis2]'";
  $rdw2 = mysqli_query($con, $qdw2) or die(mysqli_error($con));
  $ddw2 = mysqli_fetch_assoc($rdw2);
   
  $qdp2 = "SELECT * FROM dt_pegawai WHERE id='$ddw2[nip]'";
  $rdp2 = mysqli_query($con, $qdp2) or die(mysqli_error($con));
  $ddp2 = mysqli_fetch_assoc($rdp2);
   
  $qr2 = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp2[kepakaran_mayor]'";
  $rr2 = mysqli_query($con, $qr2) or die(mysqli_error($con));
  $dr2 = mysqli_fetch_assoc($rr2);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarDosen.php" );
        ?> 
      <div class="content-wrapper">
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Persetujuan</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="verPengDospem.php?page=<?php echo $page;?>">Pengajuan Dospem Tesis</a></li>
                  <li class="breadcrumb-item active small">Edit Persetujuan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Edit Persetujuan</h4>
                    <span class="small float-right"> <?php echo $dnm['nama'].' ['.$dnm['nim'].']';?></span>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-sm custom mb-0">
                        <thead>
                          <tr>
                            <th width="68%" class="text-center pl-1">Dospem Tesis yang Diajukan</th>
                            <th width="16%" class="text-center">Status Pengajuan</th>
                            <th width="16%" class="text-center pr-1">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-center pl-1"><?php echo $ddp1['nama'].' <strong class="text-primary">[Pembimbing I]</strong>';?></td>
                            <td class="text-center">
                              <form action="updateVerPengDospemSatuPerId.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <input type="text" name="nim" class="sr-only" value="<?php echo $dt['nim'];?>" required readonly>
                                <input type="text" name="id_periode" class="sr-only" value="<?php echo $dt['id_periode'];?>" required readonly>
                                <input type="text" name="dospem_tesis1" class="sr-only" value="<?php echo $dt['dospem_tesis1'];?>" required readonly>
                                <select name='cek1' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $dt['cek1'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                            <td class="text-center pr-1">
                              <?php if($dt['cek1']==1) { echo
                                "<a class='btn btn-outline-warning btn-block btn-xs' title='Edit'><i class='fas fa-user-edit'></i> Ganti Dospem Tesis</a>";}
                                else if($dt['cek1']==2) { echo 
                                "<a class='btn btn-outline-success btn-block btn-xs disabled' title='Telah disetujui'><i class='fas fa-user-check'></i> Telah Disetujui</a>";} 
                                else if($dt['cek1']==3) { echo 
                                "<a class='btn btn-outline-secondary btn-block btn-xs disabled' title='Tidak disetujui'><i class='fas fa-user-times'></i> Tidak Disetujui</a>";}
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center pl-1"><?php echo $ddp2['nama'].' <strong class="text-primary">[Pembimbing II]</strong>';?></td>
                            <td class="text-center">
                              <form action="updateVerPengDospemDuaPerId.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <input type="text" name="nim" class="sr-only" value="<?php echo $dt['nim'];?>" required readonly>
                                <input type="text" name="id_periode" class="sr-only" value="<?php echo $dt['id_periode'];?>" required readonly>
                                <input type="text" name="dospem_tesis2" class="sr-only" value="<?php echo $dt['dospem_tesis2'];?>" required readonly>
                                <select name='cek2' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $dt['cek2'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                            <td class="text-center pr-1">
                              <?php if($dt['cek2']==1) { echo
                                "<a class='btn btn-outline-warning btn-block btn-xs' title='Edit'><i class='fas fa-user-edit'></i> Ganti Dospem Tesis</a>";}
                                else if($dt['cek2']==2) { echo 
                                "<a class='btn btn-outline-success btn-block btn-xs disabled' title='Telah disetujui'><i class='fas fa-user-check'></i> Telah Disetujui</a>";} 
                                else if($dt['cek2']==3) { echo 
                                "<a class='btn btn-outline-secondary btn-block btn-xs disabled' title='Tidak disetujui'><i class='fas fa-user-times'></i>
                                </a>";}
                                ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <div class="row">
              <div class="col">
                <form action="updateCatatanBaSemproTesisPenguji4.php" method="post">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <h4 class="card-title">Catatan/Revisi</h4>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                      <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <div class="form-group">
                        <textarea id="textarea-custom-one" name="catatan_penguji4" class="form-control form-control-sm" style="height: 300px;"><?php echo $dfn['catatan_penguji4'];?></textarea>
                      </div>
                      <button role="button" type="submit" class="btn btn-sm btn-outline-info">Kirim Catatan/Revisi</button>
                      <a href="dashboardBeritaAcaraSemproTes.php?page=<?php echo $page;?>" class="btn btn-sm btn-outline-danger float-right">Selesai</a>
                    </div>
                  </div>
                </form>
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