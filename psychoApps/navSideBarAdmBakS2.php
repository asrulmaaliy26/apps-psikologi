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
$_pngjn = ['magPeriodePprpAdm.php','magEditPprpAdm.php','magVerPprpAdm.php','magPeriodePacAdm.php','magPersonalAcAdm.php','magEditPacAdm.php','magVerPacAdm.php','magAktivitasAcAdm.php','magProsesPacAdm.php','magPeriodePptAdm.php','magPersonalPtAdm.php','magVerPptAdm.php'];
$_pend = ['magRekapPendSemproAdm.php','magRekapPendUjtesAdm.php'];
$_revisi = ['magRekapRevisiProAdm.php','magRekapRevisiTesAdm.php'];
$_master = ['magRekapDosenAdm.php','magRekapMhsswAdm.php','magKontakLayananAdm.php','magRekapJudulPropAdm.php','magRekapJudulTesisAdm.php','magVariabelxyAdm.php'];
$_sop = ['magSopPprpAdm.php','magSopPacAdm.php','magSopPptAdm.php','magSopPsptAdm.php','magSopPutAdm.php','magSopSrsptAdm.php','magSopSrutAdm.php'];
$_upload = ['magRekapBerkasAdm.php','magRekapPengumumanAdm.php'];
?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-xs">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="../simagis/dashboardAdm.php" class="nav-link bg-info">
            <i class="nav-icon fas fa-arrow-circle-left"></i>
            <p>Kembali ke SIMAGIS</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="dashboardAdmBakS2.php" class="nav-link <?php echo isActive('dashboardAdmBakS2.php'); ?>">
            <i class="nav-icon fas fa-house-user"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?php echo isOpen($_pngjn); ?>">
          <a href="#" class="nav-link <?php echo isActive($_pngjn); ?>">
            <i class="fas fa-file-invoice nav-icon"></i>
            <p>Pengajuan <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item <?php echo isOpen(['magPeriodePprpAdm.php','magEditPprpAdm.php','magVerPprpAdm.php']); ?>">
              <a href="#" class="nav-link <?php echo isActive(['magPeriodePprpAdm.php','magEditPprpAdm.php','magVerPprpAdm.php']); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Peminatan Rumpun Psikologi <i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item">
                  <a href="magPeriodePprpAdm.php" class="nav-link <?php echo isActive('magPeriodePprpAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Periode Pengajuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magEditPprpAdm.php" class="nav-link <?php echo isActive('magEditPprpAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Edit Pengajuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magVerPprpAdm.php" class="nav-link <?php echo isActive('magVerPprpAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Verifikasi Pengajuan</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item <?php echo isOpen(['magPeriodePacAdm.php','magPersonalAcAdm.php','magEditPacAdm.php','magVerPacAdm.php','magAktivitasAcAdm.php','magProsesPacAdm.php']); ?>">
              <a href="#" class="nav-link <?php echo isActive(['magPeriodePacAdm.php','magPersonalAcAdm.php','magEditPacAdm.php','magVerPacAdm.php','magAktivitasAcAdm.php','magProsesPacAdm.php']); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Academic Coach <i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item">
                  <a href="magPeriodePacAdm.php" class="nav-link <?php echo isActive('magPeriodePacAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Periode Pengajuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magPersonalAcAdm.php" class="nav-link <?php echo isActive('magPersonalAcAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Personal Academic Coach</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magEditPacAdm.php" class="nav-link <?php echo isActive('magEditPacAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Edit Pengajuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magVerPacAdm.php" class="nav-link <?php echo isActive('magVerPacAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Verifikasi Pengajuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magAktivitasAcAdm.php" class="nav-link <?php echo isActive('magAktivitasAcAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Aktivitas Academic Coach</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magProsesPacAdm.php" class="nav-link <?php echo isActive('magProsesPacAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Proses Coaching Mahasiswa</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item <?php echo isOpen(['magPeriodePptAdm.php','magPersonalPtAdm.php','magVerPptAdm.php']); ?>">
              <a href="#" class="nav-link <?php echo isActive(['magPeriodePptAdm.php','magPersonalPtAdm.php','magVerPptAdm.php']); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Dosen Pembimbing Tesis <i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview" style="display: block;">
                <li class="nav-item">
                  <a href="magPeriodePptAdm.php" class="nav-link <?php echo isActive('magPeriodePptAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Periode Pengajuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magPersonalPtAdm.php" class="nav-link <?php echo isActive('magPersonalPtAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Personal Dospem Tesis</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magVerPptAdm.php" class="nav-link <?php echo isActive('magVerPptAdm.php'); ?>">
                    <i class="fas fa-sun nav-icon"></i><p>Verifikasi Pengajuan</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen($_pend); ?>">
          <a href="#" class="nav-link <?php echo isActive($_pend); ?>">
            <i class="fas fa-person-booth nav-icon"></i>
            <p>Pendaftaran <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="magRekapPendSemproAdm.php" class="nav-link <?php echo isActive('magRekapPendSemproAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Seminar Proposal Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magRekapPendUjtesAdm.php" class="nav-link <?php echo isActive('magRekapPendUjtesAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Ujian Tesis</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen($_revisi); ?>">
          <a href="#" class="nav-link <?php echo isActive($_revisi); ?>">
            <i class="fas fa-tasks nav-icon"></i>
            <p>Daftar Revisi <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="magRekapRevisiProAdm.php" class="nav-link <?php echo isActive('magRekapRevisiProAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Seminar Proposal Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magRekapRevisiTesAdm.php" class="nav-link <?php echo isActive('magRekapRevisiTesAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Ujian Tesis</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen($_master); ?>">
          <a href="#" class="nav-link <?php echo isActive($_master); ?>">
            <i class="fas fa-database nav-icon"></i>
            <p>Master Data <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="magRekapDosenAdm.php" class="nav-link <?php echo isActive('magRekapDosenAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Dosen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magRekapMhsswAdm.php" class="nav-link <?php echo isActive('magRekapMhsswAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Mahasiswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magKontakLayananAdm.php" class="nav-link <?php echo isActive('magKontakLayananAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Kontak Layanan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magRekapJudulPropAdm.php" class="nav-link <?php echo isActive('magRekapJudulPropAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Judul Proposal</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magRekapJudulTesisAdm.php" class="nav-link <?php echo isActive('magRekapJudulTesisAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Judul Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magVariabelxyAdm.php" class="nav-link <?php echo isActive('magVariabelxyAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Bank Variabel</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen($_sop); ?>">
          <a href="#" class="nav-link <?php echo isActive($_sop); ?>">
            <i class="fas fa-user-cog nav-icon"></i>
            <p>SOP <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="magSopPprpAdm.php" class="nav-link <?php echo isActive('magSopPprpAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Peminatan Rumpun Psikologi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magSopPacAdm.php" class="nav-link <?php echo isActive('magSopPacAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Academic Coach</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magSopPptAdm.php" class="nav-link <?php echo isActive('magSopPptAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Pembimbing Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magSopPsptAdm.php" class="nav-link <?php echo isActive('magSopPsptAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Seminar Proposal Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magSopPutAdm.php" class="nav-link <?php echo isActive('magSopPutAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Ujian Tesis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magSopSrsptAdm.php" class="nav-link <?php echo isActive('magSopSrsptAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Submit Revisi Sempro</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magSopSrutAdm.php" class="nav-link <?php echo isActive('magSopSrutAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Submit Revisi Ujian Tesis</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo isOpen($_upload); ?>">
          <a href="#" class="nav-link <?php echo isActive($_upload); ?>">
            <i class="fas fa-cloud nav-icon"></i>
            <p>Upload <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: block;">
            <li class="nav-item">
              <a href="magRekapBerkasAdm.php" class="nav-link <?php echo isActive('magRekapBerkasAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Berkas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="magRekapPengumumanAdm.php" class="nav-link <?php echo isActive('magRekapPengumumanAdm.php'); ?>">
                <i class="far fa-circle nav-icon"></i><p>Pengumuman</p>
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