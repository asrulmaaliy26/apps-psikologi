<?php include "koneksiUser.php";
  $nim = $_SESSION['nim'];
     $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
     $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
     $dataku = mysqli_fetch_assoc($dmhssw);
     
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
        <li class="<?php echo isActive('dashboardUser.php'); ?>"><a href="dashboardUser.php">Biodata <span class="sr-only">(current)</span></a></li>
        <li class="dropdown <?php echo isActive(['formSowam.php','formSipt.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Permohonan Surat <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('formSowam.php'); ?>"><a href="formSowam.php">Izin Observasi dan Wawancara Matakuliah</a></li>
            <li class="<?php echo isActive('formSipt.php'); ?>"><a href="formSipt.php">Izin Penelitian Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown <?php echo isActive(['formPengajuanPrp.php','formPengajuanAc.php','formPengajuanPt.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pengajuan <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('formPengajuanPrp.php'); ?>"><a href="formPengajuanPrp.php">Peminatan Rumpun Psikologi</a></li>
            <li class="<?php echo isActive('formPengajuanAc.php'); ?>"><a href="formPengajuanAc.php">Academic Coach</a></li>
            <li class="<?php echo isActive('formPengajuanPt.php'); ?>"><a href="formPengajuanPt.php">Pembimbing Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown <?php echo isActive(['formPendSempro.php','formPendUjTes.php','formRevisiSempro.php','formRevisiTesis.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pendaftaran <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('formPendSempro.php'); ?>"><a href="formPendSempro.php">Seminar Proposal</a></li>
            <li class="<?php echo isActive('formPendUjTes.php'); ?>"><a href="formPendUjTes.php">Ujian Tesis</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo isActive('formRevisiSempro.php'); ?>"><a href="formRevisiSempro.php">Upload Revisi Seminar Proposal</a></li>
            <li class="<?php echo isActive('formRevisiTesis.php'); ?>"><a href="formRevisiTesis.php">Upload Revisi Ujian Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown <?php echo isActive(['downloadUser.php','judulTesisUser.php','variabelxyUser.php']); ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bank <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo isActive('downloadUser.php'); ?>"><a href="downloadUser.php">Berkas</a></li>
            <li class="<?php echo isActive('judulTesisUser.php'); ?>"><a href="judulTesisUser.php">Judul Tesis</a></li>
            <li class="<?php echo isActive('variabelxyUser.php'); ?>"><a href="variabelxyUser.php">Variabel Tesis</a></li>
          </ul>
        </li>
        <li class="<?php echo isActive('kontakUser.php'); ?>"><a href="kontakUser.php"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span> Kontak</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
      <p class="navbar-text navbar-right hidden-sm hidden-xs small" style="padding-top:2px;"><?php echo $dataku['nama'].' ['.$dataku['nim'].']';?></p>
    </div>
  </div>
</nav>