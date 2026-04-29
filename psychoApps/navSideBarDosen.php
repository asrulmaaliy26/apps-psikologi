<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_pegawai WHERE id='$username'";
$d = mysqli_query($con, $myquery)or die( mysqli_error($con));
$dtDosen = mysqli_fetch_assoc($d);
$currentPage = basename($_SERVER['PHP_SELF']);
if (!function_exists('isActive')) {
    function isActive($page) {
        global $currentPage;
        if (is_array($page)) { return in_array($currentPage, $page) ? 'active bg-primary' : ''; }
        return ($currentPage === $page) ? 'active bg-primary' : '';
    }
}
if (!function_exists('isOpen')) {
    function isOpen($pages) {
        return 'menu-open';
    }
}
?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-xs">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdm.php" class="nav-link text-warning <?php echo isActive('dashboardAdm.php'); ?>">
            <i class="fas fa-chart-line nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?php echo isOpen(['dashboardBeritaAcaraSempro.php','dashboardBeritaAcaraUjskrip.php','dashboardBeritaAcaraSemproTes.php','dashboardBeritaAcaraUjTes.php']); ?>">
          <a href="#" class="nav-link text-warning <?php echo isActive(['dashboardBeritaAcaraSempro.php','dashboardBeritaAcaraUjskrip.php','dashboardBeritaAcaraSemproTes.php','dashboardBeritaAcaraUjTes.php']); ?>">
            <i class="fas fa-star-half-alt nav-icon"></i>
            <p>
              Penilaian
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="dashboardBeritaAcaraSempro.php" class="nav-link <?php echo isActive('dashboardBeritaAcaraSempro.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Seminar Proposal Skripsi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dashboardBeritaAcaraUjskrip.php" class="nav-link <?php echo isActive('dashboardBeritaAcaraUjskrip.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ujian Skripsi</p>
              </a>
            </li>
            <?php if($dtDosen['menguji_sempro_tesis']=='2') { ?>
            <li class="nav-item">
              <a href="dashboardBeritaAcaraSemproTes.php" class="nav-link <?php echo isActive('dashboardBeritaAcaraSemproTes.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Seminar Proposal Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dashboardBeritaAcaraUjTes.php" class="nav-link <?php echo isActive('dashboardBeritaAcaraUjTes.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ujian Tesis</p>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['pembimbingSkripsi1.php','pembimbingSkripsi2.php','pembimbingTesis1.php','pembimbingTesis2.php']); ?>">
          <a href="#" class="nav-link text-warning <?php echo isActive(['pembimbingSkripsi1.php','pembimbingSkripsi2.php','pembimbingTesis1.php','pembimbingTesis2.php']); ?>">
            <i class="fas fa-star-half-alt nav-icon"></i>
            <p>
              Rekap Pembimbingan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="pembimbingSkripsi1.php" class="nav-link <?php echo isActive('pembimbingSkripsi1.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pembimbing I Skripsi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pembimbingSkripsi2.php" class="nav-link <?php echo isActive('pembimbingSkripsi2.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pembimbing II Skripsi</p>
              </a>
            </li>
            <?php if($dtDosen['menguji_sempro_tesis']=='2') { ?>
            <li class="nav-item">
              <a href="pembimbingTesis1.php" class="nav-link <?php echo isActive('pembimbingTesis1.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pembimbing I Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pembimbingTesis2.php" class="nav-link <?php echo isActive('pembimbingTesis2.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pembimbing II Tesis</p>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['berkasSemproSkripsi.php','berkasUjskrip.php','berkasSemproTes.php','berkasTes.php','berkasSk.php','berkasSt.php','berkasUndangan.php']); ?>">
          <a href="#" class="nav-link text-warning <?php echo isActive(['berkasSemproSkripsi.php','berkasUjskrip.php','berkasSemproTes.php','berkasTes.php','berkasSk.php','berkasSt.php','berkasUndangan.php']); ?>">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Download Berkas
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="berkasSemproSkripsi.php" class="nav-link <?php echo isActive('berkasSemproSkripsi.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Seminar Proposal Skripsi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="berkasUjskrip.php" class="nav-link <?php echo isActive('berkasUjskrip.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ujian Skripsi</p>
              </a>
            </li>
            <?php if($dtDosen['menguji_sempro_tesis']=='2') { ?>
            <li class="nav-item">
              <a href="berkasSemproTes.php" class="nav-link <?php echo isActive('berkasSemproTes.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Seminar Proposal Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="berkasTes.php" class="nav-link <?php echo isActive('berkasTes.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ujian Tesis</p>
              </a>
            </li>
            <?php } ?>
            <li class="nav-item">
              <a href="berkasSk.php" class="nav-link <?php echo isActive('berkasSk.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>SK (Surat Keputusan)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="berkasSt.php" class="nav-link <?php echo isActive('berkasSt.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>ST (Surat Tugas)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="berkasUndangan.php" class="nav-link <?php echo isActive('berkasUndangan.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Undangan</p>
              </a>
            </li>
          </ul>
        </li>
        <?php if($dtDosen['jabatan_instansi']=='47') { ?>
        <li class="nav-item <?php echo isOpen(['verPropMagang.php']); ?>">
          <a href="#" class="nav-link text-warning <?php echo isActive(['verPropMagang.php']); ?>">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Verifikasi
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="verPropMagang.php" class="nav-link <?php echo isActive('verPropMagang.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Proposal Magang</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php if($dtDosen['jabatan_instansi']=='36') { ?>
        <li class="nav-item <?php echo isOpen(['verPengDospem.php','verPengDospemPerId.php']); ?>">
          <a href="#" class="nav-link text-warning <?php echo isActive(['verPengDospem.php','verPengDospemPerId.php']); ?>">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Persetujuan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="verPengDospem.php" class="nav-link <?php echo isActive('verPengDospem.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pengajuan Dospem Tesis</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php if($dtDosen['jabatan_instansi']=='47') { ?>
        <li class="nav-item <?php echo isOpen(['rekapSaranPembimbingBimtekKaprodi.php']); ?>">
          <a href="#" class="nav-link text-warning <?php echo isActive(['rekapSaranPembimbingBimtekKaprodi.php']); ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>
              Rekap Bimtek
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="rekapSaranPembimbingBimtekKaprodi.php" class="nav-link <?php echo isActive('rekapSaranPembimbingBimtekKaprodi.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Saran Dosen Pembimbing</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php
        $q_is_reviewer = mysqli_query($con, "SELECT id FROM bimtek_reviewer WHERE nip='$username' LIMIT 1");
        if(mysqli_num_rows($q_is_reviewer) > 0): ?>
        <li class="nav-item <?php echo isOpen(['reviewerBimtekDsn.php','reviewPraPropBimtekDsn.php']); ?>">
          <a href="#" class="nav-link text-warning <?php echo isActive(['reviewerBimtekDsn.php','reviewPraPropBimtekDsn.php']); ?>">
            <i class="fas fa-chalkboard-teacher nav-icon"></i>
            <p>
              Bimtek Reviewer
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="reviewerBimtekDsn.php" class="nav-link <?php echo isActive('reviewerBimtekDsn.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Daftar Mahasiswa Saya</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
      </ul>
      <ul class="nav nav-pills nav-sidebar flex-column">
        <li class="nav-item">
          <a href="https://docs.google.com/spreadsheets/d/1Rpct62WQy3AFAT5cNIgyP2iaIgFYxGVNPibLIB_RYpg/edit?usp=sharing" target="_blank" class="nav-link text-info">
            <i class="fas fa-headset nav-icon"></i>
            <p>Layanan / Pengaduan</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>