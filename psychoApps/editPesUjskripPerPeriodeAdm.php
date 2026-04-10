<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $id_ujskrip = mysqli_real_escape_string($con,  $_GET[ 'id_ujskrip' ] );
  
  $q_pes = "SELECT * FROM peserta_ujskrip WHERE id='$id'";
  $r_pes = mysqli_query($con, $q_pes)or die( mysqli_error($con));
  $dpes = mysqli_fetch_assoc($r_pes);
  
  $q_id_pes = "SELECT * FROM dt_mhssw WHERE nim='$dpes[nim]'";
  $r_id_pes = mysqli_query($con, $q_id_pes)or die( mysqli_error($con));
  $didpes = mysqli_fetch_assoc($r_id_pes);
  
  $qidper = "SELECT * FROM pendaftaran_skripsi WHERE id='$dpes[id_ujskrip]'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Verifikasi Pendaftar Ujian Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="verPndftrUjskripAdm.php?page=<?php echo $page;?>">Verifikasi Pendaftar Ujian Skripsi</a></li>
                   <li class="breadcrumb-item small"><a class="text-info" href="verPndftrUjskripPerPeriodeAdm.php?id=<?php echo $id_ujskrip;?>&page=<?php echo $page;?>">Opsi Verifikasi Pendaftar</a></li>
                  <li class="breadcrumb-item active small">Edit Pendaftaran</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updatePesUjskripPerPeriodeAdm.php" method="post" enctype="multipart/form-data">
                  <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <input type="text" name="id_ujskrip" class="sr-only" value="<?php echo $dpes['id_ujskrip'];?>" required readonly>
                  <input type="text" name="nim" class="sr-only" value="<?php echo $didpes['nim'];?>" required readonly>
                  <input type="text" name="nama" class="sr-only" value="<?php echo $didpes['nama'];?>" required readonly>
                  <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Pendaftaran</h4>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-sm" value="<?php echo $didpes['nama'].' / '.$didpes['nim'];?>" required disabled>
                      </div>
                      <div class="form-group">
                        <label for="judul_skripsi">Judul Skripsi</label>
                        <textarea id="judul_skripsi" name="judul_skripsi" class="form-control form-control-sm" required><?php echo $dpes['judul_skripsi'];?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="pembimbing1">Dosen Pembimbing Skripsi I</label>
                        <select name="pembimbing1" class="form-control form-control-sm" id="pembimbing1" required>
                        <?php
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai='1' ORDER BY nama_tg ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dpes['pembimbing1'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="pembimbing2">Dosen Pembimbing Skripsi II</label>
                        <select name="pembimbing2" class="form-control form-control-sm" id="pembimbing2" required>
                        <?php
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai='1' ORDER BY nama_tg ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $dpes['pembimbing2'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <?php if(empty($dpes['file_skripsi'])) { echo '
                          <label for="file_skripsi">Upload File Skripsi</label>
                          <input type="file" id="file_skripsi" name="file_skripsi" class="form-control form-control-sm" required>
                          ';} else { echo '
                          <label for="file_skripsi">File Skripsi</label>
                          <a class="btn btn-info btn-flat btn-sm btn-block col-2" title="Lihat/download" href="'.$dpes['file_skripsi'].'" target="_blank"><i class="fas fa-download"></i> Lihat/download</a>
                          <label for="file_skripsi">Ganti File Skripsi</label>
                          <input type="file" id="file_skripsi" name="file_skripsi" class="form-control form-control-sm">
                          ';}
                          ?>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="verPndftrUjskripPerPeriodeAdm.php?id=<?php echo $dpes['id_ujskrip'];?>&page=<?php echo "$page";?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
                      <button type="submit" class="btn btn-outline-primary btn-flat btn-sm float-right" data-dismiss="modal">Update</button>
                    </div>
                  </div>
                </form>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      tinymce.init({
      selector: "textarea#judul_skripsi",
      theme: "modern",    
      plugins: [
           "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
           "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
           "save table contextmenu directionality emoticons template paste textcolor","autoresize"
      ],
      content_css: "css/content.css",
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons", 
      style_formats: [
          {title: 'Bold text', inline: 'b'},
          {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
          {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
          {title: 'Example 1', inline: 'span', classes: 'example1'},
          {title: 'Example 2', inline: 'span', classes: 'example2'},
          {title: 'Table styles'},
          {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
      ]
      });
    </script>
  </body>
</html>