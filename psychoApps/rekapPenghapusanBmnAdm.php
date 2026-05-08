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
          <?php if (isset($_GET['message']) && $_GET['message'] == 'notifDelete') { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Pengajuan berhasil dihapus.
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
              <table class="table table-bordered table-hover table-sm">
                <thead>
                  <tr>
                    <th width="5%">No.</th>
                    <th width="20%">No. Pengajuan</th>
                    <th width="15%">Tanggal</th>
                    <th width="15%">Metode</th>
                    <th width="15%">Jumlah Barang</th>
                    <th width="15%">Status</th>
                    <th width="15%">Aksi</th>
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
                    <tr data-widget="expandable-table" aria-expanded="false">
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $d['no_pengajuan']; ?></td>
                      <td><?php echo $d['tgl_pengajuan']; ?></td>
                      <td><?php echo ucfirst($d['metode']); ?></td>
                      <td><?php echo $d['jum_barang']; ?> unit</td>
                      <td><span class="badge <?php echo $badge; ?>"><?php echo $d['status']; ?></span></td>
                      <td>
                        <a href="detailPenghapusanBmnAdm.php?id=<?php echo $d['id']; ?>" class="btn btn-xs btn-info"><i class="fas fa-eye"></i> Detail</a>
                        <a href="deletePenghapusanBmnAdm.php?id=<?php echo $d['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Yakin ingin menghapus pengajuan ini?')"><i class="fas fa-trash"></i> Hapus</a>
                      </td>
                    </tr>
                    <tr class="expandable-body">
                      <td colspan="7">
                        <div class="p-0">
                          <table class="table table-sm mb-0 bg-light">
                            <thead>
                              <tr class="bg-gray-light">
                                <th width="5%" class="text-center">No.</th>
                                <th width="20%">Kode Inventaris</th>
                                <th width="35%">Nama Barang</th>
                                <th width="20%">Merk</th>
                                <th width="15%">Kondisi</th>
                                <th width="5%" class="text-center">Foto</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $no_detail = 1;
                              $id_pengajuan = $d['id'];
                              $qd = mysqli_query($con, "SELECT b.*, omb.nm as nama_merk, okob.nm as nama_kondisi 
                                                      FROM dt_pengajuan_penghapusan_bmn_detail dd
                                                      JOIN dt_inventaris_barang b ON dd.id_barang = b.id
                                                      LEFT JOIN opsi_merk_barang omb ON b.merk = omb.id
                                                      LEFT JOIN opsi_kondisi_barang okob ON b.kondisi = okob.id
                                                      WHERE dd.id_pengajuan = '$id_pengajuan'");
                              if(mysqli_num_rows($qd) == 0){
                                echo "<tr><td colspan='5' class='text-center text-muted small'>Tidak ada data barang</td></tr>";
                              }
                              while ($dd = mysqli_fetch_array($qd)) {
                              ?>
                                <tr>
                                  <td class="text-center"><?php echo $no_detail++; ?>.</td>
                                  <td><?php echo $dd['id_inventaris']; ?></td>
                                  <td><?php echo $dd['nm']; ?></td>
                                  <td><?php echo $dd['nama_merk']; ?></td>
                                  <td><?php echo $dd['nama_kondisi']; ?></td>
                                  <td class="text-center">
                                    <a href="javascript:void(0)" onclick="viewImage('<?php echo $dd['image']; ?>', '<?php echo $dd['nm']; ?>')" class="text-info" title="Lihat Foto">
                                      <i class="fas fa-image"></i>
                                    </a>
                                  </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
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
