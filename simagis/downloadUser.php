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
    <?php include "navBankUser.php";
      include 'paginationUser.php';         
            if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
            $keyword=$_REQUEST['keyword'];
            $reload = "downloadUser.php?pagination=true&keyword=$keyword";
            
            $sql = "SELECT mub.tgl,mub.bln,mub.tahun,mub.tbt,mub.deskripsi,mub.kategori FROM mag_upload_berkas mub INNER JOIN kategori_upload_berkas kub ON mub.kategori=kub.id WHERE mub.tgl LIKE '%$keyword%' OR mub.bln LIKE '%$keyword%' OR mub.tahun LIKE '%$keyword%' OR mub.tbt LIKE '%$keyword%' OR mub.deskripsi LIKE '%$keyword%' OR kub.nm LIKE '%$keyword%' ORDER BY mub.id DESC";
      
            $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
            }else{
            $reload = "downloadUser.php?pagination=true";
            $sql =  "SELECT * FROM mag_upload_berkas ORDER BY id DESC";
            $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
            }
            
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
        <h3 class="text-center text-info">Download</h3>
        <div class="col-lg-12">
          <div class="row">
            <div class="panel panel-info">
              <div class="panel-heading">
                <ul class="list">
                  <li>Berikut adalah berkas-berkas yang berkaitan dengan kegiatan akademik.</li>
                  <li>Silahkan tekan button Download pada kolom Opsi untuk download berkas.</li>
                </ul>
              </div>
              <div class="panel-body">
                <form method="post" action="downloadUser.php">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..."  value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="downloadUser.php"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    <?php
                      }
                      ?>
                    </span>
                  </div>
                </form>
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered custom" style="margin-bottom:0px;">
                    <thead>
                      <tr class="success">
                        <th width="4%">No.</th>
                        <th class="text-center" width="16%">Tanggal Upload</th>
                        <th width="20%">Kategori</th>
                        <th width="50%">Deskripsi</th>
                        <th width="8%" class="text-center">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $id=$data['id'];
                        $kategori=$data['kategori'];
                        
                        $qkat = "SELECT * FROM kategori_upload_berkas WHERE id='$kategori'";
                        $rkat = mysqli_query($GLOBALS["___mysqli_ston"], $qkat)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dkat = mysqli_fetch_assoc($rkat);
                        ?>
                      <tr>
                        <td><?php echo ++$no;?></td>
                        <td class="text-center"><?php echo $data['tbt'];?></td>
                        <td><?php echo $dkat['nm'];?></td>
                        <td><?php echo $data['deskripsi'];?></td>
                        <td style="text-align:center;"><a class='btn btn-primary center-block' title='Download' href="<?php echo $data['berkas'];?>" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>
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