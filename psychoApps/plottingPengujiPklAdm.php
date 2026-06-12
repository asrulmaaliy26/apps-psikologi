<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
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
      <div class="content-header">
        <div class="container-fluid">
          <?php
            if (!empty($_GET['message']) && $_GET['message'] == 'notifUpdate') {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span>Plotting Penguji berhasil disimpan!</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            ';}
            ?>
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Plotting Penguji PKL</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active small">Plotting Penguji PKL</li>
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
                    <h4 class="card-title float-left">Plotting Dosen Penguji PKL</h4>
                  </div>
                </div>
                <div class="card-body pt-2 pb-2 pl-0 pr-0">
                  <div class="row pt-3 pl-3 pr-3 pb-0">
                    <div class="col-md-8">
                      <form method="GET" action="">
                        <div class="form-row">
                          <div class="col-md-6 mb-3">
                            <div class="input-group input-group-sm">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="filterPeriode">Periode</label>
                              </div>
                              <select class="custom-select" id="filterPeriode" name="periode" onchange="this.form.submit()">
                                <option value="">-- Semua Periode --</option>
                                <?php
                                  $q_active_periode_dd = mysqli_query($con, "SELECT id FROM pendaftaran_pkl WHERE status='1' LIMIT 1");
                                  $d_active_dd = mysqli_fetch_assoc($q_active_periode_dd);
                                  $active_periode_id_dd = $d_active_dd ? $d_active_dd['id'] : '';
                                  $selected_periode_dd = isset($_GET['periode']) ? $_GET['periode'] : $active_periode_id_dd;

                                  $q_periode = mysqli_query($con, "
                                      SELECT p.id, t.tahap, ta.ta, s.nama as nama_semester, p.status 
                                      FROM pendaftaran_pkl p 
                                      LEFT JOIN opsi_tahap_ujprop_ujskrip t ON p.tahap = t.id 
                                      LEFT JOIN dt_ta ta ON p.ta = ta.id 
                                      LEFT JOIN opsi_nama_semester s ON ta.semester = s.id 
                                      ORDER BY p.id DESC
                                  ");
                                  while($p = mysqli_fetch_assoc($q_periode)) {
                                      $sel_p = ($selected_periode_dd == $p['id']) ? 'selected' : '';
                                      $label_p = "Tahap ".$p['tahap']." ".$p['nama_semester']." ".$p['ta'];
                                      if ($p['status'] == '1') $label_p .= " (Aktif)";
                                      echo "<option value='".$p['id']."' ".$sel_p.">".$label_p."</option>";
                                  }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6 mb-3">
                            <div class="input-group input-group-sm">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="filterAngkatan">Angkatan</label>
                              </div>
                              <select class="custom-select" id="filterAngkatan" name="angkatan" onchange="this.form.submit()">
                                <option value="">-- Semua Angkatan --</option>
                                <?php
                                  $q_angkatan = mysqli_query($con, "SELECT DISTINCT LEFT(nim, 2) as angkatan FROM peserta_pkl WHERE val_adm='2' ORDER BY angkatan DESC");
                                  $selected_angkatan = $_GET['angkatan'] ?? '';
                                  while($a = mysqli_fetch_assoc($q_angkatan)) {
                                      $selected = ($selected_angkatan == $a['angkatan']) ? 'selected' : '';
                                      echo "<option value='".$a['angkatan']."' ".$selected.">20".$a['angkatan']."</option>";
                                  }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <form name="update" method="post" action="updatePlottingPengujiPklAdm.php" onSubmit="return confirm('Simpan perubahan plotting penguji?')">
                    <!-- Retain selected filter when saving -->
                    <input type="hidden" name="angkatan" value="<?php echo htmlspecialchars($selected_angkatan); ?>">
                    <input type="hidden" name="periode" value="<?php echo htmlspecialchars($selected_periode_dd); ?>">
                    <div class="form-group">
                      <button name="submit" type="submit" class="btn btn-outline-danger btn-flat btn-xs float-right mr-3"> <i class="fas fa-save"></i> Simpan Plotting </button>
                      <div class="table-responsive pt-2 pb-2">
                        <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                          <thead>
                            <tr class="text-center bg-secondary">
                              <td width="4%" class="pl-1">No.</td>
                              <td width="20%">Nama Mahasiswa</td>
                              <td width="15%">Instansi PKL</td>
                              <td width="25%">Dosen DPL Saat Ini</td>
                              <td width="25%" class="pr-1">Dosen Penguji</td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=0;
                              $sql = "SELECT p.*, m.nama as nama_mhs, d.nama as nama_dpl 
                                      FROM peserta_pkl p 
                                      INNER JOIN dt_mhssw m ON p.nim=m.nim 
                                      LEFT JOIN dt_pegawai d ON p.dpl=d.id
                                      WHERE p.val_adm='2'";

                              if (!empty($_GET['angkatan'])) {
                                  $filter_angkatan = mysqli_real_escape_string($con, $_GET['angkatan']);
                                  $sql .= " AND LEFT(p.nim, 2) = '$filter_angkatan'";
                              }

                              // Ambil periode aktif
                              $q_active_periode = mysqli_query($con, "SELECT id FROM pendaftaran_pkl WHERE status='1' LIMIT 1");
                              $d_active = mysqli_fetch_assoc($q_active_periode);
                              $active_periode_id = $d_active ? $d_active['id'] : '';
                              
                              $selected_periode = isset($_GET['periode']) ? $_GET['periode'] : $active_periode_id;

                              if (!empty($selected_periode)) {
                                  $filter_periode = mysqli_real_escape_string($con, $selected_periode);
                                  $sql .= " AND p.id_pkl = '$filter_periode'";
                              }

                              $sql .= " ORDER BY p.id DESC";
                              $result = mysqli_query($con, $sql);
                              
                              // Ambil semua dosen untuk opsi dropdown penguji
                              $qdosen = mysqli_query($con, "SELECT id, nama FROM dt_pegawai WHERE jenis_pegawai='1' AND status='1' ORDER BY nama ASC");
                              $dosen_options = "";
                              while($d = mysqli_fetch_assoc($qdosen)) {
                                  $dosen_options .= "<option value='".$d['id']."'>".$d['nama']."</option>";
                              }

                              // Ambil semua dosen untuk opsi dropdown DPL
                              $qdpl = mysqli_query($con, "SELECT id, nama FROM dt_pegawai WHERE jenis_pegawai='1' AND status='1' ORDER BY nama ASC");
                              $dpl_options = "";
                              while($d2 = mysqli_fetch_assoc($qdpl)) {
                                  $dpl_options .= "<option value='".$d2['id']."'>".$d2['nama']."</option>";
                              }

                              while($data = mysqli_fetch_array($result)) {
                              $no++;
                              ?>
                            <tr>
                              <?php echo '<input class="sr-only" type="text" name="id[]" id="id" value="'.$data['id'].'">';?>
                              <td class="text-center pl-1"> <?php echo $no;?> </td>
                              <td class="text-left"> <?php echo $data['nama_mhs'].'<br/><small>'.$data['nim'].'</small>';?> </td>
                              <td class="text-left"> <?php echo $data['nama_instansi'];?> </td>
                              <td class="text-center pr-1"> 
                                <select name="id_dpl[]" class="form-control form-control-sm">
                                  <option value="">-- Pilih DPL --</option>
                                  <?php 
                                    // Set selected option
                                    $options_dpl_render = str_replace("<option value='".$data['dpl']."'>", "<option value='".$data['dpl']."' selected>", $dpl_options);
                                    echo $options_dpl_render;
                                  ?>
                                </select>
                              </td>
                              <td class="text-center pr-1"> 
                                <select name="id_penguji[]" class="form-control form-control-sm">
                                  <option value="">-- Pilih Penguji --</option>
                                  <?php 
                                    // Set selected option
                                    $options = str_replace("<option value='".$data['id_penguji']."'>", "<option value='".$data['id_penguji']."' selected>", $dosen_options);
                                    echo $options;
                                  ?>
                                </select>
                              </td>
                            </tr>
                            <?php
                              }
                              ?>                        
                          </tbody>
                        </table>
                      </div>
                      <button name="submit" type="submit" class="btn btn-outline-danger btn-flat btn-xs float-right mr-3"> <i class="fas fa-save"></i> Simpan Plotting </button>
                    </div>
                  </form>
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
