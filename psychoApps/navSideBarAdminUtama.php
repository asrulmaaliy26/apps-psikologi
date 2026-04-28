<?php include("contentsConAdm.php");
$currentPage = basename($_SERVER['PHP_SELF']);
if (!function_exists('isActive')) {
  function isActive($page) {
    global $currentPage;
    if (is_array($page)) { return in_array($currentPage, $page) ? 'active bg-primary' : ''; }
    return ($currentPage === $page) ? 'active bg-primary' : '';
  }
}
?>
<aside <?php include("main-sidebar-style.php") ?>>
  <?php include("brandNavAdm.php"); ?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdminUtama.php" class="nav-link <?php echo isActive('dashboardAdminUtama.php'); ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-header">MANAJEMEN JABATAN</li>
        <li class="nav-item">
          <a href="kelolaJabatanAdm.php" class="nav-link <?php echo isActive('kelolaJabatanAdm.php'); ?>">
            <i class="nav-icon fas fa-list-ul"></i>
            <p>Daftar Jabatan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="kelolaPejabatAdm.php" class="nav-link <?php echo isActive('kelolaPejabatAdm.php'); ?>">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>Tentukan Jabatan User</p>
          </a>
        </li>
        <li class="nav-header">MANAJEMEN MAHASISWA</li>
        <li class="nav-item">
          <a href="kelolaMahasiswaS1Adm.php" class="nav-link <?php echo isActive('kelolaMahasiswaS1Adm.php'); ?>">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Daftar Mahasiswa S1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="kelolaMahasiswaS2Adm.php" class="nav-link <?php echo isActive('kelolaMahasiswaS2Adm.php'); ?>">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Daftar Mahasiswa S2</p>
          </a>
        </li>
        <li class="nav-header">IMPOR DATA</li>
        <li class="nav-item">
          <a href="imporDataMahasiswaS1Adm.php" class="nav-link <?php echo isActive('imporDataMahasiswaS1Adm.php'); ?>">
            <i class="nav-icon fas fa-file-excel"></i>
            <p>Data Mahasiswa S1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="imporUserMahasiswaS1Adm.php" class="nav-link <?php echo isActive('imporUserMahasiswaS1Adm.php'); ?>">
            <i class="nav-icon fas fa-user-plus"></i>
            <p>User Mahasiswa S1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="imporDataMahasiswaS2Adm.php" class="nav-link <?php echo isActive('imporDataMahasiswaS2Adm.php'); ?>">
            <i class="nav-icon fas fa-file-excel"></i>
            <p>Data Mahasiswa S2</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="imporUserMahasiswaS2Adm.php" class="nav-link <?php echo isActive('imporUserMahasiswaS2Adm.php'); ?>">
            <i class="nav-icon fas fa-user-plus"></i>
            <p>User Mahasiswa S2</p>
          </a>
        </li>
        <li class="nav-header">LAINNYA</li>
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