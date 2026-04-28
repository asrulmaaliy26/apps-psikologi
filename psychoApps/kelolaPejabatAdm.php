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
              <h1 class="m-0">Kelola Personalia Pegawai Fakultas Psikologi</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_GET['message'])) { ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <?php
              if ($_GET['message'] == 'notifAssign') echo 'Jabatan berhasil ditentukan.';
              if ($_GET['message'] == 'notifReset') echo 'Jabatan berhasil direset.';
              if ($_GET['message'] == 'notifCreate') echo 'User baru berhasil dibuat.';
              if ($_GET['message'] == 'notifExist') echo 'Gagal! Username/ID sudah terdaftar.';
              if ($_GET['message'] == 'notifError') echo 'Terjadi kesalahan saat memproses data.';
              ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-info">
                <div class="card-header d-flex align-items-center">
                  <h3 class="card-title">Daftar Personalia Pegawai Fakultas Psikologi</h3>
                  <button class="btn btn-success btn-xs ml-auto" data-toggle="modal" data-target="#modalCreateUser">
                    <i class="fas fa-user-plus"></i> Tambah User Baru
                  </button>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped table-sm" id="tablePejabat">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>NIP / ID</th>
                        <th>Nama Pegawai</th>
                        <th>Jabatan Saat Ini</th>
                        <th width="20%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $q = mysqli_query($con, "SELECT p.*, j.nm as nama_jabatan 
                                              FROM dt_pegawai p 
                                              LEFT JOIN opsi_jabatan_instansi j ON p.jabatan_instansi = j.id 
                                              ORDER BY p.nama_tg ASC");
                      while ($d = mysqli_fetch_array($q)) {
                      ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $d['id']; ?></td>
                          <td><?php echo $d['nama_tg']; ?></td>
                          <td>
                            <?php
                            if (!empty($d['nama_jabatan'])) {
                              echo '<span class="badge badge-info">' . $d['nama_jabatan'] . '</span>';
                            } else {
                              echo '<span class="text-muted small"><em>Belum ada jabatan</em></span>';
                            }
                            ?>
                          </td>
                          <td>
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalAssign<?php echo $d['id']; ?>">
                              <i class="fas fa-user-tag"></i> Atur Jabatan
                            </button>
                            <?php if (!empty($d['jabatan_instansi'])) { ?>
                              <a href="aksiPejabat.php?act=reset&id=<?php echo $d['id']; ?>" class="btn btn-default btn-xs" onclick="return confirm('Kosongkan jabatan user ini?')">
                                <i class="fas fa-undo"></i> Reset
                              </a>
                            <?php } ?>
                          </td>
                        </tr>

                        <!-- Modal Assign -->
                        <div class="modal fade" id="modalAssign<?php echo $d['id']; ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="aksiPejabat.php?act=assign" method="post">
                                <div class="modal-header">
                                  <h4 class="modal-title">Tentukan Jabatan</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="user_id" value="<?php echo $d['id']; ?>">
                                  <div class="form-group">
                                    <label>Pilih Jabatan untuk <strong><?php echo $d['nama_tg']; ?></strong></label>
                                    <select name="jabatan_id" class="form-control select2" style="width: 100%;" required>
                                      <option value="">- Pilih Jabatan -</option>
                                      <?php
                                      $qj = mysqli_query($con, "SELECT * FROM opsi_jabatan_instansi ORDER BY nm ASC");
                                      while ($dj = mysqli_fetch_array($qj)) {
                                        $selected = ($dj['id'] == $d['jabatan_instansi']) ? 'selected' : '';
                                        echo "<option value='$dj[id]' $selected>$dj[nm]</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Simpan Jabatan</button>
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

    <!-- Modal Create User -->
    <div class="modal fade" id="modalCreateUser">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="aksiPejabat.php?act=create" method="post">
            <div class="modal-header bg-success text-white">
              <h4 class="modal-title">Tambah User & Pejabat Baru</h4>
              <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Username / NIP / ID <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" required placeholder="Contoh: 198001012005011001">
              </div>
              <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" required placeholder="Contoh: Dr. Nama Pegawai, M.Psi">
              </div>
              <div class="form-group">
                <label>Password <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" name="password" id="passwordCreate" class="form-control" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('passwordCreate', 'eyeIconCreate')">
                      <i class="fas fa-eye" id="eyeIconCreate"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Level Akses <span class="text-danger">*</span></label>
                <select name="level" class="form-control" required>
                  <option value="">- Pilih Level -</option>
                  <?php
                  $ql = mysqli_query($con, "SELECT * FROM opsi_level_admin WHERE id NOT IN (2, 3) ORDER BY nm ASC");
                  while ($dl = mysqli_fetch_array($ql)) {
                    echo "<option value='$dl[id]'>$dl[nm]</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Jabatan Instansi <span class="text-danger">*</span></label>
                <select name="jabatan_id" class="form-control select2" style="width: 100%;" required>
                  <option value="">- Pilih Jabatan -</option>
                  <?php
                  $qj = mysqli_query($con, "SELECT * FROM opsi_jabatan_instansi ORDER BY nm ASC");
                  while ($dj = mysqli_fetch_array($qj)) {
                    echo "<option value='$dj[id]'>$dj[nm]</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success">Simpan User Baru</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
    <script>
      $(function() {
        $('#tablePejabat').DataTable({
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