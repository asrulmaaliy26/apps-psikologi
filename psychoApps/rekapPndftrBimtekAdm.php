<?php include( "contentsConAdm.php" );?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
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
                    if($id_bimtek){
                      $q_bim = mysqli_query($con, "SELECT nama_bimtek FROM bimtek_pendaftaran WHERE id='$id_bimtek'");
                      $d_bim = mysqli_fetch_assoc($q_bim);
                      echo "<div class='card-header'><h3 class='card-title'>Pendaftar: <strong>".$d_bim['nama_bimtek']."</strong></h3></div>";
                    }
                  ?>
                  <div class="card-body p-0">
                    <div class="p-3 border-bottom bg-light">
                      <form method="GET" action="">
                          <input type="hidden" name="id_bimtek" value="<?php echo $id_bimtek; ?>">
                          <div class="row">
                              <div class="col-md-4 mb-2 mb-md-0">
                                  <select name="peminatan" class="form-control form-control-sm">
                                      <option value="">-- Semua Peminatan --</option>
                                      <?php
                                          $q_ops = mysqli_query($con, "SELECT id, nm FROM opsi_bidang_skripsi ORDER BY nm ASC");
                                          while($d_ops = mysqli_fetch_assoc($q_ops)){
                                              $sel = (isset($_GET['peminatan']) && $_GET['peminatan'] == $d_ops['id']) ? 'selected' : '';
                                              echo "<option value='".$d_ops['id']."' $sel>".$d_ops['nm']."</option>";
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
                                    if(isset($_GET['peminatan']) && $_GET['peminatan'] != "") $export_url .= "&peminatan=".$_GET['peminatan'];
                                    if(isset($_GET['sort']) && $_GET['sort'] != "") $export_url .= "&sort=".$_GET['sort'];
                                  ?>
                                  <a href="<?php echo $export_url; ?>" class="btn btn-sm btn-success ml-1"><i class="fas fa-file-excel"></i> Export Excel</a>
                              </div>
                          </div>
                      </form>
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
                            $filter_sql = $id_bimtek ? " WHERE pb.id_bimtek = '$id_bimtek' " : " WHERE 1=1 ";
                            
                            $peminatan_filter = isset($_GET['peminatan']) ? mysqli_real_escape_string($con, $_GET['peminatan']) : "";
                            if($peminatan_filter != ""){
                                $filter_sql .= " AND pb.peminatan = '$peminatan_filter' ";
                            }

                            $sort = isset($_GET['sort']) ? $_GET['sort'] : "tgl_daftar";
                            $order_sql = "ORDER BY pb.tgl_daftar DESC";
                            if($sort == "nim"){
                                $order_sql = "ORDER BY pb.nim ASC";
                            } else if($sort == "nama"){
                                $order_sql = "ORDER BY m.nama ASC";
                            }

                            $query = "SELECT pb.*, m.nama, b.nama_bimtek, ops.nm as nm_peminatan 
                                      FROM bimtek_peserta pb 
                                      JOIN (SELECT MAX(id) as max_id FROM bimtek_peserta GROUP BY nim, id_bimtek) latest ON pb.id = latest.max_id
                                      JOIN dt_mhssw m ON pb.nim = m.nim 
                                      JOIN bimtek_pendaftaran b ON pb.id_bimtek = b.id
                                      JOIN opsi_bidang_skripsi ops ON pb.peminatan = ops.id
                                      $filter_sql
                                      $order_sql";
                            $result = mysqli_query($con, $query);
                            $no = 1;
                            while($row = mysqli_fetch_array($result)){
                          ?>
                          <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $row['nim'];?></td>
                            <td class="text-left"><?php echo $row['nama'];?></td>
                            <td class="text-left"><?php echo $row['nama_bimtek'];?></td>
                            <td><?php echo $row['nm_peminatan'];?></td>
                            <td>
                              <a href="file_outline_bimtek/<?php echo $row['file_outline'];?>" class="btn btn-xs btn-primary" target="_blank">
                                <i class="fas fa-file-download"></i> View
                              </a>
                            </td>
                            <td><?php echo $row['tgl_daftar'];?></td>
                            <td>
                              <div class="text-left small">
                                <?php for($s=1; $s<=3; $s++): 
                                  $col_file = 'file_absensi_'.$s;
                                  $col_tgl = 'tgl_absensi_'.$s;
                                ?>
                                  <div class="mb-1 border-bottom pb-1">
                                    <strong>Slot <?php echo $s;?>:</strong>
                                    <?php if($row[$col_file]): ?>
                                      <a href="file_absensi_bimtek/<?php echo $row[$col_file];?>" class="btn btn-xs btn-success py-0" target="_blank">
                                        <i class="fas fa-image"></i> Lihat
                                      </a>
                                      <span class="d-block text-muted" style="font-size: 0.7rem;"><?php echo $row[$col_tgl];?></span>
                                    <?php else: ?>
                                      <span class="text-danger">Belum</span>
                                    <?php endif; ?>
                                  </div>
                                <?php endfor; ?>
                              </div>
                            </td>
                            <td>
                              <button type="button" class="btn btn-xs btn-danger btn-delete" 
                                data-nim="<?php echo $row['nim'];?>" 
                                data-idbimtek="<?php echo $row['id_bimtek'];?>"
                                data-nama="<?php echo htmlspecialchars($row['nama']);?>">
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
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script>
      $(document).on('click', '.btn-delete', function() {
        const nim = $(this).data('nim');
        const idBimtek = $(this).data('idbimtek');
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
                nim: nim,
                id_bimtek: idBimtek
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
    </script>
  </body>
</html>
