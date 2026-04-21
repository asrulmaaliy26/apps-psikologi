<?php include( "contentsConAdm.php" ); ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" ); ?>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
      ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (isset($_SESSION['msg'])) {
                  echo "<div class='alert alert-info alert-dismissible fade show'><span>{$_SESSION['msg']}</span><button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
                  unset($_SESSION['msg']);
              }
            ?>
            <div class="row">
              <div class="col-sm-6"><h6 class="m-0">Plotting Lembaga PKL</h6></div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- Manajemen Periode -->
              <div class="col-md-6">
                <div class="card card-outline card-primary">
                  <div class="card-header">
                    <h5 class="card-title">Periode Plotting PKL</h5>
                    <button class="btn btn-xs btn-primary float-right" data-toggle="modal" data-target="#modalPeriode">Tambah Periode</button>
                  </div>
                  <div class="card-body p-0 table-responsive text-sm">
                    <table class="table table-sm table-bordered mb-0">
                      <thead class="bg-light"><tr><th>ID</th><th>Periode</th><th>Tahun</th><th>Status</th><th>Aksi</th></tr></thead>
                      <tbody>
                        <?php
                          $qPer = mysqli_query($con, "SELECT * FROM pkl_plot_periode ORDER BY id_periode DESC");
                          while($dPer = mysqli_fetch_array($qPer)){
                        ?>
                        <tr>
                          <td><?= $dPer['id_periode']; ?></td>
                          <td><?= $dPer['periode']; ?></td>
                          <td><?= $dPer['tahun']; ?></td>
                          <td><?= $dPer['status']; ?></td>
                          <td>
                            <?php if($dPer['status']=='Tutup'){ ?>
                                <a href="updatePlotPklAdm.php?act=open_periode&id=<?= $dPer['id_periode'] ?>" class="btn btn-xs btn-success">Buka</a>
                            <?php } else { ?>
                                <a href="updatePlotPklAdm.php?act=close_periode&id=<?= $dPer['id_periode'] ?>" class="btn btn-xs btn-danger">Tutup</a>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

               <!-- Manajemen Penjurusan -->
               <div class="col-md-6">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h5 class="card-title">Daftar Penjurusan</h5>
                    <button class="btn btn-xs btn-info float-right" data-toggle="modal" data-target="#modalPenjurusan">Tambah Penjurusan</button>
                  </div>
                  <div class="card-body p-0 table-responsive text-sm">
                    <table class="table table-sm table-bordered mb-0">
                      <thead class="bg-light"><tr><th>ID</th><th>Nama Penjurusan</th><th>Aksi</th></tr></thead>
                      <tbody>
                        <?php
                          $qPen = mysqli_query($con, "SELECT * FROM pkl_penjurusan ORDER BY id_penjurusan DESC");
                          while($dPen = mysqli_fetch_array($qPen)){
                        ?>
                        <tr>
                          <td><?= $dPen['id_penjurusan']; ?></td>
                          <td><?= $dPen['nama_penjurusan']; ?></td>
                          <td>
                            <a href="updatePlotPklAdm.php?act=delete_penjurusan&id=<?= $dPen['id_penjurusan'] ?>" onclick="return confirm('Hapus?');" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- List Lembaga -->
            <div class="row mt-3">
              <div class="col-12">
                <div class="card card-outline card-warning">
                  <div class="card-header">
                     <h5 class="card-title">Daftar Lembaga per Periode</h5>
                     <button class="btn btn-xs btn-warning float-right" data-toggle="modal" data-target="#modalLembaga">Tambah Lembaga</button>
                  </div>
                  <div class="card-body p-0 table-responsive text-sm">
                    <table class="table table-sm table-bordered table-hover mb-0">
                      <thead class="bg-light text-center">
                        <tr>
                          <th>Periode</th><th>Penjurusan</th><th>Nama Tempat</th><th>Kota / Alamat</th><th>Kuota</th><th>Pendaftar</th><th>Surat</th><th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $qLem = mysqli_query($con, "SELECT l.*, p.periode, p.tahun, pj.nama_penjurusan
                                                      FROM pkl_lembaga l
                                                      JOIN pkl_plot_periode p ON l.id_periode = p.id_periode
                                                      JOIN pkl_penjurusan pj ON l.id_penjurusan = pj.id_penjurusan
                                                      ORDER BY p.id_periode DESC, pj.nama_penjurusan ASC");
                          while($dLem = mysqli_fetch_array($qLem)){
                             $cReg = mysqli_query($con, "SELECT count(id_plot) as c FROM pkl_plot_pendaftar WHERE id_lembaga='".$dLem['id_lembaga']."'");
                             $jmlReg = mysqli_fetch_assoc($cReg)['c'];
                        ?>
                        <tr class="text-center">
                          <td><?= $dLem['periode']." ".$dLem['tahun']; ?></td>
                          <td><?= $dLem['nama_penjurusan']; ?></td>
                          <td class="text-left"><?= $dLem['nama_tempat']; ?></td>
                          <td class="text-left"><?= $dLem['kota']; ?> <br/> <small class="text-muted"><?= $dLem['alamat_lengkap']; ?></small></td>
                          <td><?= $dLem['kuota']; ?></td>
                          <td><?= $jmlReg; ?></td>
                          <td>
                            <?php if($dLem['file_surat']) { echo "<a target='_blank' href='file_surat_lembaga_pkl/{$dLem['file_surat']}'>Lihat Surat</a>"; } else { echo "-"; } ?>
                          </td>
                          <td>
                            <button class="btn btn-xs btn-info" onclick="openPendaftar(<?= $dLem['id_lembaga'] ?>)">Lihat Plot</button>
                            <a href="updatePlotPklAdm.php?act=delete_lembaga&id=<?= $dLem['id_lembaga'] ?>" onclick="return confirm('Hapus?');" class="btn btn-xs btn-danger">Hapus</a>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Area Render Pendaftar (Ajax or Just link to another page, but we can do a simple GET) -->
            <?php if(isset($_GET['lembaga_id'])) { 
               $lid = intval($_GET['lembaga_id']);
               $qLDetail = mysqli_query($con, "SELECT l.*, pj.nama_penjurusan FROM pkl_lembaga l JOIN pkl_penjurusan pj ON l.id_penjurusan=pj.id_penjurusan WHERE l.id_lembaga='$lid'");
               if($dLDetail = mysqli_fetch_assoc($qLDetail)) {
            ?>
            <div class="row mt-3" id="plotArea">
              <div class="col-12">
                <div class="card card-outline card-success">
                  <div class="card-header">
                     <h5 class="card-title">Plot Mahasiswa: <?= $dLDetail['nama_tempat'] ?> (<?= $dLDetail['nama_penjurusan'] ?>) - Kuota: <?= $dLDetail['kuota'] ?></h5>
                  </div>
                  <div class="card-body">
                    <form action="updatePlotPklAdm.php?act=add_plot_manual" method="post" class="form-inline mb-3">
                       <input type="hidden" name="id_lembaga" value="<?= $lid ?>">
                       <input type="text" name="nim" class="form-control form-control-sm mr-2" placeholder="Masukkan NIM (Offline)">
                       <button type="submit" class="btn btn-sm btn-success">Tambah Manual (Negosiasi)</button>
                    </form>
                    
                    <form action="updatePlotPklAdm.php?act=update_kuota" method="post" class="form-inline mb-3">
                       <input type="hidden" name="id_lembaga" value="<?= $lid ?>">
                       <input type="number" name="kuota" class="form-control form-control-sm mr-2" value="<?= $dLDetail['kuota'] ?>">
                       <button type="submit" class="btn btn-sm btn-warning">Update Kuota (Negosiasi)</button>
                    </form>

                    <div class="table-responsive text-sm">
                      <table class="table table-sm table-bordered">
                        <thead class="bg-light"><tr><th>NIM</th><th>Nama (Optional API)</th><th>Waktu Daftar</th><th>Aksi</th></tr></thead>
                        <tbody>
                          <?php
                            $qP = mysqli_query($con, "SELECT m.* FROM pkl_plot_pendaftar m WHERE id_lembaga='$lid'");
                            while($dP = mysqli_fetch_assoc($qP)){
                          ?>
                          <tr>
                            <td><?= $dP['nim'] ?></td>
                            <td>-</td>
                            <td><?= $dP['waktu_daftar'] ?></td>
                            <td><a href="updatePlotPklAdm.php?act=del_plot&id=<?= $dP['id_plot']?>&lid=<?= $lid ?>" class="btn btn-xs btn-danger" onclick="return confirm('Hapus?');">Cabut Plot</a></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script> 
                document.getElementById('plotArea').scrollIntoView(); 
            </script>
            <?php }} ?>

          </div>
        </section>
      </div>

      <!-- Modal Periode -->
      <form action="inputPlotPklAdm.php" method="post">
        <input type="hidden" name="tipe" value="periode">
        <div class="modal fade" id="modalPeriode">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header"><h5>Tambah Periode</h5></div>
              <div class="modal-body">
                <div class="form-group"><label>Periode</label>
                  <select name="periode" class="form-control" required><option value="Ganjil">Ganjil</option><option value="Genap">Genap</option></select>
                </div>
                <div class="form-group"><label>Tahun (Cth: 2024/2025)</label><input type="text" name="tahun" class="form-control" required></div>
              </div>
              <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
            </div>
          </div>
        </div>
      </form>

      <!-- Modal Penjurusan -->
      <form action="inputPlotPklAdm.php" method="post">
        <input type="hidden" name="tipe" value="penjurusan">
        <div class="modal fade" id="modalPenjurusan">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header"><h5>Tambah Penjurusan</h5></div>
              <div class="modal-body">
                <div class="form-group"><label>Nama Penjurusan</label><input type="text" name="nama_penjurusan" class="form-control" required></div>
              </div>
              <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
            </div>
          </div>
        </div>
      </form>
      
      <!-- Modal Lembaga -->
      <form action="inputPlotPklAdm.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="tipe" value="lembaga">
        <div class="modal fade" id="modalLembaga">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header"><h5>Tambah Lembaga</h5></div>
              <div class="modal-body">
                <div class="form-group"><label>Periode Aktif</label>
                  <select name="id_periode" class="form-control" required>
                    <?php $qp=mysqli_query($con,"SELECT * FROM pkl_plot_periode ORDER BY id_periode DESC"); while($dp=mysqli_fetch_assoc($qp)){ ?>
                      <option value="<?= $dp['id_periode'] ?>"><?= $dp['periode']." ".$dp['tahun'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group"><label>Penjurusan</label>
                  <select name="id_penjurusan" class="form-control" required>
                    <?php $qpn=mysqli_query($con,"SELECT * FROM pkl_penjurusan"); while($dpn=mysqli_fetch_assoc($qpn)){ ?>
                      <option value="<?= $dpn['id_penjurusan'] ?>"><?= $dpn['nama_penjurusan'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group"><label>Nama Lembaga/Tempat</label><input type="text" name="nama_tempat" class="form-control" required></div>
                <div class="form-group"><label>Kota</label><input type="text" name="kota" class="form-control" required></div>
                <div class="form-group"><label>Alamat Lengkap</label><textarea name="alamat_lengkap" class="form-control" required></textarea></div>
                <div class="form-group"><label>Kuota Slot</label><input type="number" name="kuota" class="form-control" required></div>
                <div class="form-group"><label>Surat Dari Lembaga (PDF)</label><input type="file" name="surat" class="form-control-file" accept=".pdf" required></div>
              </div>
              <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
            </div>
          </div>
        </div>
      </form>

      <?php include( "footerAdm.php" ); ?>
      <?php include( "jsAdm.php" ); ?>
      
      <script>
         function openPendaftar(id) {
             window.location.href = "plotLembagaPklAdm.php?lembaga_id=" + id;
         }
      </script>
    </div>
  </body>
</html>
