<?php include("contentsConAdm.php");
error_reporting(E_ALL & ~E_NOTICE);
$username = $_SESSION['username'];

// Validasi Kaprodi S1
$q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
$dMe = mysqli_fetch_assoc($q_me);
if ($dMe['jabatan_instansi'] != '47') {
    header("location:dashboardAdm.php");
    exit();
}

$angkatan = mysqli_real_escape_string($con, $_GET['angkatan']);
$page = mysqli_real_escape_string($con, $_GET['page']);

// Ambil semua dosen untuk opsi ganti
$qDosen = mysqli_query($con, "SELECT id, nama FROM dt_pegawai ORDER BY nama ASC");
$listDosen = [];
while ($rowD = mysqli_fetch_assoc($qDosen)) {
    $listDosen[] = $rowD;
}
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
            <?php include("alertUser.php"); ?>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="m-0">Seluruh Pembimbing Mahasiswa</h6>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item small"><a class="text-info" href="rekapPembimbinganKaprodi.php?page=<?php echo $page; ?>">Seluruh Pembimbing Mahasiswa</a></li>
                                <li class="breadcrumb-item active small">Total Pembimbingan Angkatan <?php echo $angkatan; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <section class="col-md-12 connectedSortable">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <div class="clearfix">
                                        <h4 class="card-title float-left">Daftar Pembimbing Mahasiswa Angkatan <?php echo $angkatan; ?></h4>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                                            <thead>
                                                <tr class="text-center bg-secondary">
                                                    <td width="4%" class="pl-1">No.</td>
                                                    <td width="16%">Nama / NIM</td>
                                                    <td width="20%">Judul Skripsi</td>
                                                    <td width="20%">Dospem I</td>
                                                    <td width="20%">Dospem II</td>
                                                    <td width="10%">Status</td>
                                                    <td width="10%" class="pr-1">Opsi</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 0;
                                                $sql = "SELECT * FROM pengelompokan_dospem_skripsi WHERE angkatan='$angkatan' ORDER BY nim ASC, id DESC";
                                                $result = mysqli_query($con, $sql);
                                                $seen_nims = [];
                                                while ($data = mysqli_fetch_array($result)) {
                                                    include("phpverdos.php");
                                                    $nim = $data['nim'];
                                                    if (!in_array($nim, $seen_nims)) {
                                                        $is_latest = true;
                                                        $seen_nims[] = $nim;
                                                    } else {
                                                        $is_latest = false;
                                                    }
                                                    $row_class = $is_latest ? '' : 'bg-light text-muted';
                                                ?>
                                                    <tr class="<?php echo $row_class; ?>">
                                                        <td class="text-center pl-1"> <?php echo $no; ?> </td>
                                                        <td class="text-left"> <?php echo $dmhssw['nama'] . '<br><small class="text-muted">' . $dmhssw['nim'] . '</small>'; ?> </td>
                                                        <td class="text-left"> <?php echo preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_skripsi']); ?> </td>
                                                        <td class="text-left">
                                                            <?php echo $ddospem1['nama'] ?? '-'; ?>
                                                            <br>
                                                            <button type="button" class="btn btn-outline-warning btn-xs mt-1" title="Ganti Dospem I" data-toggle="modal" data-target="#modalGantiDospem" data-target-id="1" data-id-pengajuan="<?php echo $data['id']; ?>" data-current-name="<?php echo htmlspecialchars($ddospem1['nama'] ?? ''); ?>">
                                                                <i class="fas fa-user-edit"></i> Ganti Dospem I
                                                            </button>
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $ddospem2['nama'] ?? '-'; ?>
                                                            <br>
                                                            <button type="button" class="btn btn-outline-warning btn-xs mt-1" title="Ganti Dospem II" data-toggle="modal" data-target="#modalGantiDospem" data-target-id="2" data-id-pengajuan="<?php echo $data['id']; ?>" data-current-name="<?php echo htmlspecialchars($ddospem2['nama'] ?? ''); ?>">
                                                                <i class="fas fa-user-edit"></i> Ganti Dospem II
                                                            </button>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($data['status'] == 1) {
                                                                echo '<span class="badge badge-warning">Pengajuan</span>';
                                                            } else if ($data['status'] == 2) {
                                                                echo '<span class="badge badge-primary">Proses</span>';
                                                            } else if ($data['status'] == 3) {
                                                                echo '<span class="badge badge-success">Selesai</span>';
                                                            } else {
                                                                echo '<span class="badge badge-secondary">Lainnya</span>';
                                                            }
                                                            
                                                            if (!$is_latest) {
                                                                echo '<br><span class="badge badge-danger mt-1">Tidak Dipakai (Riwayat)</span>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center pr-1">
                                                            <button type="button" class="btn btn-outline-info btn-xs btn-block" data-widget="collapse-row" data-target="#row-<?php echo $data['id']; ?>">
                                                                <i class="fas fa-eye"></i> Detail
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr id="row-<?php echo $data['id']; ?>" class="collapse" style="background-color: #f4f6f9;">
                                                        <td colspan="7">
                                                            <section class="content pt-2 pb-2">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <div class="card card-primary card-outline mb-0">
                                                                                <div class="card-body box-profile p-2">
                                                                                    <div class="text-center">
                                                                                        <img class="profile-user-img img-fluid img-circle" style="width:80px;height:80px;" src="<?php echo $dmhssw['photo']; ?>" onError="this.onerror=null;this.src='<?php if ($dmhssw['jenis_kelamin'] == 1) { echo "images/cewek.png"; } else { echo "images/cowok.png"; } ?>';" alt="">
                                                                                    </div>
                                                                                    <h3 class="profile-username text-center text-sm mb-0"><?php echo $dmhssw['nama']; ?></h3>
                                                                                    <p class="text-muted text-center text-xs mb-2"><?php echo $dmhssw['nim']; ?></p>
                                                                                    <ul class="list-group list-group-unbordered text-left text-xs mb-0">
                                                                                        <li class="list-group-item p-1">
                                                                                            <b>Kontak</b> <a class="float-right"><?php echo $dmhssw['kntk']; ?></a>
                                                                                        </li>
                                                                                        <li class="list-group-item p-1">
                                                                                            <b>Email</b> <a class="float-right"><?php echo $dmhssw['imel']; ?></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                            <?php include("profilPembimbingan.php"); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Modal Ganti Dospem -->
        <div class="modal fade" id="modalGantiDospem" tabindex="-1" role="dialog" aria-labelledby="modalGantiDospemLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="updateGantiDospemSkripsiKaprodi.php" method="post">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="modalGantiDospemLabel"><i class="fas fa-user-edit mr-2"></i>Ganti Dosen Pembimbing</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="angkatan" value="<?php echo $angkatan; ?>">
                            <input type="hidden" name="page" value="<?php echo $page; ?>">
                            <input type="hidden" name="id_pengajuan" id="modal-id-pengajuan" value="">
                            <input type="hidden" name="target" id="modal-target-id" value="">
                            
                            <div class="form-group">
                                <label>Pembimbing Saat Ini:</label>
                                <input type="text" class="form-control" id="modal-current-name" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label for="new_dospem_id">Pilih Pembimbing Baru:</label>
                                <select name="new_dospem_id" class="form-control" required>
                                    <option value="">- Pilih Dosen -</option>
                                    <?php foreach ($listDosen as $ld): ?>
                                        <option value="<?php echo $ld['id']; ?>"><?php echo $ld['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">* Dosen akan terganti pada data pengajuan pembimbingan skripsi ini.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
    
    <script>
        $(document).ready(function() {
            // Script for opening modal
            $('#modalGantiDospem').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var targetId = button.data('target-id');
                var currentName = button.data('current-name');
                var idPengajuan = button.data('id-pengajuan');
                
                var modal = $(this);
                modal.find('#modal-target-id').val(targetId);
                modal.find('#modal-id-pengajuan').val(idPengajuan);
                modal.find('#modal-current-name').val(currentName ? currentName : 'Belum ditentukan');
                modal.find('.modal-title').text('Ganti Dosen Pembimbing ' + (targetId == '1' ? 'I' : 'II'));
            });

            // Script for collapsible rows (since AdminLTE expandable table might need data-widget on tr, we simulate it via button)
            $('[data-widget="collapse-row"]').on('click', function() {
                var target = $(this).data('target');
                $(target).collapse('toggle');
            });
        });
    </script>
</body>
</html>
