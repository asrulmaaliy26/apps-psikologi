<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  
  $myquery = "select * from mag_upload_berkas WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $data = mysqli_fetch_assoc( $res );   
  ?>
<head>
  <?php include "headAdm.php";?>
</head>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateUploadBerkas.php" method="post" enctype="multipart/form-data">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <div class="form-group">
        <label for="tbt">Tanggal Upload</label>
        <div class="input-group date" id="datetimepicker2">
          <input type="text" id="tbt" name="tbt" class="form-control" value="<?php echo $data['tbt'];?>" required>
          <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
      <div class="form-group">
        <label for="deskripsi">Deskripsi Berkas</label>
        <input type="text" name="deskripsi" class="form-control" id="deskripsi" value="<?php echo $data['deskripsi'];?>" required>
      </div>
      <div class="form-group">
        <label for="kategori">Kategori Berkas</label>
        <?php
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_upload_berkas WHERE id='$id'" );
          $select = mysqli_fetch_array( $tampil );
          $dt = $select[ 'kategori' ];
          
          echo "<select name='kategori' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM kategori_upload_berkas ORDER BY nm ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
            if ( $dt == $w[ 'id' ] ) {
               echo "<option value='$w[id]' selected>$w[nm]</option>";
            } else {
               echo "<option value='$w[id]'>$w[nm]</option>";
            }
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="berkas"><?php if(empty($data['berkas'])) { echo 'Upload Berkas';} else { echo 'Ganti Berkas';}?></label>
        <input type="file" class="form-control" id="berkas" name="berkas">
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
  $(document).ready(function() {
  $('#datetimepicker2')
  .datetimepicker({
  format: 'YYYY-MM-DD',
  });
  $('#datetimepicker2 input').click(function(event){
  $('#datetimepicker2').data("DateTimePicker").show();
  });
  }); 
</script>