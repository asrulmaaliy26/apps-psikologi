<?php include("contentsConAdm.php");
$username = $_SESSION['username'];
$id = mysqli_real_escape_string($con, $_GET['id']);
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
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
      <?php include("alertUser.php"); ?>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-4">
              <h1 class="m-0 float-left">Pendaftaran</h1>
            </div>
            <div class="col-sm-8">
              <ol class="mt-2 breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Praktik Kerja Lapangan (PKL)</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm">
              <div class="card card-success card-outline card-outline-tabs">
                <div class="card-header">
                  <h3 class="card-title">Detail Pendaftaran & Laporan</h3>
                </div>
                <div class="card-body">
                  <div class="card mb-3">
                    <div class="card-header bg-light">
                      <h3 class="card-title">Informasi Pendaftaran</h3>
                    </div>
                    <div class="card-body p-0">
                      <div class="table-responsive">
                        <table class="table m-0 text-center table-sm custom">
                          <thead>
                            <tr>
                              <th width="14%" class="pl-1">Tgl. pendaftaran</th>
                              <th width="12%">Jenis PKL</th>
                              <th width="12%">Peminatan</th>
                              <th width="20%">Nama Instansi</th>
                              <th width="20%">DPL</th>
                              <th width="16%">SKS Diambil</th>
                              <th width="6%" class="pr-1">Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $qry = "SELECT * FROM peserta_pkl WHERE nim='$dataku[nim]' AND id='$id'";
                            $has = mysqli_query($con,  $qry) or die(mysqli_error($con));
                            $md = mysqli_fetch_assoc($has);
                            if ($md) {
                            ?>
                              <tr>
                                <td class="text-center pl-1"><?php echo $md['tgl_pengajuan']; ?></td>
                                <td class="text-center"><?php echo $md['jenis_pkl']; ?></td>
                                <td class="text-center"><?php echo $md['peminatan']; ?></td>
                                <td class="text-center"><?php echo $md['nama_instansi']; ?></td>
                                <td class="text-center"><?php echo $nama_dpl; ?></td>
                                <td class="text-center"><?php echo $md['sks_diambil']; ?></td>
                                <td class="text-center pr-1">
                                  <a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm('Yakin data ini diedit?')" title="Yakin data ini diedit?" href="editPendaftaranPklUserSatu.php?id=<?php echo $md['id']; ?>"><i class="far fa-edit"></i></a>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-sm-12">
                      <div class="card mb-3">
                        <div class="card-header bg-light">
                          <h3 class="card-title">Lampiran Berkas Pembekalan</h3>
                        </div>
                        <div class="card-body p-0">
                          <div class="table-responsive">
                            <table class="table m-0 text-center table-sm custom">
                              <thead>
                                <tr>
                                  <th width="80%" class="pl-1">Tugas Pembekalan PKL</th>
                                  <th width="20%" class="pr-1">Opsi</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="text-center pl-1"><?php if (empty($md['file_pembekalan'])) {
                                                                  echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada file" disabled><i class="fas fa-folder-minus"></i> Tidak ada file</a>';
                                                                } else {
                                                                  echo '<a class="btn btn-outline-primary btn-xs btn-block" title="Lihat/download" href="' . $md['file_pembekalan'] . '" target="_blank"><i class="fas fa-file-download"></i> Lihat/download</a>';
                                                                } ?></td>
                                  <td class="text-center pr-1">
                                    <a class="btn btn-outline-warning btn-xs btn-block" onclick="return confirm('Yakin data ini diedit?')" title="Yakin data ini diedit?" href="editPendaftaranPklUserDua.php?id=<?php echo $md['id']; ?>"><i class="far fa-edit"></i></a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Formulir Upload Pasca Pendaftaran -->
                  <div class="card mb-0">
                    <div class="card-header bg-light">
                      <h3 class="card-title">Unggah Laporan dan Output PKL</h3>
                    </div>
                    <div class="card-body">
                      <form action="sformUploadLaporanPklUser.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                          <div class="form-group col-sm-4">
                            <label for="file_laporan_akademik">Laporan Akademik (PDF)</label>
                            <input type="file" accept="application/pdf" class="form-control form-control-sm" name="file_laporan_akademik">
                            <?php if (!empty($md['file_laporan_akademik'])) {
                              echo '<small><a href="' . $md['file_laporan_akademik'] . '" target="_blank">Lihat file saat ini</a></small>';
                            } ?>
                          </div>
                          <div class="form-group col-sm-4">
                            <label for="file_laporan_output">Laporan Output (PDF)</label>
                            <input type="file" accept="application/pdf" class="form-control form-control-sm" name="file_laporan_output">
                            <?php if (!empty($md['file_laporan_output'])) {
                              echo '<small><a href="' . $md['file_laporan_output'] . '" target="_blank">Lihat file saat ini</a></small>';
                            } ?>
                          </div>
                          <div class="form-group col-sm-4">
                            <label for="link_output">Link Output</label>
                            <input type="text" class="form-control form-control-sm" name="link_output" value="<?php echo htmlspecialchars($md['link_output'] ?? ''); ?>">
                          </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="nim" value="<?php echo $md['nim']; ?>">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan Laporan & Output</button>
                      </form>
                    </div>
                  </div>
                  <!-- Akhir Formulir -->

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php include("footerAdm.php"); ?>
  <?php include("jsAdm.php"); ?>
</body>

</html>