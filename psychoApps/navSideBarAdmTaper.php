<?php include( "contentsConAdm.php" );?>
<?php
$currentPage = basename($_SERVER['PHP_SELF']);
if (!function_exists('isActive')) {
    function isActive($page) {
        global $currentPage;
        if (is_array($page)) { return in_array($currentPage, $page) ? 'active bg-primary' : ''; }
        return ($currentPage === $page) ? 'active bg-primary' : '';
    }
}
if (!function_exists('isOpen')) {
    function isOpen($pages) {
        return 'menu-open';
    }
}
$_rekap = ['dataAskAdm.php','dataAsmAdm.php','dataSkAdm.php','dataStAdm.php','dataSpdAdm.php','dataKfsSkAdm.php','dataKfsStAdm.php','dataKfsSuAdm.php','dataSuratMahasiswaAdm.php','dataSuratPegawaiAdm.php'];
?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdmTaper.php" class="nav-link disabled <?php echo isActive('dashboardAdmTaper.php'); ?>">
            <i class="fas fa-chart-line nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?php echo isOpen(['agendaSuratKeluarAdm.php','agendaSuratMasukAdm.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['agendaSuratKeluarAdm.php','agendaSuratMasukAdm.php']); ?>">
            <i class="fas fa-envelope-open-text nav-icon"></i>
            <p>Agenda Surat <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="agendaSuratKeluarAdm.php" class="nav-link <?php echo isActive('agendaSuratKeluarAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Keluar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="agendaSuratMasukAdm.php" class="nav-link <?php echo isActive('agendaSuratMasukAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Masuk</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['rekapSuratKeputusanAdm.php','rekapSuratTugasAdm.php','rekapSpdAdm.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['rekapSuratKeputusanAdm.php','rekapSuratTugasAdm.php','rekapSpdAdm.php']); ?>">
            <i class="fas fa-edit nav-icon"></i>
            <p>Buat Surat <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="rekapSuratKeputusanAdm.php" class="nav-link disabled <?php echo isActive('rekapSuratKeputusanAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Keputusan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapSuratTugasAdm.php" class="nav-link <?php echo isActive('rekapSuratTugasAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Tugas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapSpdAdm.php" class="nav-link <?php echo isActive('rekapSpdAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Perjalanan Dinas</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['rekapKirimSuratKeputusanAdm.php','rekapKirimSuratTugasAdm.php','rekapKirimSuratUndAdm.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['rekapKirimSuratKeputusanAdm.php','rekapKirimSuratTugasAdm.php','rekapKirimSuratUndAdm.php']); ?>">
            <i class="fas fa-paper-plane nav-icon"></i>
            <p>Kirim File Surat <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="rekapKirimSuratKeputusanAdm.php" class="nav-link <?php echo isActive('rekapKirimSuratKeputusanAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Keputusan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapKirimSuratTugasAdm.php" class="nav-link <?php echo isActive('rekapKirimSuratTugasAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Tugas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapKirimSuratUndAdm.php" class="nav-link <?php echo isActive('rekapKirimSuratUndAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Undangan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['rekapSuratMahasiswaAdm.php','rekapSuratPegawaiAdm.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['rekapSuratMahasiswaAdm.php','rekapSuratPegawaiAdm.php']); ?>">
            <i class="fas fa-mail-bulk nav-icon"></i>
            <p>Permohonan Surat <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="rekapSuratMahasiswaAdm.php" class="nav-link <?php echo isActive('rekapSuratMahasiswaAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Dari Mahasiswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="rekapSuratPegawaiAdm.php" class="nav-link disabled <?php echo isActive('rekapSuratPegawaiAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Dari Pegawai</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen($_rekap); ?>">
          <a href="#" class="nav-link <?php echo isActive($_rekap); ?>">
            <i class="fas fa-database nav-icon"></i>
            <p>Rekap Data <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="dataAskAdm.php" class="nav-link <?php echo isActive('dataAskAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Agenda Surat Keluar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataAsmAdm.php" class="nav-link <?php echo isActive('dataAsmAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Agenda Surat Masuk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataSkAdm.php" class="nav-link disabled <?php echo isActive('dataSkAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Keputusan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataStAdm.php" class="nav-link <?php echo isActive('dataStAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Tugas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataSpdAdm.php" class="nav-link <?php echo isActive('dataSpdAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Surat Perjalanan Dinas</p>
              </a>
            </li>
            <li class="nav-item <?php echo isOpen(['dataKfsSkAdm.php','dataKfsStAdm.php','dataKfsSuAdm.php']); ?>">
              <a href="#" class="nav-link <?php echo isActive(['dataKfsSkAdm.php','dataKfsStAdm.php','dataKfsSuAdm.php']); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Kirim File Surat <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item">
                  <a href="dataKfsSkAdm.php" class="nav-link <?php echo isActive('dataKfsSkAdm.php'); ?>">
                    <i class="text-xs fas fa-circle nav-icon"></i><p>Surat Keputusan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="dataKfsStAdm.php" class="nav-link <?php echo isActive('dataKfsStAdm.php'); ?>">
                    <i class="text-xs fas fa-circle nav-icon"></i><p>Surat Tugas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="dataKfsSuAdm.php" class="nav-link <?php echo isActive('dataKfsSuAdm.php'); ?>">
                    <i class="text-xs fas fa-circle nav-icon"></i><p>Surat Undangan</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item <?php echo isOpen(['dataSuratMahasiswaAdm.php','dataSuratPegawaiAdm.php']); ?>">
              <a href="#" class="nav-link <?php echo isActive(['dataSuratMahasiswaAdm.php','dataSuratPegawaiAdm.php']); ?>">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Permohonan Surat <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item">
                  <a href="dataSuratMahasiswaAdm.php" class="nav-link <?php echo isActive('dataSuratMahasiswaAdm.php'); ?>">
                    <i class="text-xs fas fa-circle nav-icon"></i><p>Dari Mahasiswa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="dataSuratPegawaiAdm.php" class="nav-link disabled <?php echo isActive('dataSuratPegawaiAdm.php'); ?>">
                    <i class="text-xs fas fa-circle nav-icon"></i><p>Dari Pegawai</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['rekapOrdnerAdm.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['rekapOrdnerAdm.php']); ?>">
            <i class="fas fa-cog nav-icon"></i>
            <p>Pengaturan <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="rekapOrdnerAdm.php" class="nav-link disabled <?php echo isActive('rekapOrdnerAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Data Ordner</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen(['dataKontribEksekutorAdm.php','dataKontribEditorAdm.php']); ?>">
          <a href="#" class="nav-link <?php echo isActive(['dataKontribEksekutorAdm.php','dataKontribEditorAdm.php']); ?>">
            <i class="fas fa-user-edit nav-icon"></i>
            <p>Kontribusi Saya <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="dataKontribEksekutorAdm.php" class="nav-link <?php echo isActive('dataKontribEksekutorAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Sebagai Eksekutor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dataKontribEditorAdm.php" class="nav-link disabled <?php echo isActive('dataKontribEditorAdm.php'); ?>">
                <i class="text-xs far fa-circle nav-icon"></i><p>Sebagai Editor</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="nav nav-pills nav-sidebar flex-column">
        <li class="nav-item">
          <a href="https://docs.google.com/spreadsheets/d/1Rpct62WQy3AFAT5cNIgyP2iaIgFYxGVNPibLIB_RYpg/edit?usp=sharing" target="_blank" class="nav-link text-info">
            <i class="fas fa-headset nav-icon"></i>
            <p>Layanan / Pengaduan</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>