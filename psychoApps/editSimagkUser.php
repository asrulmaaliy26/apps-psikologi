<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM magang WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );

  $qry = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $resp );
  $nim = $dt['nim'];
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updateSimagkUser.php" method="post" enctype="multipart/form-data">
    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
        <?php 
          include( "navtopAdm.php" );
          include( "navSideBarUserS1.php" );
          ?> 
        <div class="content-wrapper">
          <?php include( "alertUser.php" );?>
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-4">
                  <h1 class="m-0 float-left">Permohonan Surat</h1>
                </div>
                <div class="col-sm-8">
                  <ol class="mt-2 breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Izin Magang Mandiri Kelompok</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm">
                  <div class="card card-success card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link" href="formSimagkUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatSimagkUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editSimagkUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <label for="anggota1">Anggota 1 <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" placeholder="Nama lengkap." value="<?php echo $dt['nama']."&nbsp;"."($dt[nim])";?>" disabled required>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="anggota2">Anggota 2 <span class="text-danger">*</span></label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM anggota_magang WHERE id_magang='$id' AND urutan='2'" );
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'nim_anggota' ];
                            
                            echo "<select name='anggota2' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'nim' ] ) {
                                echo "<option value='$w[nim]' selected>$w[nama] ($w[nim])</option>";
                              } 
                              else {
                                echo "<option value='$w[nim]'>$w[nama] ($w[nim])</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="anggota3">Anggota 3</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM anggota_magang WHERE id_magang='$id' AND urutan='3'" );
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'nim_anggota' ];
                            
                            echo "<select name='anggota3' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'nim' ] ) {
                                echo "<option value='$w[nim]' selected>$w[nama] ($w[nim])</option>";
                              } 
                              else {
                                echo "<option value='$w[nim]'>$w[nama] ($w[nim])</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="anggota4">Anggota 4</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM anggota_magang WHERE id_magang='$id' AND urutan='4'" );
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'nim_anggota' ];
                            
                            echo "<select name='anggota4' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'nim' ] ) {
                                echo "<option value='$w[nim]' selected>$w[nama] ($w[nim])</option>";
                              } 
                              else {
                                echo "<option value='$w[nim]'>$w[nama] ($w[nim])</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <label for="anggota5">Anggota 5</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM anggota_magang WHERE id_magang='$id' AND urutan='5'" );
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'nim_anggota' ];
                            
                            echo "<select name='anggota5' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'nim' ] ) {
                                echo "<option value='$w[nim]' selected>$w[nama] ($w[nim])</option>";
                              } 
                              else {
                                echo "<option value='$w[nim]'>$w[nama] ($w[nim])</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="anggota6">Anggota 6</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM anggota_magang WHERE id_magang='$id' AND urutan='6'" );
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'nim_anggota' ];
                            
                            echo "<select name='anggota6' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'nim' ] ) {
                                echo "<option value='$w[nim]' selected>$w[nama] ($w[nim])</option>";
                              } 
                              else {
                                echo "<option value='$w[nim]'>$w[nama] ($w[nim])</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="anggota7">Anggota 7</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM anggota_magang WHERE id_magang='$id' AND urutan='7'" );
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'nim_anggota' ];
                            
                            echo "<select name='anggota7' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'nim' ] ) {
                                echo "<option value='$w[nim]' selected>$w[nama] ($w[nim])</option>";
                              } 
                              else {
                                echo "<option value='$w[nim]'>$w[nama] ($w[nim])</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="anggota8">Anggota 8</label>
                          <?php
                            $tampil = mysqli_query($con,  "SELECT * FROM anggota_magang WHERE id_magang='$id' AND urutan='8'" );
                            $select = mysqli_fetch_array( $tampil );
                            $data = $select[ 'nim_anggota' ];
                            
                            echo "<select name='anggota8' class='form-control form-control-sm'>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_mhssw WHERE status='1' AND nim!='$nim' ORDER BY nama ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data == $w[ 'nim' ] ) {
                                echo "<option value='$w[nim]' selected>$w[nama] ($w[nim])</option>";
                              } 
                              else {
                                echo "<option value='$w[nim]'>$w[nama] ($w[nim])</option>";
                              }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="lembaga_tujuan_surat">Instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="lembaga_tujuan_surat" placeholder="Contoh 1: Fakultas Psikologi UIN Maulana Malik Ibrahim Malang; Contoh 2: PT. Bahagia Selalu; Contoh 3: Desa Sidorejo, dst." value="<?php echo $dataku['lembaga_tujuan_surat'];?>" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="alamat_lengkap_lts">Alamat lengkap instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="alamat_lengkap_lts" placeholder="Alamat harus ditulis lengkap. Misal: Jalan, Nomor/Blok, RT., RW., Desa/Kelurahan, Kecamatan dan Kabupaten." value="<?php echo $dataku['alamat_lengkap_lts'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="sebutan_pimpinan">Sebutan pimpinan untuk instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='sebutan_pimpinan' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM opsi_sebutan_pimpinan ORDER BY nm ASC" );
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
                        <div class="form-group col-sm-6">
                          <label for="kota_lts">Kota instansi/lembaga tujuan surat <span class="text-danger">*</span></label>
                          <?php
                            echo "<select name='kota_lts' class='form-control form-control-sm' required>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dataku['kota_lts'] == $w[ 'id' ] ) {
                            echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
                            } else {
                            echo "<option value='$w[id]'>$w[nm_kota]</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="nama_obyek">Tempat magang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_obyek" class="form-control form-control-sm" placeholder="Contoh 1: Fakultas Psikologi UIN Maulana Malik Ibrahim Malang; Contoh 2: PT. Bahagia Selalu; Contoh 3: Desa Sidorejo, dst." value="<?php echo $dataku['nama_obyek'];?>" required>
                        <p class="help-block small"><strong><input type="checkbox" name="bilasama" onClick="IsiSamaNamaObyek(this.form)"> Silahkan checklist jika tempat magang sama dengan Instansi/lembaga tujuan surat.</strong></p>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="tgl_awal_pelaksanaan">Tanggal mulai magang <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="tgl_awal_pelaksanaan" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" value="<?php echo $dataku['tgl_awal_pelaksanaan'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="tgl_akhir_pelaksanaan">Tanggal selesai magang <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_two" data-target-input="nearest">
                            <input type="text" name="tgl_akhir_pelaksanaan" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_two" value="<?php echo $dataku['tgl_akhir_pelaksanaan'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php if($dataku['validasi_proposal']==2 OR $dataku['validasi_proposal']==3) {echo
                      '<div class="form-group">
                        <label for="proposal">File proposal magang telah diterima</label>
                        <input type="file" class="form-control form-control-sm" disabled>
                      </div>';}
                      else { echo
                       '<div class="form-group">
                        <label for="proposal">Upload ulang file proposal magang (PDF) <span class="text-danger">*</span></label>
                        <input type="file" name="proposal" class="form-control form-control-sm">
                        <p class="help-block small"><strong>Ukuran file yang diupload maksimal 2MB</strong></p>
                      </div>'; 
                      }?>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="anggota1" class="sr-only" value="<?php echo $nim;?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                      <input type="text" name="validasi_proposal" class="sr-only" <?php if($dataku['validasi_proposal']==1 OR $dataku['validasi_proposal']==4) {echo 'value="1"';} if($dataku['validasi_proposal']==2 OR $dataku['validasi_proposal']==3) {echo 'value="'.$dataku['validasi_proposal'].'"';}?> required readonly>
                      <input type="text" name="statusform" class="sr-only" value="1" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Update permohonan surat</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <?php include( "footerAdm.php" );?>
      <?php include( "jsAdm.php" );?>
    </body>
  </form>
</html>