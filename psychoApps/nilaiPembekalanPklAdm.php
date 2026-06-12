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
            <span>Nilai Pembekalan PKL berhasil disimpan!</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            ';}
            ?>
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Nilai Pembekalan PKL</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active small">Nilai Pembekalan PKL</li>
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
                    <h4 class="card-title float-left">Input Nilai Pembekalan (Oleh Panitia PKL)</h4>
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
                  <form name="update" method="post" action="updateNilaiPembekalanPklAdm.php" onSubmit="return confirm('Simpan nilai pembekalan?')">
                    <input type="hidden" name="angkatan" value="<?php echo htmlspecialchars($selected_angkatan); ?>">
                    <input type="hidden" name="periode" value="<?php echo htmlspecialchars($selected_periode_dd); ?>">
                    <div class="form-group mb-0">
                      <div class="table-responsive pt-2 pb-2">
                        <table class="table table-hover m-0 table-bordered text-center table-sm table-striped">
                          <thead class="bg-info text-white">
                            <tr>
                              <th width="4%" class="pl-1 align-middle text-center">No.</th>
                              <th width="20%" class="align-middle text-center">Nama Mahasiswa</th>
                              <th width="20%" class="align-middle text-center">Kedisiplinan</th>
                              <th width="20%" class="align-middle text-center">Kompetensi Dasar</th>
                              <th width="20%" class="align-middle text-center">Partisipasi Aktif</th>
                              <th width="16%" class="pr-1 align-middle text-center">Rata-rata</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=0;
                              $sql = "SELECT p.id, p.nim, p.nama_instansi, m.nama as nama_mhs,
                                      n.panitia_pembekalan_1, n.panitia_pembekalan_2, n.panitia_pembekalan_3
                                      FROM peserta_pkl p 
                                      INNER JOIN dt_mhssw m ON p.nim=m.nim 
                                      LEFT JOIN penilaian_pkl_detail n ON p.id=n.id_peserta_pkl
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
                              
                              while($data = mysqli_fetch_array($result)) {
                              $no++;
                              $avg = ($data['panitia_pembekalan_1'] + $data['panitia_pembekalan_2'] + $data['panitia_pembekalan_3']) / 3;
                              if (empty($data['panitia_pembekalan_1']) && empty($data['panitia_pembekalan_2']) && empty($data['panitia_pembekalan_3'])) {
                                  $avg = 0;
                              }
                              ?>
                            <tr>
                              <?php echo '<input class="sr-only" type="text" name="id_peserta_pkl[]" value="'.$data['id'].'">';?>
                              <td class="text-center pl-1 align-middle font-weight-bold"> <?php echo $no;?> </td>
                              <td class="text-left align-middle"> <span class="font-weight-bold"><?php echo $data['nama_mhs'];?></span><br/><small class="text-muted"><?php echo $data['nim'];?></small> </td>
                              <td class="text-center align-middle"> 
                                <input type="number" min="0" max="100" step="0.01" class="form-control form-control-sm text-center font-weight-bold text-primary" name="n1[]" value="<?php echo $data['panitia_pembekalan_1'];?>" placeholder="0-100" required>
                              </td>
                              <td class="text-center align-middle"> 
                                <input type="number" min="0" max="100" step="0.01" class="form-control form-control-sm text-center font-weight-bold text-primary" name="n2[]" value="<?php echo $data['panitia_pembekalan_2'];?>" placeholder="0-100" required>
                              </td>
                              <td class="text-center align-middle"> 
                                <input type="number" min="0" max="100" step="0.01" class="form-control form-control-sm text-center font-weight-bold text-primary" name="n3[]" value="<?php echo $data['panitia_pembekalan_3'];?>" placeholder="0-100" required>
                              </td>
                              <td class="text-center pr-1 align-middle"> 
                                <span class="badge badge-success" style="font-size: 14px;"><?php echo number_format($avg, 2); ?></span>
                              </td>
                            </tr>
                            <?php
                              }
                              ?>                        
                          </tbody>
                        </table>
                      <div class="card-footer bg-white border-top text-right mt-3 p-3 rounded shadow-sm">
                        <button name="submit" type="submit" class="btn btn-info btn-lg px-5"> <i class="fas fa-save"></i> Simpan Nilai Pembekalan </button>
                      </div>
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
    <script>
      function calculateHorizontalAverages() {
          const rows = document.querySelectorAll('tbody tr');
          rows.forEach(row => {
              const n1 = row.querySelector('input[name="n1[]"]');
              const n2 = row.querySelector('input[name="n2[]"]');
              const n3 = row.querySelector('input[name="n3[]"]');
              const badge = row.querySelector('.badge-success');

              if (n1 && n2 && n3 && badge) {
                  let v1 = parseFloat(n1.value) || 0;
                  let v2 = parseFloat(n2.value) || 0;
                  let v3 = parseFloat(n3.value) || 0;
                  let sum = 0, count = 0;

                  if(n1.value !== '') { sum += v1; count++; }
                  if(n2.value !== '') { sum += v2; count++; }
                  if(n3.value !== '') { sum += v3; count++; }

                  // Only show average if at least one is filled, otherwise 0.00
                  let avg = count > 0 ? (v1 + v2 + v3) / 3 : 0.00; // Formula is always sum of all 3 divided by 3, or maybe sum / count? 
                  // Wait, original PHP says: $avg = ($data['panitia_pembekalan_1'] + $data['panitia_pembekalan_2'] + $data['panitia_pembekalan_3']) / 3;
                  avg = (v1 + v2 + v3) / 3;
                  badge.innerText = avg.toFixed(2);
              }
          });
      }

      // Initial calculate
      calculateHorizontalAverages();

      // Listen to input changes
      document.querySelectorAll('input[type="number"]').forEach(inp => {
          inp.addEventListener('input', calculateHorizontalAverages);
          inp.addEventListener('change', function() {
              // Auto-save silently
              let formData = new FormData(document.forms['update']);
              formData.append('submit', '1');
              fetch('updateNilaiPembekalanPklAdm.php', {
                  method: 'POST',
                  body: formData
              }).then(res => {
                  console.log('Auto-saved successfully');
              }).catch(err => console.error('Auto-save error', err));
          });
      });
    </script>
  </body>
</html>
