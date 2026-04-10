<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  
  $id_sempro = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_periode_pendaftaran_sempro WHERE id='$id_sempro'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$dataku[ta]'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);

  $qry_grade = "SELECT * FROM mag_grade_sempro WHERE id_sempro='$id_sempro'";
  $res_grade = mysqli_query($GLOBALS["___mysqli_ston"], $qry_grade);
  $dt_grade = mysqli_fetch_assoc($res_grade);
  ?>
<head>
  <?php include 'headAdm.php';?>
</head>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updatePeriodePendSemproAdm.php" method="post">
      <input type="text" name="id_sempro" class="sr-only" value="<?php echo $dataku['id'];?>" required readonly>
      <input type="text" name="ta" class="sr-only" value="<?php echo $dnta['id'];?>" required readonly>
      <div class="form-group">
        <label for="tahap">Tahap</label>
        <?php
          echo "<select class='form-control' aria-label='tahap' name='tahap' id='tahap' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_tahap_ujprop_ujtes ORDER BY id ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
            if ( $dataku['tahap'] == $w[ 'id' ] ) {
              echo "<option value='$w[id]' selected>$w[tahap]</option>";
            } else {
              echo "<option value='$w[id]'>$w[tahap]</option>";
            }
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="start_datetime">Awal Durasi Pendaftaran</label>
        <div class="input-group date" id="datetimepicker3">
          <input type="text" id="start_datetime" name="start_datetime" class="form-control" value="<?php echo $dataku['start_datetime'];?>" required>
          <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
      <div class="form-group">
        <label for="end_datetime">Akhir Durasi Pendaftaran</label>
        <div class="input-group date" id="datetimepicker4">
          <input type="text" id="end_datetime" name="end_datetime" class="form-control" value="<?php echo $dataku['end_datetime'];?>" required>
          <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="lt">Grade Atas Lanjut</label>
          <input type="number" max="100" step=".0001" name="lt" class="form-control" value="<?php echo $dt_grade['lt'];?>" required>
        </div>
        <div class="form-group col-md-6">
          <label for="lb">Grade Bawah Lanjut</label>
          <input type="number" step=".0001" name="lb" class="form-control" value="<?php echo $dt_grade['lb'];?>" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="lrt">Grade Atas Lanjut Revisi</label>
          <input type="number" step=".0001" name="lrt" class="form-control" value="<?php echo $dt_grade['lrt'];?>" required>
        </div>
        <div class="form-group col-md-6">
          <label for="lrb">Grade Bawah Lanjut Revisi</label>
          <input type="number" step=".0001" name="lrb" class="form-control" value="<?php echo $dt_grade['lrb'];?>" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="sut">Grade Atas Seminar Ulang</label>
          <input type="number" step=".0001" name="sut" class="form-control" value="<?php echo $dt_grade['sut'];?>" required>
        </div>
        <div class="form-group col-md-6">
          <label for="sub">Grade Bawah Seminar Ulang</label>
          <input type="number" step=".0001" name="sub" class="form-control" value="<?php echo $dt_grade['sub'];?>" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Update</button>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
          $('#datetimepicker3')
          .datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss',
          });
          $('#datetimepicker3 input').click(function(event){
          $('#datetimepicker3 ').data("DateTimePicker").show();
          });
          }); 
          
          $(document).ready(function() {
          $('#datetimepicker4')
          .datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss',
          });
          $('#datetimepicker4 input').click(function(event){
          $('#datetimepicker4 ').data("DateTimePicker").show();
          });
          }); 
          
    $(document).ready(function () {
       $("#myModal").modal({
        backdrop: false
       });
       $("#myModal").modal("show");
       });
</script>