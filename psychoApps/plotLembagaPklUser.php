<?php 
include("contentsConAdm.php");
if(!isset($_SESSION)) { session_start(); }
$nim = $_SESSION['username'];

// Get active period
$qPer = mysqli_query($con, "SELECT * FROM pkl_plot_periode WHERE status='Buka' ORDER BY id_periode DESC LIMIT 1");
$activePeriod = mysqli_fetch_assoc($qPer);

$hasPlotted = false;
if($activePeriod) {
    // Check if user has already plotted in this period
    $qPlot = mysqli_query($con, "SELECT p.*, l.nama_tempat, l.tgl_mulai, l.tgl_selesai, pj.nama_penjurusan 
                                 FROM pkl_plot_pendaftar p 
                                 JOIN pkl_lembaga l ON p.id_lembaga = l.id_lembaga 
                                 JOIN pkl_penjurusan pj ON l.id_penjurusan = pj.id_penjurusan
                                 WHERE p.nim='$nim' AND l.id_periode='{$activePeriod['id_periode']}'");
    if($dPlot = mysqli_fetch_assoc($qPlot)) {
        $hasPlotted = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <?php include("headAdm.php"); ?>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include("navtopAdm.php");
        include("navSideBarUserS1.php");
      ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (isset($_SESSION['msg'])) {
                  $type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'info';
                  echo "<div class='alert alert-{$type} alert-dismissible fade show'><span>{$_SESSION['msg']}</span><button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
                  unset($_SESSION['msg']);
                  unset($_SESSION['msg_type']);
              }
            ?>
            <div class="row mb-2">
              <div class="col-sm-6"><h1 class="m-0 float-left">Pilih Lembaga PKL</h1></div>
            </div>
          </div>
        </div>
        
        <section class="content">
          <div class="container-fluid">
            <?php if(!$activePeriod) { ?>
               <div class="alert alert-warning">Saat ini tidak ada periode pemilihan (plotting) Lembaga PKL yang dibuka.</div>
               <!-- Cek apakah mahasiswa menang slot di periode tutup sebelumnya untuk dicetak -->
               <?php 
                  $qPlotClosed = mysqli_query($con, "SELECT p.*, l.id_periode FROM pkl_plot_pendaftar p JOIN pkl_lembaga l ON p.id_lembaga=l.id_lembaga WHERE p.nim='$nim' ORDER BY p.id_plot DESC LIMIT 1");
                  if($dPlotClosed = mysqli_fetch_assoc($qPlotClosed)) {
                      $qPerClosed = mysqli_query($con, "SELECT status FROM pkl_plot_periode WHERE id_periode='{$dPlotClosed['id_periode']}'");
                      $dPerClosed = mysqli_fetch_assoc($qPerClosed);
                      if($dPerClosed['status'] == 'Tutup') {
                          echo "<div class='card'><div class='card-body'>Anda memiliki plot lembaga yang sudah ditutup. <a href='cetakSuratLembagaPklUser.php?id_lembaga={$dPlotClosed['id_lembaga']}' target='_blank' class='btn btn-success'>Cetak Surat Telah Mendapatkan Lembaga</a></div></div>";
                      }
                  }
               ?>
            <?php } else { ?>
               <?php if($hasPlotted) { ?>
                  <!-- User has plotted -->
                  <div class="card card-success">
                     <div class="card-header"><h3 class="card-title">Slot Anda pada Periode <?= $activePeriod['periode']." ".$activePeriod['tahun'] ?></h3></div>
                     <div class="card-body">
                         <h5>Lembaga Terpilih: <?= $dPlot['nama_tempat'] ?> (<?= $dPlot['nama_penjurusan'] ?>)</h5>
                         <p>Selamat! Anda telah berhasil mendapatkan slot di lembaga ini. Anda tergabung dalam tim untuk lembaga ini.</p>
                         
                         <hr>
                         <h6>Tentukan Durasi PKL Tim</h6>
                         <p class="text-muted"><small>Tanggal ini berlaku untuk seluruh anggota tim di lembaga ini. Siapapun dari anggota tim dapat mengubah dan menyesuaikannya.</small></p>
                         <form action="updatePlotLembagaPklUser.php" method="POST" class="form-inline">
                             <input type="hidden" name="id_lembaga" value="<?= $dPlot['id_lembaga'] ?>">
                             <div class="form-group mr-3">
                                 <label class="mr-2">Tgl Mulai: </label>
                                 <input type="date" name="tgl_mulai" class="form-control" value="<?= $dPlot['tgl_mulai'] ?>" required>
                             </div>
                             <div class="form-group mr-3">
                                 <label class="mr-2">Tgl Selesai: </label>
                                 <input type="date" name="tgl_selesai" class="form-control" value="<?= $dPlot['tgl_selesai'] ?>" required>
                             </div>
                             <button type="submit" class="btn btn-primary mt-2 mt-sm-0">Simpan Durasi PKL</button>
                         </form>
                     </div>
                  </div>
               <?php } else { ?>
                  <!-- List of Lembaga -->
                  <div class="card card-primary">
                      <div class="card-header"><h3 class="card-title">Daftar Lembaga Tersedia - <?= $activePeriod['periode']." ".$activePeriod['tahun'] ?></h3></div>
                      <div class="card-body table-responsive">
                          <table class="table table-bordered table-striped">
                              <thead><tr><th>Penjurusan</th><th>Nama Tempat</th><th>Kota / Alamat</th><th>Kuota</th><th>Sisa Kuota</th><th>Surat</th><th>Aksi</th></tr></thead>
                              <tbody>
                                  <?php
                                     $qLem = mysqli_query($con, "SELECT l.*, pj.nama_penjurusan FROM pkl_lembaga l JOIN pkl_penjurusan pj ON l.id_penjurusan = pj.id_penjurusan WHERE l.id_periode='{$activePeriod['id_periode']}' ORDER BY pj.nama_penjurusan ASC");
                                     while($lem = mysqli_fetch_array($qLem)) {
                                         // Hitung Sisa Kuota dan kumpulkan pendaftar
                                         $qC = mysqli_query($con, "SELECT p.nim, p.waktu_daftar, m.nama FROM pkl_plot_pendaftar p LEFT JOIN dt_mhssw m ON p.nim = m.nim WHERE p.id_lembaga='{$lem['id_lembaga']}'");
                                         $terisi = mysqli_num_rows($qC);
                                         $sisa = $lem['kuota'] - $terisi;
                                  ?>
                                  <tr>
                                      <td><?= $lem['nama_penjurusan'] ?></td>
                                      <td><?= $lem['nama_tempat'] ?></td>
                                      <td><?= $lem['kota'] ?><br/><small><?= $lem['alamat_lengkap'] ?></small></td>
                                      <td><?= $lem['kuota'] ?></td>
                                      <td><?= $sisa ?></td>
                                      <td><?php if($lem['file_surat']) { echo "<a href='file_surat_lembaga_pkl/{$lem['file_surat']}' target='_blank'>Lihat Surat MoU</a>"; } else { echo "-"; } ?></td>
                                      <td>
                                          <?php if($sisa > 0) { ?>
                                              <form action="inputPlotLembagaPklUser.php" method="POST">
                                                  <input type="hidden" name="id_lembaga" value="<?= $lem['id_lembaga'] ?>">
                                                  <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Pilih lembaga ini? Anda tidak bisa ganti jika sudah plot!');">Pilih</button>
                                              </form>
                                          <?php } else { ?>
                                              <button class="btn btn-sm btn-secondary" onclick="alert('Penuh - Hubungi Admin BAAK S1 secara offline untuk negosiasi kuota.')">Penuh</button>
                                          <?php } ?>
                                          
                                          <button type="button" class="btn btn-sm btn-info mt-1" data-toggle="modal" data-target="#modalTim<?= $lem['id_lembaga'] ?>">Lihat Teman</button>
                                          
                                          <!-- Modal List Teman -->
                                          <div class="modal fade text-left" id="modalTim<?= $lem['id_lembaga'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Pendaftar: <?= $lem['nama_tempat'] ?></h5>
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                  <ul>
                                                    <?php 
                                                      if($terisi > 0) {
                                                          while($dt = mysqli_fetch_array($qC)){
                                                              $nama = $dt['nama'] ? $dt['nama'] : "Nama tidak tersedia";
                                                              echo "<li>{$dt['nim']} - {$nama}</li>";
                                                          }
                                                      } else {
                                                          echo "<li>Belum ada teman yang mendaftar di lembaga ini.</li>";
                                                      }
                                                    ?>
                                                  </ul>
                                                </div>
                                                <div class="modal-footer"><button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button></div>
                                              </div>
                                            </div>
                                          </div>

                                      </td>
                                  </tr>
                                  <?php } ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
               <?php } ?>
            <?php } ?>
          </div>
        </section>
      </div>
      <?php include("footerAdm.php"); ?>
      <?php include("jsAdm.php"); ?>
    </div>
  </body>
</html>
