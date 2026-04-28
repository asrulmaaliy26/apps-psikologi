<?php include("contentsConAdm.php"); ?>
<?php
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
<aside <?php include("main-sidebar-style.php") ?>>
  <?php include("brandNavAdm.php"); ?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardUserS1.php" class="nav-link <?php echo isActive('dashboardUserS1.php'); ?>">
            <i class="nav-icon fas fa-house-user"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="profilAkademikUser.php" class="nav-link <?php echo isActive(['profilAkademikUser.php','profilPribadiUser.php','profilOrtuUser.php','profilFotoUser.php']); ?>">
            <i class="nav-icon far fa-user-circle"></i>
            <p>Profil</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="permohonanSuratUser.php" class="nav-link <?php echo isActive('permohonanSuratUser.php'); ?>">
            <i class="nav-icon fas fa-envelope-open-text"></i>
            <p>Permohonan Surat</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="prePengajuanDospemUser.php" class="nav-link <?php echo isActive(['prePengajuanDospemUser.php','riwayatPengajuanDospemUser.php']); ?>">
            <i class="nav-icon fas fa-people-arrows"></i>
            <p>Pengajuan Dospem Skripsi</p>
          </a>
        </li>
        <li class="nav-item <?php echo isOpen(['unsurSkkmUser.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['unsurSkkmUser.php']); ?>">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Pengisian
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="unsurSkkmUser.php" class="nav-link <?php echo isActive('unsurSkkmUser.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>SKKM</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['prePendaftaranPklUser.php','plotLembagaPklUser.php','prePendaftaranBimtekUser.php','listPraPropBimtekUser.php','prePendaftaranSemproUser.php','prePendaftaranUjianKompreUser.php','prePendaftaranUjianSkripsiUser.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['prePendaftaranPklUser.php','plotLembagaPklUser.php','prePendaftaranBimtekUser.php','listPraPropBimtekUser.php','prePendaftaranSemproUser.php','prePendaftaranUjianKompreUser.php','prePendaftaranUjianSkripsiUser.php']); ?>">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Pendaftaran
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="prePendaftaranPklUser.php" class="nav-link <?php echo isActive('prePendaftaranPklUser.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Mendaftar PKL (Reguler)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="plotLembagaPklUser.php" class="nav-link text-warning <?php echo isActive('plotLembagaPklUser.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Pilih Lembaga PKL</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="prePendaftaranBimtekUser.php" class="nav-link <?php echo isActive('prePendaftaranBimtekUser.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Bimtek Penulisan Tugas Akhir</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="listPraPropBimtekUser.php" class="nav-link text-warning <?php echo isActive('listPraPropBimtekUser.php'); ?>">
                <i class="fas fa-file-alt nav-icon"></i>
                <p>Pra Proposal Bimtek</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="prePendaftaranSemproUser.php" class="nav-link <?php echo isActive('prePendaftaranSemproUser.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Seminar Proposal Skripsi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="prePendaftaranUjianKompreUser.php" class="nav-link <?php echo isActive('prePendaftaranUjianKompreUser.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Ujian Komprehensif</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="prePendaftaranUjianSkripsiUser.php" class="nav-link <?php echo isActive('prePendaftaranUjianSkripsiUser.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Ujian Skripsi</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>