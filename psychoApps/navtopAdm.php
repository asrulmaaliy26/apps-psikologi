<?php
include("contentsConAdm.php");
$username = $_SESSION['username'];
$queryAdm = "SELECT * FROM dt_all_adm WHERE username='$username'";
$rAdm = mysqli_query($con, $queryAdm);
$dAdm = mysqli_fetch_assoc($rAdm);
$idAdm = $dAdm['username'];
$idLevel = $dAdm['level'];

$queryNmLevel = "SELECT * FROM opsi_level_admin WHERE id='$idLevel'";
$rNmLevel = mysqli_query($con, $queryNmLevel);
$dNmLevel = mysqli_fetch_assoc($rNmLevel);

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <span class="nav-link">
        <?php echo $dAdm['nm_person'] . ' ' . '[' . $dNmLevel['nm'] . ']'; ?>
      </span>
    </li>
    <?php
    if ($idLevel != 2 && $idLevel != 3) {

      $isMonitoring = false;
      $qCheckMon = mysqli_query($con, "
        SELECT 1 FROM peg_monitoring_role 
        WHERE username='$idAdm' 
        LIMIT 1
    ");
      if ($qCheckMon && mysqli_num_rows($qCheckMon) > 0) {
        $isMonitoring = true;
      }

      $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

      <!-- Laporan Harian -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="laporanHarian.php"
          class="btn btn-sm <?php echo ($currentPage == 'laporanHarian.php') ? 'btn-success' : 'btn-outline-success'; ?> ml-2">

          <i class="fas fa-clipboard-list mr-1"></i>
          Laporan Harian
        </a>
      </li>

      <?php if ($isMonitoring) { ?>
        <!-- Monitoring -->
        <li class="nav-item d-none d-sm-inline-block">
          <a href="monitoringLaporanHarian.php"
            class="btn btn-sm <?php echo ($currentPage == 'monitoringLaporanHarian.php') ? 'btn-primary' : 'btn-outline-primary'; ?> ml-2">

            <i class="fas fa-chart-line mr-1"></i>
            Monitoring
          </a>
        </li>
      <?php } ?>

    <?php } ?>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="logout.php" class="nav-link">Logout</a>
    </li>
  </ul>
</nav>
<?php if (!empty($_SESSION['is_superadmin'])) include __DIR__ . '/_saBar.php'; ?>