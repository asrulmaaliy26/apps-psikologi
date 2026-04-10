<?php include "koneksiUser.php";
  $nim = $_SESSION['nim'];
     $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
     $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
     $dataku = mysqli_fetch_assoc($dmhssw);
     ?>
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
        <li><a href="dashboardUser.php">Biodata <span class="sr-only">(current)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Permohonan Surat <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="formSowam.php">Izin Observasi dan Wawancara Matakuliah</a></li>
            <li><a href="formSipt.php">Izin Penelitian Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pengajuan <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="formPengajuanPrp.php">Peminatan Rumpun Psikologi</a></li>
            <li><a href="formPengajuanAc.php">Academic Coach</a></li>
            <li><a href="formPengajuanPt.php">Pembimbing Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pendaftaran <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="formPendSempro.php">Seminar Proposal</a></li>
            <li><a href="formPendUjTes.php">Ujian Tesis</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="formRevisiSempro.php">Upload Revisi Seminar Proposal</a></li>
            <li><a href="formRevisiTesis.php">Upload Revisi Ujian Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bank <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="downloadUser.php">Berkas</a></li>
            <li><a href="judulTesisUser.php">Judul Tesis</a></li>
            <li><a href="variabelxyUser.php">Variabel Tesis</a></li>
          </ul>
        </li>
        <li><a href="kontakUser.php"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span> Kontak</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
      <p class="navbar-text navbar-right hidden-sm hidden-xs small" style="padding-top:2px;"><?php echo $dataku['nama'].' ['.$dataku['nim'].']';?></p>
    </div>
  </div>
</nav>