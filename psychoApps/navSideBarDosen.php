<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_pegawai WHERE id='$username'";
$d = mysqli_query($con, $myquery)or die( mysqli_error($con));
$dtDosen = mysqli_fetch_assoc($d);
?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-xs">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdm.php" class="nav-link text-warning disabled">
            <i class="fas fa-chart-line nav-icon"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link text-warning">
            <i class="fas fa-star-half-alt nav-icon"></i>
            <p>
              Penilaian
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="dashboardBeritaAcaraSempro.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Seminar Proposal Skripsi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dashboardBeritaAcaraUjskrip.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ujian Skripsi</p>
              </a>
            </li>
            <?php if($dtDosen['menguji_sempro_tesis']=='2') {echo '
            <li class="nav-item">
              <a href="dashboardBeritaAcaraSemproTes.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Seminar Proposal Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dashboardBeritaAcaraUjTes.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ujian Tesis</p>
              </a>
            </li>
            ';}?>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link text-warning">
            <i class="fas fa-star-half-alt nav-icon"></i>
            <p>
              Rekap Pembimbingan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="pembimbingSkripsi1.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pembimbing I Skripsi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pembimbingSkripsi2.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pembimbing II Skripsi</p>
              </a>
            </li>
            <?php if($dtDosen['menguji_sempro_tesis']=='2') {echo '
            <li class="nav-item">
              <a href="pembimbingTesis1.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pembimbing I Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pembimbingTesis2.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pembimbing II Tesis</p>
              </a>
            </li>
            ';}?>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link text-warning">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Download Berkas
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="berkasSemproSkripsi.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Seminar Proposal Skripsi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="berkasUjskrip.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ujian Skripsi</p>
              </a>
            </li>
            <?php if($dtDosen['menguji_sempro_tesis']=='2') {echo '
            <li class="nav-item">
              <a href="berkasSemproTes.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Seminar Proposal Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="berkasTes.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ujian Tesis</p>
              </a>
            </li>
            ';}?>
            <li class="nav-item">
              <a href="berkasSk.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>SK (Surat Keputusan)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="berkasSt.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>ST (Surat Tugas)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="berkasUndangan.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Undangan</p>
              </a>
            </li>
          </ul>
        </li>
        <?php if($dtDosen['jabatan_instansi']=='47') {echo '
        <li class="nav-item menu-open">
          <a href="#" class="nav-link text-warning">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Verifikasi
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="verPropMagang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Proposal Magang</p>
              </a>
            </li>
          </ul>
        </li>
        ';}?>
        <?php if($dtDosen['jabatan_instansi']=='36') {echo '
        <li class="nav-item menu-open">
          <a href="#" class="nav-link text-warning">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Persetujuan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="verPengDospem.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Pengajuan Dospem Tesis</p>
              </a>
            </li>
          </ul>
        </li>
        ';}?>
      </ul>
    </nav>
  </div>
</aside>