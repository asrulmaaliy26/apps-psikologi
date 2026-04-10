<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navDashUser.php";?>
    <div class="container">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil diupdate...</div>';}
          ?>
        <h3 class="text-center text-info">BIODATA</h3>
        <div class="panel panel-info">
          <div class="panel-heading">
            <ul class="list">
              <li>Lengkapi biodata Anda dengan isian yang benar.</li>
              <li>File foto yang diupload wajib foto yang resmi. Jenis file: .jpg, .jpeg, .png dengan ukuran maksimal 20kb.</li>
              <li>Tekan button <mark>Update</mark> di bagian bawah form untuk menyimpan data profil Anda.</li>
            </ul>
          </div>
          <div class="panel-body">
            <form action="udmUser.php" method="post" enctype="multipart/form-data">
              <div class="col-xs-12">
                <div class="col-md-3 hidden-lg hidden-md">
                  <div class="box center-block">
                    <label>
                    <img src="<?php echo $dataku['photo'];?>" onError="this.onerror=null;this.src='<?php if($dataku['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-rounded">
                    <input type="file"name="photo" <?php if(empty($dataku['photo'])) { echo "required";}?> style="display:none" onChange="this.form.submit()">
                    </label>
                    <p class="text-center small">Wajib foto resmi <br> Klik di image untuk ganti</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="nim">NIM:</label>
                      <input type="text" class="form-control" id="nim" value="<?php echo $dataku['nim'];?>" required disabled>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label for="nama">Nama tanpa gelar:</label>
                      <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $dataku['nama'];?>" required>
                    </div>
                    <div class="form-group">
                      <label for="gelar_depan">Gelar depan:</label>
                      <input type="text" class="form-control" name="gelar_depan" id="gelar_depan" value="<?php echo $dataku['gelar_depan'];?>">
                    </div>
                    <div class="form-group">
                      <label for="gelar_belakang">Gelar belakang:</label>
                      <input type="text" class="form-control" name="gelar_belakang" id="gelar_belakang" value="<?php echo $dataku['gelar_belakang'];?>" required>
                    </div>
                  </div>
                  <div class="col-md-3 hidden-sm hidden-xs">
                    <div class="box pull-right">
                      <label>
                      <img src="<?php echo $dataku['photo'];?>" onError="this.onerror=null;this.src='<?php if($dataku['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-rounded">
                      <input type="file"name="photo" <?php if(empty($dataku['photo'])) { echo "required";}?> style="display:none" onChange="this.form.submit()">
                      </label>
                      <p class="text-center small">Wajib foto resmi <br> Klik di image untuk ganti</p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="rumpun">Peminatan rumpun psikologi:</label>
                  <?php
                    $q1 = "select * from mag_pengelompokan_rumpun WHERE nim='$nim'";
                    $r1 = mysqli_query($GLOBALS["___mysqli_ston"], $q1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                    $dt1 = mysqli_fetch_assoc($r1);
                    
                    $q2 = "select * from mag_opsi_rumpun WHERE id='$dt1[rumpun]'";
                    $r2 = mysqli_query($GLOBALS["___mysqli_ston"], $q2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                    $dt2 = mysqli_fetch_assoc($r2);
                      ?>
                  <input type="text" class="form-control" id="rumpun" value="<?php echo $dt2['nm'];?>" disabled>
                </div>
				<div class="form-group">
                  <label for="dosen_wali">Academic coach:</label>
                  <?php
                    $q = "SELECT * FROM mag_pengelompokan_dosen_wali AS mpdw JOIN mag_dosen_wali AS mdw ON mdw.id = mpdw.dosen_wali JOIN dt_pegawai AS dp ON dp.id = mdw.nip WHERE nim='$nim'";
                    $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                    $dt = mysqli_fetch_assoc($r);
                      ?>
                  <input type="text" class="form-control" id="dosen_wali" value="<?php echo $dt['nama'];?>" disabled>
                </div>
                <div class="form-group">
                  <label for="tempat_lahir">Tempat lahir:</label>
                  <?php
                    $data = $dataku[ 'tempat_lahir' ];
                    echo "<select class='form-control' aria-label='tempat_lahir' name='tempat_lahir' id='dosen_wali' required>";
                    echo "<option value=''>-Pilih-</option>";
                    $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                    while ( $w = mysqli_fetch_array( $tampil ) ) {
                    	if ( $data == $w[ 'id' ] ) {
                    		echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                    	} else {
                    		echo "<option value='$w[id]'>$w[nm_kota]</option>";
                    	}
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group">
                  <label for="tanggal_lahir">Tanggal lahir</label>
                  <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" placeholder="Format: dd-mm-yyyy" value="<?php echo $dataku['tanggal_lahir'];?>" required>
                </div>
                <div class="form-group">
                  <label for="jenis_kelamin">Jenis kelamin:</label>
                  <?php
                    $data = $dataku[ 'jenis_kelamin' ];
                    echo "<select class='form-control' aria-label='jenis_kelamin' name='jenis_kelamin' id='jenis_kelamin' required>";
                    echo "<option value=''>-Pilih-</option>";
                    $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM jns_kelamin ORDER BY id ASC" );
                    while ( $w = mysqli_fetch_array( $tampil ) ) {
                    	if ( $data == $w[ 'id' ] ) {
                    		echo "<option value='$w[id]' selected>$w[nm]</option>";
                    	} else {
                    		echo "<option value='$w[id]'>$w[nm]</option>";
                    	}
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group">
                  <label for="alamat_ktp">Alamat sesuai KTP:</label>
                  <input type="text" class="form-control" name="alamat_ktp" id="alamat_ktp" value="<?php echo $dataku['alamat_ktp'];?>" required>
                </div>
                <div class="form-group">
                  <label for="alamat_malang">Alamat di Malang:</label>
                  <input type="text" class="form-control" name="alamat_malang" id="alamat_malang" value="<?php echo $dataku['alamat_malang'];?>" required>
                </div>
                <div class="form-group">
                  <label for="kntk">Kontak HP:</label>
                  <input type="text" class="form-control" name="kntk" id="kntk" value="<?php echo $dataku['kntk'];?>" required>
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" name="email" id="email" value="<?php echo $dataku['email'];?>" required>
                </div>
                <div class="form-group">
                  <label for="pekerjaan">Pekerjaan:</label>
                  <?php
                    $data = $dataku[ 'pekerjaan' ];
                    echo "<select class='form-control' aria-label='pekerjaan' name='pekerjaan' id='pekerjaan' required>";
                    echo "<option value=''>-Pilih-</option>";
                    $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM jns_pkrjn ORDER BY nm ASC" );
                    while ( $w = mysqli_fetch_array( $tampil ) ) {
                    	if ( $data == $w[ 'id' ] ) {
                    		echo "<option value='$w[id]' selected>$w[nm]</option>";
                    	} else {
                    		echo "<option value='$w[id]'>$w[nm]</option>";
                    	}
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group">
                  <label for="asal_s1">Asal Strata 1:</label>
                  <input type="text" class="form-control" name="asal_s1" id="asal_s1" value="<?php echo $dataku['asal_s1'];?>" required>
                </div>
                <div class="form-group">
                  <label for="pend_terakhir">Pendidikan terakhir:</label>
                  <input type="text" class="form-control" name="pend_terakhir" id="pend_terakhir" value="<?php echo $dataku['pend_terakhir'];?>" required>
                </div>
                <div class="form-group">
                  <label for="nama_ibu">Nama ibu:</label>
                  <input type="text" class="form-control" name="nama_ibu" id="nama_ibu" value="<?php echo $dataku['nama_ibu'];?>" required>
                </div>
                <div class="form-group">
                  <label for="pekerjaan_ibu">Pekerjaan ibu:</label>
                  <?php
                    $data = $dataku[ 'pekerjaan_ibu' ];
                    echo "<select class='form-control' aria-label='pekerjaan_ibu' name='pekerjaan_ibu' id='pekerjaan_ibu'>";
                    echo "<option value=''>-Pilih-</option>";
                    $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM jns_pkrjn ORDER BY nm ASC" );
                    while ( $w = mysqli_fetch_array( $tampil ) ) {
                    	if ( $data == $w[ 'id' ] ) {
                    		echo "<option value='$w[id]' selected>$w[nm]</option>";
                    	} else {
                    		echo "<option value='$w[id]'>$w[nm]</option>";
                    	}
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group">
                  <label for="alamat_ibu">Alamat ibu:</label>
                  <input type="text" class="form-control" name="alamat_ibu" id="alamat_ibu" value="<?php echo $dataku['alamat_ibu'];?>">
                </div>
                <div class="form-group">
                  <label for="telepon_ibu">Telepon ibu:</label>
                  <input type="text" class="form-control" name="telepon_ibu" id="telepon_ibu" value="<?php echo $dataku['telepon_ibu'];?>">
                </div>
                <div class="form-group">
                  <label for="nama_ayah">Nama ayah:</label>
                  <input type="text" class="form-control" name="nama_ayah" id="nama_ayah" value="<?php echo $dataku['nama_ayah'];?>" required>
                </div>
                <div class="form-group">
                  <label for="pekerjaan_ayah">Pekerjaan ayah:</label>
                  <?php
                    $data = $dataku[ 'pekerjaan_ayah' ];
                    echo "<select class='form-control' aria-label='pekerjaan_ayah' name='pekerjaan_ayah' id='pekerjaan_ayah'>";
                    echo "<option value=''>-Pilih-</option>";
                    $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM jns_pkrjn ORDER BY nm ASC" );
                    while ( $w = mysqli_fetch_array( $tampil ) ) {
                    	if ( $data == $w[ 'id' ] ) {
                    		echo "<option value='$w[id]' selected>$w[nm]</option>";
                    	} else {
                    		echo "<option value='$w[id]'>$w[nm]</option>";
                    	}
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group">
                  <label for="alamat_ayah">Alamat ayah:</label>
                  <input type="text" class="form-control" name="alamat_ayah" id="alamat_ayah" value="<?php echo $dataku['alamat_ayah'];?>">
                </div>
                <div class="form-group">
                  <label for="telepon_ayah">Telepon ayah:</label>
                  <input type="text" class="form-control" name="telepon_ayah" id="telepon_ayah" value="<?php echo $dataku['telepon_ayah'];?>">
                </div>
              </div>
          </div>
          <div class="panel-footer">
          <button class="btn btn-success" type="submit">Update</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
    <script>
       $(function () {
          $('#tanggal_lahir').datetimepicker({
              format: 'DD-MM-YYYY'
          });
      });
    </script>
  </body>
</html>

