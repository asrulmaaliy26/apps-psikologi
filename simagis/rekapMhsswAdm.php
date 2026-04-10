<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
   $qta = "select * from mag_dt_ta WHERE status='1'";
   $rta = mysqli_query($GLOBALS["___mysqli_ston"], $qta)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dta = mysqli_fetch_assoc($rta);   
   
   $qwd1 = "select * from dt_pegawai WHERE jabatan_instansi = '2'";
   $rwd1 = mysqli_query($GLOBALS["___mysqli_ston"], $qwd1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dwd1 = mysqli_fetch_assoc($rwd1);   
   
   $qkaprodi = "select * from dt_pegawai WHERE jabatan_instansi = '36'";
   $rkaprodi = mysqli_query($GLOBALS["___mysqli_ston"], $qkaprodi)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dkaprodi = mysqli_fetch_assoc($rkaprodi); 
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navMasterDataAdm.php";
      $qry = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca GROUP BY angkatan";
      $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $jumlahData = $dataku['jumData'];
            
      include 'pagination.php';                 
      $reload = "rekapMhsswAdm.php?pagination=true";
      $sql =  "SELECT * FROM mag_dt_mhssw_pasca GROUP BY angkatan ORDER BY angkatan DESC";
      $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
      $rpp = 10;
      $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
      $tcount = mysqli_num_rows($result);
      $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
      $count = 0;
      $i = ($page-1)*$rpp;
      $no_urut = ($page-1)*$rpp;
      ?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
          echo '
          <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Import gagal</h4>
          </div>
          <div class="modal-body">
          <p><strong>Note: Import gagal.</strong> Kemungkinan ada NIM yang telah terdaftar di database, silahkan cek dan ulangi lagi!</p>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div>
          </div>
          </div>';}
          
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diinput</div>';}
          ?>
        <h3 class="text-center text-warning">Master Data Mahasiswa</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah master data mahasiswa per angkatan.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
              <li>Keterangan kode: <code>A = "Aktif", SPT="Seminar Proposal", UT="Ujian Tesis", L = "Lulus", C = "Cuti", DO = "Drop Out", NA = "Non Aktif"</code>.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Data Mahasiswa Per Angkatan</a></li>
                  <div class="btn-group pull-right" role="group">
                    <a role="presentation group" class="btn btn-default btn-group" title="Download Template Import File" href="images/template-impor-data-mahasiswa.xls"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download Template Import File</a>
                    <button role="presentation group" class="btn btn-primary btn-group" title="Import Data Mahasiswa Baru" data-toggle="modal" data-target="#modalImport"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Import Data Mahasiswa Baru</button>
                  </div>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-condensed table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th rowspan="3" class="text-center" width="3%">No.</th>
                        <th rowspan="3" class="text-center" width="6%">Angkatan</th>
                        <th colspan="16" class="text-center">Semester Daftar</th>
                        <th rowspan="3" class="text-center" width="5%">Total</th>
                        <th rowspan="3" class="text-center" width="8%">Opsi</th>
                      </tr>
                      <tr>
                        <th colspan="8" class="text-center">Ganjil</th>
                        <th colspan="8" class="text-center">Genap</th>
                      </tr>
                      <tr>
                        <th class="text-center" width="4.5%">A</th>
                        <th class="text-center" width="4.5%">SPT</th>
                        <th class="text-center" width="4.5%">UT</th>
                        <th class="text-center" width="4.5%">L</th>
                        <th class="text-center" width="4.5%">C</th>
                        <th class="text-center" width="4.5%">DO</th>
                        <th class="text-center" width="4.5%">NA</th>
                        <th class="text-center" width="4.5%">Subtotal</th>
                        <th class="text-center" width="4.5%">A</th>
                        <th class="text-center" width="4.5%">SPT</th>
                        <th class="text-center" width="4.5%">UT</th>
                        <th class="text-center" width="4.5%">L</th>
                        <th class="text-center" width="4.5%">C</th>
                        <th class="text-center" width="4.5%">DO</th>
                        <th class="text-center" width="4.5%">NA</th>
                        <th class="text-center" width="4.5%">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $angkatan=$data['angkatan'];
                        
                        $qry1 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='1' AND angkatan='$angkatan' AND smt_daftar='1'";
                        $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData1 = $dataku1['jumData'];
                        
                        $qry2 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='2' AND angkatan='$angkatan' AND smt_daftar='1'";
                        $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData2 = $dataku2['jumData'];
                        
                        $qry3 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='3' AND angkatan='$angkatan' AND smt_daftar='1'";
                        $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData3 = $dataku3['jumData'];
                        
                        $qry4 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='4' AND angkatan='$angkatan' AND smt_daftar='1'";
                        $result4 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData4 = $dataku4['jumData'];
                        
                        $qry5 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='5' AND angkatan='$angkatan' AND smt_daftar='1'";
                        $result5 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData5 = $dataku5['jumData'];
                        
                        $qry6 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE angkatan='$angkatan' AND smt_daftar='1'";
                        $result6 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData6 = $dataku6['jumData'];
                        
                        $qry7 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='1' AND angkatan='$angkatan' AND smt_daftar='2'";
                        $result7 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku7 = mysqli_fetch_assoc($result7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData7 = $dataku7['jumData'];
                        
                        $qry8 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='2' AND angkatan='$angkatan' AND smt_daftar='2'";
                        $result8 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku8 = mysqli_fetch_assoc($result8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData8 = $dataku8['jumData'];
                        
                        $qry9 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='3' AND angkatan='$angkatan' AND smt_daftar='2'";
                        $result9 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku9 = mysqli_fetch_assoc($result9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData9 = $dataku9['jumData'];
                        
                        $qry10 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='4' AND angkatan='$angkatan' AND smt_daftar='2'";
                        $result10 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry10) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku10 = mysqli_fetch_assoc($result10) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData10 = $dataku10['jumData'];
                        
                        $qry11 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE status='5' AND angkatan='$angkatan' AND smt_daftar='2'";
                        $result11 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku11 = mysqli_fetch_assoc($result11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData11 = $dataku11['jumData'];
                        
                        $qry12 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE angkatan='$angkatan' AND smt_daftar='2'";
                        $result12 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku12 = mysqli_fetch_assoc($result12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData12 = $dataku12['jumData'];
                        
                        $qry13 = "SELECT COUNT(*) AS jumData FROM mag_peserta_sempro WHERE angkatan='$angkatan' AND smt_daftar='1'";
                        $result13 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku13 = mysqli_fetch_assoc($result13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumDataSpt1 = $dataku13['jumData'];

                        $qry14 = "SELECT COUNT(*) AS jumData FROM mag_peserta_ujtes WHERE angkatan='$angkatan' AND smt_daftar='1'";
                        $result14 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry14) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku14 = mysqli_fetch_assoc($result14) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumDataUt1 = $dataku14['jumData'];

                        $qry15 = "SELECT COUNT(*) AS jumData FROM mag_peserta_sempro WHERE angkatan='$angkatan' AND smt_daftar='2'";
                        $result15 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry15) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku15 = mysqli_fetch_assoc($result15) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumDataSpt2 = $dataku15['jumData'];

                        $qry16 = "SELECT COUNT(*) AS jumData FROM mag_peserta_ujtes WHERE angkatan='$angkatan' AND smt_daftar='2'";
                        $result16 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry16) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku16 = mysqli_fetch_assoc($result16) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumDataUt2 = $dataku16['jumData'];

                        $qry0 = "SELECT COUNT(*) AS jumData FROM mag_dt_mhssw_pasca WHERE angkatan='$angkatan'";
                        $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData0 = $dataku0['jumData'];
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td class="text-center"><?php echo $data['angkatan'];?></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalAktif1" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData1";?></button></td>
                        
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalSpt1" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumDataSpt1";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalUt1" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumDataUt1";?></button></td>

                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalLulus1" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData2";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalCuti1" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData3";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalDo1" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData4";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalNonAktif1" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData5";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-danger" title="Lihat data" data-toggle="modal" data-target="#modalTotal1" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData6";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalAktif2" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData7";?></button></td>
                        
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalSpt2" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumDataSpt2";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalUt2" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumDataUt2";?></button></td>

                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalLulus2" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData8";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalCuti2" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData9";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalDo2" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData10";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalNonAktif2" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData11";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-danger" title="Lihat data" data-toggle="modal" data-target="#modalTotal2" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData12";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-success" title="Lihat data" data-toggle="modal" data-target="#modalTotal" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData0";?></button></td>
                        <td class="text-center"><a href='editMhsswPerAngkatan.php?angkatan=<?php echo "$angkatan";?>' class='btn btn-sm btn-block btn-warning' title='Lihat dan edit'><span class="glyphicon glyphicon-edit"></span> Detail & Edit</a></td>
                      </tr>
                      <?php
                        $i++; 
                        $count++;
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
                <div class="text-center"><?php echo paginate_one($reload, $page, $tpages);?></div>
              </div>
              <div class="col-md-12">
                <h3 class="text-center">Chart Rekap Data Mahasiswa</h3>
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div id ="mygraph"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalImport" aria-labelledby="labelModalImport" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalImport">Import Data Mahasiswa Baru</h4>
            </div>
            <div class="modal-body">
              <div class="panel-default">
                <div class="panel-heading">
                  <b>Petunjuk:</b>
                  <ul class="list">
                    <li>Form ini untuk import data mahasiswa baru yang belum terdaftar di database.</li>
                    <li>File yang akan diimport hanya berekstensi .xls (Excel 97-2003).</li>
                    <li>Silahkan download template file untuk import data mahasiswa baru, dan silahkan baca di sheet "baca petunjuk" untuk pengisian kolom yang tersedia.</li>
                  </ul>
                </div>
                <form action="sformImportDataMhssw.php" method="post" enctype="multipart/form-data">
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="data_mahasiswa">Pilih File yang Akan Diimport:</label>
                      <input type="file" id="data_mahasiswa" name="data_mahasiswa" required>
                    </div>
                  </div>
                  <div class="panel-footer">
                    <input type="submit" name="submit" class="btn btn-primary" value="Import!" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalSpt1" aria-labelledby="labelModalSpt1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalSpt1">Data Mahasiswa yang Telah Mengikuti Seminar Proposal Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalSpt1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalUt1" aria-labelledby="labelModalUt1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalUt1">Data Mahasiswa yang Telah Mengikuti Ujian Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalUt1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalAktif1" aria-labelledby="labelModalAktif1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalAktif1">Data Mahasiswa yang Aktif</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalAktif1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalLulus1" aria-labelledby="labelModalLulus1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalLulus1">Data Mahasiswa yang Lulus</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalLulus1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalCuti1" aria-labelledby="labelModalCuti1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalCuti1">Data Mahasiswa yang Cuti</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalCuti1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDo1" aria-labelledby="labelModalDo1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDo1">Data Mahasiswa yang Drop Out</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDo1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalNonAktif1" aria-labelledby="labelModalNonAktif1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalNonAktif1">Data Mahasiswa yang Non Aktif</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalNonAktif1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalTotal1" aria-labelledby="labelModalTotal1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalTotal1">Total Data Mahasiswa</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalTotal1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalAktif2" aria-labelledby="labelModalAktif2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalAktif2">Data Mahasiswa yang Aktif</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalAktif2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalSpt2" aria-labelledby="labelModalSpt2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalSpt2">Data Mahasiswa yang Telah Mengikuti Seminar Proposal Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalSpt2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalUt2" aria-labelledby="labelModalUt2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalUt2">Data Mahasiswa yang Telah Mengikuti Ujian Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalUt2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalLulus2" aria-labelledby="labelModalLulus2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalLulus2">Data Mahasiswa yang Lulus</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalLulus2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalCuti2" aria-labelledby="labelModalCuti2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalCuti2">Data Mahasiswa yang Cuti</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalCuti2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDo2" aria-labelledby="labelModalDo2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDo2">Data Mahasiswa yang Drop Out</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDo2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalNonAktif2" aria-labelledby="labelModalNonAktif2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalNonAktif2">Data Mahasiswa yang Non Aktif</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalNonAktif2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalTotal2" aria-labelledby="labelModalTotal2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalTotal2">Total Data Mahasiswa</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalTotal2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalTotal" aria-labelledby="labelModalTotal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalTotal">Total Data Mahasiswa</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalTotal"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerAdm.php";?>
    <?php include "jsSourceAdm.php";?>
    <script>
      $(document).ready(function () {
      $("#myModal").modal({
       backdrop: false
      });
      $("#myModal").modal("show");
      });
      var chart1;
      $(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'mygraph',
            type: 'column'
         },   
         title: {
            text: 'Grafik Rekap Mahasiswa Per Semester'
         },
         xAxis: {
            categories: ['Angkatan'],
      crosshair: true
         },
         yAxis: {
            title: {
               text: 'Total Mahasiswa'
            }
         },
              series:    
            [
            <?php
        $sql   = "SELECT * FROM mag_dt_mhssw_pasca GROUP BY angkatan,smt_daftar";
        $query = mysqli_query($GLOBALS["___mysqli_ston"],  $sql )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
        while( $ret = mysqli_fetch_array( $query ) ){
        $smt_daftar=$ret['smt_daftar'];
        $angkatan=$ret['angkatan'];
             $sql_jumlah   = "SELECT COUNT(nim) AS jumData FROM mag_dt_mhssw_pasca WHERE smt_daftar='$smt_daftar' AND angkatan='$angkatan'";        
             $query_jumlah = mysqli_query($GLOBALS["___mysqli_ston"],  $sql_jumlah )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
             while( $data = mysqli_fetch_array( $query_jumlah ) ){
             $jumlah = $data['jumData'];                 
              }             
              ?>
                  {
                      name: '<?php echo $angkatan; ?> <?php echo "Semester:"; ?> <?php echo $smt_daftar; ?>',
                      data: [<?php echo $jumlah; ?>]
                  },
                  <?php } ?>
            ]
      });
      }); 
      
      $('#modalAktif1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswAktifPerAngkatan1Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalAktif1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalSpt1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswSemproPerAngkatan1Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalSpt1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });

      $('#modalUt1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswUjtesPerAngkatan1Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalUt1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });

      $('#modalLulus1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswLulusPerAngkatan1Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalLulus1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalCuti1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswCutiPerAngkatan1Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalCuti1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalDo1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswDoPerAngkatan1Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDo1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalNonAktif1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswNonAktifPerAngkatan1Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalNonAktif1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalTotal1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewTotalMhsswPerAngkatan1Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalTotal1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalAktif2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswAktifPerAngkatan2Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalAktif2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalSpt2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswSemproPerAngkatan2Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalSpt2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });

      $('#modalUt2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswUjtesPerAngkatan2Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalUt2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });

      $('#modalLulus2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswLulusPerAngkatan2Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalLulus2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalCuti2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswCutiPerAngkatan2Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalCuti2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalDo2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswDoPerAngkatan2Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDo2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalNonAktif2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewMhsswNonAktifPerAngkatan2Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalNonAktif2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalTotal2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewTotalMhsswPerAngkatan2Adm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalTotal2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalTotal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewTotalMhsswPerAngkatanAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalTotal').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
    </script>
    <script src="assets/js/highcharts.js"></script>
  </body>
</html>