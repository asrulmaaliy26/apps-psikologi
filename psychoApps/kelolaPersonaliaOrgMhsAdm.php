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
              <h1 class="m-0">Kelola Personalia Organisasi Mahasiswa</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_GET['message'])) { ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <?php
              if ($_GET['message'] == 'notifAdd') echo 'Personalia berhasil ditambahkan.';
              if ($_GET['message'] == 'notifEdit') echo 'Personalia berhasil diupdate.';
              if ($_GET['message'] == 'notifDel') echo 'Personalia berhasil dihapus.';
              ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">Daftar Penempatan Mahasiswa dalam Organisasi</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                      <i class="fas fa-plus"></i> Tambah Personalia
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped table-sm" id="tablePersonalia">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Kategori / Unit</th>
                        <th>Role / Jabatan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $q = mysqli_query($con, "SELECT p.*, m.nama as nama_mhs, k.nm as nama_kat, r.nm as nama_role 
                                              FROM org_mhs_personalia p 
                                              JOIN dt_mhssw m ON p.nim = m.nim 
                                              JOIN org_mhs_kat k ON p.kat_id = k.id 
                                              JOIN org_mhs_role r ON p.role_id = r.id 
                                              ORDER BY k.nm ASC, r.id ASC");
                      while ($d = mysqli_fetch_array($q)) {
                      ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $d['nim']; ?></td>
                          <td><?php echo $d['nama_mhs']; ?></td>
                          <td><span class="badge badge-info"><?php echo $d['nama_kat']; ?></span></td>
                          <td><span class="badge badge-secondary"><?php echo $d['nama_role']; ?></span></td>
                          <td>
                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalEdit<?php echo $d['id']; ?>">
                              <i class="fas fa-edit"></i> Edit
                            </button>
                            <a href="aksiOrgMhs.php?act=delPers&id=<?php echo $d['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Hapus personalia ini?')">
                              <i class="fas fa-trash"></i> Hapus
                            </a>
                          </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?php echo $d['id']; ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="aksiOrgMhs.php?act=editPers" method="post">
                                <div class="modal-header">
                                  <h4 class="modal-title">Edit Personalia</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                  <div class="form-group">
                                    <label>Mahasiswa</label>
                                    <select name="nim" class="form-control select2" style="width: 100%;" required>
                                      <?php
                                      $qm = mysqli_query($con, "SELECT nim, nama FROM dt_mhssw ORDER BY nim DESC");
                                      while ($dm = mysqli_fetch_array($qm)) {
                                        $sel = ($dm['nim'] == $d['nim']) ? 'selected' : '';
                                        echo "<option value='$dm[nim]' $sel>$dm[nim] - $dm[nama]</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label>Kategori / Unit</label>
                                    <select name="kat_id" class="form-control" required>
                                      <?php
                                      $qk = mysqli_query($con, "SELECT * FROM org_mhs_kat ORDER BY nm ASC");
                                      while ($dk = mysqli_fetch_array($qk)) {
                                        $sel = ($dk['id'] == $d['kat_id']) ? 'selected' : '';
                                        echo "<option value='$dk[id]' $sel>$dk[nm]</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label>Role / Jabatan</label>
                                    <select name="role_id" class="form-control" required>
                                      <?php
                                      $qr = mysqli_query($con, "SELECT * FROM org_mhs_role ORDER BY nm ASC");
                                      while ($dr = mysqli_fetch_array($qr)) {
                                        $sel = ($dr['id'] == $d['role_id']) ? 'selected' : '';
                                        echo "<option value='$dr[id]' $sel>$dr[nm]</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

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

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="aksiOrgMhs.php?act=addPers" method="post">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Personalia Baru</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Mahasiswa</label>
                <select name="nim" class="form-control select2" style="width: 100%;" required>
                  <option value="">- Pilih Mahasiswa -</option>
                  <?php
                  $qm = mysqli_query($con, "SELECT nim, nama FROM dt_mhssw ORDER BY nim DESC");
                  while ($dm = mysqli_fetch_array($qm)) {
                    echo "<option value='$dm[nim]'>$dm[nim] - $dm[nama]</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kategori / Unit</label>
                <select name="kat_id" class="form-control" required>
                  <option value="">- Pilih Kategori -</option>
                  <?php
                  $qk = mysqli_query($con, "SELECT * FROM org_mhs_kat ORDER BY nm ASC");
                  while ($dk = mysqli_fetch_array($qk)) {
                    echo "<option value='$dk[id]'>$dk[nm]</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Role / Jabatan</label>
                <select name="role_id" class="form-control" required>
                  <option value="">- Pilih Role -</option>
                  <?php
                  $qr = mysqli_query($con, "SELECT * FROM org_mhs_role ORDER BY nm ASC");
                  while ($dr = mysqli_fetch_array($qr)) {
                    echo "<option value='$dr[id]'>$dr[nm]</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
    <script>
      $(function() {
        $('#tablePersonalia').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
        $('.select2').select2();
      });
    </script>
  </div>
</body>

</html>
