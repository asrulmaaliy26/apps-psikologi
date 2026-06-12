<?php include("contentsConAdm.php");
$currentPage = basename($_SERVER['PHP_SELF']);
if (!function_exists('isActive')) {
  function isActive($page)
  {
    global $currentPage;
    if (is_array($page)) {
      return in_array($currentPage, $page) ? 'active bg-primary' : '';
    }
    return ($currentPage === $page) ? 'active bg-primary' : '';
  }
}
?>
<aside <?php include("main-sidebar-style.php") ?>>
  <?php include("brandNavAdm.php"); ?>
  <div class="sidebar text-sm">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdminUtama.php" class="nav-link <?php echo isActive('dashboardAdminUtama.php'); ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-header">MANAJEMEN JABATAN</li>
        <li class="nav-item">
          <a href="kelolaJabatanAdm.php" class="nav-link <?php echo isActive('kelolaJabatanAdm.php'); ?>">
            <i class="nav-icon fas fa-list-ul"></i>
            <p>Daftar Jabatan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="kelolaPejabatAdm.php" class="nav-link <?php echo isActive('kelolaPejabatAdm.php'); ?>">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>Tentukan Jabatan User</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="pengaturanTtdAdm.php" class="nav-link <?php echo isActive('pengaturanTtdAdm.php'); ?>">
            <i class="nav-icon fas fa-signature"></i>
            <p>Pengaturan TTD</p>
          </a>
        </li>
        <li class="nav-header">ORGANISASI MAHASISWA</li>
        <li class="nav-item">
          <a href="kelolaKatOrgMhsAdm.php" class="nav-link <?php echo isActive('kelolaKatOrgMhsAdm.php'); ?>">
            <i class="nav-icon fas fa-sitemap"></i>
            <p>Kategori Organisasi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="kelolaRoleOrgMhsAdm.php" class="nav-link <?php echo isActive('kelolaRoleOrgMhsAdm.php'); ?>">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>Role Jabatan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="kelolaPersonaliaOrgMhsAdm.php" class="nav-link <?php echo isActive('kelolaPersonaliaOrgMhsAdm.php'); ?>">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Personalia Org</p>
          </a>
        </li>
        <li class="nav-header">MANAJEMEN MAHASISWA</li>
        <li class="nav-item">
          <a href="kelolaMahasiswaS1Adm.php" class="nav-link <?php echo isActive('kelolaMahasiswaS1Adm.php'); ?>">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Daftar Mahasiswa S1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="kelolaMahasiswaS2Adm.php" class="nav-link <?php echo isActive('kelolaMahasiswaS2Adm.php'); ?>">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Daftar Mahasiswa S2</p>
          </a>
        </li>
        <li class="nav-header">IMPOR DATA</li>
        <li class="nav-item">
          <a href="imporDataMahasiswaS1Adm.php" class="nav-link <?php echo isActive('imporDataMahasiswaS1Adm.php'); ?>">
            <i class="nav-icon fas fa-file-excel"></i>
            <p>Data Mahasiswa S1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="imporUserMahasiswaS1Adm.php" class="nav-link <?php echo isActive('imporUserMahasiswaS1Adm.php'); ?>">
            <i class="nav-icon fas fa-user-plus"></i>
            <p>User Mahasiswa S1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="imporDataMahasiswaS2Adm.php" class="nav-link <?php echo isActive('imporDataMahasiswaS2Adm.php'); ?>">
            <i class="nav-icon fas fa-file-excel"></i>
            <p>Data Mahasiswa S2</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="imporUserMahasiswaS2Adm.php" class="nav-link <?php echo isActive('imporUserMahasiswaS2Adm.php'); ?>">
            <i class="nav-icon fas fa-user-plus"></i>
            <p>User Mahasiswa S2</p>
          </a>
        </li>
        <li class="nav-header">Percatakan</li>
        <li class="nav-item <?php echo isActive(['suratMahasiswaAdm.php', 'suratPegawaiAdm.php']) ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo isActive(['suratMahasiswaAdm.php', 'suratPegawaiAdm.php']); ?>">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
              Tata Persuratan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="suratMahasiswaAdm.php" class="nav-link <?php echo isActive('suratMahasiswaAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Surat Mahasiswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="suratPegawaiAdm.php" class="nav-link <?php echo isActive('suratPegawaiAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Surat Pegawai</p>
              </a>
            </li>
          </ul>
        </li>
        <?php if (isFeatureEnabled('peminjaman_ruangan')) { ?>
        <li class="nav-header">BOOKING RUANGAN</li>
        <li class="nav-item <?php echo isActive(['bmnBookingRuangan.php', 'bmnBookingPersetujuan.php', 'peminjamanRuangUmum.php']) ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo isActive(['bmnBookingRuangan.php', 'bmnBookingPersetujuan.php', 'peminjamanRuangUmum.php']); ?>">
            <i class="nav-icon fas fa-calendar-check"></i>
            <p>
              Booking Ruangan BMN
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="bmnBookingRuangan.php" class="nav-link <?php echo isActive('bmnBookingRuangan.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelola Ruangan Booking</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="bmnBookingPersetujuan.php" class="nav-link <?php echo isActive('bmnBookingPersetujuan.php'); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Persetujuan Booking</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="peminjamanRuangUmum.php" class="nav-link <?php echo isActive(['peminjamanRuangUmum.php','peminjamanRuangForm.php','peminjamanRuangDetail.php']); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Portal Booking Umum</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <li class="nav-header">PENGATURAN SISTEM</li>
        <li class="nav-item">
          <a href="kelolaFiturAdm.php" class="nav-link <?php echo isActive('kelolaFiturAdm.php'); ?>">
            <i class="nav-icon fas fa-toggle-on text-warning"></i>
            <p>Manajemen Fitur</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="pengaturanSistemAdm.php" class="nav-link <?php echo isActive('pengaturanSistemAdm.php'); ?>">
            <i class="nav-icon fas fa-cogs text-info"></i>
            <p>Pengaturan Informasi</p>
          </a>
        </li>
        <li class="nav-header">LAINNYA</li>
        <li class="nav-item">
          <a href="https://docs.google.com/spreadsheets/d/1Rpct62WQy3AFAT5cNIgyP2iaIgFYxGVNPibLIB_RYpg/edit?usp=sharing" target="_blank" class="nav-link text-info">
            <i class="fas fa-headset nav-icon"></i>
            <p>Layanan / Pengaduan</p>
          </a>
        </li>
        <?php if (isFeatureEnabled('kalender_kegiatan')) { ?>
<li class="nav-header">KALENDAR</li>
<li class="nav-item">
  <a href="adminKalender.php" class="nav-link <?php echo isActive('adminKalender.php'); ?>">
    <i class="nav-icon fas fa-calendar-alt"></i>
    <p>Kalender Kegiatan</p>
  </a>
</li>
<?php } ?>
      </ul>
    </nav>
  </div>
</aside>