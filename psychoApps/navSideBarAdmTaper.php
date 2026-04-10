<?php include( "contentsConAdm.php" );?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdmTaper.php" class="nav-link disabled">
            <i class="fas fa-chart-line nav-icon"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-envelope-open-text nav-icon"></i>
            <p>
              Agenda Surat
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="agendaSuratKeluarAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Keluar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="agendaSuratMasukAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Masuk</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-edit nav-icon"></i>
            <p>
              Buat Surat
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="rekapSuratKeputusanAdm.php" class="nav-link disabled">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Keputusan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapSuratTugasAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Tugas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapSpdAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Perjalanan Dinas</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-paper-plane nav-icon"></i>
            <p>
              Kirim File Surat
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="rekapKirimSuratKeputusanAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Keputusan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapKirimSuratTugasAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Tugas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapKirimSuratUndAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Undangan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-mail-bulk nav-icon"></i>
            <p>
              Permohonan Surat
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="rekapSuratMahasiswaAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Dari Mahasiswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapSuratPegawaiAdm.php" class="nav-link disabled">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Dari Pegawai</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-database nav-icon"></i>
            <p>
              Rekap Data
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="dataAskAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Agenda Surat Keluar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataAsmAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Agenda Surat Masuk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataSkAdm.php" class="nav-link disabled">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Keputusan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataStAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Tugas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataSpdAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Surat Perjalanan Dinas</p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>
                  Kirim File Surat
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="dataKfsSkAdm.php" class="nav-link">
                    <i class="text-xs fas fa-circle nav-icon"></i>
                    <p>Surat Keputusan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="dataKfsStAdm.php" class="nav-link">
                    <i class="text-xs fas fa-circle nav-icon"></i>
                    <p>Surat Tugas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="dataKfsSuAdm.php" class="nav-link">
                    <i class="text-xs fas fa-circle nav-icon"></i>
                    <p>Surat Undangan</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>
                  Permohonan Surat
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="dataSuratMahasiswaAdm.php" class="nav-link">
                    <i class="text-xs fas fa-circle nav-icon"></i>
                    <p>Dari Mahasiswa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="dataSuratPegawaiAdm.php" class="nav-link disabled">
                    <i class="text-xs fas fa-circle nav-icon"></i>
                    <p>Dari Pegawai</p>
                  </a>
                </li>
              </ul>
            </li>            
          </ul>
        </li>        
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-cog nav-icon"></i>
            <p>
              Pengaturan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="rekapOrdnerAdm.php" class="nav-link disabled">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Data Ordner</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-user-edit nav-icon"></i>
            <p>
              Kontribusi Saya
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="dataKontribEksekutorAdm.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Sebagai Eksekutor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataKontribEditorAdm.php" class="nav-link disabled">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Sebagai Editor</p>
              </a>
            </li>        
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>