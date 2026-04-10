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
    <?php include "navUploadAdm.php";
      include 'pagination.php';         
      if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
      $keyword=$_REQUEST['keyword'];
      $reload = "rekapUpload.php?pagination=true&keyword=$keyword";
      
      $sql = "SELECT mub.id,mub.tgl,mub.bln,mub.tahun,mub.tbt,mub.deskripsi,mub.kategori FROM mag_upload_berkas mub INNER JOIN kategori_upload_berkas kub ON mub.kategori=kub.id WHERE mub.tgl LIKE '%$keyword%' OR mub.bln LIKE '%$keyword%' OR mub.tahun LIKE '%$keyword%' OR mub.tbt LIKE '%$keyword%' OR mub.deskripsi LIKE '%$keyword%' OR kub.nm LIKE '%$keyword%' ORDER BY mub.id DESC";
      
      $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      }else{
      $reload = "rekapUpload.php?pagination=true";
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
    <div class="container-fluid">
      <div class="row">
        <?php          
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diinput</div>';}  
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';} 
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}     
                 ?>
        <h3 class="text-center text-warning">Upload Berkas</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut data upload berkas.</li>
              <li>Ekstensi file: <code>.doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip, .jpg dan .rtf</code>.</li>
              <li>Silahkan tekan button yang dimaksud untuk konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Data Upload Berkas</a></li>
                  <button role="presentation" class="btn btn-primary pull-right" title="Input periode baru" data-toggle="modal" data-target="#modalInput"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Upload Berkas Baru</button>
                </ul>
              </div>
              <div class="col-md-12">
                <form method="post" action="rekapUpload.php">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..."  value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="rekapUpload.php"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    <?php
                      }
                      ?>
                    </span>
                  </div>
                </form>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table-condensed table table-bordered table-striped custom" style="margin-bottom:0px; font-size:12px;">
                    <thead>
                      <tr class="">
                        <th class="text-center" width="4%">No.</th>
                        <th class="text-center" width="16%">Tanggal Upload</th>
                        <th class="text-center" width="20%">Kategori</th>
                        <th class="text-center" width="50%">Deskripsi</th>
                        <th class="text-center" width="8%">Opsi</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $id = $data['id'];
                        
                        $qberkas = "SELECT * FROM kategori_upload_berkas WHERE id='$data[kategori]'";
                        $rberkas = mysqli_query($GLOBALS["___mysqli_ston"], $qberkas)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dberkas = mysqli_fetch_assoc($rberkas);            
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td class="text-center"><?php echo $data['tbt'];?></td>
                        <td class="text-center"><?php echo $dberkas['nm'];?></td>
                        <td><?php echo $data['deskripsi'];?></td>
                        <td class="text-center">
                          <button class="btn btn-warning" title="Edit berkas" data-toggle="modal" data-target="#modalEdit" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                          <a class="btn btn-default" href="deleteUploadBerkas.php?id=<?php echo $data['id'];?>" onclick="return confirm('Yakin data ini dihapus?')" title="Hapus"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
      <div class="modal fade" tabindex="-1" role="dialog" id="modalInput" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="modalInput">Upload Berkas Baru</h4>
            </div>
            <div class="modal-body">
              <div class="panel panel-default">
                <div class="panel-body">
                  <form action="sformInputUploadBerkas.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="tbt">Tanggal Upload</label>
                      <div class="input-group date" id="datetimepicker1">
                        <input type="text" id="tbt" name="tbt" class="form-control" required>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="deskripsi">Deskripsi Berkas</label>
                      <input type="text" name="deskripsi" class="form-control" id="deskripsi" required>
                    </div>
                    <div class="form-group">
                      <label for="kategori">Kategori Berkas</label>
                      <select id="kategori" name="kategori" class="form-control" required>
                        <option value="">-Pilih-</option>
                        <?php
                          $q = mysqli_query($GLOBALS["___mysqli_ston"], "select * from kategori_upload_berkas ORDER BY nm ASC");
                          while ($tampil = mysqli_fetch_array($q)){
                            echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                          }
                          ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="berkas">Upload Berkas</label>
                      <input type="file" class="form-control" id="berkas" name="berkas" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Upload</button>
                  </form>
                </div>
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
              <h4 class="modal-title" id="modalEdit">Edit Upload Berkas</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
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
      
      $(document).ready(function() {
      $('#datetimepicker1')
      .datetimepicker({
      format: 'YYYY-MM-DD',
      });
      $('#datetimepicker1 input').click(function(event){
      $('#datetimepicker1 ').data("DateTimePicker").show();
      });
      });
      
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "editUploadBerkas.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalEdit').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
    </script>
  </body>
</html>