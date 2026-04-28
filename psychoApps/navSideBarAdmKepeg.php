<?php include( "contentsConAdm.php" );?>
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
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdmKepeg.php" class="nav-link <?php echo isActive('dashboardAdmKepeg.php'); ?>">
            <i class="fas fa-chart-line nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?php echo isOpen(['dtDosen.php','dtTendik.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['dtDosen.php','dtTendik.php']); ?>">
            <i class="fas fa-user-tie nav-icon"></i>
            <p>Data Pegawai <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="dtDosen.php" class="nav-link <?php echo isActive('dtDosen.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Data Dosen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtTendik.php" class="nav-link <?php echo isActive('dtTendik.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Data Tendik</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['dtKatPeg.php','dtPangkat.php','dtJabDik.php','dtJabSi.php','dtPpk.php','ubahNip.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['dtKatPeg.php','dtPangkat.php','dtJabDik.php','dtJabSi.php','dtPpk.php','ubahNip.php']); ?>">
            <i class="fas fa-tools nav-icon"></i>
            <p>Konfigurasi <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="dtKatPeg.php" class="nav-link <?php echo isActive('dtKatPeg.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Kategori Pegawai</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtPangkat.php" class="nav-link <?php echo isActive('dtPangkat.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Kepangkatan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtJabDik.php" class="nav-link <?php echo isActive('dtJabDik.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Jabatan Pendidik</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtJabSi.php" class="nav-link <?php echo isActive('dtJabSi.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Jabatan Instansi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtPpk.php" class="nav-link <?php echo isActive('dtPpk.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>PPK</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="ubahNip.php" class="nav-link <?php echo isActive('ubahNip.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Ubah NIP/Id Lainnya</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['dtFoto.php','dtBerkasPegawai.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['dtFoto.php','dtBerkasPegawai.php']); ?>">
            <i class="fas fa-file-image nav-icon"></i>
            <p>Direktori <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="dtFoto.php" class="nav-link <?php echo isActive('dtFoto.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Foto Pegawai</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtBerkasPegawai.php" class="nav-link <?php echo isActive('dtBerkasPegawai.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Berkas Pegawai</p>
              </a>
            </li>
          </ul>
        </li>
        <?php if($_SESSION['username']=="adminkepegawaian1") { ?>
        <li class="nav-item <?php echo isOpen(['imporUserTataPersuratan.php','imporDataMahasiswaS1.php','imporUserMahasiswaS1.php','imporDataMahasiswaS2.php','imporUserMahasiswaS2.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['imporUserTataPersuratan.php','imporDataMahasiswaS1.php','imporUserMahasiswaS1.php','imporDataMahasiswaS2.php','imporUserMahasiswaS2.php']); ?>">
            <i class="fas fa-file-image nav-icon"></i>
            <p>Impor Data <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="imporUserTataPersuratan.php" class="nav-link <?php echo isActive('imporUserTataPersuratan.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Admin Tata Persuratan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imporDataMahasiswaS1.php" class="nav-link <?php echo isActive('imporDataMahasiswaS1.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Mahasiswa S1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imporUserMahasiswaS1.php" class="nav-link <?php echo isActive('imporUserMahasiswaS1.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>User Mahasiswa S1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imporDataMahasiswaS2.php" class="nav-link <?php echo isActive('imporDataMahasiswaS2.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Mahasiswa S2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imporUserMahasiswaS2.php" class="nav-link <?php echo isActive('imporUserMahasiswaS2.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>User Mahasiswa S2</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
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