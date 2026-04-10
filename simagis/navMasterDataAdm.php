<?php include "koneksiAdm.php";
  $username = $_SESSION['username'];
     $myquery = "select * from mag_dt_admin_bak WHERE username='$username'";
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
        <li><a href="dashboardAdm.php">Dashboard <span class="sr-only">(current)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pengajuan <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="rekapPprpAdm.php">Peminatan Rumpun Psikologi</a></li>
            <li><a href="rekapPacAdm.php">Academic Coach</a></li>
            <li><a href="rekapPptAdm.php">Pembimbing Tesis</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="rekapSiowAdm.php">Surat Izin Observasi dan Wawancara</a></li>
            <li><a href="rekapPsiptAdm.php">Surat Izin Penelitian Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pendaftaran <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="rekapPendSemproAdm.php">Seminar Proposal</a></li>
            <li><a href="rekapPendUjtesAdm.php">Ujian Tesis</a></li>
            <li><a href="rekapRevisiProAdm.php">Revisi Seminar Proposal</a></li>
            <li><a href="rekapRevisiTesAdm.php">Revisi Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown active">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master Data <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="rekapDosenAdm.php">Dosen</a></li>
            <li><a href="rekapMhsswAdm.php">Mahasiswa</a></li>
            <li><a href="kontakLayananAdm.php">Kontak Layanan</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="rekapJudulPropAdm.php">Judul Proposal</a></li>
            <li><a href="rekapJudulTesisAdm.php">Judul Tesis</a></li>
            <li><a href="variabelxyAdm.php">Bank Variabel</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SOP <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="sopPprp.php">Pengajuan Peminatan Rumpun Psikologi</a></li>
            <li><a href="sopPac.php">Pengajuan Academic Coach</a></li>
            <li><a href="sopPpt.php">Pengajuan Pembimbing Tesis</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="sopPspt.php">Pendaftaran Sempro</a></li>
            <li><a href="sopPut.php">Pendaftaran Ujian Tesis</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Upload <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="rekapUpload.php">Berkas</a></li>
            <li><a href="rekapPengumuman.php">Pengumuman</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logoutAdm.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
      <p class="navbar-text navbar-right hidden-sm hidden-xs">Admin: <?php echo $dataku['nama'];?></p>
    </div>
  </div>
</nav>