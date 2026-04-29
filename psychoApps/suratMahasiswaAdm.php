<?php include("contentsConAdm.php"); ?>
<!DOCTYPE html>
<html lang="id">
  <?php include("headAdm.php"); ?>
  <style>
    .letter-card {
      transition: transform 0.3s, box-shadow 0.3s;
      border: none;
      border-radius: 12px;
      overflow: hidden;
    }
    .letter-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .letter-icon {
      font-size: 2.5rem;
      margin-bottom: 15px;
      background: linear-gradient(135deg, #007bff, #00d2ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .btn-preview {
      border-radius: 20px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .card-category {
      font-size: 0.7rem;
      text-transform: uppercase;
      font-weight: bold;
      color: #6c757d;
      margin-bottom: 5px;
      display: block;
    }
  </style>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include("navtopAdm.php");
        include("navSideBarAdminUtama.php");
      ?>
      <div class="content-wrapper text-sm">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="m-0 font-weight-bold"><i class="fas fa-print mr-2 text-primary"></i>Katalog Percetakan Surat</h4>
                <p class="text-muted mt-1">Pilih jenis surat di bawah ini untuk melihat langsung hasil format cetakannya.</p>
              </div>
              <div class="col-sm-6 text-right">
                <span class="badge badge-info p-2"><i class="fas fa-info-circle mr-1"></i> Mode Preview Template</span>
              </div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">
            
            <!-- KATEGORI: OBSERVASI & WAWANCARA -->
            <h5 class="mb-3 mt-4 text-dark font-weight-bold"><i class="fas fa-search mr-2"></i>Izin Observasi & Wawancara</h5>
            <div class="row">
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm">
                  <div class="card-body text-center">
                    <span class="card-category">Individu</span>
                    <i class="fas fa-user-friends letter-icon"></i>
                    <h6 class="font-weight-bold">Izin Observasi & Wawancara (Matkul)</h6>
                    <p class="small text-muted">Surat izin penelitian/observasi untuk tugas mata kuliah secara mandiri.</p>
                    <a href="cetakSiowiAdm.php?id=dummy" target="_blank" class="btn btn-outline-primary btn-sm btn-block btn-preview">
                      <i class="fas fa-eye mr-1"></i> Lihat Hasil Cetak
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm">
                  <div class="card-body text-center">
                    <span class="card-category">Kelompok</span>
                    <i class="fas fa-users letter-icon"></i>
                    <h6 class="font-weight-bold">Izin Observasi & Wawancara (Matkul)</h6>
                    <p class="small text-muted">Surat izin penelitian/observasi tugas kelompok dengan daftar nama anggota.</p>
                    <a href="cetakSiowkAdm.php?id=dummy" target="_blank" class="btn btn-outline-primary btn-sm btn-block btn-preview">
                      <i class="fas fa-eye mr-1"></i> Lihat Hasil Cetak
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm">
                  <div class="card-body text-center">
                    <span class="card-category">Skripsi</span>
                    <i class="fas fa-book-reader letter-icon"></i>
                    <h6 class="font-weight-bold">Izin Observasi Pra Skripsi</h6>
                    <p class="small text-muted">Surat izin pencarian data awal untuk keperluan pengajuan judul skripsi.</p>
                    <a href="cetakPrasipsAdm.php?id=dummy" target="_blank" class="btn btn-outline-primary btn-sm btn-block btn-preview">
                      <i class="fas fa-eye mr-1"></i> Lihat Hasil Cetak
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- KATEGORI: MAGANG & PKL -->
            <h5 class="mb-3 mt-4 text-dark font-weight-bold"><i class="fas fa-briefcase mr-2"></i>Izin Magang & PKL</h5>
            <div class="row">
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm border-left border-info">
                  <div class="card-body text-center">
                    <span class="card-category">Individu</span>
                    <i class="fas fa-user-tie letter-icon text-info" style="background: none; -webkit-text-fill-color: #17a2b8;"></i>
                    <h6 class="font-weight-bold">Izin Magang Mandiri</h6>
                    <p class="small text-muted">Surat permohonan magang di instansi luar secara mandiri/individu.</p>
                    <a href="cetakSimagIndividuAdm.php?id=dummy" target="_blank" class="btn btn-info btn-sm btn-block btn-preview">
                      <i class="fas fa-external-link-alt mr-1"></i> Buka Cetakan
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm border-left border-info">
                  <div class="card-body text-center">
                    <span class="card-category">Kelompok</span>
                    <i class="fas fa-user-group letter-icon text-info" style="background: none; -webkit-text-fill-color: #17a2b8;"></i>
                    <h6 class="font-weight-bold">Izin Magang Mandiri</h6>
                    <p class="small text-muted">Surat permohonan magang kelompok dengan lampiran daftar anggota.</p>
                    <a href="cetakSimagKelompokAdm.php?id=dummy" target="_blank" class="btn btn-info btn-sm btn-block btn-preview">
                      <i class="fas fa-external-link-alt mr-1"></i> Buka Cetakan
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm border-left border-info">
                  <div class="card-body text-center">
                    <span class="card-category">Lokasi</span>
                    <i class="fas fa-map-marked-alt letter-icon text-info" style="background: none; -webkit-text-fill-color: #17a2b8;"></i>
                    <h6 class="font-weight-bold">Izin Tempat (Lokasi) PKL</h6>
                    <p class="small text-muted">Surat permohonan kesediaan tempat untuk pelaksanaan PKL.</p>
                    <a href="cetakSitpAdm.php?id=dummy" target="_blank" class="btn btn-info btn-sm btn-block btn-preview">
                      <i class="fas fa-external-link-alt mr-1"></i> Buka Cetakan
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- KATEGORI: PRAKTIKUM & SKKB -->
            <h5 class="mb-3 mt-4 text-dark font-weight-bold"><i class="fas fa-flask mr-2"></i>Praktikum & Lainnya</h5>
            <div class="row">
              <div class="col-md-3 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm border-bottom border-success">
                  <div class="card-body text-center">
                    <span class="card-category">Testee Siswa</span>
                    <i class="fas fa-vial letter-icon text-success" style="background: none; -webkit-text-fill-color: #28a745;"></i>
                    <h6 class="font-weight-bold">Izin Praktikum (Ind/Kel)</h6>
                    <p class="small text-muted">Surat izin praktikum dengan subjek testee Siswa sekolah.</p>
                    <a href="cetakSiprakisAdm.php?id=dummy" target="_blank" class="btn btn-success btn-sm btn-block btn-preview">
                      <i class="fas fa-file-pdf mr-1"></i> Hasil Cetak
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm border-bottom border-success">
                  <div class="card-body text-center">
                    <span class="card-category">Testee Mahasiswa</span>
                    <i class="fas fa-microscope letter-icon text-success" style="background: none; -webkit-text-fill-color: #28a745;"></i>
                    <h6 class="font-weight-bold">Izin Praktikum (Ind/Kel)</h6>
                    <p class="small text-muted">Surat izin praktikum dengan subjek testee sesama Mahasiswa.</p>
                    <a href="cetakSiprakimAdm.php?id=dummy" target="_blank" class="btn btn-success btn-sm btn-block btn-preview">
                      <i class="fas fa-file-pdf mr-1"></i> Hasil Cetak
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm border-bottom border-danger">
                  <div class="card-body text-center">
                    <span class="card-category">Penelitian</span>
                    <i class="fas fa-graduation-cap letter-icon text-danger" style="background: none; -webkit-text-fill-color: #dc3545;"></i>
                    <h6 class="font-weight-bold">Izin Penelitian Skripsi</h6>
                    <p class="small text-muted">Surat izin pengambilan data utama untuk penelitian skripsi.</p>
                    <a href="cetakSipsAdm.php?id=dummy" target="_blank" class="btn btn-danger btn-sm btn-block btn-preview">
                      <i class="fas fa-file-pdf mr-1"></i> Hasil Cetak
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 mb-4">
                <div class="card letter-card h-100 shadow-sm border-bottom border-warning">
                  <div class="card-body text-center">
                    <span class="card-category">Keterangan</span>
                    <i class="fas fa-user-check letter-icon text-warning" style="background: none; -webkit-text-fill-color: #ffc107;"></i>
                    <h6 class="font-weight-bold">Kelakuan Baik (SKKB)</h6>
                    <p class="small text-muted">Surat Keterangan Kelakuan Baik untuk mahasiswa aktif.</p>
                    <a href="cetakSkkbAdm.php?id=dummy" target="_blank" class="btn btn-warning btn-sm btn-block btn-preview">
                      <i class="fas fa-file-pdf mr-1"></i> Hasil Cetak
                    </a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </section>
      </div>
    </div>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
  </body>
</html>
