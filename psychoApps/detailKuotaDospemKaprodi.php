<?php include("contentsConAdm.php");
$username = $_SESSION['username'];

// Validasi Kaprodi
$q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
$dMe = mysqli_fetch_assoc($q_me);
if ($dMe['jabatan_instansi'] != '47') {
  header("location:dashboardAdm.php");
  exit();
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$page = mysqli_real_escape_string($con, $_GET['page']);

$qidper = "SELECT * FROM pengajuan_dospem WHERE id='$id'";
$ridper = mysqli_query($con, $qidper) or die(mysqli_error($con));
$didper = mysqli_fetch_assoc($ridper);

$qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
$dthp = mysqli_fetch_assoc(mysqli_query($con, $qry_thp));

$qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
$dnta = mysqli_fetch_assoc(mysqli_query($con, $qry_nm_ta));

$qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
$dsemester = mysqli_fetch_assoc(mysqli_query($con, $qry_nm_smt));
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarDosen.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><span>Submit berhasil!</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          }
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><span>Edit berhasil!</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          }
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><span>Delete berhasil!</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          }
          ?>
          <div class="row">
            <div class="col-sm-6">
              <h6 class="m-0">Detail Kuota Dospem - <?php echo 'Tahap ' . $dthp['tahap'] . ' ' . $dsemester['nama'] . ' ' . $dnta['ta']; ?></h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="rekapKuotaDospemKaprodi.php?page=<?php echo $page; ?>">Daftar Periode</a></li>
                <li class="breadcrumb-item active small">Detail Kuota</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h4 class="card-title">Daftar Dosen Pembimbing & Kuota</h4>
              <div class="card-tools">
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#inputModal"><i class="fas fa-plus"></i> Tambah Dosen</button>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover m-0 table-bordered text-center table-sm small">
                  <thead>
                    <tr class="bg-secondary">
                      <th width="5%">No.</th>
                      <th>Nama Dosen</th>
                      <th width="15%">Kuota I</th>
                      <th width="15%">Kuota II</th>
                      <th width="15%">Total Bimbingan</th>
                      <th width="10%">Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    // Query untuk mengambil SELURUH dosen yang terdaftar di sistem
                    $sql = "SELECT p.id as nip, p.nama, ds.id as id_kuota, 
                                   COALESCE(ds.kuota1, 0) as kuota1, 
                                   COALESCE(ds.kuota2, 0) as kuota2
                            FROM dt_pegawai p
                            LEFT JOIN dospem_skripsi ds ON p.id = ds.nip AND ds.id_periode = '$id'
                            WHERE p.jenis_pegawai = '1' AND p.nama NOT LIKE '%Admin%'
                            ORDER BY p.nama ASC";
                    $res = mysqli_query($con, $sql);
                    while ($data = mysqli_fetch_array($res)) {
                      $nip_dosen = $data['nip'];
                      // Hitung total bimbingan (proses + selesai)
                      $q_count = "SELECT COUNT(*) as total FROM pengelompokan_dospem_skripsi 
                                   WHERE (dospem_skripsi1 = '$nip_dosen' OR dospem_skripsi2 = '$nip_dosen') 
                                   AND id_periode = '$id' AND status IN ('2','3')";
                      $d_count = mysqli_fetch_assoc(mysqli_query($con, $q_count));
                    ?>
                      <tr class="main-row" style="cursor:pointer;" data-nip="<?php echo $nip_dosen; ?>" data-idper="<?php echo $id; ?>" title="Klik untuk lihat daftar mahasiswa">
                        <td><?php echo $no++; ?></td>
                        <td class="text-left font-weight-bold"><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['kuota1']; ?></td>
                        <td><?php echo $data['kuota2']; ?></td>
                        <td>
                          <span class="badge badge-info px-2">
                            <?php echo $d_count['total']; ?> Mahasiswa
                          </span>
                        </td>
                        <td class="click-disabled">
                          <?php if ($data['id_kuota']) { ?>
                            <a href="editKuotaDospemKaprodi.php?id=<?php echo $data['id_kuota']; ?>&id_per=<?php echo $id; ?>&page=<?php echo $page; ?>" class="btn btn-xs btn-warning" title="Edit Kuota"><i class="fas fa-edit"></i></a>
                            <a href="deleteKuotaDospemKaprodi.php?id=<?php echo $data['id_kuota']; ?>&id_per=<?php echo $id; ?>&page=<?php echo $page; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Hapus dosen ini dari periode?')" title="Hapus"><i class="fas fa-trash"></i></a>
                          <?php } else { ?>
                            <a href="addInitialKuotaKaprodi.php?nip=<?php echo $nip_dosen; ?>&id_per=<?php echo $id; ?>&page=<?php echo $page; ?>" class="btn btn-xs btn-primary" title="Aktifkan & Set Kuota"><i class="fas fa-plus"></i> Set</a>
                          <?php } ?>
                        </td>
                      </tr>
                      <!-- Baris Detail Mahasiswa (Expandable) -->
                      <tr id="detail-<?php echo $nip_dosen; ?>" class="detail-row bg-light" style="display:none;">
                        <td colspan="6" class="p-2 text-left">
                          <div class="card card-sm m-0 border-0 shadow-none">
                            <div class="card-header py-1 bg-info text-white">
                              <h6 class="card-title small font-weight-bold">Daftar Mahasiswa: <?php echo $data['nama']; ?></h6>
                            </div>
                            <div class="card-body p-0 container-mhs">
                              <div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Memuat data...</div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Modal Input Tambah Dosen -->
    <form action="sDetailKuotaDospemKaprodi.php" method="post">
      <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h6 class="modal-title">Tambah Dosen Pembimbing</h6>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id_per" value="<?php echo $id; ?>">
              <input type="hidden" name="page" value="<?php echo $page; ?>">
              <div class="form-group">
                <label class="small font-weight-bold">Dosen</label>
                <select name="nip" class="form-control form-control-sm select2" style="width: 100%;" required>
                  <option value="">- Pilih Dosen -</option>
                  <?php
                  $q_dosen = mysqli_query($con, "SELECT id, nama FROM dt_pegawai WHERE id != '' AND nama NOT LIKE '%Admin%' ORDER BY nama ASC");
                  while ($row = mysqli_fetch_array($q_dosen)) {
                    echo "<option value='$row[id]'>$row[nama]</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="small font-weight-bold">Kuota I</label>
                    <input type="number" name="kuota1" class="form-control form-control-sm" value="0" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="small font-weight-bold">Kuota II</label>
                    <input type="number" name="kuota2" class="form-control form-control-sm" value="0" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <?php include("footerAdm.php"); ?>
  <?php include("jsAdm.php"); ?>

  <script>
    // Gunakan fungsi pendukung untuk memastikan jQuery siap
    $(document).ready(function() {
      console.log("Halaman Detail Kuota Siap. Versi SlideToggle Aktif.");

      // Inisialisasi Select2
      if ($.fn.select2) {
        $('.select2').select2({ theme: 'bootstrap4' });
      }

      // Event Click pada Baris Dosen (Delegasi agar lebih kuat)
      $(document).on('click', '.main-row', function(e) {
        // Abaikan klik jika pada kolom Opsi atau tombol di dalamnya
        if ($(e.target).closest('.click-disabled').length || $(e.target).is('a') || $(e.target).is('button') || $(e.target).is('i')) {
          console.log("Klik pada tombol opsi diabaikan.");
          return;
        }

        const nip = $(this).data('nip');
        const idper = $(this).data('idper');
        const detailRow = $('#detail-' + nip);
        const container = detailRow.find('.container-mhs');

        console.log("Membuka bimbingan untuk NIP:", nip);

        // Slide Toggle (Efek Slide)
        if (detailRow.is(':visible')) {
          detailRow.fadeOut(200);
        } else {
          // Tutup baris lain jika ada yang terbuka
          $('.detail-row').not(detailRow).fadeOut(100);
          
          detailRow.fadeIn(300);
          container.html('<div class="text-center py-3 small text-muted"><i class="fas fa-spinner fa-spin mr-1"></i> Memuat data mahasiswa...</div>');

          // Ambil data via AJAX
          $.ajax({
            url: 'getBimbinganList.php',
            type: 'GET',
            data: { nip: nip, id_per: idper },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                let html = `
                  <table class="table table-sm table-striped table-hover m-0" style="background:#fff; border: 1px solid #dee2e6;">
                    <thead class="text-center bg-light small font-weight-bold">
                      <tr>
                        <th width="5%">No</th>
                        <th width="15%">NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th width="15%">Peran</th>
                        <th width="15%">Status</th>
                      </tr>
                    </thead>
                    <tbody>`;

                if (response.data.length > 0) {
                  response.data.forEach((item, index) => {
                    html += `
                      <tr class="small text-center">
                        <td>${index + 1}</td>
                        <td>${item.nim}</td>
                        <td class="text-left">${item.nama}</td>
                        <td>${item.role}</td>
                        <td>${item.status}</td>
                      </tr>`;
                  });
                } else {
                  html += '<tr><td colspan="5" class="text-center py-3 text-muted small">Belum ada mahasiswa bimbingan di periode ini.</td></tr>';
                }
                html += '</tbody></table>';
                container.html(html);
              } else {
                container.html('<div class="text-center py-3 text-danger small">Gagal memuat data: ' + response.message + '</div>');
              }
            },
            error: function() {
              container.html('<div class="text-center py-3 text-danger small">Gagal terhubung ke server. Silakan coba lagi.</div>');
            }
          });
        }
      });
    });
  </script>
</body>

</html>