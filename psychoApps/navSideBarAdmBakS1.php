<?php include("contentsConAdm.php");
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

$_pngjnDospem = ['pngjnDospemAdm.php','rekapDospemAdm.php','rekapPembimbinganAdm.php'];
$_pkl = ['pndftrnPklAdm.php','plotLembagaPklAdm.php','rekapNilaiPklAdm.php','rekapDplPklAdm.php'];
$_sempro = ['pndftrnSemproAdm.php','verPndftrSemproAdm.php','rekapPndftrSemproAdm.php','inputJdwlSemproAdm.php','rekapJdwlSemproAdm.php','rekapBaSemproAdm.php','rekapNilaiSemproAdm.php','rekapPengujiSemproAdm.php'];
$_kompre = ['pndftrnKompreAdm.php','rekapNilaiKompreAdm.php','rekapPengawasKompreAdm.php'];
$_ujskrip = ['pndftrnUjskripAdm.php','verPndftrUjskripAdm.php','rekapPndftrUjskripAdm.php','inputJdwlUjskripAdm.php','rekapJdwlUjskripAdm.php','rekapBaUjskripAdm.php','rekapNilaiUjskripAdm.php','rekapPengujiUjskripAdm.php'];
$_bimtek = ['pndftrnBimtekAdm.php','dataDosenKepakaranAdm.php','rekapPraPropBimtekAdm.php'];
$_semuaPendaftaran = array_merge($_pkl, $_sempro, $_kompre, $_ujskrip, $_bimtek);

?>
<aside <?php include("main-sidebar-style.php") ?>>
  <?php include("brandNavAdm.php"); ?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdmBakS1.php" class="nav-link <?php echo isActive('dashboardAdmBakS1.php'); ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?php echo isOpen($_pngjnDospem); ?>">
          <a href="#" class="nav-link <?php echo isActive($_pngjnDospem); ?>">
            <i class="fas fa-file-signature nav-icon"></i>
            <p>Pengajuan <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item <?php echo isOpen($_pngjnDospem); ?>">
              <a href="#" class="nav-link <?php echo isActive($_pngjnDospem); ?>">
                <i class="fas fa-file-signature nav-icon"></i>
                <p>Dospem Skripsi <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item">
                  <a href="pngjnDospemAdm.php" class="nav-link <?php echo isActive('pngjnDospemAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Periode Pengajuan</p></a>
                </li>
                <li class="nav-item">
                  <a href="rekapDospemAdm.php" class="nav-link <?php echo isActive('rekapDospemAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Dospem</p></a>
                </li>
                <li class="nav-item">
                  <a href="rekapPembimbinganAdm.php" class="nav-link <?php echo isActive('rekapPembimbinganAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Pembimbingan</p></a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen($_semuaPendaftaran); ?>">
          <a href="#" class="nav-link <?php echo isActive($_semuaPendaftaran); ?>">
            <i class="fas fa-users-cog nav-icon"></i>
            <p>Pendaftaran <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item <?php echo isOpen($_pkl); ?>">
              <a href="#" class="nav-link <?php echo isActive($_pkl); ?>">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>PKL <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item"><a href="pndftrnPklAdm.php" class="nav-link <?php echo isActive('pndftrnPklAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Periode Pendaftaran</p></a></li>
                <li class="nav-item"><a href="plotLembagaPklAdm.php" class="nav-link text-warning <?php echo isActive('plotLembagaPklAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Plotting Lembaga</p></a></li>
                <li class="nav-item"><a href="rekapNilaiPklAdm.php" class="nav-link <?php echo isActive('rekapNilaiPklAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Nilai</p></a></li>
                <li class="nav-item"><a href="rekapDplPklAdm.php" class="nav-link <?php echo isActive('rekapDplPklAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap DPL</p></a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item <?php echo isOpen($_sempro); ?>">
              <a href="#" class="nav-link <?php echo isActive($_sempro); ?>">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>Seminar Proposal <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item"><a href="pndftrnSemproAdm.php" class="nav-link <?php echo isActive('pndftrnSemproAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Periode Pendaftaran</p></a></li>
                <li class="nav-item"><a href="verPndftrSemproAdm.php" class="nav-link <?php echo isActive('verPndftrSemproAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Verifikasi Pendaftar</p></a></li>
                <li class="nav-item"><a href="rekapPndftrSemproAdm.php" class="nav-link <?php echo isActive('rekapPndftrSemproAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Pendaftar</p></a></li>
                <li class="nav-item"><a href="inputJdwlSemproAdm.php" class="nav-link <?php echo isActive('inputJdwlSemproAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Input Jadwal</p></a></li>
                <li class="nav-item"><a href="rekapJdwlSemproAdm.php" class="nav-link <?php echo isActive('rekapJdwlSemproAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Jadwal</p></a></li>
                <li class="nav-item"><a href="rekapBaSemproAdm.php" class="nav-link <?php echo isActive('rekapBaSemproAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Form Berita Acara</p></a></li>
                <li class="nav-item"><a href="rekapNilaiSemproAdm.php" class="nav-link <?php echo isActive('rekapNilaiSemproAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Nilai</p></a></li>
                <li class="nav-item"><a href="rekapPengujiSemproAdm.php" class="nav-link <?php echo isActive('rekapPengujiSemproAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Penguji</p></a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item <?php echo isOpen($_kompre); ?>">
              <a href="#" class="nav-link <?php echo isActive($_kompre); ?>">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>Kompre <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item"><a href="pndftrnKompreAdm.php" class="nav-link <?php echo isActive('pndftrnKompreAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Periode Pendaftaran</p></a></li>
                <li class="nav-item"><a href="rekapNilaiKompreAdm.php" class="nav-link <?php echo isActive('rekapNilaiKompreAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Nilai</p></a></li>
                <li class="nav-item"><a href="rekapPengawasKompreAdm.php" class="nav-link <?php echo isActive('rekapPengawasKompreAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Pengawas</p></a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item <?php echo isOpen($_ujskrip); ?>">
              <a href="#" class="nav-link <?php echo isActive($_ujskrip); ?>">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>Ujian Skripsi <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item"><a href="pndftrnUjskripAdm.php" class="nav-link <?php echo isActive('pndftrnUjskripAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Periode Pendaftaran</p></a></li>
                <li class="nav-item"><a href="verPndftrUjskripAdm.php" class="nav-link <?php echo isActive('verPndftrUjskripAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Verifikasi Pendaftar</p></a></li>
                <li class="nav-item"><a href="rekapPndftrUjskripAdm.php" class="nav-link <?php echo isActive('rekapPndftrUjskripAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Pendaftar</p></a></li>
                <li class="nav-item"><a href="inputJdwlUjskripAdm.php" class="nav-link <?php echo isActive('inputJdwlUjskripAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Input Jadwal</p></a></li>
                <li class="nav-item"><a href="rekapJdwlUjskripAdm.php" class="nav-link <?php echo isActive('rekapJdwlUjskripAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Jadwal</p></a></li>
                <li class="nav-item"><a href="rekapBaUjskripAdm.php" class="nav-link <?php echo isActive('rekapBaUjskripAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Form Berita Acara</p></a></li>
                <li class="nav-item"><a href="rekapNilaiUjskripAdm.php" class="nav-link <?php echo isActive('rekapNilaiUjskripAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Nilai</p></a></li>
                <li class="nav-item"><a href="rekapPengujiUjskripAdm.php" class="nav-link <?php echo isActive('rekapPengujiUjskripAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Rekap Penguji</p></a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item <?php echo isOpen($_bimtek); ?>">
              <a href="#" class="nav-link <?php echo isActive($_bimtek); ?>">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>Bimtek Penulisan TA <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item"><a href="pndftrnBimtekAdm.php" class="nav-link <?php echo isActive('pndftrnBimtekAdm.php'); ?>"><i class="fas fa-ellipsis-v nav-icon"></i><p>Periode Pendaftaran</p></a></li>
                <li class="nav-item"><a href="dataDosenKepakaranAdm.php" class="nav-link <?php echo isActive('dataDosenKepakaranAdm.php'); ?>"><i class="fas fa-user-tie nav-icon"></i><p>Kepakaran Dosen</p></a></li>
                <li class="nav-item"><a href="rekapPraPropBimtekAdm.php" class="nav-link <?php echo isActive('rekapPraPropBimtekAdm.php'); ?>"><i class="fas fa-file-alt nav-icon"></i><p>Rekap Pra Proposal</p></a></li>
              </ul>
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