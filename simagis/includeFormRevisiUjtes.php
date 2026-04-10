<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  $id_ujtes = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id_ujtes']);
  $id_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id_pendaftaran']);
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navPendUser.php";?>
    <div class="container">
      <div class="row">
        <h3 class="text-center text-info">Form Upload Revisi Tesis</h3>
        <div class="panel panel-info">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah Form Upload Revisi Tesis.</li>
              <li>Silahkan isi dengan benar.</li>
            </ul>
          </div>
          <form action="sformUploadRevisiUjtes.php" method="post" enctype="multipart/form-data">
            <div class="panel-body">
              <div class="form-group">
                <label for="judul_tesis">Judul tesis (setelah direvisi):</label>
                <textarea name="judul_tesis" class="form-control textinput" id="judul_tesis" required></textarea>
              </div>
              <div class="form-group">
                <label for="variable_x1">Variabel X 1:</label>
                <select name="variable_x1" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_variablexy ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Variabel Tesis (X dan Y) => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="variable_x2">Variabel X 2:</label>
                <select name="variable_x2" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_variablexy ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Variabel Tesis (X dan Y) => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="variable_x3">Variabel X 3:</label>
                <select name="variable_x3" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_variablexy ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Variabel Tesis (X dan Y) => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="variable_y1">Variabel Y 1:</label>
                <select name="variable_y1" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_variablexy ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Variabel Tesis (X dan Y) => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="variable_y2">Variabel Y 2:</label>
                <select name="variable_y2" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_variablexy ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Variabel Tesis (X dan Y) => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="variable_y3">Variabel Y 3:</label>
                <select name="variable_y3" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_variablexy ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Variabel Tesis (X dan Y) => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="co_variable_1">Co-Variabel 1:</label>
                <select name="co_variable_1" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_covariable ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Co-Variable => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="co_variable_2">Co-Variabel 2:</label>
                <select name="co_variable_2" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_covariable ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Co-Variable => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="co_variable_3">Co-Variabel 3:</label>
                <select name="co_variable_3" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_covariable ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Co-Variable => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="mediator">Variabel Mediator:</label>
                <select name="mediator" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_mediatorvariable ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Variable Mediator => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="moderator">Variabel Moderator:</label>
                <select name="moderator" class="form-control">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_moderatorvariable ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
                <p class="help-text small"><code>* Jika tidak ada di list, silahkan tekan button Bank => Variabel Tesis => Variable Moderator => Input Variabel Baru di kanan atas</code>.</p>
              </div>
              <div class="form-group">
                <label for="jns_penel">Jenis Penelitian:</label>
                <select name="jns_penel" class="form-control" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_jns_pen ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="jns_alat_ukur">Jenis Alat Ukur:</label>
                <select name="jns_alat_ukur" class="form-control" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_jns_alat_ukur ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="keyword_1">Keyword 1:</label>
                <input name="keyword_1" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="keyword_2">Keyword 2:</label>
                <input name="keyword_2" class="form-control">
              </div>
              <div class="form-group">
                <label for="keyword_3">Keyword 3:</label>
                <input name="keyword_3" class="form-control">
              </div>
              <div class="form-group">
                <label for="keyword_4">Keyword 4:</label>
                <input name="keyword_4" class="form-control">
              </div>
              <div class="form-group">
                <label for="link_pub">Link Publikasi (Jurnal) Tesis:</label>
                <input name="link_pub" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="file_tesis">Upload file proposal tesis (setelah direvisi):</label>
                <input type="file" name="file_tesis" class="form-control" id="file_tesis" required>
                <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan telah direvisi</code>.</p>
              </div>
              <div class="form-group">
                <label for="file_form_revisi">Upload file form revisi tesis:</label>
                <input type="file" name="file_form_revisi" class="form-control" id="file_form_revisi" required>
                <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan telah ditandatangani dosen penguji tesis</code>.</p>
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
              <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id_pendaftaran;?>" required readonly>
              <input type="text" name="id_ujtes" class="sr-only" value="<?php echo $id_ujtes;?>" required readonly>
              <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" required readonly>
              <input type="text" name="cek" class="sr-only" value="1" required readonly>
              <button type="submit" class="btn btn-primary" name="submit">Submit</button>
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
    </script>
  </body>
</html>