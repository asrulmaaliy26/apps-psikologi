<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];   
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navMasterDataAdm.php";
      include 'pagination.php';     
       if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
       $keyword=$_REQUEST['keyword'];
       $reload = "rekapJudulTesisAdm.php?pagination=true&keyword=$keyword";
       
       $sql = "SELECT mrt.id
       , mrt.id_ujtes
       , mrt.nim
       , mrt.judul_tesis
       , mrt.file_tesis
       , mrt.file_form_revisi
       , mrt.tgl_upload
      FROM mag_revisi_tesis mrt
      INNER JOIN mag_dt_mhssw_pasca mdmp
       on mrt.nim = mdmp.nim
      
      WHERE mrt.nim LIKE '%$keyword%' OR mdmp.nama LIKE '%$keyword%' OR mrt.judul_tesis LIKE '%$keyword%' OR mrt.tgl_upload LIKE '%$keyword%'";
       
       $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       }else{
       $reload = "rekapJudulTesisAdm.php?pagination=true";
       $sql = "SELECT * FROM mag_revisi_tesis ORDER BY id_ujtes DESC";
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
    <div class="container-fluid">
      <div class="row">
        <h3 class="text-center text-warning">Judul Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah semua data Judul Tesis.</li>
              <li>Silahkan tekan button pada kolom opsi untuk melihat data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Semua Data</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <form method="post" action="rekapJudulTesisAdm.php">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="rekapJudulTesisAdm.php"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    <?php
                      }
                      ?>
                    </span>
                  </div>
                </form>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class=" table table-condensed table-bordered table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th class="text-center" width="3%">No.</th>
                        <th class="text-center" width="23%">Nama | NIM</th>
                        <th class="text-center" width="48%">Judul Tesis</th>
                        <th class="text-center" width="18%">Periode Pendaftaran</th>
                        <th class="text-center" width="4%">File</th>
                        <th class="text-center" width="4%">Opsi</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        
                        $id=$data['id'];
                        
                        $qnm =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim = '$data[nim]'";
                        $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnm);
                        $dnm = mysqli_fetch_assoc($r);
                        
                        $qryperiod = "SELECT * FROM mag_periode_pendaftaran_ujtes WHERE id='$data[id_ujtes]'";
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
                         
                        $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                        $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
                        $dsemester = mysqli_fetch_assoc($h);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php echo $dnm['nama'].' | '.$dnm['nim'];?></td>
                        <td><?php echo $data['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_tesis']);?></td>
                        <td><?php echo 'Thp.'.' '.$dthp['tahap'].' Smt.'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?></td>
                        <td class="text-center"><?php if(empty($data['file_tesis'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_tesis'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center">
                          <button class="btn btn-primary" title="Lihat detail" data-toggle="modal" data-target="#modalDetail" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-folder-open"></span></button>           
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
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetail" aria-labelledby="labelModalDetail" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetail">Detail Data</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetail"></div>
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
      
      $('#modalDetail').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient; 
      $.ajax({
      type: "GET",
      url: "detailRevisiTesPerIndAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDetail').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });      
    </script>
  </body>
</html>