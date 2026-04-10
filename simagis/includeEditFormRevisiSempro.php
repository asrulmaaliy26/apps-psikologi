<?php
  include("koneksiUser.php");
  $nim = $_SESSION[ 'nim' ];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
  $id_peserta = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id_pendaftaran']);
  $id_sempro = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id_sempro']);

  $q = "SELECT * FROM mag_revisi_sempro WHERE id='$id' AND id_peserta='$id_peserta' AND id_sempro='$id_sempro'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"],  $q )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $r );
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navPendUser.php";?>
    <div class="container">
      <div class="row">
        <h3 class="text-center text-info">Form Edit Upload Revisi Seminar Proposal Tesis</h3>
        <div class="panel panel-info">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah Form Edit Upload Revisi Seminar Proposal Tesis.</li>
              <li>Silahkan isi dengan benar.</li>
            </ul>
          </div>
          <form action="updateUploadRevisiSempro.php" method="post" enctype="multipart/form-data">
            <div class="panel-body">
              <div class="form-group">
                <label for="judul_prop">Judul proposal tesis (setelah direvisi):</label>
                <textarea name="judul_prop" class="form-control textedit" id="judul_prop" required><?php echo $dt['judul_prop'];?></textarea>
              </div>
              <div class="form-group">
                <?php if(empty($dt['file_prop'])) { echo '  
                  <label for="file_prop">Upload file proposal tesis (setelah direvisi):</label>
                  <input type="file" name="file_prop" class="form-control" id="file_prop" required>
                  <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan harus sudah bertandatangan sah dari dosen penguji seminar proposal tesis</code>.</p>';}
                  else {
                  echo '<label for="file_prop">File proposal tesis (setelah direvisi)<code> telah terupload!</code>. Ganti:</label>
                  <input type="file" name="file_prop" class="form-control" id="file_prop">
                  <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan telah direvisi</code>.</p>';
                  }
                  ?>
              </div>
              <div class="form-group">
                <?php if(empty($dt['file_form_revisi'])) { echo '  
                  <label for="file_form_revisi">Upload file form revisi seminar proposal tesis:</label>
                  <input type="file" name="file_form_revisi" class="form-control" id="file_form_revisi" required>
                  <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan telah ditandatangani dosen penguji seminar proposal tesis</code>.</p>';}
                  else {
                  echo '<label for="file_form_revisi">File form revisi seminar proposal tesis<code> telah terupload!</code>. Ganti:</label>
                  <input type="file" name="file_form_revisi" class="form-control" id="file_form_revisi">
                  <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan telah ditandatangani dosen penguji seminar proposal tesis</code>.</p>';
                  }
                  ?>
              </div>
              <div class="form-group">
                <label for="tgl_upload">Tanggal upload:</label>
                <input type="text" class="form-control" id="tgl_upload" value="<?php echo date("d-m-Y");?>" disabled>
                <input type="text" name="tgl_upload" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
              </div>
              <div class="checkbox">
                <label>
                <input type="checkbox" id="checked" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar.
                </label>
              </div>
            </div>
            <div class="panel-footer">
              <input type="text" name="id" class="sr-only" value="<?php echo $dt['id'];?>" required readonly>
              <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
              <button type="submit" class="btn btn-primary" name="update">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
    <script type="text/javascript" src="tinymce/tinymce.min.js"></script>
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
    </script>
  </body>
</html>