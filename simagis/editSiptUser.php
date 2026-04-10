<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_sipt WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qry = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $resp );
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateSiUser.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
      <div class="form-group">
        <label for="lembaga_tujuan_surat">Instansi/lembaga tujuan surat</label>
        <input type="text" name="lembaga_tujuan_surat" class="form-control" id="lembaga_tujuan_surat" placeholder="Contoh: Bagian Akademik Universitas Islam Negeri Maulana Malik Ibrahim Malang, dll." value="<?php echo $dataku['lembaga_tujuan_surat'];?>" required>
      </div>
      <div class="form-group">
        <label for="sebutan_pimpinan">Sebutan pimpinan untuk instansi/lembaga tujuan surat</label>
        <?php
          echo "<select name='sebutan_pimpinan' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM opsi_sebutan_pimpinan ORDER BY nm ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          	if ( $dataku['sebutan_pimpinan'] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$w[nm]</option>";
          	} else {
          		echo "<option value='$w[id]'>$w[nm]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="kota_penelitian">Kota instansi/lembaga tujuan surat</label>
        <?php
          echo "<select name='kota_penelitian' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          	if ( $dataku[ 'kota_penelitian' ] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
          	} else {
          		echo "<option value='$w[id]'>$w[nm_kota]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="nama_obyek">Tempat penelitian <br />
        <input type="checkbox" name="bilasama" onclick="IsiSama(this.form)" <?php if($dataku['nama_obyek']==$dataku['lembaga_tujuan_surat']) { echo "checked";}?>> Tempat observasi dan wawancara sama dengan instansi/lembaga tujuan surat
        </label>
        <input type="text" name="nama_obyek" class="form-control" id="nama_obyek" placeholder="Contoh: Fakultas Psikologi Universitas Islam Negeri Maulana Malik Ibrahim Malang, dll." value="<?php echo $dataku['nama_obyek'];?>" required>
      </div>
      <div class="form-group">
        <label for="tujuan_surat">Maksud permohonan surat:</label>
        <input type="text" name="tujuan_surat" class="form-control" id="tujuan_surat" value="<?php echo $dataku['tujuan_surat'];?>" placeholder="Contoh: Permohonan data bla bla bla, dll." required>
      </div>
      <div class="form-group">
                <label for="judul_tesis">Judul tesis:</label>
                <textarea name="judul_tesis" class="form-control" id="judul_tesis2" required><?php echo $dataku['judul_tesis'];?></textarea>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar untuk digunakan sebagaimana mestinya.
        </label>
      </div>
      <button type="submit" class="btn btn-success" name="update">Update</button>
      <button type="reset" class="btn btn-info">Ulang</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>
<script>
  function IsiSama(f) {
    if (f.bilasama.checked == true) {
      f.tempat_ow.value = f.lembaga_tujuan_surat.value;
    }
    if (f.bilasama.checked == false) {
      f.tempat_ow.value = "";
    }
  }

tinymce.init({
  selector: "textarea#judul_tesis2",
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
