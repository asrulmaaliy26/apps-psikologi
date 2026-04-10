<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];   
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPendAdm.php";
    $qry = "SELECT COUNT(*) AS jumData FROM mag_revisi_sempro";
    $resj =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $dataku = mysqli_fetch_assoc($resj) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $jumData = $dataku['jumData'];
            
    include 'pagination.php';                 
    $reload = "rekapRevisiProAdm.php?pagination=true";
    $sql =  "SELECT * FROM mag_revisi_sempro GROUP BY id_sempro ORDER BY id_sempro DESC";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
    $rpp = 20;
    $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
    $tcount = mysqli_num_rows($result);
    $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
    $count = 0;
    $i = ($page-1)*$rpp;
    $no_urut = ($page-1)*$rpp;
    ?>
    <div class="container-fluid">
      <div class="row">
        <h3 class="text-center text-warning">Revisi Seminar Proposal Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Revisi Seminar Proposal Tesis berdasarkan periode pendaftaran.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Periode Pendaftaran</a></li>
                  <li role="presentation"><a href="rekapAllRevisiProAdm.php">Semua Data</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class=" table table-condensed table-bordered table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th class="text-center" width="3%" rowspan="2">No.</th>
                        <th class="text-center" width="48%"rowspan="2">Periode Pendaftaran</th>
                        <th class="text-center" colspan="3">Status Validasi</th>
                        <th class="text-center" width="8%" rowspan="2">Total</th>
                        <th class="text-center" width="17%" rowspan="2">Opsi</th>
                      </tr>
                      <tr>
                        <th class="text-center" width="8%">Belum</th>
                        <th class="text-center" width="8%">Diterima</th>
                        <th class="text-center" width="8%">Ditolak</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $no=0;
                        $id_sempro=$data['id_sempro'];
                        
                        $qryperiod = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$id_sempro'";
                        $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dperiod = mysqli_fetch_assoc($rperiod);
                        $tahap = $dperiod['tahap'];
                        $ta = $dperiod['ta'];
                         
                        $qry_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$tahap'";
                        $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_thp);
                        $dthp = mysqli_fetch_assoc($hasil);
                         
                        $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
                        $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
                        $dnta = mysqli_fetch_assoc($hasil);
                        $dta = $dnta['semester']; 
                        
                        $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dta'";
                        $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
                        $dsemester = mysqli_fetch_assoc($h);
                        
                        $qjum = "SELECT COUNT(*) AS jumData FROM mag_revisi_sempro WHERE id_sempro='$id_sempro'";
                        $resjum =  mysqli_query($GLOBALS["___mysqli_ston"], $qjum) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $d = mysqli_fetch_assoc($resjum) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData = $d['jumData'];

                        $qjb = "SELECT COUNT(*) AS jumData FROM mag_revisi_sempro WHERE id_sempro='$id_sempro' AND cek='1'";
                        $rjb =  mysqli_query($GLOBALS["___mysqli_ston"], $qjb) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $djb = mysqli_fetch_assoc($rjb) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jb = $djb['jumData'];

                        $qjter = "SELECT COUNT(*) AS jumData FROM mag_revisi_sempro WHERE id_sempro='$id_sempro' AND cek='2'";
                        $rjbter =  mysqli_query($GLOBALS["___mysqli_ston"], $qjter) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $djter = mysqli_fetch_assoc($rjbter) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jter = $djter['jumData'];

                        $qjtol = "SELECT COUNT(*) AS jumData FROM mag_revisi_sempro WHERE id_sempro='$id_sempro' AND cek='3'";
                        $rjbtol =  mysqli_query($GLOBALS["___mysqli_ston"], $qjtol) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $djtol = mysqli_fetch_assoc($rjbtol) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jtol = $djtol['jumData'];
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?></td>
                        <td class="text-center"><?php echo $jb;?></td>
                        <td class="text-center"><?php echo $jter;?></td>
                        <td class="text-center"><?php echo $jtol;?></td>
                        <td class="text-center"><?php echo $jumlahData;?></td>
                        <td class="text-center">
                          <a href='detailRekapRevisiProPerPeriode.php?id_sempro=<?php echo "$id_sempro";?>&page=<?php echo "$page";?>' class='btn btn-warning btn-sm btn-block' title='Lihat dan validasi'>Lihat dan Validasi</a>
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
                <div class="text-center"><?php echo paginate_one($reload, $page, $tpages); ?></div>
              </div>
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
    </script>
  </body>
</html>