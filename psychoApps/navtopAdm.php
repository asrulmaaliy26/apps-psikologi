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
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="logout.php" class="nav-link">Logout</a>
    </li>
  </ul>
</nav>
<?php if (!empty($_SESSION['is_superadmin'])) include __DIR__ . '/_saBar.php'; ?>