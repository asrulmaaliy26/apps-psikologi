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
      $reload = "rekapPengumuman.php?pagination=true&keyword=$keyword";
      
      $sql = "SELECT * FROM mag_upload_pengumuman WHERE judul LIKE '%$keyword%' OR isi LIKE '%$keyword%' OR tbt LIKE '%$keyword%' ORDER BY id DESC";
      
      $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      }else{
      $reload = "rekapPengumuman.php?pagination=true";
      $sql =  "SELECT * FROM mag_upload_pengumuman ORDER BY id ASC";
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
        <h3 class="text-center text-warning">Upload Pengumuman</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut data upload pengumuman.</li>
              <li>Silahkan tekan button yang dimaksud untuk konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Data Upload Pengumuman</a></li>
                  <button role="presentation" class="btn btn-primary pull-right" title="Input pengumuman baru" data-toggle="modal" data-target="#modalInput"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Upload Pengumuman Baru</button>
                </ul>
              </div>
              <div class="col-md-12">
                <form method="post" action="rekapPengumuman.php">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..."  value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="rekapPengumuman.php"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
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
                        <th class="text-center" width="70%">Judul</th>
                        <th class="text-center" width="8%">Opsi</th>
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
                        <td class="text-center"><?php echo $data['tbt'];?></td>
                        <td><?php echo $data['judul'];?></td>
                        <td class="text-center">
                          <button class="btn btn-warning" title="Edit pengumuman" data-toggle="modal" data-target="#modalEdit" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                          <a class="btn btn-default" href="deleteUploadPengumuman.php?id=<?php echo $data['id'];?>&page=<?php echo "$page";?>" onclick="return confirm('Yakin data ini dihapus?')" title="Hapus"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="modalInput">Upload Pengumuman Baru</h4>
            </div>
            <div class="modal-body">
              <div class="panel panel-default">
                <div class="panel-body">
                  <form action="sformInputUploadPengumuman.php" method="post" enctype="multipart/form-data">
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
                      <label for="judul">Judul Pengumuman</label>
                      <input type="text" name="judul" class="form-control" id="judul" required>
                    </div>
                    <div class="form-group">
                      <label for="isi">Isi Pengumuman</label>
                      <textarea name="isi" class="form-control textinput" id="isi" required></textarea>
                    </div>
                    <div class="checkbox">
                      <label>
                      <input type="checkbox" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar.
                      </label>
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
              <h4 class="modal-title" id="modalEdit">Edit Upload Pengumuman</h4>
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
      
      tinymce.init({
      selector: ".textinput",
      setup: function (editor) {
      editor.on('change', function () {
      tinymce.triggerSave();
      });
      },
      theme: "modern",
      plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table contextmenu directionality emoticons template paste textcolor", "autoresize"
      ],
      content_css: "css/content.css",
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
      style_formats: [{
      title: 'Bold text',
      inline: 'b'
      },
      {
      title: 'Red text',
      inline: 'span',
      styles: {
      color: '#ff0000'
      }
      },
      {
      title: 'Red header',
      block: 'h1',
      styles: {
      color: '#ff0000'
      }
      },
      {
      title: 'Example 1',
      inline: 'span',
      classes: 'example1'
      },
      {
      title: 'Example 2',
      inline: 'span',
      classes: 'example2'
      },
      {
      title: 'Table styles'
      },
      {
      title: 'Table row 1',
      selector: 'tr',
      classes: 'tablerow1'
      }
      ]
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
      url: "editUploadPengumuman.php",
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