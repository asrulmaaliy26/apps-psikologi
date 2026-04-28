<?php include "koneksiAdm.php";
  $username = $_SESSION['username'];
     $myquery = "select * from mag_dt_admin_bak WHERE username='$username'";
     $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
     $dataku = mysqli_fetch_assoc($dmhssw);
     $nama_admin = !empty($dataku['nama']) ? $dataku['nama'] : (isset($_SESSION['nm_person']) ? $_SESSION['nm_person'] : (isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Admin'));
     
$currentPage = basename($_SERVER['PHP_SELF']);
if (!function_exists('isActive')) {
    function isActive($page) {
        global $currentPage;
        if (is_array($page)) { return in_array($currentPage, $page) ? 'active' : ''; }
        return ($currentPage === $page) ? 'active' : '';
    }
}
?>
<style>
  .navbar-nav > li.active > a {
    background-color: #007bff !important;
    color: #fff !important;
    font-weight: bold;
  }
  .dropdown-menu > li.active > a {
    background-color: #007bff !important;
    color: #fff !important;
  }
  @media (min-width: 768px) {
    .navbar-nav > li.dropdown:hover > ul.dropdown-menu {
      display: block;
    }
  }
</style>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Simagis</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php echo isActive('dashboardAdm.php'); ?>"><a href="dashboardAdm.php">Dashboard <span class="sr-only">(current)</span></a></li>
        <li class="dropdown <?php echo isActive(['rekapPprpAdm.php','rekapPacAdm.php','rekapPptAdm.php','rekapSiowAdm.php','rekapPsiptAdm.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pengajuan <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('rekapPprpAdm.php'); ?>"><a href="rekapPprpAdm.php">Peminatan Rumpun Psikologi</a></li>
            <li class="<?php echo isActive('rekapPacAdm.php'); ?>"><a href="rekapPacAdm.php">Academic Coach</a></li>
            <li class="<?php echo isActive('rekapPptAdm.php'); ?>"><a href="rekapPptAdm.php">Pembimbing Tesis</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo isActive('rekapSiowAdm.php'); ?>"><a href="rekapSiowAdm.php">Surat Izin Observasi dan Wawancara</a></li>
            <li class="<?php echo isActive('rekapPsiptAdm.php'); ?>"><a href="rekapPsiptAdm.php">Surat Izin Penelitian Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown <?php echo isActive(['rekapPendSemproAdm.php','rekapPendUjtesAdm.php','rekapRevisiProAdm.php','rekapRevisiTesAdm.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pendaftaran <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('rekapPendSemproAdm.php'); ?>"><a href="rekapPendSemproAdm.php">Seminar Proposal</a></li>
            <li class="<?php echo isActive('rekapPendUjtesAdm.php'); ?>"><a href="rekapPendUjtesAdm.php">Ujian Tesis</a></li>
            <li class="<?php echo isActive('rekapRevisiProAdm.php'); ?>"><a href="rekapRevisiProAdm.php">Revisi Seminar Proposal</a></li>
            <li class="<?php echo isActive('rekapRevisiTesAdm.php'); ?>"><a href="rekapRevisiTesAdm.php">Revisi Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown <?php echo isActive(['rekapDosenAdm.php','rekapMhsswAdm.php','kontakLayananAdm.php','rekapJudulPropAdm.php','rekapJudulTesisAdm.php','variabelxyAdm.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master Data <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('rekapDosenAdm.php'); ?>"><a href="rekapDosenAdm.php">Dosen</a></li>
            <li class="<?php echo isActive('rekapMhsswAdm.php'); ?>"><a href="rekapMhsswAdm.php">Mahasiswa</a></li>
            <li class="<?php echo isActive('kontakLayananAdm.php'); ?>"><a href="kontakLayananAdm.php">Kontak Layanan</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo isActive('rekapJudulPropAdm.php'); ?>"><a href="rekapJudulPropAdm.php">Judul Proposal</a></li>
            <li class="<?php echo isActive('rekapJudulTesisAdm.php'); ?>"><a href="rekapJudulTesisAdm.php">Judul Tesis</a></li>
            <li class="<?php echo isActive('variabelxyAdm.php'); ?>"><a href="variabelxyAdm.php">Bank Variabel</a></li>
          </ul>
        </li>
        <li class="dropdown <?php echo isActive(['sopPprp.php','sopPac.php','sopPpt.php','sopPspt.php','sopPut.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SOP <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('sopPprp.php'); ?>"><a href="sopPprp.php">Pengajuan Peminatan Rumpun Psikologi</a></li>
            <li class="<?php echo isActive('sopPac.php'); ?>"><a href="sopPac.php">Pengajuan Academic Coach</a></li>
            <li class="<?php echo isActive('sopPpt.php'); ?>"><a href="sopPpt.php">Pengajuan Pembimbing Tesis</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo isActive('sopPspt.php'); ?>"><a href="sopPspt.php">Pendaftaran Sempro</a></li>
            <li class="<?php echo isActive('sopPut.php'); ?>"><a href="sopPut.php">Pendaftaran Ujian Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown <?php echo isActive(['rekapUpload.php','rekapPengumuman.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Upload <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('rekapUpload.php'); ?>"><a href="rekapUpload.php">Berkas</a></li>
            <li class="<?php echo isActive('rekapPengumuman.php'); ?>"><a href="rekapPengumuman.php">Pengumuman</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../psychoApps/laporanHarian.php" style="font-weight:bold; color:#28a745;"><span class="glyphicon glyphicon-list-alt"></span> Laporan Harian</a></li>
        <li><a href="https://docs.google.com/spreadsheets/d/1Rpct62WQy3AFAT5cNIgyP2iaIgFYxGVNPibLIB_RYpg/edit?usp=sharing" target="_blank" style="font-weight:bold; color:#17a2b8;"><span class="glyphicon glyphicon-headset"></span> Layanan / Pengaduan</a></li>
        <li><a href="logoutAdm.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
      <p class="navbar-text navbar-right hidden-sm hidden-xs">Admin: <?php echo $nama_admin; ?></p>
    </div>
  </div>
</nav>
<?php if (!empty($_SESSION['is_superadmin'])) include __DIR__ . '/../psychoApps/_saBar.php'; ?>