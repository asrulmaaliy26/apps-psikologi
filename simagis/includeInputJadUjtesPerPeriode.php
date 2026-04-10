<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION['username'];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_peserta_ujtes WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qryperiod = "select * from mag_periode_pendaftaran_ujtes WHERE id='$dt[id_ujtes]'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $qryperiod )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dperiod = mysqli_fetch_assoc( $res );
  
  $qjdwl = "select * from mag_jadwal_ujtes WHERE id_pendaftaran='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $qjdwl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djdwl = mysqli_fetch_assoc( $res );
  
  $qry = "select * from mag_dt_mhssw_pasca WHERE nim='$dt[nim]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $data = mysqli_fetch_assoc( $resp );
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateJadUjtesPerPeriode.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <input type="text" name="id_ujtes" class="sr-only" value="<?php echo $dperiod['id'];?>" required readonly>
      <div class="form-group">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" class="form-control" id="nama" name="" value="<?php echo "$data[nama]".' / '."$data[nim]";?>" disabled>
      </div>
      <div class="form-group row">
        <div class="col-md-4">
          <label for="tgl_ujian">Tanggal Ujian:</label>
          <div class="input-group input-append date" id="datetimepicker4">
            <input type="text" class="form-control" name="tgl_ujian" value="<?php echo "$djdwl[tgl_ujian]";?>" required>
            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="jam_mulai">Jam Mulai:</label>
          <div class="input-group" id="timepicker1">
            <input type="text" class="form-control" name="jam_mulai" value="<?php echo "$djdwl[jam_mulai]";?>" required>
            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-time"></span></span>
          </div>
        </div>
        <div class="col-md-4">
          <label for="jam_selesai">Jam Selesai:</label>
          <div class="input-group" id="timepicker2">
            <input type="text" class="form-control" name="jam_selesai" value="<?php echo "$djdwl[jam_selesai]";?>" required>
            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-time"></span></span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="ruang">Ruang:</label>
        <?php
          echo "<select class='form-control' id='ruang' name='ruang' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM dt_ruang ORDER BY nm ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          	if ( $djdwl['ruang'] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$w[nm]</option>";
          	} else {
          		echo "<option value='$w[id]'>$w[nm]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="penguji3">Penguji Utama:</label>
        <?php
          echo "<select class='form-control' id='penguji3' name='penguji3' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM dt_pegawai WHERE menguji_ujian_tesis = '2' ORDER BY nama_tg ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          	if ( $djdwl['penguji3'] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
          	} else {
          		echo "<option value='$w[id]'>$w[nama_tg]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
	  <div class="form-group">
        <label for="penguji4">Ketua Penguji:</label>
        <?php
          echo "<select class='form-control' id='penguji4' name='penguji4' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM dt_pegawai WHERE menguji_ujian_tesis = '2' ORDER BY nama_tg ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          	if ( $djdwl['penguji4'] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
          	} else {
          		echo "<option value='$w[id]'>$w[nama_tg]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
	  <div class="form-group">
        <label for="penguji1">Pembimbing I:</label>
        <?php
          echo "<select class='form-control' id='penguji1' name='penguji1' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM dt_pegawai WHERE menguji_ujian_tesis = '2' ORDER BY nama_tg ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          	if ( $djdwl['penguji1'] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
          	} else {
          		echo "<option value='$w[id]'>$w[nama_tg]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="penguji2">Pembimbing II:</label>
        <?php
          echo "<select class='form-control' id='penguji2' name='penguji2' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM dt_pegawai WHERE menguji_ujian_tesis = '2' ORDER BY nama_tg ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          	if ( $djdwl['penguji2'] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
          	} else {
          		echo "<option value='$w[id]'>$w[nama_tg]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
      <button type="submit" class="btn btn-primary" name="update">Submit</button>
    </form>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
  $('#timepicker1')
  .datetimepicker({
  format: 'HH:mm'
  });
  $('#timepicker1 input').click(function(event){
  $('#timepicker1 ').data("DateTimePicker").show();
  });
  }); 
  
  $(document).ready(function() {
  $('#timepicker2')
  .datetimepicker({
  format: 'HH:mm'
  });
  $('#timepicker2 input').click(function(event){
  $('#timepicker2 ').data("DateTimePicker").show();
  });
  }); 
  
  $(document).ready(function() {
  $('#datetimepicker4')
  .datetimepicker({
  format: 'DD-MM-YYYY'
  });
  });
</script>