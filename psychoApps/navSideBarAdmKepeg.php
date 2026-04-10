<?php include( "contentsConAdm.php" );?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdmKepeg.php" class="nav-link">
            <i class="fas fa-chart-line nav-icon"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-user-tie nav-icon"></i>
            <p>
              Data Pegawai
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="dtDosen.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Data Dosen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtTendik.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Data Tendik</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-tools nav-icon"></i>
            <p>
              Konfigurasi
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="dtKatPeg.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Kategori Pegawai</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtPangkat.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Kepangkatan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtJabDik.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Jabatan Pendidik</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtJabSi.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Jabatan Instansi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtPpk.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>PPK</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="ubahNip.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ubah NIP/Id Lainnya</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-file-image nav-icon"></i>
            <p>
              Direktori
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="dtFoto.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Foto Pegawai</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtBerkasPegawai.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Berkas Pegawai</p>
              </a>
            </li>
          </ul>
        </li>
        <?php
        if($_SESSION['username']=="adminkepegawaian1") {
          echo '
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-file-image nav-icon"></i>
            <p>
              Impor Data
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="imporUserTataPersuratan.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Admin Tata Persuratan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imporDataMahasiswaS1.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Mahasiswa S1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imporUserMahasiswaS1.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>User Mahasiswa S1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imporDataMahasiswaS2.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Mahasiswa S2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imporUserMahasiswaS2.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>User Mahasiswa S2</p>
              </a>
            </li>            
          </ul>
        </li>
          ';
        }
        else {
          echo '';
        }?>
      </ul>
    </nav>
  </div>
</aside>