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
              <h1 class="m-0">Daftar Mahasiswa S1</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_GET['message'])) { ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <?php
              if ($_GET['message'] == 'notifCreate') echo 'Mahasiswa baru berhasil ditambahkan.';
              if ($_GET['message'] == 'notifDelete') echo 'Data mahasiswa berhasil dihapus.';
              if ($_GET['message'] == 'notifExist') echo 'Gagal! NIM sudah terdaftar.';
              if ($_GET['message'] == 'notifError') echo 'Terjadi kesalahan saat memproses data.';
              ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-primary">
                <div class="card-header d-flex align-items-center">
                  <h3 class="card-title">Data Mahasiswa S1 Fakultas Psikologi</h3>
                  <button class="btn btn-primary btn-xs ml-auto" data-toggle="modal" data-target="#modalCreateMhs">
                    <i class="fas fa-user-plus"></i> Tambah Mahasiswa S1
                  </button>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped table-sm" id="tableMhs">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Angkatan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $q = mysqli_query($con, "SELECT m.* FROM dt_mhssw m 
                                              JOIN dt_all_adm a ON m.nim = a.username 
                                              WHERE a.level = 2 
                                              ORDER BY m.nim DESC");
                      while ($d = mysqli_fetch_array($q)) {
                      ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $d['nim']; ?></td>
                          <td><?php echo $d['nama']; ?></td>
                          <td><?php echo $d['angkatan']; ?></td>
                          <td class="text-center">
                            <a href="aksiMahasiswa.php?act=delete&nim=<?php echo $d['nim']; ?>&level=2" class="btn btn-danger btn-xs" onclick="return confirm('Hapus data mahasiswa ini?')">
                              <i class="fas fa-trash"></i> Hapus
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

    <!-- Modal Create Mahasiswa -->
    <div class="modal fade" id="modalCreateMhs">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="aksiMahasiswa.php?act=create" method="post">
            <div class="modal-header bg-primary text-white">
              <h4 class="modal-title">Tambah Mahasiswa S1 Baru</h4>
              <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="level" value="2">
              <div class="form-group">
                <label>NIM <span class="text-danger">*</span></label>
                <input type="text" name="nim" class="form-control" required placeholder="Contoh: 1808101010">
              </div>
              <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" required placeholder="Nama Lengkap Tanpa Gelar">
              </div>
              <div class="form-group">
                <label>Angkatan <span class="text-danger">*</span></label>
                <input type="number" name="angkatan" class="form-control" required placeholder="Contoh: 2023">
              </div>
              <div class="form-group">
                <label>Password <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" name="password" id="passwordMhs" class="form-control" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('passwordMhs', 'eyeIconMhs')">
                      <i class="fas fa-eye" id="eyeIconMhs"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Mahasiswa</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
    <script>
      $(function() {
        $('#tableMhs').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });

      function togglePass(inputId, iconId) {
        var x = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
        if (x.type === "password") {
          x.type = "text";
          icon.classList.remove("fa-eye");
          icon.classList.add("fa-eye-slash");
        } else {
          x.type = "password";
          icon.classList.remove("fa-eye-slash");
          icon.classList.add("fa-eye");
        }
      }
    </script>
  </div>
</body>

</html>
