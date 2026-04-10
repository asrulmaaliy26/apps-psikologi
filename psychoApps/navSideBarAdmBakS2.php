<?php include( "contentsConAdm.php" );?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-xs">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdmBakS2.php" class="nav-link active">
            <i class="nav-icon fas fa-house-user"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-file-invoice nav-icon"></i>
            <p>
              Pengajuan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Peminatan Rumpun Psikologi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="magPeriodePprpAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Periode Pengajuan
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magEditPprpAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Edit Pengajuan
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magVerPprpAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Verifikasi Pengajuan
                    </p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Academic Coach
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="magPeriodePacAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Periode Pengajuan
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magPersonalAcAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Personal Academic Coach
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magEditPacAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Edit Pengajuan
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magVerPacAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Verifikasi Pengajuan
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magAktivitasAcAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Aktivitas Academic Coach
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magProsesPacAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Proses Coaching Mahasiswa
                    </p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Dosen Pembimbing Tesis
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="magPeriodePptAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Periode Pengajuan
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magPersonalPtAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Personal Dospem Tesis
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magVerPptAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Verifikasi Pengajuan
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magAktivitasAcAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Aktivitas Academic Coach
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="magProsesPacAdm.php" class="nav-link">
                    <i class="fas fa-sun nav-icon"></i>
                    <p>
                      Proses Coaching Mahasiswa
                    </p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-person-booth nav-icon"></i>
            <p>
              Pendaftaran
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="magRekapPendSemproAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Seminar Proposal Tesis
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magRekapPendUjtesAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Ujian Tesis
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-tasks nav-icon"></i>
            <p>
              Daftar Revisi
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="magRekapRevisiProAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Seminar Proposal Tesis
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magRekapRevisiTesAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Ujian Tesis
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-database nav-icon"></i>
            <p>
              Master Data
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="magRekapDosenAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Dosen
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magRekapMhsswAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Mahasiswa
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magKontakLayananAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Kontak Layanan
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magRekapJudulPropAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Judul Proposal
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magRekapJudulTesisAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Judul Tesis
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magVariabelxyAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Bank Variabel
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-user-cog nav-icon"></i>
            <p>
              SOP
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="magSopPprpAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Peminatan Rumpun Psikologi
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magSopPacAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Academic Coach
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magSopPptAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Pembimbing Tesis
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magSopPsptAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Seminar Proposal Tesis
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magSopPutAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Ujian Tesis
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magSopSrsptAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Submit Revisi Sempro
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magSopSrutAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Submit Revisi Ujian Tesis
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-cloud nav-icon"></i>
            <p>
              Upload
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item menu-open">
              <a href="magRekapBerkasAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Berkas
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <a href="magRekapPengumumanAdm.php" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Pengumuman
                </p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>