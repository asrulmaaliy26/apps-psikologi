<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_peserta_sempro WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qdpt = "select * from mag_pengelompokan_dospem_tesis WHERE nim='$nim'";
  $ddpt = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt = mysqli_fetch_assoc($ddpt);
  
  $qdpt1 = "select * from mag_dospem_tesis JOIN dt_pegawai ON mag_dospem_tesis.nip=dt_pegawai.id WHERE mag_dospem_tesis.id='$ddpt[dospem_tesis1]'";
  $ddpt1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt1 = mysqli_fetch_assoc($ddpt1);
  
  $qdpt2 = "select * from mag_dospem_tesis JOIN dt_pegawai ON mag_dospem_tesis.nip=dt_pegawai.id WHERE mag_dospem_tesis.id='$ddpt[dospem_tesis2]'";
  $ddpt2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt2 = mysqli_fetch_assoc($ddpt2);
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updatePendSemproUser.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="judul_prop">Judul proposal tesis:</label>
        <textarea name="judul_prop" class="form-control textedit" id="judul_prop" required><?php echo $dataku['judul_prop'];?></textarea>
      </div>
      <div class="form-group">
        <?php if(empty($dataku['file_prop'])) { echo '  
          <label for="file_prop">Upload file proposal tesis:</label>
          <input type="file" name="file_prop" class="form-control" id="file_prop" required>
          <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan harus sudah bertandatangan sah dari dosen pembimbing tesis</code>.</p>';}
          else {
          echo '<label for="file_prop">File proposal tesis <code>telah terupload!</code>. Ganti:</label>
          <input type="file" name="file_prop" class="form-control" id="file_prop">
          <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan harus sudah bertandatangan sah dari dosen pembimbing tesis</code>.</p>';
          }
          ?>
      </div>
      <div class="form-group">
        <?php if(empty($dataku['file_turnitin'])) { echo '  
          <label for="file_turnitin">Upload file lampiran turnitin:</label>
          <input type="file" name="file_turnitin" class="form-control" id="file_turnitin" required>
          <p class="help-text small"><code>* File berbentuk PDF dan angka maksimal similiarity: 25%</code>.</p>';}
          else {
          echo '<label for="file_turnitin">File lampiran turnitin <code>telah terupload!</code>. Ganti:</label>
          <input type="file" name="file_turnitin" class="form-control" id="file_turnitin">
          <p class="help-text small"><code>* File berbentuk PDF dan angka maksimal similiarity: 25%</code>.</p>';
          }
          ?>
      </div>
      <div class="form-group">
        <?php if(empty($dataku['file_toefl'])) { echo '  
          <label for="file_toefl">Upload file sertifikat TOEFL:</label>
          <input type="file" name="file_toefl" class="form-control" id="file_toefl">
          <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF, skor minimal TOEFL (dalam versi tercetak): 450</code>.</p>';}
          else {
          echo '<label for="file_toefl">File sertifikat TOEFL <code>telah terupload!</code>. Ganti:</label>
          <input type="file" name="file_toefl" class="form-control" id="file_toefl">
          <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF, skor minimal TOEFL (dalam versi tercetak): 450</code>.</p>';
          }
          ?>
      </div>
      <div class="form-group">
        <?php if(empty($dataku['file_transkrip'])) { echo '  
          <label for="file_transkrip">Upload file transkrip nilai terakhir:</label>
          <input type="file" name="file_transkrip" class="form-control" id="file_transkrip">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';}
          else {
          echo '<label for="file_transkrip">Upload file transkrip nilai terakhir <code>telah terupload!</code>. Ganti:</label>
          <input type="file" name="file_transkrip" class="form-control" id="file_transkrip">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';
          }
          ?>
      </div>
      <div class="form-group">
        <?php if(empty($dataku['file_audien'])) { echo '  
          <label for="file_audien">Bukti keikutsertaan sebagai audien seminar proposal tesis:</label>
          <input type="file" name="file_audien" class="form-control" id="file_audien">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';}
          else {
          echo '<label for="file_audien">Bukti keikutsertaan sebagai audien seminar proposal tesis <code>telah terupload!</code>. Ganti:</label>
          <input type="file" name="file_audien" class="form-control" id="file_audien">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';
          }
          ?>
      </div>
      <div class="form-group">
        <?php if(empty($dataku['file_diseminasi'])) { echo '  
          <label for="file_diseminasi">Bukti diseminasi publik yang telah dicapai:</label>
          <input type="file" name="file_diseminasi" class="form-control" id="file_diseminasi">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';}
          else {
          echo '<label for="file_diseminasi">Bukti diseminasi publik yang telah dicapai <code>telah terupload!</code>. Ganti:</label>
          <input type="file" name="file_diseminasi" class="form-control" id="file_diseminasi">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';
          }
          ?>
      </div>
      <div class="form-group">
        <?php if(empty($dataku['file_publikasi'])) { echo '  
          <label for="file_publikasi">Bukti publikasi ilmiah (Jurnal/book chapter/publikasi ilmiah lainnya):</label>
          <input type="file" name="file_publikasi" class="form-control" id="file_publikasi">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';}
          else {
          echo '<label for="file_publikasi">Bukti publikasi ilmiah (Jurnal/book chapter/publikasi ilmiah lainnya) <code>telah terupload!</code>. Ganti:</label>
          <input type="file" name="file_publikasi" class="form-control" id="file_publikasi">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';
          }
          ?>
      </div>
      <div class="form-group">
        <?php if(empty($dataku['file_kwitansi'])) { echo '  
          <label for="file_kwitansi">Bukti kwitansi pembayaran seminar proposal tesis:</label>
          <input type="file" name="file_kwitansi" class="form-control" id="file_kwitansi">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';}
          else {
          echo '<label for="file_kwitansi">Bukti kwitansi pembayaran seminar proposal tesis <code>telah terupload!</code>. Ganti:</label>
          <input type="file" name="file_kwitansi" class="form-control" id="file_kwitansi">
          <p class="help-text small"><code>* File berbentuk PDF</code>.</p>';
          }
          ?>
      </div>
      <div class="form-group">
        <label for="dospem_tesis1">Dosen pembimbing tesis I:</label>
        <input type="text" class="form-control" id="dospem_tesis1" value="<?php echo $ddpt1['nama'];?>" required disabled>
      </div>
      <div class="form-group">
        <label for="dospem_tesis2">Dosen pembimbing tesis II:</label>
        <input type="text" class="form-control" id="dospem_tesis2" value="<?php echo $ddpt2['nama'];?>" required disabled>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" id="checked" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar.
        </label>
      </div>
      <input type="text" name="id" class="sr-only" value="<?php echo $dataku['id'];?>" required readonly>
      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" required readonly>
      <input type="text" name="tgl_pendaftaran" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
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
</script>