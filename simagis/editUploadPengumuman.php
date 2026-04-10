<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  
  $myquery = "select * from mag_upload_pengumuman WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $data = mysqli_fetch_assoc( $res );   
  ?>
<head>
  <?php include "headAdm.php";?>
</head>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateUploadPengumuman.php" method="post" enctype="multipart/form-data">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <div class="form-group">
                      <label for="tbt">Tanggal Upload</label>
                      <div class="input-group date" id="datetimepicker2">
                        <input type="text" id="tbt" name="tbt" class="form-control" value="<?php echo $data['tbt']?>" required>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="judul">Judul Pengumuman</label>
                        <input type="text" name="judul" class="form-control" id="judul" value="<?php echo $data['judul']?>" required>
                    </div>
                    <div class="form-group">
                      <label for="isi">Isi Pengumuman</label>
                        <textarea name="isi" class="form-control textedit" id="textedit" required><?php echo $data['isi']?></textarea>
                    </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar.
        </label>
      </div>
      <button type="submit" class="btn btn-success" name="update">Update</button>
      <button type="reset" class="btn btn-info">Ulang</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>
<script>
  tinymce.init({
      selector: ".textedit",
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
  $('#datetimepicker2')
  .datetimepicker({
  format: 'YYYY-MM-DD',
  });
  $('#datetimepicker2 input').click(function(event){
  $('#datetimepicker2 ').data("DateTimePicker").show();
  });
  }); 
</script>