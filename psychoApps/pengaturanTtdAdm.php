<?php include("contentsConAdm.php"); ?>
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
              <h1 class="m-0">Pengaturan Tanda Tangan & Pejabat Dekanat</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_GET['message'])) { ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <?php
              if ($_GET['message'] == 'notifUpdate') echo 'Data Pejabat & TTD berhasil diperbarui.';
              if ($_GET['message'] == 'notifError') echo 'Terjadi kesalahan saat memproses data.';
              if ($_GET['message'] == 'notifType') echo 'Gagal! Format file harus PNG/JPG.';
              ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-primary">
                <div class="card-header">
                  <h3 class="card-title">Daftar Pejabat Penandatangan (Dekanat)</h3>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped table-sm">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th>Jabatan</th>
                        <th>Kode Nomor Surat</th>
                        <th width="20%">Preview TTD</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $q = mysqli_query($con, "SELECT d.*, p.nama_tg as nama_pejabat 
                                              FROM dekanat d 
                                              LEFT JOIN dt_pegawai p ON d.nm_jabatan = p.id 
                                              ORDER BY d.id ASC");
                      while ($d = mysqli_fetch_array($q)) {
                        $label_jabatan = "";
                        if($d['id'] == 1) $label_jabatan = "Dekan";
                        if($d['id'] == 2) $label_jabatan = "Wakil Dekan I";
                        if($d['id'] == 3) $label_jabatan = "Wakil Dekan II";
                        if($d['id'] == 4) $label_jabatan = "Wakil Dekan III";
                      ?>
                        <tr>
                          <td><?php echo $d['id']; ?></td>
                          <td>
                            <strong><?php echo $label_jabatan; ?></strong><br>
                            <small class="text-muted"><?php echo $d['nama_pejabat'] ?: '<em>Belum ditentukan</em>'; ?></small>
                          </td>
                          <td><code><?php echo $d['kd_nmr_srt']; ?></code></td>
                          <td class="text-center">
                            <?php if (!empty($d['ttd']) && file_exists("images/" . $d['ttd'])) { ?>
                              <img src="images/<?php echo $d['ttd']; ?>" height="50px" style="border: 1px solid #ddd; padding: 2px;">
                            <?php } else { ?>
                              <span class="badge badge-warning">Belum ada TTD</span>
                            <?php } ?>
                          </td>
                          <td>
                            <button class="btn btn-info btn-xs btn-block" data-toggle="modal" data-target="#modalEdit<?php echo $d['id']; ?>">
                              <i class="fas fa-edit"></i> Edit Pejabat & TTD
                            </button>
                          </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?php echo $d['id']; ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="aksiTtd.php" method="post" enctype="multipart/form-data">
                                <div class="modal-header bg-info">
                                  <h4 class="modal-title">Edit Pejabat & Tanda Tangan</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                  <div class="form-group">
                                    <label>Pejabat Penandatangan</label>
                                    <select name="nm_jabatan" class="form-control select2" style="width: 100%;" required>
                                      <option value="">- Pilih Pegawai -</option>
                                      <?php
                                      $qp = mysqli_query($con, "SELECT id, nama_tg FROM dt_pegawai ORDER BY nama_tg ASC");
                                      while ($dp = mysqli_fetch_array($qp)) {
                                        $selected = ($dp['id'] == $d['nm_jabatan']) ? 'selected' : '';
                                        echo "<option value='$dp[id]' $selected>$dp[id] - $dp[nama_tg]</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label>Kode Nomor Surat (Contoh: B-xxx/Un.03.8/PP.00.9/04/2024)</label>
                                    <input type="text" name="kd_nmr_srt" class="form-control" value="<?php echo $d['kd_nmr_srt']; ?>" required>
                                    <small class="text-muted">Kode ini akan muncul di nomor surat hasil cetak.</small>
                                  </div>
                                  <div class="form-group">
                                    <label>Upload Tanda Tangan (PNG Transparan Disarankan)</label>
                                    <input type="file" name="ttd_file" class="form-control-file mb-2">
                                    <?php if (!empty($d['ttd'])) { ?>
                                      <p class="small">File saat ini: <code><?php echo $d['ttd']; ?></code></p>
                                    <?php } ?>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                  <button type="submit" name="submit" class="btn btn-info">Simpan Perubahan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                  <p class="small text-muted"><i class="fas fa-info-circle mr-1"></i> Perubahan pada halaman ini akan langsung berdampak pada seluruh hasil cetak surat mahasiswa yang menggunakan tanda tangan pejabat terkait.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
  </div>
</body>
</html>
