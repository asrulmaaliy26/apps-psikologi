<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
   
  $qidper = "SELECT * FROM pendaftaran_skripsi WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qjdwl = "SELECT * FROM jadwal_ujskrip WHERE id_pendaftaran='$id'";
  $res = mysqli_query($con,  $qjdwl )or die( mysqli_error($con) );
  $djdwl = mysqli_fetch_assoc( $res );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Form Berita Acara Ujian Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapBaUjskripAdm.php?page=<?php echo $page;?>">Form Berita Acara Ujian Skripsi</a></li>
                  <li class="breadcrumb-item active small">Cetak Berita Acara</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Cetak Berita Acara</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="34%" rowspan="2">Nama</td>
                            <td colspan="3" class="border-bottom-0">Waktu</td>
                            <td class="pr-1" rowspan="2" colspan="2">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="12%" class="pl-1">Tanggal</td>
                            <td width="12%">Jam</td>
                            <td width="24%" class="pr-1">Ruang</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_ujskrip INNER JOIN dt_mhssw ON peserta_ujskrip.nim=dt_mhssw.nim WHERE peserta_ujskrip.id_ujskrip='$id' ORDER BY dt_mhssw.nama ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rmhssw = mysqli_query($con, $qry_mhssw);
                            $dmhssw = mysqli_fetch_assoc($rmhssw);
                            
                            $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_ujskrip WHERE nim='$data[nim]'";
                            $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
                            $dfrek = mysqli_fetch_assoc( $hfrek );
                            
                            $qidper = "SELECT * FROM pendaftaran_skripsi WHERE id='$data[id_ujskrip]'";
                            $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
                            $didper = mysqli_fetch_assoc($ridper);
                            
                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qry_jdwl = "SELECT * FROM jadwal_ujskrip WHERE id_ujskrip='$data[id_ujskrip]' AND id='$data[id_jdwl]'";
                            $res_jdwl = mysqli_query($con, $qry_jdwl);
                            $dt_jdwl = mysqli_fetch_assoc($res_jdwl);
                            
                            $qry_p1 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[sekretaris_penguji]'";
                            $res_p1 = mysqli_query($con, $qry_p1);
                            $dt_p1 = mysqli_fetch_assoc($res_p1);

                            $qry_p2 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[ketua_penguji]'";
                            $res_p2 = mysqli_query($con, $qry_p2);
                            $dt_p2 = mysqli_fetch_assoc($res_p2);

                            $qry_p3 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[penguji_utama]'";
                            $res_p3 = mysqli_query($con, $qry_p3);
                            $dt_p3 = mysqli_fetch_assoc($res_p3);
                            
                            $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$dt_jdwl[ruang]'";
                            $res_ruang = mysqli_query($con, $qry_ruang);
                            $dt_ruang = mysqli_fetch_assoc($res_ruang);
                            
                            $qry_nilai = "SELECT * FROM nilai_ujskrip WHERE id_pendaftaran='$data[id]'";
                            $res_nilai = mysqli_query($con, $qry_nilai);
                            $dt_nilai = mysqli_fetch_assoc($res_nilai);
                            
                            $qry_grade = "SELECT * FROM grade_ujskrip WHERE id_ujskrip='$data[id_ujskrip]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_assoc($res_grade);
                            
                            $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
                            $hdt_cek = mysqli_query($con, $qdt_cek);
                            $dcek = mysqli_fetch_assoc($hdt_cek);
                            $no++;
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </td>
                            <td class="text-center"> <?php echo $dt_jdwl['tgl_ujian'];?> </td>
                            <td class="text-center"> <?php echo $dt_jdwl['jam_mulai'].'-'.$dt_jdwl['jam_selesai'];?> </td>
                            <td class="text-center"> <?php echo $dt_ruang['nm'];?> </td>
                            <td width="6%" class="text-center"> <?php if(empty($dt_jdwl['tgl_ujian']) || empty($dt_jdwl['jam_mulai']) || empty($dt_jdwl['jam_selesai']) || empty($dt_jdwl['ruang'])) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-print"></i></a>';} else { echo '<a href="cetakBaUjskripKosongPerPeriodeAdm.php?id='.$data['id'].'&page='.$page.'" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Cetak berita acara kosong" target="_blank"><i class="fas fa-print"></i></a>';} ?> </td>
                            <td width="6%" class="text-center pr-1"> <?php if($dt_nilai['nilai_sekretaris']==0 || $dt_nilai['nilai_ketua']==0 || $dt_nilai['nilai_utama']==0 || $dt_nilai['mean_nilai']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')"><i class="fas fa-print"></i></a>';} else { echo '<a href="cetakBaUjskripIsiPerPeriodeAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak berita acara terisi"><i class="fas fa-print"></i></a>';} ?> </td>
                          </tr>
                          <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>