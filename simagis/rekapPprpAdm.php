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
    <?php include "navPngjnAdm.php";
      $qry = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun GROUP BY angkatan";
         $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $jumlahData = $dataku['jumData'];
         	  
          include 'pagination.php';                 
       	  $reload = "rekapPprpAdm.php?pagination=true";
       	  $sql =  "SELECT * FROM mag_pengelompokan_rumpun GROUP BY angkatan ORDER BY angkatan DESC";
       	  $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
           $rpp = 50;
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
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}	
            ?>
        <h3 class="text-center text-warning">Peminatan Rumpun Psikologi</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah rekap Pengajuan Peminatan Rumpun Psikologi Per Angkatan.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat data.</li>
              <li>Silahkan tekan button <code>Lihat</code> untuk melihat dan memverifikasi pengajuan.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Rekap Pengajuan</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-condensed table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th rowspan="2" class="text-center" width="4%">No.</th>
                        <th rowspan="2" class="text-center" width="25%">Angkatan</th>
                        <th colspan="5" class="text-center">Pengajuan Peminatan Rumpun Psikologi</th>
                        <th colspan="2" class="text-center">Verifikasi</th>
                        <th rowspan="2" class="text-center" width="6%">Opsi</th>
                      </tr>
                      <tr>
                        <th class="text-center" width="7%">Klinis</th>
                        <th class="text-center" width="7%">Pendidikan</th>
                        <th class="text-center" width="7%">Industri</th>
                        <th class="text-center" width="7%">Sosial</th>
                        <th class="text-center" width="7%">Total</th>
                        <th class="text-center" width="7%">Belum</th>
                        <th class="text-center" width="7%">Sudah</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $angkatan=$data['angkatan'];
                        
                        $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE rumpun='1' AND angkatan='$angkatan'";
                        $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData1 = $dataku1['jumData'];
                        
                        $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE rumpun='2' AND angkatan='$angkatan'";
                        $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData2 = $dataku2['jumData'];
                        
                        $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE rumpun='3' AND angkatan='$angkatan'";
                        $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData3 = $dataku3['jumData'];
                        
                        $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE rumpun='4' AND angkatan='$angkatan'";
                        $result4 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData4 = $dataku4['jumData'];
                        
                        $qry5 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE cek='1' AND angkatan='$angkatan'";
                        $result5 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData5 = $dataku5['jumData'];
                        
                        $qry6 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE cek='2' AND angkatan='$angkatan'";
                        $result6 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData6 = $dataku6['jumData'];
                        
                        $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun WHERE angkatan='$angkatan'";
                        $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData0 = $dataku0['jumData'];
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td class="text-center"><?php echo $data['angkatan'];?></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalKlinis" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData1";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalPendidikan" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData2";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalIndustri" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData3";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalSosial" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData4";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat data" data-toggle="modal" data-target="#modalTotal" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData0";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-danger" title="Lihat data" data-toggle="modal" data-target="#modalBelum" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData5";?></button></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-success" title="Lihat data" data-toggle="modal" data-target="#modalSudah" data-whatever="<?php echo "$angkatan";?>"><?php echo"$jumlahData6";?></button></td>
                        <td class="text-center"><a href='pprpPerAngkatan.php?angkatan=<?php echo "$angkatan";?>' class='btn btn-sm btn-block btn-warning' title='Lihat dan verifikasi'><span class="glyphicon glyphicon-edit"></span> Lihat</a></td>
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
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalKlinis" aria-labelledby="labelModalKlinis" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalKlinis">Data yang Mengajukan Peminatan Rumpun Psikologi Klinis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalKlinis"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalPendidikan" aria-labelledby="labelModalPendidikan" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalPendidikan">Data yang Mengajukan Peminatan Rumpun Psikologi Pendidikan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalPendidikan"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalIndustri" aria-labelledby="labelModalIndustri" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalIndustri">Data yang Mengajukan Peminatan Rumpun Psikologi Industri</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalIndustri"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalSosial" aria-labelledby="labelModalSosial" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalSosial">Data yang Mengajukan Peminatan Rumpun Psikologi Sosial</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalSosial"></div>
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
              <h4 class="modal-title" id="modalTotal">Total Data Pengajuan Peminatan Rumpun Psikologi Per Angkatan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalTotal"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalBelum" aria-labelledby="labelModalBelum" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalBelum">Data Pengajuan yang Belum Diverifikasi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalBelum"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalSudah" aria-labelledby="labelModalSudah" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalSudah">Data Pengajuan yang Telah Diverifikasi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalSudah"></div>
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
      
      $('#modalKlinis').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPprpKlinisPerAngkatanAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalKlinis').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalPendidikan').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPprpPendidikanPerAngkatanAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalPendidikan').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalIndustri').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPprpIndustriPerAngkatanAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalIndustri').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalSosial').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPprpSosialPerAngkatanAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalSosial').html(data);
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
      url: "viewTotalPprpPerAngkatanAdm.php",
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
      
      $('#modalBelum').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPprpBelumPerAngkatanAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalBelum').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalSudah').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'angkatan=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPprpSudahPerAngkatanAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalSudah').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
    </script>
  </body>
</html>