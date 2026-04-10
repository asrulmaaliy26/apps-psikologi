<?php
  include( "koneksiAdm.php" );
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_pengelompokan_dosen_wali WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateCatatanPacAdm.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <input type="text" name="id_periode" class="sr-only" value="<?php echo $dataku['id_periode'];?>" required readonly>
      <div class="form-group">
        <label for="catatan">Catatan yang Diberikan:</label>
        <textarea name="catatan" class="form-control textedit" id="catatan" required><?php echo $dataku['catatan'];?></textarea>
      </div>
      <button type="submit" class="btn btn-success" name="update">Submit</button>
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