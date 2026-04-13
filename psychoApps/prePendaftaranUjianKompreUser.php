<?php include("contentsConAdm.php");
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
$nim = $dataku['nim'];

$qry_moment = "SELECT * FROM pendaftaran_kompre ORDER BY status ASC, id DESC LIMIT 1";
$hasil = mysqli_query($con, $qry_moment);
$data = mysqli_fetch_assoc($hasil);
$id_kompre = $data['id'];
$thp = $data['tahap'];
$jenis_periode = $data['jenis_periode'];
$ta = $data['ta'];

$qry_nm_thp = "SELECT * FROM opsi_tahap_ujian_kompre WHERE id='$thp'";
$hasil = mysqli_query($con, $qry_nm_thp);
$dthp = mysqli_fetch_assoc($hasil);

$qry_jenis_periode = "SELECT * FROM opsi_kategori_periode_kompre WHERE id='$jenis_periode'";
$hasil = mysqli_query($con, $qry_jenis_periode);
$djp = mysqli_fetch_assoc($hasil);

$qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
$hasil = mysqli_query($con, $qry_nm_ta);
$dnta = mysqli_fetch_assoc($hasil);

$qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
$h = mysqli_query($con, $qry_nm_smt);
$dsemester = mysqli_fetch_assoc($h);

$now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
$start = new DateTime($data['start_datetime'] ?? 'now', new DateTimeZone('Asia/Jakarta'));
$end = new DateTime($data['end_datetime'] ?? 'now', new DateTimeZone('Asia/Jakarta'));

$DATE_NOW = $now->format('Y-m-d H:i:s');
$START_DATE = $start->format('Y-m-d H:i:s');
$END_DATE = $end->format('Y-m-d H:i:s');

$dateStart = $start->format('d-m-Y');
$dateEnd = $end->format('d-m-Y');
$timeStart = $start->format('H:i');
$timeEnd = $end->format('H:i');
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarUserS1.php");
    ?>
    <div class="content-wrapper">
      <?php include("alertUser.php"); ?>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 float-left">Pendaftaran</h1>
            </div>
            <div class="col-sm-6">
              <ol class="mt-2 breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Ujian Komprehensif</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm">
              <div class="card card-success card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" href="prePendaftaranUjianKompreUser.php" role="tab" aria-selected="true">Form</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="riwayatPendaftaranUjianKompreUser.php" role="tab" aria-selected="true">Riwayat</a>
                    </li>
                  </ul>
                </div>
                <?php if (!$data || $data['status'] == '2' || $end < $now) {
                  echo
                  '<div class="card-body">
                       <h5>Pendaftaran Ujian Komprehensif Tahap ' . ($dthp['tahap'] ?? '') . ' ' . ($djp['nm'] ?? '') . ' Semester ' . ($dsemester['nama'] ?? '') . ' ' . ($dnta['ta'] ?? '') . ' telah ditutup.</h5>
                      </div>';
                } else if ($start > $now) {
                  echo
                  '<div class="card-body">
                       <h5>Pendaftaran Ujian Komprehensif Tahap ' . ($dthp['tahap'] ?? '') . ' ' . ($djp['nm'] ?? '') . ' Semester ' . ($dsemester['nama'] ?? '') . ' ' . ($dnta['ta'] ?? '') . ' belum dibuka. <br>Pendaftaran dibuka mulai tanggal ' . $dateStart . ' pukul ' . $timeStart . ' sampai dengan tanggal ' . $dateEnd . ' pukul ' . $timeEnd . '.</h5>
                      </div>';
                } else {
                  $cek_dospem = "SELECT COUNT(nim) AS jumData FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]' AND status = '2'";
                  $res = mysqli_query($con, $cek_dospem)  or die(mysqli_error($con));
                  $dt_dospem = mysqli_fetch_assoc($res);

                  $cek_pes_pkl = "SELECT * FROM peserta_pkl WHERE nim='$dataku[nim]' ORDER BY id DESC";
                  $res = mysqli_query($con, $cek_pes_pkl)  or die(mysqli_error($con));
                  $dt_pes_pkl = mysqli_fetch_assoc($res);

                  $qry_grade_pkl = "SELECT * FROM grade_pkl WHERE id_pkl='$dt_pes_pkl[id_pkl]'";
                  $res_grade_pkl = mysqli_query($con, $qry_grade_pkl);
                  $dt_grade_pkl = mysqli_fetch_assoc($res_grade_pkl);

                  $cek_pkl = "SELECT COUNT(nim) AS jumData FROM peserta_pkl WHERE (nim='$dataku[nim]' AND id_pkl='$dt_pes_pkl[id_pkl]') AND (nilai <= '$dt_grade_pkl[dt]' AND nilai >= '$dt_grade_pkl[db]') ORDER BY id DESC";
                  $res = mysqli_query($con, $cek_pkl)  or die(mysqli_error($con));
                  $dt = mysqli_fetch_assoc($res);

                  $cek_pes_sempro = "SELECT * FROM peserta_sempro WHERE nim='$dataku[nim]' ORDER BY id DESC";
                  $res = mysqli_query($con, $cek_pes_sempro)  or die(mysqli_error($con));
                  $dt_pes_sempro = mysqli_fetch_assoc($res);

                  $qry_grade_sempro = "SELECT * FROM grade_sempro WHERE id_sempro='$dt_pes_sempro[id_sempro]'";
                  $res_grade_sempro = mysqli_query($con, $qry_grade_sempro);
                  $dt_grade_sempro = mysqli_fetch_assoc($res_grade_sempro);

                  $cek_sempro = "SELECT COUNT(nim) AS jumData FROM nilai_sempro WHERE (nim='$dataku[nim]' AND id_sempro='$dt_pes_sempro[id_sempro]') AND (mean_nilai <= '$dt_grade_sempro[sut]' AND mean_nilai >= '$dt_grade_sempro[sub]') ORDER BY id DESC";
                  $res = mysqli_query($con, $cek_sempro)  or die(mysqli_error($con));
                  $dt_sempro = mysqli_fetch_assoc($res);

                  $cekbio = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
                  $rbio = mysqli_query($con, $cekbio) or die(mysqli_error($con));
                  $dbio = mysqli_fetch_array($rbio);

                  $myquery1 = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
                  $res1 = mysqli_query($con,  $myquery1) or die(mysqli_error($con));
                  $dataku1 = mysqli_fetch_assoc($res1);
                  $angkatan = $dataku1['angkatan'];
                  $yearnow = date("Y");
                  $monthnow = date("m");
                  $jarakyear = ($yearnow - $angkatan);
                  $jaraksemestergenap = ($monthnow <= 6) + 1 + ($jarakyear * 2);
                  $jaraksemestergasal = ($monthnow > 6) + ($jarakyear * 2);

                  $cekdata = "SELECT nim FROM peserta_kompre WHERE nim='$username' AND id_kompre='$id_kompre'";
                  $ada = mysqli_query($con, $cekdata)  or die(mysqli_error($con));

                  if ($dbio['fakultas_pertama_daftar'] == '' || $dbio['jurusan_pertama_daftar'] == '' || $dbio['jurusan_pertama_daftar'] == '' || $dbio['asal_sekolah'] == '' || $dbio['pend_terakhir'] == '' || $dbio['dosen_wali'] == '' || $dbio['tempat_lahir'] == '' || $dbio['tanggal_lahir'] == '' || $dbio['jenis_kelamin'] == '' || $dbio['alamat_ktp'] == '' || $dbio['alamat_malang'] == '' || $dbio['kntk'] == '' || $dbio['imel'] == '' || $dbio['nama_ayah'] == '' || $dbio['alamat_ayah'] == '' || $dbio['telepon_ayah'] == '' || $dbio['nama_ibu'] == '' || $dbio['pekerjaan_ibu'] == '' || $dbio['alamat_ibu'] == '' || $dbio['telepon_ibu'] == '' || $dbio['photo'] == '') {
                    echo
                    '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Cek dan lengkapi isian biodata terlebih dahulu di menu Profil.</h5>
                           </div>';
                  } else if ($jaraksemestergasal < 7) {
                    echo
                    '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda sekarang masih semester ' . $jaraksemestergasal . '.</h5>
                           </div>';
                  } else if ($jaraksemestergenap < 7) {
                    echo
                    '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda sekarang masih semester ' . $jaraksemestergenap . '.</h5>
                           </div>';
                  } else if ($dt_dospem['jumData'] < 1) {
                    echo
                    '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda belum mendapatkan Dosen Pembimbing Skripsi.</h5>
                           </div>';
                  } else if ($dt['jumData'] >= 1) {
                    echo
                    '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda dinyatakan belum lulus atau belum mengikuti atau nilai Praktik Kerja Lapangan (PKL) belum lengkap. Silahkan lihat Riwayat Pendaftaran Praktik Kerja Lapangan (PKL).</h5>
                           </div>';
                  } else if ($dt_sempro['jumData'] >= 1) {
                    echo
                    '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda dinyatakan belum lulus atau belum mengikuti atau nilai Seminar Proposal Skripsi belum lengkap. Silahkan lihat Riwayat Pendaftaran Seminar Proposal Skripsi.</h5>
                           </div>';
                  } else {
                    $cekIsian = "SELECT * FROM peserta_kompre WHERE nim='$username' AND id_kompre='$id_kompre'";
                    $r = mysqli_query($con, $cekIsian)  or die(mysqli_error($con));
                    $adaIsian = mysqli_fetch_assoc($r);

                    if (empty($adaIsian['id_kompre']) && empty($adaIsian['nim'])) {
                      include("formPendaftaranKompreUserSatu.php");
                    } else if (empty($adaIsian['file_transkrip_nilai'])) {
                      include("formPendaftaranKompreUserDua.php");
                    } else if (!empty($adaIsian['id_kompre']) && !empty($adaIsian['nim']) && !empty($adaIsian['file_transkrip_nilai'])) {
                      echo
                      '<div class="card-body">
                             <h5>Anda telah submit. Silahkan lihat di menu riwayat.</h5>
                           </div>';
                    }
                  }
                } ?>
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