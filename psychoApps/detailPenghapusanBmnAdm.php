<?php include("contentsConAdm.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarAdmBmn.php");
    
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $q = mysqli_query($con, "SELECT * FROM dt_pengajuan_penghapusan_bmn WHERE id='$id'");
    $d = mysqli_fetch_assoc($q);
    
    if (!$d) {
        echo "<script>window.location='rekapPenghapusanBmnAdm.php';</script>";
        exit;
    }
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Detail Pengajuan #<?php echo $d['no_pengajuan']; ?></h1>
            </div>
            <div class="col-sm-6 text-right">
              <a href="rekapPenghapusanBmnAdm.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-5">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Informasi Pengajuan</h3>
                </div>
                <div class="card-body">
                  <table class="table table-sm">
                    <tr>
                      <th width="40%">Status Saat Ini</th>
                      <td>: <span class="badge badge-info"><?php echo $d['status']; ?></span></td>
                    </tr>
                    <tr>
                      <th>Metode</th>
                      <td>: <?php echo ucfirst($d['metode']); ?></td>
                    </tr>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <td>: <?php echo $d['tgl_pengajuan']; ?></td>
                    </tr>
                    <tr>
                      <th>Pengaju</th>
                      <td>: <?php echo $d['username_pengaju']; ?></td>
                    </tr>
                    <tr>
                      <th>Alasan</th>
                      <td>: <?php echo $d['alasan']; ?></td>
                    </tr>
                  </table>
                </div>
              </div>

              <div class="card card-warning mt-3">
                <div class="card-header">
                  <h3 class="card-title">Update Status (Khusus Admin BMN)</h3>
                </div>
                <form action="updateStatusPenghapusanBmnAdm.php" method="post">
                  <div class="card-body">
                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                    <div class="form-group">
                      <label>Ubah Status Menjadi</label>
                      <select name="status" class="form-control" required>
                        <option value="Draft" <?php if($d['status']=='Draft') echo 'selected'; ?>>Draft</option>
                        <option value="Diajukan" <?php if($d['status']=='Diajukan') echo 'selected'; ?>>Diajukan</option>
                        <option value="Disetujui" <?php if($d['status']=='Disetujui') echo 'selected'; ?>>Disetujui</option>
                        <option value="Ditolak" <?php if($d['status']=='Ditolak') echo 'selected'; ?>>Ditolak</option>
                        <option value="Selesai" <?php if($d['status']=='Selesai') echo 'selected'; ?>>Selesai</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Keterangan Admin</label>
                      <textarea name="keterangan_admin" class="form-control" rows="3" placeholder="Tambahkan catatan jika perlu..."><?php echo $d['keterangan_admin']; ?></textarea>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-warning btn-block">Simpan Perubahan Status</button>
                  </div>
                </form>
              </div>
            </div>

            <div class="col-md-7">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Daftar Barang yang Diajukan</h3>
                </div>
                <div class="card-body p-0">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th width="5%" class="text-center">No.</th>
                        <th>Kode Inventaris</th>
                        <th>Nama Barang</th>
                        <th>Merk</th>
                        <th>Kondisi</th>
                        <th width="10%" class="text-center">Foto</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $qd = mysqli_query($con, "SELECT b.*, okb.nm as nama_kat, omb.nm as nama_merk, okob.nm as nama_kondisi 
                                              FROM dt_pengajuan_penghapusan_bmn_detail d
                                              JOIN dt_inventaris_barang b ON d.id_barang = b.id
                                              LEFT JOIN opsi_kat_barang okb ON b.kategori = okb.id
                                              LEFT JOIN opsi_merk_barang omb ON b.merk = omb.id
                                              LEFT JOIN opsi_kondisi_barang okob ON b.kondisi = okob.id
                                              WHERE d.id_pengajuan = '$id'");
                      while ($dd = mysqli_fetch_array($qd)) {
                      ?>
                        <tr>
                          <td class="text-center"><?php echo $no++; ?></td>
                          <td><?php echo $dd['id_inventaris']; ?></td>
                          <td><?php echo $dd['nm']; ?></td>
                          <td><?php echo $dd['nama_merk']; ?></td>
                          <td><?php echo $dd['nama_kondisi']; ?></td>
                          <td class="text-center">
                            <a href="javascript:void(0)" onclick="viewImage('<?php echo $dd['image']; ?>', '<?php echo $dd['nm']; ?>')" class="btn btn-xs btn-outline-info" title="Lihat Foto">
                              <i class="fas fa-image"></i>
                            </a>
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
      </section>
    </div>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
    <script>
      function viewImage(url, name) {
        if (!url || url === '') {
          url = 'images/image_none.jpg';
        }
        Swal.fire({
          title: name,
          imageUrl: url,
          imageAlt: name,
          imageWidth: 600,
          showCloseButton: true,
          showConfirmButton: false,
          imageError: function() {
            this.src = 'images/image_none.jpg';
          }
        });
      }
    </script>
  </div>
</body>

</html>
