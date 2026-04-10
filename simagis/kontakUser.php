<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navKontakUser.php";
      $qry = "SELECT COUNT(*) AS jumData FROM mag_kontak_layanan";
         $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $jumlahData = $dataku['jumData'];
      
      include 'paginationUser.php';         
            $reload = "kontakUser.php?pagination=true";
          $sql =  "SELECT * FROM mag_kontak_layanan ORDER BY id ASC";
          $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
           $rpp = 20;
           $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
           $tcount = mysqli_num_rows($result);
           $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
           $count = 0;
           $i = ($page-1)*$rpp;
           $no_urut = ($page-1)*$rpp;
          ?>
    <div class="container">
      <div class="row">
        <h3 class="text-center text-info">Kontak</h3>
        <div class="col-lg-12">
          <div class="row">
            <div class="panel panel-info">
              <div class="panel-heading">
                <ul class="list">
                  <li>Berikut adalah data kontak beserta deskripsinya yang dapat dihubungi terkait kegiatan akademik.</li>
                  <li>Silahkan pilih sesuai dengan tujuan dan maksud Anda.</li>
                </ul>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered custom" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr class="success">
                        <th rowspan="2" class="text-center" width="4%" style="vertical-align: middle;">No.</th>
                        <th rowspan="2" class="text-center" width="20%" style="vertical-align: middle;">Nama</th>
                        <th colspan="2" class="text-center" style="vertical-align: middle;">Kontak</th>
                        <th rowspan="2" class="text-center" width="44%" style="vertical-align: middle;">Spesifikasi Layanan</th>
                      </tr>
                      <tr class="success">
                        <th class="text-center" width="12%" style="vertical-align: middle;">HP</th>
                        <th class="text-center" width="20%" style="vertical-align: middle;">Email</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $id = $data['id'];            
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php echo $data['nm'];?></td>
                        <td class="text-center"><?php echo $data['hp'];?></td>
                        <td class="text-center"><?php echo $data['email'];?></td>
                        <td><?php echo $data['deskripsi_layanan'];?></td>
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
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Form Edit Peminatan Rumpun Psikologi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
  </body>
</html>