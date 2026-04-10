<?php include("contentsConAdm.php");
  $qry_jumAktif = "SELECT COUNT(id) AS jumData FROM dt_pegawai WHERE jenis_pegawai='1' AND status='1'";
  $r_jumAktif = mysqli_query($con, $qry_jumAktif);
  $d_jumAktif = mysqli_fetch_assoc($r_jumAktif);
  
  $qry_jumTidakAktif = "SELECT COUNT(id) AS jumData FROM dt_pegawai WHERE jenis_pegawai='1' AND status='2'";
  $r_jumTidakAktif = mysqli_query($con, $qry_jumTidakAktif);
  $d_jumTidakAktif = mysqli_fetch_assoc($r_jumTidakAktif);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmKepeg.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                  echo '
                  <div class="alert alert-danger d-none" role="alert" id="alert">
                  <span>Input data gagal! NIP sudah terdaftar!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Submit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Edit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Delete data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}              
              ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Data Pegawai</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Data Dosen</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dtDosen.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT 
          dpeg.id,
          dpeg.kat_pegawai,
          dpeg.tgl_cpns,
          dpeg.tmt,
          dpeg.jenis_pegawai,
          dpeg.pangkat,
          dpeg.jabatan,
          dpeg.jabatan_instansi,
          dpeg.kepakaran_minor,
          dpeg.kepakaran_mayor,
          dpeg.trend_riset,
          dpeg.profil_riset_terkini,
          dpeg.mengajar_pasca,
          dpeg.menguji_sempro_tesis,
          dpeg.menguji_ujian_tesis,
          dpeg.status,
          dpeg.nama,
          dpeg.nama_tg,
          dpeg.tempat_lahir,
          dpeg.tanggal_lahir,
          dpeg.alamat_ktp,
          dpeg.alamat_rumah,
          dpeg.jenis_kelamin,
          dpeg.kntk1,
          dpeg.kntk2,
          dpeg.email1,
          dpeg.email2,
          dpeg.photo,
          dpeg.strata1,
          dpeg.th_s1,
          dpeg.strata2,
          dpeg.th_s2,
          dpeg.strata3,
          dpeg.th_s3,
          dpeg.guru_bsr,
          dpeg.th_gb,
          dpeg.tgl_3a,
          dpeg.tgl_3b,
          dpeg.tgl_3c,
          dpeg.tgl_3d,
          dpeg.tgl_4a,
          dpeg.tgl_4b,
          dpeg.tgl_4c,
          dpeg.tgl_4d,
          dpeg.tgl_4e,
          dpeg.password
          
          FROM dt_pegawai dpeg
          LEFT JOIN opsi_kat_pegawai okp
          on dpeg.kat_pegawai = okp.id
          LEFT JOIN opsi_jenis_pegawai ojp
          on dpeg.jenis_pegawai = ojp.id
          LEFT JOIN opsi_pangkat op
          on dpeg.pangkat = op.id
          LEFT JOIN opsi_jabatan oj
          on dpeg.jabatan = oj.id
          LEFT JOIN opsi_jabatan_instansi oji
          on dpeg.jabatan_instansi = oji.id
          LEFT JOIN opsi_kepakaran_mayor okm
          on dpeg.kepakaran_mayor = okm.id
          LEFT JOIN opsi_mengajar_pasca omp
          on dpeg.mengajar_pasca = omp.id
          LEFT JOIN opsi_menguji_sempro_tesis omst
          on dpeg.menguji_sempro_tesis = omst.id
          LEFT JOIN opsi_menguji_ujian_tesis omut
          on dpeg.menguji_ujian_tesis = omut.id
          LEFT JOIN opsi_status_pegawai osp
          on dpeg.status = osp.id
          LEFT JOIN dt_kota dk
          on dpeg.tempat_lahir = dk.id
          LEFT JOIN opsi_jenis_kelamin ojk
          on dpeg.jenis_kelamin = ojk.id
          
          WHERE (dpeg.id LIKE '%$keyword%' OR dpeg.tgl_cpns LIKE '%$keyword%' OR dpeg.tmt LIKE '%$keyword%' OR dpeg.kepakaran_minor LIKE '%$keyword%' OR dpeg.trend_riset LIKE '%$keyword%' OR dpeg.profil_riset_terkini LIKE '%$keyword%' OR dpeg.nama LIKE '%$keyword%' OR dpeg.nama_tg LIKE '%$keyword%' OR dpeg.alamat_ktp LIKE '%$keyword%' OR dpeg.alamat_rumah LIKE '%$keyword%' OR dpeg.kntk1 LIKE '%$keyword%' OR dpeg.kntk2 LIKE '%$keyword%' OR dpeg.email1 LIKE '%$keyword%' OR dpeg.email2 LIKE '%$keyword%' OR dpeg.strata1 LIKE '%$keyword%' OR dpeg.th_s1 LIKE '%$keyword%' OR dpeg.strata2 LIKE '%$keyword%' OR dpeg.th_s2 LIKE '%$keyword%' OR dpeg.strata3 LIKE '%$keyword%' OR dpeg.th_s3 LIKE '%$keyword%' OR dpeg.guru_bsr LIKE '%$keyword%' OR dpeg.th_gb LIKE '%$keyword%' OR dpeg.tgl_3b LIKE '%$keyword%' OR dpeg.tgl_3c LIKE '%$keyword%' OR dpeg.tgl_3d LIKE '%$keyword%' OR dpeg.tgl_4a LIKE '%$keyword%' OR dpeg.tgl_4b LIKE '%$keyword%' OR dpeg.tgl_4c LIKE '%$keyword%' OR dpeg.tgl_4d LIKE '%$keyword%' OR dpeg.tgl_4e LIKE '%$keyword%' OR okp.nm LIKE '%$keyword%' OR ojp.nm LIKE '%$keyword%' OR op.nm_pangkat LIKE '%$keyword%' OR oj.nm LIKE '%$keyword%' OR oji.nm LIKE '%$keyword%' OR okm.nm LIKE '%$keyword%' OR omp.nm LIKE '%$keyword%' OR omst.nm LIKE '%$keyword%' OR omut.nm LIKE '%$keyword%' OR osp.nm LIKE '%$keyword%' OR dk.nm_kota LIKE '%$keyword%' OR ojk.nm LIKE '%$keyword%') AND (jenis_pegawai='1') ORDER BY dpeg.nama_tg ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dtDosen.php?pagination=true";
          $sql = "SELECT * FROM dt_pegawai WHERE jenis_pegawai='1' ORDER BY nama_tg ASC";
          $result = mysqli_query($con, $sql);
          }
          
          $rpp = 100;
          $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
          $tcount = mysqli_num_rows($result);
          $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
          $count = 0;
          $i = ($page-1)*$rpp;
          $no_urut = ($page-1)*$rpp;
          ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm mb-2">
                <form method="post" action="dtDosen.php">
                  <?php error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){
                        ?>
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dtDosen.php"><i class="fas fa-sync"></i> Kembali</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Data Dosen || Aktif: <span class="badge badge-success"><?php echo $d_jumAktif['jumData'];?> Orang</span>, Tidak Aktif: <span class="badge badge-danger"><?php echo $d_jumTidakAktif['jumData'];?> Orang</span></h4>
                      <button type="button" class="btn btn-outline-success btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="far fa-plus-square"></i> Input Data Dosen</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="24%">Nama</th>
                          <th width="16%">NIP</th>
                          <th width="38%">Pangkat * Jabatan</th>
                          <th width="10%">Status</th>
                          <th class="pr-1 text-center" colspan="2">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id= $data['id'];
                            $tgl_lahir = strtotime($data['tanggal_lahir']);
                            $new_tgl_lahir = date("d-m-Y", $tgl_lahir);
                            $tgl_cpns = strtotime($data['tgl_cpns']);
                            $new_tgl_cpns = date("d-m-Y", $tgl_cpns);
                            $tmt = strtotime($data['tmt']);
                            $new_tmt = date("d-m-Y", $tmt);
                            $tgl_3a = strtotime($data['tgl_3a']);
                            $new_tgl_3a = date("d-m-Y", $tgl_3a);
                            $tgl_3b = strtotime($data['tgl_3b']);
                            $new_tgl_3b = date("d-m-Y", $tgl_3b);
                            $tgl_3c = strtotime($data['tgl_3c']);
                            $new_tgl_3c = date("d-m-Y", $tgl_3c);
                            $tgl_3d = strtotime($data['tgl_3d']);
                            $new_tgl_3d = date("d-m-Y", $tgl_3d);
                            $tgl_4a = strtotime($data['tgl_4a']);
                            $new_tgl_4a = date("d-m-Y", $tgl_4a);
                            $tgl_4b = strtotime($data['tgl_4b']);
                            $new_tgl_4b = date("d-m-Y", $tgl_4b);
                            $tgl_4c = strtotime($data['tgl_4c']);
                            $new_tgl_4c = date("d-m-Y", $tgl_4c);
                            $tgl_4d = strtotime($data['tgl_4d']);
                            $new_tgl_4d = date("d-m-Y", $tgl_4d);
                            $tgl_4e = strtotime($data['tgl_4e']);
                            $new_tgl_4e = date("d-m-Y", $tgl_4e);
                            
                            $th_s1 = strtotime($data['th_s1']);
                            $new_th_s1 = date("d-m-Y", $th_s1);
                            $th_s2 = strtotime($data['th_s2']);
                            $new_th_s2 = date("d-m-Y", $th_s2);
                            $th_s3 = strtotime($data['th_s3']);
                            $new_th_s3 = date("d-m-Y", $th_s3);
                            $th_gb = strtotime($data['th_gb']);
                            $new_th_gb = date("d-m-Y", $th_gb);
                            
                            $qkatpegawai =  "SELECT * FROM opsi_kat_pegawai WHERE id='$data[kat_pegawai]'";
                            $rkatpegawai = mysqli_query($con, $qkatpegawai);
                            $dkatpegawai = mysqli_fetch_array($rkatpegawai);
                            
                            $qjenispegawai =  "SELECT * FROM opsi_jenis_pegawai WHERE id='$data[jenis_pegawai]'";
                            $rjenispegawai = mysqli_query($con, $qjenispegawai);
                            $djenispegawai = mysqli_fetch_array($rjenispegawai);
                            
                            $qpangkat =  "SELECT * FROM opsi_pangkat WHERE id='$data[pangkat]'";
                            $rpangkat = mysqli_query($con, $qpangkat);
                            $dpangkat = mysqli_fetch_array($rpangkat);
                            
                            $qjabatan =  "SELECT * FROM opsi_jabatan WHERE id='$data[jabatan]'";
                            $rjabatan = mysqli_query($con, $qjabatan);
                            $djabatan = mysqli_fetch_array($rjabatan);
                            
                            $qjabataninstansi =  "SELECT * FROM opsi_jabatan_instansi WHERE id='$data[jabatan_instansi]'";
                            $rjabataninstansi = mysqli_query($con, $qjabataninstansi);
                            $djabataninstansi = mysqli_fetch_array($rjabataninstansi);
                            
                            $qkepakaranmayor =  "SELECT * FROM opsi_kepakaran_mayor WHERE id='$data[kepakaran_mayor]'";
                            $rkepakaranmayor = mysqli_query($con, $qkepakaranmayor);
                            $dkepakaranmayor = mysqli_fetch_array($rkepakaranmayor);
                            
                            $qmengajarpasca =  "SELECT * FROM opsi_mengajar_pasca WHERE id='$data[mengajar_pasca]'";
                            $rmengajarpasca = mysqli_query($con, $qmengajarpasca);
                            $dmengajarpasca = mysqli_fetch_array($rmengajarpasca);
                            
                            $qmengujisemprotesis =  "SELECT * FROM opsi_menguji_sempro_tesis WHERE id='$data[menguji_sempro_tesis]'";
                            $rmengujisemprotesis = mysqli_query($con, $qmengujisemprotesis);
                            $dmengujisemprotesis = mysqli_fetch_array($rmengujisemprotesis);
                            
                            $qmengujiujiantesis =  "SELECT * FROM opsi_menguji_ujian_tesis WHERE id='$data[menguji_ujian_tesis]'";
                            $rmengujiujiantesis = mysqli_query($con, $qmengujiujiantesis);
                            $dmengujiujiantesis = mysqli_fetch_array($rmengujiujiantesis);
                            
                            $qstatuspegawai =  "SELECT * FROM opsi_status_pegawai WHERE id='$data[status]'";
                            $rstatuspegawai = mysqli_query($con, $qstatuspegawai);
                            $dstatuspegawai = mysqli_fetch_array($rstatuspegawai);
                            
                            $qkota =  "SELECT * FROM dt_kota WHERE id='$data[tempat_lahir]'";
                            $rkota = mysqli_query($con, $qkota);
                            $dkota = mysqli_fetch_array($rkota);
                            
                            $qjeniskelamin =  "SELECT * FROM opsi_jenis_kelamin WHERE id='$data[jenis_kelamin]'";
                            $rjeniskelamin = mysqli_query($con, $qjeniskelamin);
                            $djeniskelamin = mysqli_fetch_array($rjeniskelamin);
                            
                            $q1 = "SELECT nip FROM dospem_skripsi WHERE nip='$id'";
                            $r1 = mysqli_query($con, $q1);
                            $data1 = mysqli_fetch_assoc($r1);

                            $q2 = "SELECT dosen_wali FROM dt_mhssw WHERE dosen_wali='$id'";
                            $r2 = mysqli_query($con, $q2);
                            $data2 = mysqli_fetch_assoc($r2);

                            $q3 = "SELECT penguji1 FROM jadwal_sempro WHERE penguji1='$id'";
                            $r3 = mysqli_query($con, $q3);
                            $data3 = mysqli_fetch_assoc($r3);

                            $q4 = "SELECT penguji2 FROM jadwal_sempro WHERE penguji2='$id'";
                            $r4 = mysqli_query($con, $q4);
                            $data4 = mysqli_fetch_assoc($r4);

                            $q5 = "SELECT ketua_penguji FROM jadwal_ujskrip WHERE ketua_penguji='$id'";
                            $r5 = mysqli_query($con, $q5);
                            $data5 = mysqli_fetch_assoc($r5);

                            $q6 = "SELECT sekretaris_penguji FROM jadwal_ujskrip WHERE sekretaris_penguji='$id'";
                            $r6 = mysqli_query($con, $q6);
                            $data6 = mysqli_fetch_assoc($r6);

                            $q7 = "SELECT penguji_utama FROM jadwal_ujskrip WHERE penguji_utama='$id'";
                            $r7 = mysqli_query($con, $q7);
                            $data7 = mysqli_fetch_assoc($r7);

                            $q8 = "SELECT nip FROM mag_dosen_wali WHERE nip='$id'";
                            $r8 = mysqli_query($con, $q8);
                            $data8 = mysqli_fetch_assoc($r8);

                            $q9 = "SELECT nip FROM mag_dospem_tesis WHERE nip='$id'";
                            $r9 = mysqli_query($con, $q9);
                            $data9 = mysqli_fetch_assoc($r9);

                            $q10 = "SELECT penguji1 FROM mag_jadwal_sempro WHERE penguji1='$id'";
                            $r10 = mysqli_query($con, $q10);
                            $data10 = mysqli_fetch_assoc($r10);

                            $q11 = "SELECT penguji2 FROM mag_jadwal_sempro WHERE penguji2='$id'";
                            $r11 = mysqli_query($con, $q11);
                            $data11 = mysqli_fetch_assoc($r11);

                            $q12 = "SELECT penguji3 FROM mag_jadwal_sempro WHERE penguji3='$id'";
                            $r12 = mysqli_query($con, $q12);
                            $data12 = mysqli_fetch_assoc($r12);

                            $q13 = "SELECT penguji4 FROM mag_jadwal_sempro WHERE penguji4='$id'";
                            $r13 = mysqli_query($con, $q13);
                            $data13 = mysqli_fetch_assoc($r13);

                            $q14 = "SELECT penguji1 FROM mag_jadwal_ujtes WHERE penguji1='$id'";
                            $r14 = mysqli_query($con, $q14);
                            $data14 = mysqli_fetch_assoc($r14);

                            $q15 = "SELECT penguji2 FROM mag_jadwal_ujtes WHERE penguji2='$id'";
                            $r15 = mysqli_query($con, $q15);
                            $data15 = mysqli_fetch_assoc($r15);

                            $q16 = "SELECT penguji3 FROM mag_jadwal_ujtes WHERE penguji3='$id'";
                            $r16 = mysqli_query($con, $q16);
                            $data16 = mysqli_fetch_assoc($r16);

                            $q17 = "SELECT penguji4 FROM mag_jadwal_ujtes WHERE penguji4='$id'";
                            $r17 = mysqli_query($con, $q17);
                            $data17 = mysqli_fetch_assoc($r17);

                            $q18 = "SELECT nip_dospem_tesis1 FROM mag_pengelompokan_dospem_tesis WHERE nip_dospem_tesis1='$id'";
                            $r18 = mysqli_query($con, $q18);
                            $data18 = mysqli_fetch_assoc($r18);

                            $q19 = "SELECT nip_dospem_tesis2 FROM mag_pengelompokan_dospem_tesis WHERE nip_dospem_tesis2='$id'";
                            $r19 = mysqli_query($con, $q19);
                            $data19 = mysqli_fetch_assoc($r19);

                            $q20 = "SELECT dospem_tesis1 FROM mag_peserta_sempro WHERE dospem_tesis1='$id'";
                            $r20 = mysqli_query($con, $q20);
                            $data20 = mysqli_fetch_assoc($r20);

                            $q21 = "SELECT dospem_tesis2 FROM mag_peserta_sempro WHERE dospem_tesis2='$id'";
                            $r21 = mysqli_query($con, $q21);
                            $data21 = mysqli_fetch_assoc($r21);

                            $q22 = "SELECT dospem_tesis1 FROM mag_peserta_ujtes WHERE dospem_tesis1='$id'";
                            $r22 = mysqli_query($con, $q22);
                            $data22 = mysqli_fetch_assoc($r22);

                            $q23 = "SELECT dospem_tesis2 FROM mag_peserta_ujtes WHERE dospem_tesis2='$id'";
                            $r23 = mysqli_query($con, $q23);
                            $data23 = mysqli_fetch_assoc($r23);

                            $q24 = "SELECT dosen_pembimbing FROM mag_siowi WHERE dosen_pembimbing='$id'";
                            $r24 = mysqli_query($con, $q24);
                            $data24 = mysqli_fetch_assoc($r24);

                            $q25 = "SELECT penerima FROM penerima_surat WHERE penerima='$id'";
                            $r25 = mysqli_query($con, $q25);
                            $data25 = mysqli_fetch_assoc($r25);

                            $q26 = "SELECT dospem_skripsi1 FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$id'";
                            $r26 = mysqli_query($con, $q26);
                            $data26 = mysqli_fetch_assoc($r26);

                            $q27 = "SELECT dospem_skripsi2 FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$id'";
                            $r27 = mysqli_query($con, $q27);
                            $data27 = mysqli_fetch_assoc($r27);

                            $q28 = "SELECT nama FROM personil_sk WHERE nama='$id'";
                            $r28 = mysqli_query($con, $q28);
                            $data28 = mysqli_fetch_assoc($r28);

                            $q29 = "SELECT nama FROM personil_st WHERE nama='$id'";
                            $r29 = mysqli_query($con, $q29);
                            $data29 = mysqli_fetch_assoc($r29);

                            $q30 = "SELECT pembimbing1 FROM peserta_sempro WHERE pembimbing1='$id'";
                            $r30 = mysqli_query($con, $q30);
                            $data30 = mysqli_fetch_assoc($r30);

                            $q31 = "SELECT pembimbing2 FROM peserta_sempro WHERE pembimbing2='$id'";
                            $r31 = mysqli_query($con, $q31);
                            $data31 = mysqli_fetch_assoc($r31);

                            $q32 = "SELECT pembimbing1 FROM peserta_ujskrip WHERE pembimbing1='$id'";
                            $r32 = mysqli_query($con, $q32);
                            $data32 = mysqli_fetch_assoc($r32);

                            $q33 = "SELECT pembimbing2 FROM peserta_ujskrip WHERE pembimbing2='$id'";
                            $r33 = mysqli_query($con, $q33);
                            $data33 = mysqli_fetch_assoc($r33);

                            $q34 = "SELECT dosen_pembimbing1 FROM prasips WHERE dosen_pembimbing1='$id'";
                            $r34 = mysqli_query($con, $q34);
                            $data34 = mysqli_fetch_assoc($r34);

                            $q35 = "SELECT dosen_pembimbing2 FROM prasips WHERE dosen_pembimbing2='$id'";
                            $r35 = mysqli_query($con, $q35);
                            $data35 = mysqli_fetch_assoc($r35);

                            $q36 = "SELECT dosen_pembimbing FROM siow_individu WHERE dosen_pembimbing='$id'";
                            $r36 = mysqli_query($con, $q36);
                            $data36 = mysqli_fetch_assoc($r36);

                            $q37 = "SELECT dosen_pembimbing1 FROM sips WHERE dosen_pembimbing1='$id'";
                            $r37 = mysqli_query($con, $q37);
                            $data37 = mysqli_fetch_assoc($r37);

                            $q38 = "SELECT dosen_pembimbing2 FROM sips WHERE dosen_pembimbing2='$id'";
                            $r38 = mysqli_query($con, $q38);
                            $data38 = mysqli_fetch_assoc($r38);

                            $q39 = "SELECT dekan FROM sk WHERE dekan='$id'";
                            $r39 = mysqli_query($con, $q39);
                            $data39 = mysqli_fetch_assoc($r39);

                            $q40 = "SELECT penerima FROM spd WHERE penerima='$id'";
                            $r40 = mysqli_query($con, $q40);
                            $data40 = mysqli_fetch_assoc($r40);

                            $q41 = "SELECT ppk FROM spd WHERE ppk='$id'";
                            $r41 = mysqli_query($con, $q41);
                            $data41 = mysqli_fetch_assoc($r41);

                            $q42 = "SELECT dekan FROM spd WHERE dekan='$id'";
                            $r42 = mysqli_query($con, $q42);
                            $data42 = mysqli_fetch_assoc($r42);

                            $q43 = "SELECT dekan FROM st WHERE dekan='$id'";
                            $r43 = mysqli_query($con, $q43);
                            $data43 = mysqli_fetch_assoc($r43);

                            $q44 = "SELECT wd1 FROM siow_individu WHERE wd1='$id'";
                            $r44 = mysqli_query($con, $q44);
                            $data44 = mysqli_fetch_assoc($r44);

                            $q45 = "SELECT wd1 FROM siow_kelompok WHERE wd1='$id'";
                            $r45 = mysqli_query($con, $q45);
                            $data45 = mysqli_fetch_assoc($r45);

                            $q46 = "SELECT wd1 FROM magang WHERE wd1='$id'";
                            $r46 = mysqli_query($con, $q46);
                            $data46 = mysqli_fetch_assoc($r46);

                            $q47 = "SELECT wd1 FROM sitp WHERE wd1='$id'";
                            $r47 = mysqli_query($con, $q47);
                            $data47 = mysqli_fetch_assoc($r47);

                            $q48 = "SELECT wd1 FROM prasips WHERE wd1='$id'";
                            $r48 = mysqli_query($con, $q48);
                            $data48 = mysqli_fetch_assoc($r48);

                            $q49 = "SELECT wd1 FROM sips WHERE wd1='$id'";
                            $r49 = mysqli_query($con, $q49);
                            $data49 = mysqli_fetch_assoc($r49);

                            $q50 = "SELECT wd1 FROM siprak_mahasiswa WHERE wd1='$id'";
                            $r50 = mysqli_query($con, $q50);
                            $data50 = mysqli_fetch_assoc($r50);

                            $q51 = "SELECT wd1 FROM siprak_siswa WHERE wd1='$id'";
                            $r51 = mysqli_query($con, $q51);
                            $data51 = mysqli_fetch_assoc($r51);

                            $q52 = "SELECT wd1 FROM skkb WHERE wd1='$id'";
                            $r52 = mysqli_query($con, $q52);
                            $data52 = mysqli_fetch_assoc($r52);

                            $q53 = "SELECT wd1 FROM mag_siowi WHERE wd1='$id'";
                            $r53 = mysqli_query($con, $q53);
                            $data53 = mysqli_fetch_assoc($r53);

                            $q54 = "SELECT kp2 FROM mag_siowi WHERE kp2='$id'";
                            $r54 = mysqli_query($con, $q54);
                            $data54 = mysqli_fetch_assoc($r54);

                            $q55 = "SELECT wd1 FROM mag_sipt WHERE wd1='$id'";
                            $r55 = mysqli_query($con, $q55);
                            $data55 = mysqli_fetch_assoc($r55);

                            $q56 = "SELECT kp2 FROM mag_sipt WHERE kp2='$id'";
                            $r56 = mysqli_query($con, $q56);
                            $data56 = mysqli_fetch_assoc($r56);

                            $q57 = "SELECT * FROM dt_all_adm WHERE username='$id'";
                            $r57 = mysqli_query($con, $q57);
                            $data57 = mysqli_fetch_assoc($r57);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class=""> <?php echo $data['nama_tg'];?> </td>
                            <td class=""> <?php echo $data['id'];?> </td>
                            <td class=""> <?php echo $dpangkat['nm_pangkat'].' * '.$djabatan['nm'];?> </td>
                            <td class=""> <?php echo $dstatuspegawai['nm'];?> </td>
                            <td class="text-center" width="4%"> <a class="btn btn-outline-success btn-xs btn-block" href="editDtDosen.php?id=<?php echo $data['id'].'&page='.$page;?>" title="Edit data"><i class="far fa-edit"></i></a> </td>
                            <td class="text-center pr-1" width="4%"> 
                              <?php 
                              if($data1['nip']==$id || $data2['dosen_wali']==$id || $data3['penguji1']==$id || $data4['penguji2']==$id || $data5['ketua_penguji']==$id || $data6['sekretaris_penguji']==$id || $data7['penguji_utama']==$id || $data8['nip']==$id || $data9['nip']==$id || $data10['penguji1']==$id || $data11['penguji2']==$id || $data12['penguji3']==$id || $data13['penguji4']==$id || $data14['penguji1']==$id || $data15['penguji2']==$id || $data16['penguji3']==$id || $data17['penguji4']==$id || $data18['nip_dospem_tesis1']==$id || $data19['nip_dospem_tesis2']==$id || $data20['dospem_tesis1']==$id || $data21['dospem_tesis2']==$id || $data22['dospem_tesis1']==$id || $data23['dospem_tesis2']==$id || $data24['dosen_pembimbing']==$id || $data25['penerima']==$id || $data26['dospem_skripsi1']==$id || $data27['dospem_skripsi2']==$id || $data28['nama']==$id || $data29['nama']==$id || $data30['pembimbing1']==$id || $data31['pembimbing2']==$id || $data32['pembimbing1']==$id || $data33['pembimbing2']==$id || $data34['dosen_pembimbing1']==$id || $data35['dosen_pembimbing2']==$id || $data36['dosen_pembimbing']==$id || $data37['dosen_pembimbing1']==$id || $data38['dosen_pembimbing1']==$id || $data39['dekan']==$id || $data40['penerima']==$id || $data41['ppk']==$id || $data42['dekan']==$id || $data43['dekan']==$id || $data44['wd1']==$id || $data45['wd1']==$id || $data46['wd1']==$id || $data47['wd1']==$id || $data48['wd1']==$id || $data49['wd1']==$id || $data50['wd1']==$id || $data51['wd1']==$id || $data52['wd1']==$id || $data53['wd1']==$id || $data54['kp2']==$id || $data55['wd1']==$id || $data56['kp2']==$id || $data57['username']==$id)
                                { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Data ini berhubungan dengan data lain!\")' title='Tidak bisa dihapus! Data ini berhubungan dengan data lain!' disabled><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-xs btn-block' href='deleteDtDosen.php?id=".$data['id']."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus data'><i class='far fa-trash-alt'></i></a>";}?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="10">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th colspan="4" class="bg-gradient-success">
                                          <h6 class="m-0">DATA DIRI</h6>
                                        </th>
                                      </tr>
                                      <tr>
                                        <th width="28%">Nama dengan Gelar</th>
                                        <td width="4%">:</td>
                                        <td width="48%"><?php echo $data['nama'];?></td>
                                        <td width="20%" rowspan="7" class="pr-1"><img class="profile-user-img img-fluid rounded mx-auto d-block" src="<?php echo $data['photo'];?>" onError="this.onerror=null;this.src='<?php if($data['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt=""></td>
                                      </tr>
                                      <tr>
                                        <th>Tempat dan Tanggal Lahir</th>
                                        <td>:</td>
                                        <td><?php echo $dkota['nm_kota'].' / '.$new_tgl_lahir;?></td>
                                      </tr>
                                      <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>:</td>
                                        <td><?php echo $djeniskelamin['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>No. Kontak</th>
                                        <td>:</td>
                                        <td><?php echo 'Kontak 1. '.$data['kntk1'].'. '.'Kontak 2. '.$data['kntk2'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Email</th>
                                        <td>:</td>
                                        <td><?php echo 'Email 1. '.$data['email1'].'. '.'Email 2. '.$data['email2'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Alamat KTP</th>
                                        <td>:</td>
                                        <td><?php echo $data['alamat_ktp'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Alamat Rumah</th>
                                        <td>:</td>
                                        <td><?php echo $data['alamat_rumah'];?></td>
                                      </tr>
                                      <tr>
                                        <th colspan="4" class="bg-gradient-success">
                                          <h6 class="m-0">DATA KEPEGAWAIAN</h6>
                                        </th>
                                      </tr>
                                      <tr>
                                        <th><?php if($data['kat_pegawai']=='1') {echo "NIP";} elseif($data['kat_pegawai']=='2') {echo "NITNP";} elseif($data['kat_pegawai']=='3') {echo "NIPPPK";} elseif($data['kat_pegawai']=='4') {echo "NIBLU";} elseif($data['kat_pegawai']=='5') {echo "NILB";} elseif($data['kat_pegawai']=='6') {echo "NIKFU";}?></th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $data['id'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Kategori</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $dkatpegawai['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Pangkat</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $dpangkat['nm_pangkat'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Jabatan</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $djabatan['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Jabatan Instansi</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $djabataninstansi['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Kepakaran Mayor</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $dkepakaranmayor['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Kepakaran Minor</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $data['kepakaran_minor']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['kepakaran_minor']);?></td>
                                      </tr>
                                      <tr>
                                        <th>Trend Riset</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $data['trend_riset']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['trend_riset']);?></td>
                                      </tr>
                                      <tr>
                                        <th>Profil Riset Terkini</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $data['profil_riset_terkini']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['profil_riset_terkini']);?></td>
                                      </tr>
                                      <tr>
                                        <th>Dosen Prodi Magister Psikologi</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $dmengajarpasca['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Penguji Sempro Tesis</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $dmengujisemprotesis['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Penguji Ujian Tesis</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $dmengujiujiantesis['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Status Dosen</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $dstatuspegawai['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th colspan="4" class="bg-gradient-success">
                                          <h6 class="m-0">DATA KARIR</h6>
                                        </th>
                                      </tr>
                                      <tr>
                                        <th>Tanggal CPNS</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_cpns;?></td>
                                      </tr>
                                      <tr>
                                        <th>TMT Kerja</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tmt;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IIIa</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_3a;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IIIb</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_3b;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IIIc</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_3c;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IIId</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_3d;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IVa</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_4a;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IVb</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_4b;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IVc</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_4c;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IVd</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_4d;?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal IVe</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_tgl_4e;?></td>
                                      </tr>
                                      <tr>
                                        <th colspan="4" class="bg-gradient-success">
                                          <h6 class="m-0">DATA KUALIFIKASI AKADEMIK</h6>
                                        </th>
                                      </tr>
                                      <tr>
                                        <th>Prodi Fakultas PT Strata 1</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $data['strata1'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal Lulus Strata 1</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_th_s1;?></td>
                                      </tr>
                                      <tr>
                                        <th>Prodi Fakultas PT Strata 2</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $data['strata2'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal Lulus Strata 2</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_th_s2;?></td>
                                      </tr>
                                      <tr>
                                        <th>Prodi Fakultas PT Strata 3</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $data['strata3'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal Lulus Strata 3</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_th_s3;?></td>
                                      </tr>
                                      <tr>
                                        <th>Bidang Guru Besar</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $data['guru_bsr'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal Pengukuhan Guru Besar</th>
                                        <td>:</td>
                                        <td colspan="2"><?php echo $new_th_gb;?></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <?php
                            $i++; 
                            $count++;
                            }
                            ?>                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages);?></div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <form action="sDtDosen.php" method="post" enctype="multipart/form-data">
      <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="inputModalLabel">Input Data Dosen</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <input type="text" value="1" name="jenis_pegawai" class="form-control form-control-sm sr-only" required>
                <input type="text" value="11" name="level" class="form-control form-control-sm sr-only" required>
                <div class="form-group col-6">
                  <label for="nama">Nama dengan Gelar <span class="text-danger">*</span></label>
                  <input type="text" name="nama" class="form-control form-control-sm" required>
                </div>
                <div class="form-group col-6">
                  <label for="nama_tg">Nama tanpa Gelar <span class="text-danger">*</span></label>
                  <input type="text" name="nama_tg" class="form-control form-control-sm" required>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-4">
                  <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                  <select name="tempat_lahir" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM dt_kota ORDER BY nm_kota ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm_kota]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-4">
                  <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                  <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                    <input type="text" name="tanggal_lahir" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_one" required>
                    <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                  <select name="jenis_kelamin" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_jenis_kelamin ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-2">
                  <label for="kntk1">No. Kontak 1 <span class="text-danger">*</span></label>
                  <input type="text" name="kntk1" class="form-control form-control-sm" required>
                </div>
                <div class="form-group col-2">
                  <label for="kntk2">No. Kontak 2</label>
                  <input type="text" name="kntk2" class="form-control form-control-sm">
                </div>
                <div class="form-group col-4">
                  <label for="email1">Email 1 <span class="text-danger">*</span></label>
                  <input type="text" name="email1" class="form-control form-control-sm" required>
                </div>
                <div class="form-group col-4">
                  <label for="email2">Email 2</label>
                  <input type="text" name="email2" class="form-control form-control-sm">
                </div>
              </div>
              <div class="form-group">
                <label for="alamat_ktp">Alamat sesuai KTP <span class="text-danger">*</span></label>
                <input type="text" name="alamat_ktp" class="form-control form-control-sm" required>
              </div>
              <div class="form-group">
                <label for="alamat_rumah">Alamat Domisili Rumah <span class="text-danger">*</span></label>
                <input type="text" name="alamat_rumah" class="form-control form-control-sm" required>
              </div>
              <hr>
              <div class="row">
                <div class="form-group col-4">
                  <label for="id">NIP/Id Lainnya <span class="text-danger">*</span></label>
                  <input type="text" name="id" class="form-control form-control-sm" required>
                </div>
                <div class="form-group col-4">
                  <label for="kat_pegawai">Kategori Pegawai <span class="text-danger">*</span></label>
                  <select name="kat_pegawai" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_kat_pegawai ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-4">
                  <label for="pangkat">Pangkat <span class="text-danger">*</span></label>
                  <select name="pangkat" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_pangkat ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm_pangkat]</option>";
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-4">
                  <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                  <select name="jabatan" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_jabatan ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-4">
                  <label for="jabatan_instansi">Jabatan Instansi <span class="text-danger">*</span></label>
                  <select name="jabatan_instansi" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_jabatan_instansi ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-4">
                  <label for="kepakaran_mayor">Kepakaran Mayor <span class="text-danger">*</span></label>
                  <select name="kepakaran_mayor" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_kepakaran_mayor ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="kepakaran_minor">Kepakaran Minor <span class="text-danger">*</span></label>
                <textarea id="textarea-custom-one" name="kepakaran_minor" class="form-control form-control-sm" style="height: 300px;" required></textarea>
              </div>
              <div class="form-group">
                <label for="trend_riset">Trend riset <span class="text-danger">*</span></label>
                <textarea id="textarea-custom-two" name="trend_riset" class="form-control form-control-sm" style="height: 300px;" required></textarea>
              </div>
              <div class="form-group">
                <label for="profil_riset_terkini">Profil Riset Terkini <span class="text-danger">*</span></label>
                <textarea id="textarea-custom-three" name="profil_riset_terkini" class="form-control form-control-sm" style="height: 300px;" required></textarea>
              </div>
              <div class="row">
                <div class="form-group col-4">
                  <label for="mengajar_pasca">Dosen Prodi Magister Psikologi <span class="text-danger">*</span></label>
                  <select name="mengajar_pasca" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_mengajar_pasca ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-3">
                  <label for="menguji_sempro_tesis">Penguji Sempro Tesis <span class="text-danger">*</span></label>
                  <select name="menguji_sempro_tesis" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_menguji_sempro_tesis ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-3">
                  <label for="menguji_ujian_tesis">Penguji Ujian Tesis <span class="text-danger">*</span></label>
                  <select name="menguji_ujian_tesis" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM opsi_menguji_ujian_tesis ORDER BY id ASC");
                      while ($c = mysqli_fetch_array($q)){
                        echo "<option value='$c[id]'>$c[nm]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-2">
                  <label for="status">Status Dosen <span class="text-danger">*</span></label>
                  <select name="status" class="form-control form-control-sm" required>
                    <option value="">-Pilih-</option>
                    <?php
                    $q = mysqli_query($con, "SELECT * FROM opsi_status_pegawai ORDER BY id ASC");
                    while ($c = mysqli_fetch_array($q)){
                      echo "<option value='$c[id]'>$c[nm]</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="form-group col-3">
                  <label for="tgl_cpns">Tanggal CPNS</label>
                  <div class="input-group date" id="tgl_cpns" data-target-input="nearest">
                    <input type="text" name="tgl_cpns" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_cpns">
                    <div class="input-group-append" data-target="#tgl_cpns" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-3">
                  <label for="tmt">TMT Kerja</label>
                  <div class="input-group date" id="tmt" data-target-input="nearest">
                    <input type="text" name="tmt" class="form-control form-control-sm datetimepicker-input" data-target="#tmt">
                    <div class="input-group-append" data-target="#tmt" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-3">
                  <label for="tgl_3a">Tanggal IIIa</label>
                  <div class="input-group date" id="tgl_3a" data-target-input="nearest">
                    <input type="text" name="tgl_3a" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_3a">
                    <div class="input-group-append" data-target="#tgl_3a" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-3">
                  <label for="tgl_3b">Tanggal IIIb</label>
                  <div class="input-group date" id="tgl_3b" data-target-input="nearest">
                    <input type="text" name="tgl_3b" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_3b">
                    <div class="input-group-append" data-target="#tgl_3b" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-3">
                  <label for="tgl_3c">Tanggal IIIc</label>
                  <div class="input-group date" id="tgl_3c" data-target-input="nearest">
                    <input type="text" name="tgl_3c" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_3c">
                    <div class="input-group-append" data-target="#tgl_3c" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-3">
                  <label for="tgl_3d">Tanggal IIId</label>
                  <div class="input-group date" id="tgl_3d" data-target-input="nearest">
                    <input type="text" name="tgl_3d" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_3d">
                    <div class="input-group-append" data-target="#tgl_3d" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-3">
                  <label for="tgl_4a">Tanggal IVa</label>
                  <div class="input-group date" id="tgl_4a" data-target-input="nearest">
                    <input type="text" name="tgl_4a" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4a">
                    <div class="input-group-append" data-target="#tgl_4a" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-3">
                  <label for="tgl_4b">Tanggal IVb</label>
                  <div class="input-group date" id="tgl_4b" data-target-input="nearest">
                    <input type="text" name="tgl_4b" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4b">
                    <div class="input-group-append" data-target="#tgl_4b" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-4">
                  <label for="tgl_4c">Tanggal IVc</label>
                  <div class="input-group date" id="tgl_4c" data-target-input="nearest">
                    <input type="text" name="tgl_4c" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4c">
                    <div class="input-group-append" data-target="#tgl_4c" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="tgl_4d">Tanggal IVd</label>
                  <div class="input-group date" id="tgl_4d" data-target-input="nearest">
                    <input type="text" name="tgl_4d" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4d">
                    <div class="input-group-append" data-target="#tgl_4d" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="tgl_4e">Tanggal IVe</label>
                  <div class="input-group date" id="tgl_4e" data-target-input="nearest">
                    <input type="text" name="tgl_4e" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_4e">
                    <div class="input-group-append" data-target="#tgl_4e" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="form-group col-9">
                  <label for="strata1">Prodi Fakultas PT Strata 1</label>
                  <input type="text" name="strata1" class="form-control form-control-sm">
                </div>
                <div class="form-group col-3">
                  <label for="th_s1">Tanggal Lulus Strata 1</label>
                  <div class="input-group date" id="th_s1" data-target-input="nearest">
                    <input type="text" name="th_s1" class="form-control form-control-sm datetimepicker-input" data-target="#th_s1">
                    <div class="input-group-append" data-target="#th_s1" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-9">
                  <label for="strata2">Prodi Fakultas PT Strata 2</label>
                  <input type="text" name="strata2" class="form-control form-control-sm">
                </div>
                <div class="form-group col-3">
                  <label for="th_s2">Tanggal Lulus Strata 2</label>
                  <div class="input-group date" id="th_s2" data-target-input="nearest">
                    <input type="text" name="th_s2" class="form-control form-control-sm datetimepicker-input" data-target="#th_s2">
                    <div class="input-group-append" data-target="#th_s2" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-9">
                  <label for="strata3">Prodi Fakultas PT Strata 3</label>
                  <input type="text" name="strata3" class="form-control form-control-sm">
                </div>
                <div class="form-group col-3">
                  <label for="th_s3">Tanggal Lulus Strata 3</label>
                  <div class="input-group date" id="th_s3" data-target-input="nearest">
                    <input type="text" name="th_s3" class="form-control form-control-sm datetimepicker-input" data-target="#th_s3">
                    <div class="input-group-append" data-target="#th_s3" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-9">
                  <label for="guru_bsr">Bidang Guru Besar</label>
                  <input type="text" name="guru_bsr" class="form-control form-control-sm">
                </div>
                <div class="form-group col-3">
                  <label for="th_gb">Tanggal Pengukuhan</label>
                  <div class="input-group date" id="th_gb" data-target-input="nearest">
                    <input type="text" name="th_gb" class="form-control form-control-sm datetimepicker-input" data-target="#th_gb">
                    <div class="input-group-append" data-target="#th_gb" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label for="password">Password Akun <span class="text-danger">*</span></label>
                <input type="text" name="password" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="submit" name="submit" class="btn btn-outline-success btn-sm">Submit</button>
              <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>