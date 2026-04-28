<?php include( "contentsConAdm.php" );
  $id_periode = mysqli_real_escape_string($con, $_GET['id']);
  $page = isset($_GET['page']) ? mysqli_real_escape_string($con, $_GET['page']) : 1;

  // Get period details
  $q_periode = "SELECT * FROM bimtek_pendaftaran WHERE id='$id_periode'";
  $r_periode = mysqli_query($con, $q_periode);
  $d_periode = mysqli_fetch_assoc($r_periode);

  if(!$d_periode){
    header("location:pndftrnBimtekAdm.php");
    exit();
  }

  // Pre-fetch kepakaran options
  $kep_options = [];
  $q_kep = mysqli_query($con, "SELECT id, nm FROM opsi_bidang_skripsi ORDER BY nm ASC");
  while($dk = mysqli_fetch_assoc($q_kep)){
      $kep_options[] = $dk;
  }

  // Pre-calculate quota per kepakaran
  $kuota_per_kepakaran = [];
  foreach($kep_options as $dk) {
      $id_kep = $dk['id'];
      $q_pend = mysqli_query($con, "SELECT COUNT(*) as tot FROM bimtek_peserta WHERE id_bimtek='$id_periode' AND peminatan='$id_kep'");
      $tot_pendaftar = mysqli_fetch_assoc($q_pend)['tot'];
      
      $q_jml_rev = mysqli_query($con, "SELECT COUNT(*) as tot FROM bimtek_reviewer WHERE id_periode='$id_periode' AND id_kepakaran='$id_kep'");
      $jml_rev = mysqli_fetch_assoc($q_jml_rev)['tot'];
      
      $kuota_dasar = ($jml_rev > 0) ? floor($tot_pendaftar / $jml_rev) : 0;
      $sisa_kuota = ($jml_rev > 0) ? ($tot_pendaftar % $jml_rev) : 0;
      
      $kuota_per_kepakaran[$id_kep] = [
          'tot_pendaftar' => $tot_pendaftar,
          'jml_rev' => $jml_rev,
          'kuota_dasar' => $kuota_dasar,
          'sisa_kuota' => $sisa_kuota
      ];
  }

  // Pre-fetch assigned reviewers
  $q_rev = mysqli_query($con, "SELECT nip, id_kepakaran, kuota_tambahan FROM bimtek_reviewer WHERE id_periode='$id_periode'");
  $rev_data = [];
  while($dr = mysqli_fetch_assoc($q_rev)){
      $rev_data[$dr['nip']] = $dr;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
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
              if (!empty($_GET['message']) && $_GET['message'] == 'notifAdd') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><span>Reviewer berhasil ditugaskan!</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              }
              if (!empty($_GET['message']) && $_GET['message'] == 'notifPlot') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><span>Plotting berhasil disimpan!</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              }
              if (!empty($_GET['message']) && $_GET['message'] == 'notifReset') {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><span>Semua plotting pada periode ini berhasil dikosongkan!</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              }
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDeletePeserta') {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><span>Data peserta berhasil dihapus!</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              }
              if (!empty($_GET['message']) && $_GET['message'] == 'notifResetAll') {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><span>Semua plotting dan kepakaran reviewer berhasil di-reset! (Kuota tambahan tetap tersimpan)</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              }
            ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Manajemen Reviewer Bimtek</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="pndftrnBimtekAdm.php?page=<?php echo $page;?>">Periode Pendaftaran</a></li>
                  <li class="breadcrumb-item active small">Reviewer</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h3 class="card-title"><strong>Periode:</strong> <?php echo $d_periode['nama_bimtek']; ?></h3>
                  </div>
                  <div class="card-body">
                    <h5 class="mb-3">Penugasan Reviewer & Kepakaran</h5>
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle"></i> Pilih kepakaran (rumpun) pada dosen yang akan ditugaskan sebagai reviewer. Biarkan pilihan kosong ("- Tidak Ditugaskan -") untuk dosen yang tidak menjadi reviewer.
                    </div>
                    
                    <form action="sAddReviewerBimtekAdm.php" method="POST">
                      <input type="hidden" name="id_periode" value="<?php echo $id_periode;?>">
                      <input type="hidden" name="page" value="<?php echo $page;?>">
                      
                      <div class="table-responsive" style="max-height: 500px;">
                        <table class="table table-bordered table-sm text-center table-head-fixed">
                          <thead class="bg-secondary">
                            <tr>
                              <th width="5%">No</th>
                              <th width="30%">Nama Dosen</th>
                              <th width="25%">Kepakaran / Rumpun (Untuk Bimtek Ini)</th>
                              <th width="10%">Kuota Tambahan</th>
                              <th width="10%">Kuota Dasar</th>
                              <th width="10%">Total Kuota</th>
                              <th width="10%">Telah Di-plot</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no = 1;
                              $sisa_distributed = [];
                              $q_dsn = mysqli_query($con, "SELECT id, nama FROM dt_pegawai WHERE jenis_pegawai='1' AND status='1' ORDER BY nama ASC");
                              while($d_dsn = mysqli_fetch_assoc($q_dsn)){
                                  $nip = $d_dsn['id'];
                                  $is_rev = isset($rev_data[$nip]);
                                  $id_kep = $is_rev ? $rev_data[$nip]['id_kepakaran'] : '';
                                  $kuota = $is_rev ? $rev_data[$nip]['kuota_tambahan'] : 0;
                                  
                                  $kuota_dasar = "-";
                                  $total_kuota = "-";
                                  $telah_plot = "-";
                                  $tr_class = "";
                                  
                                  if($is_rev && !empty($id_kep)) {
                                      $tr_class = "bg-light";
                                      $k_data = isset($kuota_per_kepakaran[$id_kep]) ? $kuota_per_kepakaran[$id_kep] : ['kuota_dasar'=>0, 'sisa_kuota'=>0];
                                      $kuota_dasar = $k_data['kuota_dasar'];
                                      
                                      if(!isset($sisa_distributed[$id_kep])) $sisa_distributed[$id_kep] = 0;
                                      
                                      if($sisa_distributed[$id_kep] < $k_data['sisa_kuota']) {
                                          $kuota_dasar++;
                                          $sisa_distributed[$id_kep]++;
                                      }
                                      
                                      $total_kuota = $kuota_dasar + $kuota;
                                      
                                      $q_plot = mysqli_query($con, "SELECT COUNT(*) as tot FROM bimtek_peserta WHERE id_bimtek='$id_periode' AND id_reviewer='$nip'");
                                      $telah_plot = mysqli_fetch_assoc($q_plot)['tot'];
                                  }

                                  $plot_html = "<span class='badge ".(($telah_plot >= $total_kuota && $is_rev) ? 'badge-danger' : 'badge-success')."'>$telah_plot</span>";
                                  if($telah_plot > 0) {
                                      $plot_html = "<a href='#' data-toggle='modal' data-target='#modalListMhs_".$nip."' class='badge ".(($telah_plot >= $total_kuota && $is_rev) ? 'badge-danger' : 'badge-success')."'>$telah_plot <i class='fas fa-search'></i></a>";
                                  }

                                  echo "<tr class='$tr_class'>
                                      <td>".$no++."</td>
                                      <td class='text-left'>
                                          <input type='hidden' name='nip[]' value='".$nip."'>
                                          ".$d_dsn['nama']."
                                      </td>
                                      <td>
                                          <select name='id_kepakaran[]' class='form-control form-control-sm select2bs4'>
                                              <option value=''>- Tidak Ditugaskan -</option>";
                                              foreach($kep_options as $dk){
                                                  $sel = ($id_kep == $dk['id']) ? "selected" : "";
                                                  echo "<option value='".$dk['id']."' $sel>".$dk['nm']."</option>";
                                              }
                                          echo "</select>
                                      </td>
                                      <td>
                                          <input type='number' name='kuota_tambahan[]' class='form-control form-control-sm text-center' value='".$kuota."' min='0'>
                                      </td>
                                      <td>$kuota_dasar</td>
                                      <td><strong>$total_kuota</strong></td>
                                      <td>$plot_html</td>
                                  </tr>";
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="mt-3">
                          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Penugasan Reviewer</button>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="card card-outline card-success mt-4">
                  <div class="card-header">
                    <h3 class="card-title">Plotting Mahasiswa ke Reviewer</h3>
                  </div>
                  <div class="card-body">
                    <form action="sPlotReviewerBimtekAdm.php" method="POST">
                        <input type="hidden" name="id_periode" value="<?php echo $id_periode;?>">
                        <input type="hidden" name="page" value="<?php echo $page;?>">
                        <div class="table-responsive" style="max-height: 500px;">
                            <table class="table table-bordered table-striped table-sm text-center table-head-fixed">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Peminatan</th>
                                        <th>Pilih Reviewer (Dosen)</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no_mhs = 1;
                                        $q_mhs = "SELECT bp.*, dp.nama, o.nm as nm_peminatan 
                                                  FROM bimtek_peserta bp
                                                  LEFT JOIN dt_mhssw dp ON bp.nim = dp.nim
                                                  JOIN opsi_bidang_skripsi o ON bp.peminatan = o.id
                                                  WHERE bp.id_bimtek = '$id_periode'
                                                  ORDER BY o.nm ASC, dp.nama ASC";
                                        $r_mhs = mysqli_query($con, $q_mhs);
                                        while($d_mhs = mysqli_fetch_assoc($r_mhs)){
                                            $id_peminatan = $d_mhs['peminatan'];
                                            echo "<tr>
                                                <td>".$no_mhs++."</td>
                                                <td>".$d_mhs['nim']."</td>
                                                <td class='text-left'>".($d_mhs['nama'] ? $d_mhs['nama'] : '<span class="text-danger">[Data Mahasiswa Tidak Ditemukan]</span>')."</td>
                                                <td>".$d_mhs['nm_peminatan']."</td>
                                                <td>
                                                    <input type='hidden' name='id_peserta[]' value='".$d_mhs['id']."'>
                                                    <select name='id_reviewer[]' class='form-control form-control-sm custom-select'>
                                                        <option value=''>- Belum di-plot -</option>";
                                                        
                                            // Get reviewers for this peminatan
                                            $q_rev_opt = "SELECT r.nip, p.nama 
                                                          FROM bimtek_reviewer r
                                                          JOIN dt_pegawai p ON r.nip = p.id
                                                          WHERE r.id_periode = '$id_periode' AND r.id_kepakaran = '$id_peminatan'
                                                          ORDER BY p.nama ASC";
                                            $r_rev_opt = mysqli_query($con, $q_rev_opt);
                                            while($d_rev_opt = mysqli_fetch_assoc($r_rev_opt)){
                                                $selected = ($d_mhs['id_reviewer'] == $d_rev_opt['nip']) ? "selected" : "";
                                                echo "<option value='".$d_rev_opt['nip']."' $selected>".$d_rev_opt['nama']."</option>";
                                            }
                                            $del_url = "sDeletePesertaBimtekAdm.php?id_peserta=".$d_mhs['id']."&id_periode=$id_periode&page=$page";
                                            echo "</select>
                                                </td>
                                                <td>
                                                    <a href='$del_url' class='btn btn-xs btn-danger' onclick=\"return confirm('Yakin hapus data peserta ini?')\">
                                                        <i class='fas fa-trash'></i>
                                                    </a>
                                                </td>
                                            </tr>";
                                        }
                                        if(mysqli_num_rows($r_mhs) == 0){
                                            echo "<tr><td colspan='5'>Belum ada pendaftar di periode ini.</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if(mysqli_num_rows($r_mhs) > 0): ?>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Plotting</button>
                            <a href="sAutoPlotReviewerBimtekAdm.php?id=<?php echo $id_periode;?>&page=<?php echo $page;?>" class="btn btn-warning ml-2" onclick="return confirm('Yakin ingin mem-plot secara otomatis? Mahasiswa yang belum mendapat reviewer akan di-assign secara otomatis berdasar kuota terendah.')"><i class="fas fa-magic"></i> Plot Otomatis</a>
                            <a href="sResetPlotReviewerBimtekAdm.php?id=<?php echo $id_periode;?>&page=<?php echo $page;?>&mode=all" class="btn btn-danger float-right ml-2" onclick="return confirm('Yakin RESET SEMUA? Plotting mahasiswa DAN kepakaran reviewer akan dikosongkan. Kuota tambahan tetap tersimpan.')"><i class="fas fa-power-off"></i> Reset Semua</a>
                            <a href="sResetPlotReviewerBimtekAdm.php?id=<?php echo $id_periode;?>&page=<?php echo $page;?>" class="btn btn-secondary float-right" onclick="return confirm('Yakin ingin mengosongkan semua plotting? Semua mahasiswa akan kembali berstatus Belum di-plot.')"><i class="fas fa-trash"></i> Kosongkan Plotting</a>
                        </div>
                        <?php endif; ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <?php
        // Generate Modals for Reviewers with students
        $q_dsn_modal = mysqli_query($con, "SELECT id, nama FROM dt_pegawai WHERE jenis_pegawai='1' AND status='1'");
        while($d_dsn_modal = mysqli_fetch_assoc($q_dsn_modal)){
            $nip_modal = $d_dsn_modal['id'];
            $q_mhs_plot = mysqli_query($con, "SELECT bp.nim, dp.nama FROM bimtek_peserta bp LEFT JOIN dt_mhssw dp ON bp.nim = dp.nim WHERE bp.id_bimtek='$id_periode' AND bp.id_reviewer='$nip_modal' ORDER BY dp.nama ASC");
            if(mysqli_num_rows($q_mhs_plot) > 0){
      ?>
      <div class="modal fade" id="modalListMhs_<?php echo $nip_modal; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h5 class="modal-title">Daftar Mahasiswa Di-plot: <?php echo $d_dsn_modal['nama']; ?></h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body p-0">
              <table class="table table-sm table-striped text-center mb-0">
                <thead><tr><th width="10%">No</th><th width="30%">NIM</th><th width="60%">Nama Mahasiswa</th></tr></thead>
                <tbody>
                  <?php $nom = 1; while($dm = mysqli_fetch_assoc($q_mhs_plot)): ?>
                  <tr>
                    <td><?php echo $nom++; ?></td>
                    <td><?php echo $dm['nim']; ?></td>
                    <td class="text-left"><?php echo $dm['nama'] ? $dm['nama'] : '<span class="text-danger">[Data Mahasiswa Tidak Ditemukan]</span>'; ?></td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php } } ?>

    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script>
      $(document).ready(function() {
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          });
      });
    </script>
  </body>
</html>
