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
  <div class="sidebar text-xs">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="laporanHarian.php" class="nav-link text-warning <?php echo isActive('laporanHarian.php'); ?>">
            <i class="fas fa-clipboard-list nav-icon"></i>
            <p>Laporan Harian</p>
          </a>
        </li>
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