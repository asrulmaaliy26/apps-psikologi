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
              <h1 class="m-0">Rekap Pengajuan Penghapusan BMN</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_GET['message']) && $_GET['message'] == 'notifInput') { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Pengajuan berhasil disimpan.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
          <?php if (isset($_GET['message']) && $_GET['message'] == 'notifUpdate') { ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              Status pengajuan berhasil diperbarui.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>

          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Daftar Pengajuan</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>No. Pengajuan</th>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th>Jumlah Barang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $q = mysqli_query($con, "SELECT h.*, (SELECT COUNT(*) FROM dt_pengajuan_penghapusan_bmn_detail WHERE id_pengajuan = h.id) as jum_barang 
                                          FROM dt_pengajuan_penghapusan_bmn h 
                                          ORDER BY h.created_at DESC");
                  while ($d = mysqli_fetch_array($q)) {
                    $badge = "badge-secondary";
                    if ($d['status'] == 'Diajukan') $badge = "badge-info";
                    if ($d['status'] == 'Disetujui') $badge = "badge-primary";
                    if ($d['status'] == 'Ditolak') $badge = "badge-danger";
                    if ($d['status'] == 'Selesai') $badge = "badge-success";
                  ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $d['no_pengajuan']; ?></td>
                      <td><?php echo $d['tgl_pengajuan']; ?></td>
                      <td><?php echo ucfirst($d['metode']); ?></td>
                      <td><?php echo $d['jum_barang']; ?> unit</td>
                      <td><span class="badge <?php echo $badge; ?>"><?php echo $d['status']; ?></span></td>
                      <td>
                        <a href="detailPenghapusanBmnAdm.php?id=<?php echo $d['id']; ?>" class="btn btn-xs btn-info"><i class="fas fa-eye"></i> Detail / Ubah Status</a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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
