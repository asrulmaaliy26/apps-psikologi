<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  $nim = $dataku['nim'];

  $qry_moment = "SELECT * FROM pendaftaran_skripsi WHERE status='1'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_ujskrip=$data['id'];
  $thp=$data['tahap'];
  $ta=$data['ta'];
   
  $qry_nm_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$thp'";
  $hasil = mysqli_query($con, $qry_nm_thp);
  $dthp = mysqli_fetch_assoc($hasil);

  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);

  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
   
  $DATE_NOW=date("Y-m-d H:m:s");
  $START_DATE=date($data['start_datetime']); 
  $END_DATE=date($data['end_datetime']);
   
  $SPLIT_START_DATE=date_create($data['start_datetime']); 
  $SPLIT_END_DATE=date_create($data['end_datetime']);
      
  $dateStart = date_format($SPLIT_START_DATE,"d-m-Y");
  $dateEnd = date_format($SPLIT_END_DATE,"d-m-Y");
  $timeStart = date_format($SPLIT_START_DATE,"H:i");
  $timeEnd = date_format($SPLIT_END_DATE,"H:i");
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarUserS1.php" );
        ?> 
      <div class="content-wrapper">
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 float-left">Pendaftaran</h1>
              </div>
              <div class="col-sm-6">
                <ol class="mt-2 breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Ujian Skripsi</li>
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
                        <a class="nav-link active" href="prePendaftaranUjianSkripsiUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="riwayatPendaftaranUjianSkripsiUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                    </ul>
                  </div>
                  <?php if($END_DATE < $DATE_NOW) { echo 
                    '<div class="card-body">
                       <h5>Pendaftaran Ujian Skripsi Tahap '.$dthp['tahap'].' Semester '.$dsemester['nama'].' '.$dnta['ta'].' telah ditutup.</h5>
                      </div>';}
                    else if($START_DATE > $DATE_NOW) {echo 
                    '<div class="card-body">
                       <h5>Pendaftaran Ujian Skripsi Tahap '.$dthp['tahap'].' Semester '.$dsemester['nama'].' '.$dnta['ta'].' belum dibuka. <br>Pendaftaran dibuka mulai tanggal '.$dateStart.' pukul '.$timeStart.' sampai dengan tanggal '.$dateEnd.' pukul '.$timeEnd.'.</h5>
                      </div>';}
                      else {
                        $cek_dospem="SELECT COUNT(nim) AS jumData FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]' AND status = '2'";
                        $res=mysqli_query($con, $cek_dospem)  or die(mysqli_error($con));
                        $dt_dospem=mysqli_fetch_assoc($res);

                        $cek_pes_pkl="SELECT * FROM peserta_pkl WHERE nim='$dataku[nim]' ORDER BY id DESC";
                        $res=mysqli_query($con, $cek_pes_pkl)  or die(mysqli_error($con));
                        $dt_pes_pkl=mysqli_fetch_assoc($res);

                        $qry_grade_pkl = "SELECT * FROM grade_pkl WHERE id_pkl='$dt_pes_pkl[id_pkl]'";
                        $res_grade_pkl = mysqli_query($con, $qry_grade_pkl);
                        $dt_grade_pkl = mysqli_fetch_assoc($res_grade_pkl);

                        $cek_pkl="SELECT COUNT(nim) AS jumData FROM peserta_pkl WHERE (nim='$dataku[nim]' AND id_pkl='$dt_pes_pkl[id_pkl]') AND (nilai <= '$dt_grade_pkl[dt]' AND nilai >= '$dt_grade_pkl[db]') ORDER BY id DESC";
                        $res=mysqli_query($con, $cek_pkl)  or die(mysqli_error($con));
                        $dt=mysqli_fetch_assoc($res);

                        $cek_pes_sempro="SELECT * FROM peserta_sempro WHERE nim='$dataku[nim]' ORDER BY id DESC";
                        $res=mysqli_query($con, $cek_pes_sempro)  or die(mysqli_error($con));
                        $dt_pes_sempro=mysqli_fetch_assoc($res);

                        $qry_grade_sempro = "SELECT * FROM grade_sempro WHERE id_sempro='$dt_pes_sempro[id_sempro]'";
                        $res_grade_sempro = mysqli_query($con, $qry_grade_sempro);
                        $dt_grade_sempro = mysqli_fetch_assoc($res_grade_sempro);

                        $cek_sempro="SELECT COUNT(nim) AS jumData FROM nilai_sempro WHERE (nim='$dataku[nim]' AND id_sempro='$dt_pes_sempro[id_sempro]') AND (mean_nilai <= '$dt_grade_sempro[sut]' AND mean_nilai >= '$dt_grade_sempro[sub]') ORDER BY id DESC";
                        $res=mysqli_query($con, $cek_sempro)  or die(mysqli_error($con));
                        $dt_sempro=mysqli_fetch_assoc($res);

                        $cek_pes_kompre="SELECT * FROM peserta_kompre WHERE nim='$dataku[nim]' ORDER BY id DESC";
                        $res=mysqli_query($con, $cek_pes_kompre)  or die(mysqli_error($con));
                        $dt_pes_kompre=mysqli_fetch_assoc($res);

                        $qry_grade_kompre = "SELECT * FROM grade_kompre WHERE id_kompre='$dt_pes_kompre[id_kompre]'";
                        $res_grade_kompre = mysqli_query($con, $qry_grade_kompre);
                        $dt_grade_kompre = mysqli_fetch_assoc($res_grade_kompre);

                        $cek_kompre="SELECT COUNT(nim) AS jumData FROM peserta_kompre WHERE (nim='$dataku[nim]' AND id_kompre='$dt_pes_kompre[id_kompre]') AND (hasil_ujian <= '$dt_grade_kompre[dt]' AND hasil_ujian >= '$dt_grade_kompre[db]') ORDER BY id DESC";
                        $res=mysqli_query($con, $cek_kompre)  or die(mysqli_error($con));
                        $dt_kompre=mysqli_fetch_assoc($res);

                        $cek_skkm="SELECT COUNT(nim) AS jumData FROM skkm WHERE nim='$dataku[nim]'";
                        $res=mysqli_query($con, $cek_skkm)  or die(mysqli_error($con));
                        $dt_skkm=mysqli_fetch_assoc($res);

                        $cekbio = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
                        $rbio = mysqli_query($con, $cekbio) or die( mysqli_error($con));
                        $dbio = mysqli_fetch_array($rbio);
                    
                        $myquery1 = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
                        $res1 = mysqli_query($con,  $myquery1 )or die( mysqli_error($con) );
                        $dataku1 = mysqli_fetch_assoc( $res1 );
                        $angkatan=$dataku1['angkatan'];
                        $yearnow=date("Y");
                        $monthnow=date("m");
                        $jarakyear=($yearnow - $angkatan);
                        $jaraksemestergenap=($monthnow <=6)+1+($jarakyear * 2);
                        $jaraksemestergasal=($monthnow >6)+($jarakyear * 2);

                        $cekdata="SELECT nim FROM peserta_ujskrip WHERE nim='$username' AND id_ujskrip='$id_ujskrip'";
                        $ada=mysqli_query($con, $cekdata)  or die(mysqli_error($con));
                    
                        if($dbio['fakultas_pertama_daftar']=='' || $dbio['jurusan_pertama_daftar']=='' || $dbio['jurusan_pertama_daftar']==''|| $dbio['asal_sekolah']=='' || $dbio['pend_terakhir']=='' || $dbio['dosen_wali']=='' || $dbio['tempat_lahir']=='' || $dbio['tanggal_lahir']=='' || $dbio['jenis_kelamin']=='' || $dbio['alamat_ktp']=='' || $dbio['alamat_malang']=='' || $dbio['kntk']=='' || $dbio['imel']=='' || $dbio['nama_ayah']=='' || $dbio['alamat_ayah']=='' || $dbio['telepon_ayah']=='' || $dbio['nama_ibu']=='' || $dbio['pekerjaan_ibu']=='' || $dbio['alamat_ibu']=='' || $dbio['telepon_ibu']=='' || $dbio['photo']=='') { echo 
                          '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Cek dan lengkapi isian biodata terlebih dahulu di menu Profil.</h5>
                           </div>';}
                        else if($jaraksemestergasal <7)  { echo 
                          '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda sekarang masih semester '.$jaraksemestergasal.'.</h5>
                           </div>';}
                        else if($jaraksemestergenap <7)  { echo 
                          '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda sekarang masih semester '.$jaraksemestergenap.'.</h5>
                           </div>';}
                        else if($dt_dospem['jumData'] < 1) { echo
                          '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda belum mendapatkan Dosen Pembimbing Skripsi.</h5>
                           </div>';}
                        else if($dt['jumData'] >= 1) { echo
                          '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda dinyatakan belum lulus atau belum mengikuti atau nilai Praktik Kerja Lapangan (PKL) belum lengkap. Silahkan lihat Riwayat Pendaftaran Praktik Kerja Lapangan (PKL).</h5>
                           </div>';}
                        else if($dt_sempro['jumData'] >= 1) { echo
                          '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda dinyatakan belum lulus atau belum mengikuti atau nilai Seminar Proposal Skripsi belum lengkap. Silahkan lihat Riwayat Pendaftaran Seminar Proposal Skripsi.</h5>
                           </div>';}
                        else if($dt_kompre['jumData'] >= 1) { echo
                          '<div class="card-body">
                             <h5>Tidak bisa mendaftar! Anda dinyatakan belum lulus atau belum mengikuti atau nilai Ujian Skripsi belum lengkap. Silahkan lihat Riwayat Pendaftaran Ujian Skripsi.</h5>
                           </div>';}
                  // else if($dt_skkm['jumData'] < 1) { echo
                  //   '<div class="card-body">
                  //      <h5>Tidak bisa mendaftar! Anda belum mengisi SKKM (Satuan Kredit Kegiatan Mahasiswa).</h5>
                  //    </div>';}
                        else {
                          $cekIsian="SELECT * FROM peserta_ujskrip WHERE nim='$username' AND id_ujskrip='$id_ujskrip'";
                          $r=mysqli_query($con, $cekIsian)  or die(mysqli_error($con));
                          $adaIsian = mysqli_fetch_assoc( $r );
                          
                          if(empty($adaIsian['id_ujskrip']) && empty($adaIsian['nim'])) {
                          include ("formPendaftaranUjskripUserSatu.php");}

                          else if(empty($adaIsian['file_skripsi'])) {
                          include ("formPendaftaranUjskripUserDua.php");}

                          else if(!empty($adaIsian['id_ujskrip']) && !empty($adaIsian['nim']) && !empty($adaIsian['file_skripsi'])) { echo
                          '<div class="card-body">
                             <h5>Anda telah submit. Silahkan lihat di menu riwayat.</h5>
                           </div>';}
                        }
                        }?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>
