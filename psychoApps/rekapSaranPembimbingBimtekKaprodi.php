<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];

// Validasi: hanya Kaprodi (jabatan_instansi = 47)
$q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
$dMe = mysqli_fetch_assoc($q_me);
if ($dMe['jabatan_instansi'] != '47') {
  header("location:dashboardAdm.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include("navtopAdm.php");
    include("navSideBarDosen.php"); ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Rekap Saran Dosen Pembimbing - Bimtek</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active small">Rekap Saran Pembimbing</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <!-- Filter -->
          <div class="card card-outline card-secondary mb-3">
            <div class="card-header">
              <h5 class="card-title">Filter Periode</h5>
            </div>
            <div class="card-body">
              <form method="GET" class="form-inline">
                <div class="form-group mr-3">
                  <label class="mr-2">Periode:</label>
                  <select name="id_bimtek" class="form-control form-control-sm">
                    <option value="">-- Semua Periode --</option>
                    <?php
                    $q_all_per = mysqli_query($con, "SELECT id, nama_bimtek FROM bimtek_pendaftaran ORDER BY id DESC");
                    $latest_id = '';
                    $periods = [];
                    while ($dp = mysqli_fetch_assoc($q_all_per)) {
                      $periods[] = $dp;
                      if ($latest_id == '') $latest_id = $dp['id'];
                    }
                    $current_id_bimtek = isset($_GET['id_bimtek']) ? $_GET['id_bimtek'] : $latest_id;
                    foreach ($periods as $dp) {
                      $sel = ($current_id_bimtek == $dp['id']) ? 'selected' : '';
                      echo "<option value='" . $dp['id'] . "' $sel>" . $dp['nama_bimtek'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="rekapSaranPembimbingBimtekKaprodi.php" class="btn btn-secondary btn-sm ml-2"><i class="fas fa-times"></i> Reset</a>
              </form>
            </div>
          </div>

          <!-- Tabel -->
          <div class="card card-outline card-warning">
            <div class="card-header">
              <h5 class="card-title"><i class="fas fa-user-friends"></i> Rekap Saran Dosen Pembimbing Mahasiswa</h5>
              <div class="card-tools">
                <span class="badge badge-warning">Hanya tampil yang sudah diterima dan memilih saran pembimbing</span>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm text-center small">
                  <thead class="bg-warning">
                    <tr>
                      <th>No</th>
                      <th>NIM</th>
                      <th>Nama Mahasiswa</th>
                      <th>Peminatan</th>
                      <th>Periode Bimtek</th>
                      <th>Saran Dosen Pembimbing 1</th>
                      <th>Saran Dosen Pembimbing 2</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $where = ["pp.status='diterima'", "(pp.pembimbing_saran_1 IS NOT NULL OR pp.pembimbing_saran_2 IS NOT NULL)"];
                    if (!empty($current_id_bimtek)) $where[] = "pp.id_bimtek='" . mysqli_real_escape_string($con, $current_id_bimtek) . "'";
                    $where_sql = "WHERE " . implode(' AND ', $where);

                    $q_list = mysqli_query($con, "SELECT pp.nim, pp.pembimbing_saran_1, pp.pembimbing_saran_2,
                            m.nama as mhs_nama, b.nama_bimtek, o.nm as nm_pem,
                            d1.nama as saran1_nama, d2.nama as saran2_nama
                            FROM bimtek_pra_proposal pp
                            LEFT JOIN dt_mhssw m ON pp.nim = m.nim
                            LEFT JOIN bimtek_pendaftaran b ON pp.id_bimtek = b.id
                            LEFT JOIN dt_pegawai d1 ON pp.pembimbing_saran_1 = d1.id
                            LEFT JOIN dt_pegawai d2 ON pp.pembimbing_saran_2 = d2.id
                            LEFT JOIN bimtek_peserta bp ON bp.nim = pp.nim AND bp.id_bimtek = pp.id_bimtek
                            LEFT JOIN opsi_bidang_skripsi o ON bp.peminatan = o.id
                            $where_sql
                            ORDER BY b.id DESC, m.nama ASC");
                    $no = 1;
                    while ($d = mysqli_fetch_assoc($q_list)):
                    ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['nim']; ?></td>
                        <td class="text-left font-weight-bold"><?php echo $d['mhs_nama']; ?></td>
                        <td><?php echo $d['nm_pem']; ?></td>
                        <td class="small text-muted"><?php echo $d['nama_bimtek']; ?></td>
                        <td class="text-left">
                          <?php if ($d['saran1_nama']): ?>
                            <i class="fas fa-user-tie text-warning mr-1"></i><?php echo $d['saran1_nama']; ?>
                          <?php else: ?>
                            <span class="text-muted">-</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-left">
                          <?php if ($d['saran2_nama']): ?>
                            <i class="fas fa-user-tie text-warning mr-1"></i><?php echo $d['saran2_nama']; ?>
                          <?php else: ?>
                            <span class="text-muted">-</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($q_list) == 0): ?>
                      <tr>
                        <td colspan="7" class="text-center text-muted py-3">Belum ada data saran pembimbing untuk periode ini.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>
  </div>
  <?php include("footerAdm.php");
  include("jsAdm.php"); ?>
</body>

</html>
