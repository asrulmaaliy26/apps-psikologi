<?php
include("contentsConAdm.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>
<style>
  .btn-premium {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
  }
  .modal-content-premium {
    border-radius: 15px;
    border: none;
  }
  .modal-header-premium {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    background: linear-gradient(135deg, #28a745 0%, #218838 100%);
  }
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarUserS1.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold text-success"><i class="fas fa-door-open mr-2"></i>Data Ruangan Lab</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php
          $msg_title = "";
          $msg_body = "";
          $msg_icon = "";
          $msg_color = "";
          
          if (!empty($_GET['message'])) {
            $m = $_GET['message'];
            if ($m == 'notifAdd') {
              $msg_title = "Berhasil!";
              $msg_body = "Data ruangan baru telah berhasil ditambahkan.";
              $msg_icon = "fa-check-circle";
              $msg_color = "success";
            } elseif ($m == 'notifEdit') {
              $msg_title = "Berhasil Diperbarui!";
              $msg_body = "Perubahan data ruangan telah disimpan dengan sukses.";
              $msg_icon = "fa-edit";
              $msg_color = "success";
            } elseif ($m == 'notifDel') {
              $msg_title = "Berhasil Dihapus!";
              $msg_body = "Data ruangan telah dihapus dari sistem.";
              $msg_icon = "fa-trash-alt";
              $msg_color = "success";
            }
          }
          ?>
          <div class="row">
            <div class="col-12">
              <div class="card card-outline card-success shadow-sm">
                <div class="card-header border-0">
                  <h3 class="card-title font-weight-bold">Daftar Ruangan & Kuota</h3>
                  <button type="button" class="btn btn-success btn-sm float-right btn-premium shadow-sm px-4" data-toggle="modal" data-target="#modalAdd">
                    <i class="fas fa-plus mr-1"></i> Tambah Ruangan
                  </button>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-hover m-0 table-bordered text-center align-middle">
                      <thead class="bg-light text-muted">
                        <tr>
                          <th>No</th>
                          <th>Nama Ruangan</th>
                          <th>Kuota (Max Orang/Sesi)</th>
                          <th>Opsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $modals = "";
                        $q = mysqli_query($con, "SELECT * FROM lab_booking_ruangan ORDER BY nama ASC");
                        while ($d = mysqli_fetch_array($q)) {
                        ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td class="font-weight-bold"><?php echo $d['nama']; ?></td>
                            <td><span class="badge badge-info px-3 py-2" style="font-size: 0.9rem;"><?php echo $d['kuota']; ?> Orang</span></td>
                            <td>
                              <button class="btn btn-warning btn-xs btn-premium" data-toggle="modal" data-target="#modalEdit<?php echo $d['id']; ?>">
                                <i class="fas fa-edit"></i>
                              </button>
                              <a href="aksiLabBooking.php?act=delRuangan&id=<?php echo $d['id']; ?>" class="btn btn-danger btn-xs btn-premium" onclick="return confirm('Yakin ingin menghapus ruangan ini?')">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                          </tr>
                        <?php
                          // Modal Edit
                          $modals .= '
                          <div class="modal fade" id="modalEdit' . $d['id'] . '" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content modal-content-premium">
                                <form action="aksiLabBooking.php?act=editRuangan" method="post">
                                  <div class="modal-header modal-header-premium text-white border-0">
                                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit Ruangan</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body p-4">
                                    <input type="hidden" name="id" value="' . $d['id'] . '">
                                    <div class="form-group">
                                      <label>Nama Ruangan</label>
                                      <input type="text" name="nama" class="form-control" value="' . $d['nama'] . '" required>
                                    </div>
                                    <div class="form-group">
                                      <label>Kuota (Kapasitas Maksimal)</label>
                                      <input type="number" name="kuota" class="form-control" value="' . $d['kuota'] . '" min="1" required>
                                    </div>
                                  </div>
                                  <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary btn-premium" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success btn-premium px-4">Simpan Perubahan</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>';
                        }
                        ?>
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

    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-premium">
          <form action="aksiLabBooking.php?act=addRuangan" method="post">
            <div class="modal-header modal-header-premium text-white border-0">
              <h5 class="modal-title font-weight-bold"><i class="fas fa-plus mr-2"></i>Tambah Ruangan Baru</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body p-4">
              <div class="form-group">
                <label>Nama Ruangan</label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Lab Psikodiagnostik I" required>
              </div>
              <div class="form-group">
                <label>Kuota (Kapasitas Maksimal)</label>
                <input type="number" name="kuota" class="form-control" value="1" min="1" required>
                <small class="text-muted">Jumlah maksimal orang yang diperbolehkan dalam satu sesi.</small>
              </div>
            </div>
            <div class="modal-footer border-0">
              <button type="button" class="btn btn-secondary btn-premium" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success btn-premium px-4">Tambah Ruangan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php echo $modals; ?>

    <!-- Modal Notification Centered -->
    <?php if (!empty($msg_title)) { ?>
    <div class="modal fade" id="modalNotification" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
          <div class="modal-body text-center p-5">
            <div class="mb-4">
              <i class="fas <?php echo $msg_icon; ?> text-<?php echo $msg_color; ?>" style="font-size: 5rem; opacity: 0.8;"></i>
            </div>
            <h3 class="font-weight-bold mb-2 text-dark"><?php echo $msg_title; ?></h3>
            <p class="text-muted mb-4"><?php echo $msg_body; ?></p>
            <button type="button" class="btn btn-<?php echo $msg_color; ?> btn-lg btn-block btn-premium py-3" data-dismiss="modal" style="border-radius: 12px;">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
    <script>
      window.onload = function() {
        $('#modalNotification').modal('show');
        window.history.replaceState({}, document.title, window.location.pathname);
      };
    </script>
    <?php } ?>

    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
  </div>
</body>
</html>
