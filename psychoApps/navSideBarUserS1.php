<?php include( "contentsConAdm.php" );?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardUserS1.php" class="nav-link active">
            <i class="nav-icon fas fa-house-user"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="profilAkademikUser.php" class="nav-link active">
            <i class="nav-icon far fa-user-circle"></i>
            <p>
              Profil
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="permohonanSuratUser.php" class="nav-link active">
            <i class="nav-icon fas fa-envelope-open-text"></i>
            <p>
              Permohonan Surat
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="prePengajuanDospemUser.php" class="nav-link active">
            <i class="nav-icon fas fa-people-arrows"></i>
            <p>
              Pengajuan Dospem Skripsi
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Pengisian
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="unsurSkkmUser.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  SKKM
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>
              Pendaftaran
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="prePendaftaranPklUser.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Praktik Kerja Lapangan (PKL)
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="prePendaftaranSemproUser.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Seminar Proposal Skripsi
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="prePendaftaranUjianKompreUser.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Ujian Komprehensif
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="prePendaftaranUjianSkripsiUser.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Ujian Skripsi
                </p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>