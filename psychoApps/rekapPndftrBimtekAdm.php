<?php include("contentsConAdm.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarAdmBakS1.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Rekap Pendaftar Bimtek Penulisan TA</h6>
            </div>
            <div class="col-sm-6 text-right">
              <a href="pndftrnBimtekAdm.php" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali ke Periode
              </a>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <section class="col-md-12">
              <div class="card card-outline card-info">
                <?php
                $id_bimtek = isset($_GET['id_bimtek']) ? mysqli_real_escape_string($con, $_GET['id_bimtek']) : "";
                if ($id_bimtek) {
                  $q_bim = mysqli_query($con, "SELECT nama_bimtek FROM bimtek_pendaftaran WHERE id='$id_bimtek'");
                  $d_bim = mysqli_fetch_assoc($q_bim);
                  $judul = "Pendaftar: <strong>" . $d_bim['nama_bimtek'] . "</strong>";
                } else {
                  $judul = "Seluruh Pendaftar Bimtek (Database)";
                }
                echo "<div class='card-header'><h3 class='card-title'>$judul</h3></div>";
                ?>
                <div class="card-body p-0">
                  <div class="p-3 border-bottom bg-light">
                    <form method="GET" action="">
                      <div class="row">
                        <div class="col-md-3 mb-2 mb-md-0">
                          <select name="id_bimtek" class="form-control form-control-sm">
                            <option value="">-- Semua Periode --</option>
                            <?php
                            $q_per = mysqli_query($con, "SELECT id, nama_bimtek FROM bimtek_pendaftaran ORDER BY start_datetime DESC");
                            while ($d_per = mysqli_fetch_assoc($q_per)) {
                              $sel_per = ($id_bimtek == $d_per['id']) ? 'selected' : '';
                              echo "<option value='" . $d_per['id'] . "' $sel_per>" . $d_per['nama_bimtek'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-3 mb-2 mb-md-0">
                          <select name="peminatan" class="form-control form-control-sm">
                            <option value="">-- Semua Peminatan --</option>
                            <?php
                            $q_ops = mysqli_query($con, "SELECT id, nm FROM opsi_bidang_skripsi ORDER BY nm ASC");
                            while ($d_ops = mysqli_fetch_assoc($q_ops)) {
                              $sel = (isset($_GET['peminatan']) && $_GET['peminatan'] == $d_ops['id']) ? 'selected' : '';
                              echo "<option value='" . $d_ops['id'] . "' $sel>" . $d_ops['nm'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-3 mb-2 mb-md-0">
                          <select name="sort" class="form-control form-control-sm">
                            <option value="tgl_daftar" <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'tgl_daftar') ? 'selected' : ''; ?>>Urutkan: Tgl Daftar (Terbaru)</option>
                            <option value="nim" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nim') ? 'selected' : ''; ?>>Urutkan: NIM (A-Z)</option>
                            <option value="nama" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nama') ? 'selected' : ''; ?>>Urutkan: Nama (A-Z)</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Filter & Sort</button>
                          <a href="?id_bimtek=<?php echo $id_bimtek; ?>" class="btn btn-sm btn-default">Reset</a>
                          <?php
                          $export_url = "exportExcelRekapPndftrBimtekAdm.php?id_bimtek=$id_bimtek";
                          if (isset($_GET['peminatan']) && $_GET['peminatan'] != "") $export_url .= "&peminatan=" . $_GET['peminatan'];
                          if (isset($_GET['sort']) && $_GET['sort'] != "") $export_url .= "&sort=" . $_GET['sort'];
                          ?>
                          <a href="<?php echo $export_url; ?>" class="btn btn-sm btn-success ml-1"><i class="fas fa-file-excel"></i> Export Excel</a>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="px-3 py-2 bg-white small border-bottom">
                    <i class="fas fa-exclamation-circle text-danger mr-1"></i> <span class="text-muted">Baris berwarna kuning menandakan <b>NIM Ganda</b> (pendaftaran berulang oleh mahasiswa yang sama).</span>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover m-0 table-bordered text-center table-sm small">
                      <thead>
                        <tr class="bg-secondary">
                          <th width="4%">No.</th>
                          <th width="12%">NIM</th>
                          <th width="18%">Nama</th>
                          <th width="15%">Bimtek / Periode</th>
                          <th width="15%">Peminatan</th>
                          <th width="10%">Outline</th>
                          <th width="10%">Tgl Daftar</th>
                          <th width="12%">Bukti Absensi</th>
                          <th width="4%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $filter_sql = " WHERE 1=1 ";

                        if ($id_bimtek) {
                          $filter_sql .= " AND pb.id_bimtek = '$id_bimtek' ";
                        }

                        $peminatan_filter = isset($_GET['peminatan']) ? mysqli_real_escape_string($con, $_GET['peminatan']) : "";
                        if ($peminatan_filter != "") {
                          $filter_sql .= " AND pb.peminatan = '$peminatan_filter' ";
                        }

                        $sort = isset($_GET['sort']) ? $_GET['sort'] : "tgl_daftar";
                        $order_sql = "ORDER BY pb.tgl_daftar DESC";
                        if ($sort == "nim") {
                          $order_sql = "ORDER BY pb.nim ASC";
                        } else if ($sort == "nama") {
                          $order_sql = "ORDER BY m.nama ASC";
                        }

                        $query = "SELECT pb.*, m.nama, b.nama_bimtek, ops.nm as nm_peminatan 
                                      FROM bimtek_peserta pb 
                                      LEFT JOIN dt_mhssw m ON pb.nim = m.nim 
                                      LEFT JOIN bimtek_pendaftaran b ON pb.id_bimtek = b.id
                                      LEFT JOIN opsi_bidang_skripsi ops ON pb.peminatan = ops.id
                                      $filter_sql
                                      $order_sql";
                        $result = mysqli_query($con, $query);
                        $data_list = [];
                        $nim_counts = [];
                        while ($row = mysqli_fetch_assoc($result)) {
                          $data_list[] = $row;
                          if (!empty($row['nim'])) {
                            $nim_counts[$row['nim']] = ($nim_counts[$row['nim']] ?? 0) + 1;
                          }
                        }

                        $no = 1;
                        foreach ($data_list as $row) {
                          $is_duplicate = (!empty($row['nim']) && ($nim_counts[$row['nim']] ?? 0) > 1);
                          $row_class = $is_duplicate ? 'table-warning' : '';
                        ?>
                          <tr class="<?php echo $row_class; ?>">
                            <td><?php echo $no++; ?></td>
                            <td>
                              <?php 
                                if (empty($row['nim'])) {
                                  echo "<span class='text-danger font-italic'>[NIM Kosong]</span>";
                                } else {
                                  echo $row['nim']; 
                                  if ($is_duplicate) {
                                    echo " <i class='fas fa-exclamation-circle text-danger' title='Pendaftar Ganda (NIM sama ditemukan)'></i>";
                                  }
                                }
                              ?>
                            </td>
                            <td class="text-left">
                              <?php echo $row['nama'] ? $row['nama'] : "<span class='text-danger font-italic small'>[Data Mahasiswa Tidak Ditemukan]</span>"; ?>
                            </td>
                            <td class="text-left"><?php echo $row['nama_bimtek']; ?></td>
                            <td><?php echo $row['nm_peminatan']; ?></td>
                            <td>
                              <a href="file_outline_bimtek/<?php echo $row['file_outline']; ?>" class="btn btn-xs btn-primary" target="_blank">
                                <i class="fas fa-file-download"></i> View
                              </a>
                            </td>
                            <td><?php echo $row['tgl_daftar']; ?></td>
                            <td>
                              <div class="text-left small">
                                <?php for ($s = 1; $s <= 4; $s++):
                                  $col_file = 'file_absensi_' . $s;
                                  $col_tgl = 'tgl_absensi_' . $s;
                                ?>
                                  <div class="mb-1 border-bottom pb-1">
                                    <strong>Slot <?php echo $s; ?>:</strong>
                                    <?php if ($row[$col_file]): ?>
                                      <a href="file_absensi_bimtek/<?php echo $row[$col_file]; ?>" class="btn btn-xs btn-success py-0 btn-view-image" data-img="file_absensi_bimtek/<?php echo $row[$col_file]; ?>" data-title="Absensi Slot <?php echo $s; ?> - <?php echo htmlspecialchars($row['nama']); ?>">
                                        <i class="fas fa-image"></i> Lihat
                                      </a>
                                      <span class="d-block text-muted" style="font-size: 0.7rem;"><?php echo $row[$col_tgl]; ?></span>
                                    <?php else: ?>
                                      <span class="text-danger">Belum</span>
                                    <?php endif; ?>
                                  </div>
                                <?php endfor; ?>
                              </div>
                            </td>
                            <td>
                              <button type="button" class="btn btn-xs btn-danger btn-delete"
                                data-id="<?php echo $row['id']; ?>"
                                data-nama="<?php echo htmlspecialchars($row['nama'] ?: 'Tanpa Nama'); ?>">
                                <i class="fas fa-trash"></i>
                              </button>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
    </div>
  </div>
  </div>

  <!-- Modal Preview Gambar -->
  <div class="modal fade" id="modalPreviewImage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="modalPreviewTitle">Preview Foto</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center bg-light">
          <img src="" id="imgPreview" class="img-fluid rounded shadow" style="max-height: 80vh;">
        </div>
        <div class="modal-footer">
          <a href="" id="btnDownloadImg" class="btn btn-primary" target="_blank"><i class="fas fa-download"></i> Buka Fullscreen / Download</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <?php include("footerAdm.php"); ?>
  <?php include("jsAdm.php"); ?>
  <script>
    $(document).on('click', '.btn-delete', function() {
      const id = $(this).data('id');
      const nama = $(this).data('nama');

      Swal.fire({
        title: 'Hapus Pendaftar?',
        html: `Apakah Anda yakin ingin menghapus pendaftaran <b>${nama}</b>?<br><br><small class="text-danger">Tindakan ini tidak dapat dibatalkan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'sDeletePndftrBimtekAdm.php',
            type: 'POST',
            data: {
              id: id
            },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                Swal.fire({
                  title: 'Berhasil!',
                  text: response.message,
                  icon: 'success'
                }).then(() => {
                  location.reload();
                });
              } else {
                Swal.fire('Gagal!', response.message, 'error');
              }
            },
            error: function() {
              Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
            }
          });
        }
      });
    });

    // Preview Gambar Modal
    $(document).on('click', '.btn-view-image', function(e) {
      e.preventDefault();
      const imgUrl = $(this).data('img');
      const title = $(this).data('title');

      $('#imgPreview').attr('src', imgUrl);
      $('#modalPreviewTitle').text(title);
      $('#btnDownloadImg').attr('href', imgUrl);
      $('#modalPreviewImage').modal('show');
    });
  </script>
</body>

</html>