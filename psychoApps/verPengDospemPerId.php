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

  // Hitung total mahasiswa yang sudah disetujui dospem1 (kuota terpakai)
  $qUsed1 = "SELECT COUNT(id) AS used FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$dt[dospem_tesis1]' AND id_periode='$dt[id_periode]' AND (cek1='1' OR cek1='2' OR cek1='3')";
  $rUsed1 = mysqli_query($con, $qUsed1);
  $dUsed1 = mysqli_fetch_assoc($rUsed1);
  $kuota1 = (int)($ddw1['kuota1'] ?? 0);
  $terpakai1 = (int)($dUsed1['used'] ?? 0);
  $sisa1 = $kuota1 - $terpakai1;
   
  $qdw2 = "SELECT * FROM mag_dospem_tesis WHERE id='$dt[dospem_tesis2]'";
  $rdw2 = mysqli_query($con, $qdw2) or die(mysqli_error($con));
  $ddw2 = mysqli_fetch_assoc($rdw2);
   
  $qdp2 = "SELECT * FROM dt_pegawai WHERE id='$ddw2[nip]'";
  $rdp2 = mysqli_query($con, $qdp2) or die(mysqli_error($con));
  $ddp2 = mysqli_fetch_assoc($rdp2);
   
  $qr2 = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp2[kepakaran_mayor]'";
  $rr2 = mysqli_query($con, $qr2) or die(mysqli_error($con));
  $dr2 = mysqli_fetch_assoc($rr2);

  // Hitung total mahasiswa yang sudah disetujui dospem2 (kuota terpakai)
  $qUsed2 = "SELECT COUNT(id) AS used FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$dt[dospem_tesis2]' AND id_periode='$dt[id_periode]' AND (cek2='1' OR cek2='2' OR cek2='3')";
  $rUsed2 = mysqli_query($con, $qUsed2);
  $dUsed2 = mysqli_fetch_assoc($rUsed2);
  $kuota2 = (int)($ddw2['kuota2'] ?? 0);
  $terpakai2 = (int)($dUsed2['used'] ?? 0);
  $sisa2 = $kuota2 - $terpakai2;

  // Ambil daftar dospem yang tersedia di periode yang sama beserta info kuota
  $qListDospem = mysqli_query($con, "
    SELECT 
        m.id, 
        p.nama_tg, 
        m.kuota1, 
        m.kuota2,
        (SELECT COUNT(*) FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1 = m.id AND id_periode = '$dt[id_periode]' AND (cek1='1' OR cek1='2' OR cek1='3')) as used1,
        (SELECT COUNT(*) FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2 = m.id AND id_periode = '$dt[id_periode]' AND (cek2='1' OR cek2='2' OR cek2='3')) as used2
    FROM mag_dospem_tesis m
    JOIN dt_pegawai p ON m.nip = p.id 
    WHERE m.id_periode = '$dt[id_periode]' 
    ORDER BY p.nama_tg ASC");
  
  $listDospem = [];
  while($rowL = mysqli_fetch_assoc($qListDospem)) {
      $listDospem[] = $rowL;
  }
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
                  <?php if(!empty($dt['judul_tesis'])): ?>
                  <div class="card-body pb-1 pt-2 border-bottom">
                    <small class="text-muted font-weight-bold"><i class="fas fa-book mr-1"></i>Judul Tesis:</small>
                    <p class="mb-0 small"><?php echo preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_tesis']); ?></p>
                  </div>
                  <?php endif; ?>
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
                            <td class="text-center pl-1">
                              <?php echo $ddp1['nama'].' <strong class="text-primary">[Pembimbing I]</strong>'; ?>
                              <br>
                              <small class="text-muted">
                                Kuota: <strong><?php echo $kuota1; ?></strong> &nbsp;|&nbsp;
                                Terpakai: <strong><?php echo $terpakai1; ?></strong> &nbsp;|&nbsp;
                                Sisa: <strong class="<?php echo ($sisa1 > 0) ? 'text-success' : 'text-danger'; ?>"><?php echo $sisa1; ?></strong>
                              </small>
                            </td>
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
                               <?php if($dt['cek1']==1) { ?>
                                 <button type="button" class="btn btn-outline-warning btn-block btn-xs" title="Ganti Dospem Tesis I" data-toggle="modal" data-target="#modalGantiDospem" data-target-id="1" data-current-name="<?php echo $ddp1['nama'];?>">
                                   <i class="fas fa-user-edit"></i> Ganti Dospem Tesis
                                 </button>
                               <?php } else if($dt['cek1']==2) { echo 
                                 "<a class='btn btn-outline-success btn-block btn-xs disabled' title='Telah disetujui'><i class='fas fa-user-check'></i> Telah Disetujui</a>";} 
                                 else if($dt['cek1']==3) { echo 
                                 "<a class='btn btn-outline-secondary btn-block btn-xs disabled' title='Tidak disetujui'><i class='fas fa-user-times'></i> Tidak Disetujui</a>";}
                                 ?>
                             </td>
                          </tr>
                          <tr>
                            <td class="text-center pl-1">
                              <?php echo $ddp2['nama'].' <strong class="text-primary">[Pembimbing II]</strong>'; ?>
                              <br>
                              <small class="text-muted">
                                Kuota: <strong><?php echo $kuota2; ?></strong> &nbsp;|&nbsp;
                                Terpakai: <strong><?php echo $terpakai2; ?></strong> &nbsp;|&nbsp;
                                Sisa: <strong class="<?php echo ($sisa2 > 0) ? 'text-success' : 'text-danger'; ?>"><?php echo $sisa2; ?></strong>
                              </small>
                            </td>
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
                               <?php if($dt['cek2']==1) { ?>
                                 <button type="button" class="btn btn-outline-warning btn-block btn-xs" title="Ganti Dospem Tesis II" data-toggle="modal" data-target="#modalGantiDospem" data-target-id="2" data-current-name="<?php echo $ddp2['nama'];?>">
                                   <i class="fas fa-user-edit"></i> Ganti Dospem Tesis
                                 </button>
                               <?php } else if($dt['cek2']==2) { echo 
                                 "<a class='btn btn-outline-success btn-block btn-xs disabled' title='Telah disetujui'><i class='fas fa-user-check'></i> Telah Disetujui</a>";} 
                                 else if($dt['cek2']==3) { echo 
                                 "<a class='btn btn-outline-secondary btn-block btn-xs disabled' title='Tidak disetujui'><i class='fas fa-user-times'></i> Tidak Disetujui</a>";}
                                 ?>
                             </td>
                          </tr>
                          <tr>
                            <td class="text-center pl-1 font-weight-bold">
                              Persetujuan Judul Tesis
                            </td>
                            <td class="text-center">
                              <form action="updateVerJudPengDospemTesisPerId.php" method="post" enctype="multipart/form-data">
                                <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                                <select name='cekjudul' class='form-control form-control-xs' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($con,  "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $dt['cekjudul'] == $w[ 'id' ] ) {
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
                               <?php if($dt['cekjudul']==1) { echo "<span class='badge badge-warning'>Ditinjau</span>"; }
                                 else if($dt['cekjudul']==2) { echo "<span class='badge badge-success'><i class='fas fa-check-circle'></i> Disetujui</span>";} 
                                 else if($dt['cekjudul']==3) { echo "<span class='badge badge-danger'><i class='fas fa-times-circle'></i> Ditolak</span>";}
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
    
    <!-- Modal Ganti Dospem -->
    <div class="modal fade" id="modalGantiDospem" tabindex="-1" role="dialog" aria-labelledby="modalGantiDospemLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="updateGantiDospemTesisPerId.php" method="post">
            <div class="modal-header bg-warning">
              <h5 class="modal-title" id="modalGantiDospemLabel"><i class="fas fa-user-edit mr-2"></i>Ganti Dosen Pembimbing</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <input type="hidden" name="page" value="<?php echo $page;?>">
              <input type="hidden" name="target" id="modal-target-id" value="">
              
              <div class="form-group">
                <label>Pembimbing Saat Ini:</label>
                <input type="text" class="form-control" id="modal-current-name" readonly>
              </div>
              
              <div class="form-group">
                <label for="new_dospem_id">Pilih Pembimbing Baru:</label>
                <select name="new_dospem_id" class="form-control" required>
                  <option value="">- Pilih Dosen -</option>
                  <?php foreach($listDospem as $ld): 
                    $sisaP1 = $ld['kuota1'] - $ld['used1'];
                    $sisaP2 = $ld['kuota2'] - $ld['used2'];
                  ?>
                    <option value="<?php echo $ld['id'];?>">
                      <?php echo $ld['nama_tg'];?> 
                      (Sisa I: <?php echo $sisaP1;?> | II: <?php echo $sisaP2;?>)
                    </option>
                  <?php endforeach; ?>
                </select>
                <small class="text-muted">* Pilih dosen dari daftar yang tersedia pada periode ini.</small>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    
    <script>
      $(document).ready(function() {
        $('#modalGantiDospem').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var targetId = button.data('target-id');
          var currentName = button.data('current-name');
          
          var modal = $(this);
          modal.find('#modal-target-id').val(targetId);
          modal.find('#modal-current-name').val(currentName);
          modal.find('.modal-title').text('Ganti Dosen Pembimbing ' + (targetId == '1' ? 'I' : 'II'));
        });
      });
    </script>
  </body>
</html>