<?php
include("contentsConAdm.php");

// Proteksi Level: Hanya Admin BMN (5) dan Admin Utama (10)
if ($_SESSION['level'] != '5' && $_SESSION['level'] != '10') {
    header("location:dashboardAdm.php");
    exit();
}

$qry_jum = "SELECT COUNT(id) AS jumData FROM bmn_ruangan_booking";
$r_jum = mysqli_query($con, $qry_jum) or die(mysqli_error($con));
$d_jum = mysqli_fetch_assoc($r_jum);
?>
<?php
$roomsResult = mysqli_query($con, "SELECT id, nm, lokasi_kampus FROM dt_ruang ORDER BY nm ASC");
$rooms = [];
while ($row = mysqli_fetch_assoc($roomsResult)) {
    $rooms[] = $row;
}
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
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
  }
  .room-img-preview {
    max-width: 100px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarAdmBmn.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold text-info"><i class="fas fa-home mr-2"></i>Kelola Ruangan Booking (BMN)</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="dashboardAdmBmn.php">Dashboard</a></li>
                <li class="breadcrumb-item active small">Kelola Ruangan</li>
              </ol>
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
            } elseif ($m == 'notifGagal') {
              $msg_title = "Gagal!";
              $msg_body = "Terjadi kesalahan saat memproses data. Periksa kembali inputan dan ukuran gambar Anda.";
              $msg_icon = "fa-exclamation-triangle";
              $msg_color = "danger";
            }
          }
          ?>
          <div class="row">
            <div class="col-12">
              <div class="card card-outline card-info shadow-sm">
                <div class="card-header border-0">
                  <h3 class="card-title font-weight-bold">Daftar Ruang Booking BMN (<?php echo $d_jum['jumData']; ?>)</h3>
                  <button type="button" class="btn btn-info btn-sm float-right btn-premium shadow-sm px-4" data-toggle="modal" data-target="#modalAdd">
                    <i class="fas fa-plus mr-1"></i> Tambah Ruangan Booking
                  </button>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-hover m-0 table-bordered text-center align-middle small">
                      <thead class="bg-light text-muted">
                        <tr>
                          <th width="4%">No</th>
                          <th width="12%">Gambar</th>
                          <th width="20%">Nama Ruangan</th>
                          <th width="12%">Kondisi</th>
                          <th width="15%">Lokasi</th>
                          <th width="10%">Kapasitas</th>
                          <th width="12%">Status</th>
                          <th width="15%">Opsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $modals = "";
                        $q = mysqli_query($con, "SELECT * FROM bmn_ruangan_booking ORDER BY nama_ruangan ASC");
                        while ($d = mysqli_fetch_array($q)) {
                            $imgPath = !empty($d['gambar']) ? "images/ruangan/" . $d['gambar'] : "images/no-image.png";
                            $statusBadge = $d['status_aktif'] == 1 ? '<span class="badge badge-success px-2 py-1">Aktif</span>' : '<span class="badge badge-secondary px-2 py-1">Nonaktif</span>';
                        ?>
                          <tr>
                            <td class="align-middle"><?php echo $no++; ?></td>
                            <td class="align-middle">
                              <img src="<?php echo $imgPath; ?>" class="room-img-preview" onError="this.onerror=null;this.src='images/cowok.png';">
                            </td>
                            <td class="align-middle font-weight-bold text-left"><?php echo $d['nama_ruangan']; ?></td>
                            <td class="align-middle"><?php echo $d['kondisi']; ?></td>
                            <td class="align-middle text-left"><?php echo $d['lokasi']; ?></td>
                            <td class="align-middle"><span class="badge badge-info"><?php echo $d['kapasitas']; ?> Orang</span></td>
                            <td class="align-middle"><?php echo $statusBadge; ?></td>
                            <td class="align-middle">
                              <button class="btn btn-warning btn-xs btn-premium" data-toggle="modal" data-target="#modalEdit<?php echo $d['id']; ?>" title="Edit Ruangan">
                                <i class="fas fa-edit"></i> Edit
                              </button>
                              <a href="bmnBookingRuanganAksi.php?act=del&id=<?php echo $d['id']; ?>" class="btn btn-danger btn-xs btn-premium" onclick="return confirm('Yakin ingin menghapus ruangan ini dari daftar booking?')" title="Hapus Ruangan">
                                <i class="fas fa-trash"></i> Hapus
                              </a>
                            </td>
                          </tr>
                        <?php
                          // Modal Edit Room
                          $modals .= '
                          <div class="modal fade" id="modalEdit' . $d['id'] . '" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                              <div class="modal-content modal-content-premium">
                                <form action="bmnBookingRuanganAksi.php?act=edit" method="post" enctype="multipart/form-data">
                                  <div class="modal-header modal-header-premium text-white border-0">
                                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit Ruangan Booking</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body p-4 text-left">
                                    <input type="hidden" name="id" value="' . $d['id'] . '">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                  
                                          <input type="text" name="nama_ruangan" class="form-control form-control-sm" value="' . htmlspecialchars($d['nama_ruangan']) . '" required>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-weight-bold">Kondisi Ruangan</label>
                                           <input type="text" name="kondisi" id="kondisiInput" class="form-control form-control-sm" value="' . htmlspecialchars($d['kondisi']) . '" placeholder="Contoh: Sangat Baik / Layak Pakai" required>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-weight-bold">Lokasi</label>
                                          <input type="text" name="lokasi" class="form-control form-control-sm" value="' . htmlspecialchars($d['lokasi']) . '" placeholder="Contoh: Gedung B Lantai 1" required>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="font-weight-bold">Kapasitas (Orang)</label>
                                          <input type="number" name="kapasitas" class="form-control form-control-sm" value="' . $d['kapasitas'] . '" min="1" required>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-weight-bold">Status Aktif</label>
                                          <select name="status_aktif" class="form-control form-control-sm" required>
                                            <option value="1" ' . ($d['status_aktif'] == 1 ? 'selected' : '') . '>Aktif (Dapat Dibooking)</option>
                                            <option value="0" ' . ($d['status_aktif'] == 0 ? 'selected' : '') . '>Nonaktif (Disembunyikan)</option>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-weight-bold">Gambar Ruangan</label>
                                          <input type="file" name="gambar" class="form-control-file form-control-sm">
                                          <small class="text-muted">* Kosongkan jika tidak ingin mengubah gambar saat ini</small>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="font-weight-bold">Keterangan / Fasilitas</label>
                                      <textarea name="keterangan" class="form-control form-control-sm" rows="3">' . htmlspecialchars($d['keterangan']) . '</textarea>
                                    </div>
                                  </div>
                                  <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary btn-premium" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-info btn-premium px-4">Simpan Perubahan</button>
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

    <!-- Modal Add Room -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-content-premium">
          <form action="bmnBookingRuanganAksi.php?act=add" method="post" enctype="multipart/form-data">
            <div class="modal-header modal-header-premium text-white border-0 bg-info">
              <h5 class="modal-title font-weight-bold"><i class="fas fa-plus mr-2"></i>Tambah Ruangan Booking Baru</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body p-4 text-left">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="font-weight-bold">Pilih Ruangan (atau Isi Manual)</label>
                    <div class="custom-control custom-checkbox mb-2">
                      <input type="checkbox" class="custom-control-input" id="filterKampus3" checked>
                      <label class="custom-control-label font-weight-normal text-muted" for="filterKampus3" style="cursor: pointer;">Hanya tampilkan ruang di Kampus 3</label>
                    </div>
                    <select id="existingRoomSelect" class="form-control form-control-sm">
                      <option value="">-- Pilih dari daftar --</option>
                      <!-- Options will be populated by JS -->
                    </select>
                  </div>
                  <div class="form-group">
                      <label class="font-weight-bold">Nama Ruangan (Jika custom)</label>
                      <input type="text" id="customNamaRuangan" name="nama_ruangan" class="form-control form-control-sm" placeholder="Masukkan nama ruangan (atau pilih di atas)">
                  </div>
                  <div class="form-group">
                      <label class="font-weight-bold">Kondisi Ruangan</label>
                      <input type="text" id="kondisiInput" name="kondisi" class="form-control form-control-sm" placeholder="Contoh: Sangat Baik / Bersih">
                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold">Lokasi</label>
                    <input type="text" id="lokasiInput" name="lokasi" class="form-control form-control-sm" placeholder="Contoh: Gedung C Lantai 3" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="font-weight-bold">Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" class="form-control form-control-sm" value="50" min="1" required>
                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold">Status Aktif</label>
                    <select name="status_aktif" class="form-control form-control-sm" required>
                      <option value="1">Aktif (Dapat Dibooking)</option>
                      <option value="0">Nonaktif (Disembunyikan)</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold">Gambar Ruangan</label>
                    <input type="file" name="gambar" class="form-control-file form-control-sm" required>
                    <small class="text-muted">Ukuran maks 2MB (format: jpg, jpeg, png)</small>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Keterangan / Fasilitas</label>
                <textarea name="keterangan" class="form-control form-control-sm" rows="3" placeholder="Sebutkan fasilitas seperti AC, LCD, Sound System, Panggung, dll."></textarea>
              </div>
            </div>
            <div class="modal-footer border-0">
              <button type="button" class="btn btn-secondary btn-premium" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-info btn-premium px-4">Tambah Ruangan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php echo $modals; ?>

<!-- Modal Image Preview -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0">
        <img id="bigImage" src="" class="img-fluid rounded">
      </div>
    </div>
  </div>
</div>
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
    <script>
      var roomsData = <?php echo json_encode($rooms); ?>;
      
      function populateRooms() {
        var showOnlyKampus3 = $('#filterKampus3').is(':checked');
        var select = $('#existingRoomSelect');
        select.empty();
        select.append('<option value="">-- Pilih dari daftar --</option>');
        
        roomsData.forEach(function(room) {
          if (!showOnlyKampus3 || room.lokasi_kampus === 'Kampus 3') {
            select.append($('<option>', {
              value: room.id,
              'data-nama': room.nm,
              text: room.nm
            }));
          }
        });
      }

      $('#filterKampus3').on('change', populateRooms);
      
      // Initialize on load
      populateRooms();

      // Image click to preview larger version
      $(document).on('click', '.room-img-preview', function(){
        var src = $(this).attr('src');
        $('#bigImage').attr('src', src);
        $('#imageModal').modal('show');
      });

      // Existing room selection auto-fill
      $(document).on('change', '#existingRoomSelect', function(){
        var selected = $(this).find('option:selected');
        var nama = selected.data('nama') || '';
        $('#customNamaRuangan').val(nama);
        if (selected.val()) {
          $('#customNamaRuangan').prop('readonly', true);
        } else {
          $('#customNamaRuangan').prop('readonly', false);
        }
      });

      // Clear modal on hidden
      $('#modalAdd').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('#filterKampus3').prop('checked', true); // reset checkbox
        populateRooms(); // rebuild options
        $('#existingRoomSelect').val('');
        $('#customNamaRuangan').prop('readonly', false);
      });
    </script>
  </div>
</body>
</html>
