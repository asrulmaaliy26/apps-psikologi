<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  $id_ujtes = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 2;
  $qryperiod = "SELECT * FROM mag_periode_pendaftaran_ujtes WHERE id='$id_ujtes'";
  $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or DIE( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dperiod = mysqli_fetch_assoc($rperiod);
  $tahap = $dperiod['tahap'];
  $ta = $dperiod['ta'];
   
  $qry_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$tahap'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
   
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
   
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPendAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php               
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                     echo '<div class="alert alert-success custom-alert" role="alert">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}  
                       ?>
        <h3 class="text-center text-warning">Ujian Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah form Penilaian Ujian Tesis <?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan lakukan validasi, jika nilai dari masing-masing penguji telah terisi.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPendUjtesAdm.php?page=<?php echo "$page";?>">Periode Pendaftaran</a></li>
                  <li role="presentation" class="active"><a>Form Validasi Nilai</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped custom" width="100%" style="margin-bottom:0px;">
                    <thead>
                      <tr>
                        <th class="text-center" width="3%">No.</th>
                        <th class="text-center" width="28%">Nama/NIM</th>
                        <th class="text-center" width="11%">Penguji Utama</th>
                        <th class="text-center" width="11%">Ketua Penguji</th>
                        <th class="text-center" width="11%">Pembimbing I</th>
                        <th class="text-center" width="11%">Pembimbing II</th>
                        <th class="text-center" width="11%">Nilai Akhir</th>
                        <th class="text-center" width="14%">Validasi</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted" style="font-size:13px;">
                      <?php
                        $no=0;
                        $qry = "SELECT * FROM mag_peserta_ujtes WHERE id_ujtes='$id_ujtes'";
                        $has = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        while($md = mysqli_fetch_assoc( $has )) {
                        $id=$md['id'];
                        $no++;
                        
                        $qrymhssw = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$md[nim]'";
                        $rmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $qrymhssw);
                        $dmhssw = mysqli_fetch_assoc($rmhssw);
                        
                        $qjdwl = "SELECT * FROM mag_jadwal_ujtes WHERE id_pendaftaran='$id'";
                        $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qjdwl )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $djdwl = mysqli_fetch_assoc($row);
                        
                        $qpenguji1 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji1]'";
                        $rpenguji1 = mysqli_query($GLOBALS["___mysqli_ston"],  $qpenguji1 )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dpenguji1 = mysqli_fetch_assoc($rpenguji1);
                        
                        $qpenguji2 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji2]'";
                        $rpenguji2 = mysqli_query($GLOBALS["___mysqli_ston"],  $qpenguji2 )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dpenguji2 = mysqli_fetch_assoc($rpenguji2);
                        
                        $qpenguji3 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji3]'";
                        $rpenguji3 = mysqli_query($GLOBALS["___mysqli_ston"],  $qpenguji3 )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dpenguji3 = mysqli_fetch_assoc($rpenguji3);
                        
                        $qpenguji4 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji4]'";
                        $rpenguji4 = mysqli_query($GLOBALS["___mysqli_ston"],  $qpenguji4 )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dpenguji4 = mysqli_fetch_assoc($rpenguji4);
                        
                        $qcount1 = "SELECT COUNT(*) AS jumData FROM mag_nilai_ujtes WHERE mean_nilai_penguji1 <>'' AND id_pendaftaran='$id'";
                        $hcount1 = mysqli_query($GLOBALS["___mysqli_ston"],  $qcount1 )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dcount1 = mysqli_fetch_assoc( $hcount1 );

                        $qcount2 = "SELECT COUNT(*) AS jumData FROM mag_nilai_ujtes WHERE mean_nilai_penguji2 <>'' AND id_pendaftaran='$id'";
                        $hcount2 = mysqli_query($GLOBALS["___mysqli_ston"],  $qcount2 )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dcount2 = mysqli_fetch_assoc( $hcount2 );

                        $qcount3 = "SELECT COUNT(*) AS jumData FROM mag_nilai_ujtes WHERE mean_nilai_penguji3 <>'' AND id_pendaftaran='$id'";
                        $hcount3 = mysqli_query($GLOBALS["___mysqli_ston"],  $qcount3 )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dcount3 = mysqli_fetch_assoc( $hcount3 );

                        $qcount4 = "SELECT COUNT(*) AS jumData FROM mag_nilai_ujtes WHERE mean_nilai_penguji4 <>'' AND id_pendaftaran='$id'";
                        $hcount4 = mysqli_query($GLOBALS["___mysqli_ston"],  $qcount4 )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dcount4 = mysqli_fetch_assoc( $hcount4 );

                        $qnilai = "SELECT * FROM mag_nilai_ujtes WHERE id_pendaftaran='$id'";
                        $rnilai = mysqli_query($GLOBALS["___mysqli_ston"],  $qnilai )or DIE( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dnilai = mysqli_fetch_assoc($rnilai);
                        
                        $jumCountPenilai= $dcount1['jumData'] + $dcount2['jumData'] + $dcount3['jumData'] + $dcount4['jumData'];

                        $akum = $dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji3'] + $dnilai['mean_nilai_penguji4'];
                        $nilaiakhir= @($akum/$jumCountPenilai);
                        $nilaibulat = round($nilaiakhir);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dmhssw['nama'].' | '.$dmhssw['nim'];?></td>
                        <td class="text-center <?php if(empty($dnilai['mean_nilai_penguji3'])) { echo 'bg-danger';}?>"><span data-toggle="tooltip" data-placement="bottom" title="<?php echo $dpenguji3['nama'];?>"><?php if($dnilai['mean_nilai_penguji3'] >=91 && $dnilai['mean_nilai_penguji3'] <= 100) { echo 'A';} if($dnilai['mean_nilai_penguji3'] >=80 && $dnilai['mean_nilai_penguji3'] <= 90) { echo 'B+';} if($dnilai['mean_nilai_penguji3'] >=70 && $dnilai['mean_nilai_penguji3'] <= 79) { echo 'B';} if($dnilai['mean_nilai_penguji3'] >=60 && $dnilai['mean_nilai_penguji3'] <= 69) { echo 'C+';} if($dnilai['mean_nilai_penguji3'] >=0 && $dnilai['mean_nilai_penguji3'] <= 59) { echo 'C (Tidak Lulus)';}?> (<?php echo $dnilai['mean_nilai_penguji3'];?>)</span></td>
                        <td class="text-center <?php if(empty($dnilai['mean_nilai_penguji4'])) { echo 'bg-danger';}?>"><span data-toggle="tooltip" data-placement="bottom" title="<?php echo $dpenguji4['nama'];?>"><?php if($dnilai['mean_nilai_penguji4'] >=91 && $dnilai['mean_nilai_penguji4'] <= 100) { echo 'A';} if($dnilai['mean_nilai_penguji4'] >=80 && $dnilai['mean_nilai_penguji4'] <= 90) { echo 'B+';} if($dnilai['mean_nilai_penguji4'] >=70 && $dnilai['mean_nilai_penguji4'] <= 79) { echo 'B';} if($dnilai['mean_nilai_penguji4'] >=60 && $dnilai['mean_nilai_penguji4'] <= 69) { echo 'C+';} if($dnilai['mean_nilai_penguji4'] >=0 && $dnilai['mean_nilai_penguji4'] <= 59) { echo 'C (Tidak Lulus)';}?> (<?php echo $dnilai['mean_nilai_penguji4'];?>)</span></td>
                        <td class="text-center <?php if(empty($dnilai['mean_nilai_penguji1'])) { echo 'bg-danger';}?>"><span data-toggle="tooltip" data-placement="bottom" title="<?php echo $dpenguji1['nama'];?>"><?php if($dnilai['mean_nilai_penguji1'] >=91 && $dnilai['mean_nilai_penguji1'] <= 100) { echo 'A';} if($dnilai['mean_nilai_penguji1'] >=80 && $dnilai['mean_nilai_penguji1'] <= 90) { echo 'B+';} if($dnilai['mean_nilai_penguji1'] >=70 && $dnilai['mean_nilai_penguji1'] <= 79) { echo 'B';} if($dnilai['mean_nilai_penguji1'] >=60 && $dnilai['mean_nilai_penguji1'] <= 69) { echo 'C+';} if($dnilai['mean_nilai_penguji1'] >=0 && $dnilai['mean_nilai_penguji1'] <= 59) { echo 'C (Tidak Lulus)';}?> (<?php echo $dnilai['mean_nilai_penguji1'];?>)</span></td>
                        <td class="text-center <?php if(empty($dnilai['mean_nilai_penguji2'])) { echo 'bg-danger';}?>"><span data-toggle="tooltip" data-placement="bottom" title="<?php echo $dpenguji2['nama'];?>"><?php if($dnilai['mean_nilai_penguji2'] >=91 && $dnilai['mean_nilai_penguji2'] <= 100) { echo 'A';} if($dnilai['mean_nilai_penguji2'] >=80 && $dnilai['mean_nilai_penguji2'] <= 90) { echo 'B+';} if($dnilai['mean_nilai_penguji2'] >=70 && $dnilai['mean_nilai_penguji2'] <= 79) { echo 'B';} if($dnilai['mean_nilai_penguji2'] >=60 && $dnilai['mean_nilai_penguji2'] <= 69) { echo 'C+';} if($dnilai['mean_nilai_penguji2'] >=0 && $dnilai['mean_nilai_penguji2'] <= 59) { echo 'C (Tidak Lulus)';}?> (<?php echo $dnilai['mean_nilai_penguji2'];?>)</span></td>
                        <td class="text-center"><?php if($nilaibulat >=91 && $nilaibulat <= 100) { echo 'A';} if($nilaibulat >=80 && $nilaibulat <= 90) { echo 'B+';} if($nilaibulat >=70 && $nilaibulat <= 79) { echo 'B';} if($nilaibulat >=60 && $nilaibulat <= 69) { echo 'C+';} if($nilaibulat >=0 && $nilaibulat <= 59) { echo 'C (Tidak Lulus)';}?> (<?php echo $nilaibulat;?>)</td>
                        <?php if($jumCountPenilai < 3) { echo '
                          <td class="text-center"><span class="text-danger">Nilai Belum Lengkap</span></td>';} else { ?>
                        <td class="text-center" style="padding-bottom:2px; padding-top:2px;">
                          <label for="" class="sr-only">Validasi Nilai</label>
                          <form class="" style="margin-bottom:0px;" action="updateValidasiPenilaianUjtes.php" method="post">
                            <input type="text" class="sr-only" name="id_pendaftaran" value="<?php echo $id;?>">
                            <input type="text" class="sr-only" name="id_ujtes" value="<?php echo $id_ujtes;?>">
                            <input type="text" class="sr-only" name="nim" value="<?php echo $md['nim'];?>">
                            <input type="text" class="sr-only" name="page" value="<?php echo $page;?>">
                            <select name='validasi' class='form-control input-sm' onchange='this.form.submit();' required>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_validasi_nilai_ujtes ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $dnilai['validasi'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                            </select>
                          </form>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerAdm.php";?>
    <?php include "jsSourceAdm.php";?>
    <script>
      $(function () {
       $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
  </body>
</html>