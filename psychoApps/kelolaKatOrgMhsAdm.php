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
              <h1 class="m-0">Kelola Kategori Organisasi Mahasiswa</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_GET['message'])) { ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <?php
              if ($_GET['message'] == 'notifAdd') echo 'Kategori berhasil ditambahkan.';
              if ($_GET['message'] == 'notifEdit') echo 'Kategori berhasil diupdate.';
              if ($_GET['message'] == 'notifDel') echo 'Kategori berhasil dihapus.';
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
                  <h3 class="card-title">Daftar Kategori / Unit (Contoh: Lab Psikologi Industri)</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                      <i class="fas fa-plus"></i> Tambah Kategori
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped table-sm">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nama Kategori</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $q = mysqli_query($con, "SELECT * FROM org_mhs_kat ORDER BY nm ASC");
                      while ($d = mysqli_fetch_array($q)) {
                      ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $d['nm']; ?></td>
                          <td>
                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalEdit<?php echo $d['id']; ?>">
                              <i class="fas fa-edit"></i> Edit
                            </button>
                            <a href="aksiOrgMhs.php?act=delKat&id=<?php echo $d['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Hapus kategori ini?')">
                              <i class="fas fa-trash"></i> Hapus
                            </a>
                          </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?php echo $d['id']; ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="aksiOrgMhs.php?act=editKat" method="post">
                                <div class="modal-header">
                                  <h4 class="modal-title">Edit Kategori</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                  <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input type="text" name="nm" class="form-control" value="<?php echo $d['nm']; ?>" required>
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
          <form action="aksiOrgMhs.php?act=addKat" method="post">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kategori Baru</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nm" class="form-control" placeholder="Contoh: Lab Psikologi Industri" required>
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
  </div>
</body>

</html>
