<?php
include("contentsConAdm.php");
// catatan: $con didefinisikan di contentsConAdm.php / conAdm.php

// Proteksi level (hanya Admin Utama)
if (empty($_SESSION['level']) || $_SESSION['level'] !== 'adminutama') {
    header("Location: ../index.php");
    exit();
}

// Handle Toggle Status Fitur
if (isset($_GET['act']) && $_GET['act'] == 'toggle' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT nama_fitur, status FROM pengaturan_fitur WHERE id = $id LIMIT 1");
    if ($fitur = mysqli_fetch_assoc($query)) {
        $newStatus = 1 - intval($fitur['status']);
        mysqli_query($con, "UPDATE pengaturan_fitur SET status = $newStatus WHERE id = $id");
        $_SESSION['msg_fitur'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Status fitur ' . htmlspecialchars($fitur['nama_fitur']) . ' berhasil diperbarui.'
        ];
    }
    header("Location: kelolaFiturAdm.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarAdminUtama.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold text-dark"><i class="fas fa-toggle-on mr-2 text-info"></i>Manajemen Fitur Aplikasi</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-info shadow">
                <div class="card-header bg-white">
                  <h3 class="card-title text-muted font-weight-bold"><i class="fas fa-tasks mr-2 text-secondary"></i>Daftar Layanan & Fitur Sistem</h3>
                </div>
                <div class="card-body">
                  <p class="text-muted mb-4">
                    Gunakan tabel di bawah ini untuk mengaktifkan atau menonaktifkan fitur sistem secara global. 
                    Menonaktifkan suatu fitur akan langsung menyembunyikan opsi menu terkait dari seluruh navigasi pengguna (mahasiswa, dosen, dan staf BMN).
                  </p>
                  
                  <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                      <thead class="bg-light">
                        <tr>
                          <th width="5%" class="text-center">No</th>
                          <th width="25%">Nama Layanan / Fitur</th>
                          <th>Deskripsi & Keterangan</th>
                          <th width="15%" class="text-center">Status</th>
                          <th width="15%" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $q = mysqli_query($con, "SELECT * FROM pengaturan_fitur ORDER BY id ASC");
                        while ($d = mysqli_fetch_array($q)) {
                            $isAktif = (intval($d['status']) === 1);
                        ?>
                          <tr>
                            <td class="text-center align-middle font-weight-bold"><?php echo $no++; ?></td>
                            <td class="align-middle">
                              <span class="font-weight-bold text-dark" style="font-size: 15px;"><?php echo htmlspecialchars($d['label_fitur']); ?></span>
                              <br>
                              <small class="text-muted font-family-monospace">code: <?php echo htmlspecialchars($d['nama_fitur']); ?></small>
                              <br>
                            </td>
                            <td class="align-middle text-muted"><?php echo htmlspecialchars($d['keterangan']); ?></td>
                            <td class="text-center align-middle">
                              <?php if ($isAktif) { ?>
                                <span class="badge badge-success px-3 py-2" style="font-size: 12px; border-radius: 30px;">
                                  <i class="fas fa-check-circle mr-1"></i> AKTIF
                                </span>
                              <?php } else { ?>
                                <span class="badge badge-danger px-3 py-2" style="font-size: 12px; border-radius: 30px;">
                                  <i class="fas fa-times-circle mr-1"></i> NONAKTIF
                                </span>
                              <?php } ?>
                            </td>
                            <td class="text-center align-middle">
                              <?php if ($isAktif) { ?>
                                <button class="btn btn-warning btn-sm btn-block font-weight-bold shadow-sm" 
                                        onclick="confirmToggle(<?php echo $d['id']; ?>, '<?php echo htmlspecialchars($d['label_fitur']); ?>', 'nonaktifkan')">
                                  <i class="fas fa-toggle-off mr-1"></i> Nonaktifkan
                                </button>
                              <?php } else { ?>
                                <button class="btn btn-success btn-sm btn-block font-weight-bold shadow-sm" 
                                        onclick="confirmToggle(<?php echo $d['id']; ?>, '<?php echo htmlspecialchars($d['label_fitur']); ?>', 'aktifkan')">
                                  <i class="fas fa-toggle-on mr-1"></i> Aktifkan
                                </button>
                              <?php } ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include("footerAdm.php"); ?>

    <?php include("jsAdm.php"); ?>

    <script>
      // Fallback untuk halaman Manajemen Fitur: jika confirmToggle belum didefinisikan di jsAdm.php
      // (kelolaFiturAdm.php menggunakan onclick="confirmToggle(...)".)
      if (typeof window.confirmToggle !== 'function') {
        window.confirmToggle = function(id, label, act) {
          const actionText = (act === 'nonaktifkan') ? 'nonaktifkan' : 'aktifkan';

          Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin ${actionText} fitur: ${label}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: act === 'nonaktifkan' ? '#f59e0b' : '#22c55e',
            cancelButtonColor: '#6b7280',
            confirmButtonText: `Ya, ${actionText}`,
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = `kelolaFiturAdm.php?act=toggle&id=${id}`;
            }
          });
        };
      }
    </script>

  </div>
