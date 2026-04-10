<?php include( "contentsConAdm.php" );?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdmBakS1.php" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-file-signature nav-icon"></i>
            <p>
              Pengajuan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="fas fa-file-signature nav-icon"></i>
                <p>
                  Dospem Skripsi
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pngjnDospemAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Periode Pengajuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapDospemAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Dospem</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapPembimbinganAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Pembimbingan</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-users-cog nav-icon"></i>
            <p>
              Pendaftaran
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>
                  PKL
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pndftrnPklAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Periode Pendaftaran</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapNilaiPklAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Nilai</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapDplPklAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap DPL</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>
                  Seminar Proposal
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pndftrnSemproAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Periode Pendaftaran</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="verPndftrSemproAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Verifikasi Pendaftar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapPndftrSemproAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Pendaftar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="inputJdwlSemproAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Input Jadwal</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapJdwlSemproAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Jadwal</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapBaSemproAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Form Berita Acara</p>
                  </a>
                </li>                
                <li class="nav-item">
                  <a href="rekapNilaiSemproAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Nilai</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapPengujiSemproAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Penguji</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>
                  Kompre
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pndftrnKompreAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Periode Pendaftaran</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapNilaiKompreAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Nilai</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapPengawasKompreAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Pengawas</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>          
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>
                  Ujian Skripsi
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pndftrnUjskripAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Periode Pendaftaran</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="verPndftrUjskripAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Verifikasi Pendaftar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapPndftrUjskripAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Pendaftar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="inputJdwlUjskripAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Input Jadwal</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapJdwlUjskripAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Jadwal</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapBaUjskripAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Form Berita Acara</p>
                  </a>
                </li>                
                <li class="nav-item">
                  <a href="rekapNilaiUjskripAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Nilai</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="rekapPengujiUjskripAdm.php" class="nav-link">
                    <i class="fas fa-ellipsis-v nav-icon"></i>
                    <p>Rekap Penguji</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>