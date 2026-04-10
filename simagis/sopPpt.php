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
  
   $qsop = "select * from mag_sop_ppt";
   $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dsop = mysqli_fetch_assoc($rsop);
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navSopAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';} 
            ?>
        <h3 class="text-center text-warning">SOP Pengajuan Pembimbing Tesis</h3>
        <form action="updateSopPpt.php" method="post" enctype="multipart/form-data">
          <div class="panel panel-success">
            <div class="panel-heading">
              <ul class="list">
                <li>Berikut deskripsi SOP (Standar Operasional Procedure) Pengajuan Pembimbing Tesis.</li>
                <li>Setelah edit data, silahkan tekan button Update.</li>
              </ul>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="isi">Deskripsi:</label>
                <textarea name="isi" class="form-control textedit" id="isi" required><?php echo $dsop['isi'];?></textarea>
              </div>
            </div>
            <div class="panel-footer">
              <input type="text" name="id" class="sr-only" value="<?php echo $dsop['id'];?>" required readonly>
              <button type="submit" class="btn btn-primary" name="update">Update</button>
            </div>
          </div>
        </form>
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