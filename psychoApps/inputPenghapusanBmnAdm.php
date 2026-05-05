<?php include("contentsConAdm.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

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
              <h1 class="m-0">Pengajuan Penghapusan Barang</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php
          if (!isset($_POST['id_barang']) || empty($_POST['id_barang'])) {
            echo "<div class='alert alert-warning'>Pilih barang terlebih dahulu di menu Data Barang.</div>";
            echo "<a href='dtBarang.php' class='btn btn-primary'>Kembali ke Data Barang</a>";
          } else {
            $ids = $_POST['id_barang'];
          ?>
            <form action="sinputPenghapusanBmnAdm.php" method="post">
              <div class="row">
                <div class="col-md-6">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Informasi Pengajuan</h3>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label>Alasan Penghapusan</label>
                        <textarea name="alasan" class="form-control" rows="3" required placeholder="Contoh: Barang sudah rusak berat dan tidak bisa diperbaiki."></textarea>
                      </div>
                      <div class="form-group">
                        <label>Metode Penghapusan</label>
                        <select name="metode" class="form-control" required>
                          <option value="lelang">Lelang</option>
                          <option value="hibah">Hibah</option>
                          <option value="musnah">Dimusnahkan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Tanggal Pengajuan</label>
                        <input type="date" name="tgl_pengajuan" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">Daftar Barang Terpilih</h3>
                    </div>
                    <div class="card-body p-0">
                      <table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Kode Inventaris</th>
                            <th>Nama Barang</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          foreach ($ids as $id) {
                            $id = mysqli_real_escape_string($con, $id);
                            $q = mysqli_query($con, "SELECT id_inventaris, nm FROM dt_inventaris_barang WHERE id='$id'");
                            $d = mysqli_fetch_assoc($q);
                            echo "<tr>
                                    <td>$no</td>
                                    <td>$d[id_inventaris]</td>
                                    <td>$d[nm]</td>
                                    <input type='hidden' name='id_barang[]' value='$id'>
                                  </tr>";
                            $no++;
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer">
                      <button type="submit" name="status" value="Draft" class="btn btn-secondary">Simpan Draft</button>
                      <button type="submit" name="status" value="Diajukan" class="btn btn-primary float-right">Ajukan Sekarang</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          <?php } ?>
        </div>
      </section>
    </div>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
  </div>
</body>

</html>
