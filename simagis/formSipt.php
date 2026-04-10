<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qwd1 = "select * from dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($GLOBALS["___mysqli_ston"], $qwd1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dwd1 = mysqli_fetch_assoc($rwd1);
  
  $qkp2 = "select * from dt_pegawai WHERE jabatan_instansi = '36'";
  $rkp2 = mysqli_query($GLOBALS["___mysqli_ston"], $qkp2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dkp2 = mysqli_fetch_assoc($rkp2);
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navPermSurUser.php";?>
    <div class="container">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '<div class="alert alert-warning custom-alert" role="alert">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit berhasil...</div>';}
            
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                  echo '<div class="alert alert-success custom-alert" role="alert">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil diupdate...</div>';}
          
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
                  echo '<div class="alert alert-danger custom-alert" role="alert">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil dihapus...</div>';}
                  ?>
        <h3 class="text-center text-info">Izin Penelitian Tesis</h3>
        <div class="panel panel-info">
          <div class="panel-heading">
            <ul class="list">
              <li>Form ini adalah form permohonan surat izin penelitian yang berkaitan dengan penggalian data tesis.</li>
              <li>Isilah form di bawah dengan isian yang benar.</li>
              <li>Tekan button <mark>Submit</mark> di bagian bawah form untuk menyimpan isian Anda.</li>
			  <li>Permohonan surat dapat diedit atau dihapus sebelum diverifikasi oleh admin.</li>
              <li>Setelah submit, silahkan hubungi admin, untuk dilakukan proses selanjutnya.</li>
              <li>Rekap permohonan surat dapat dilihat di kolom <mark>Rekap Permohonan Surat</mark>.</li>
            </ul>
          </div>
          <div class="panel-body">
            <form action="sformSipt.php" method="post">
              <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
              <div class="form-group">
                <label for="lembaga_tujuan_surat">Instansi/lembaga tujuan surat:</label>
                <input type="text" name="lembaga_tujuan_surat" class="form-control" id="lembaga_tujuan_surat" placeholder="Contoh: Bagian Akademik Universitas Islam Negeri Maulana Malik Ibrahim Malang, dll." required>
              </div>
              <div class="form-group">
                <label for="sebutan_pimpinan">Sebutan pimpinan untuk instansi/lembaga tujuan surat:</label>
                <select name="sebutan_pimpinan" class="form-control" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "select * from opsi_sebutan_pimpinan ORDER BY nm ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="kota_penelitian">Kota instansi/lembaga tujuan surat:</label>
                <select name="kota_penelitian" class="form-control" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($GLOBALS["___mysqli_ston"], "select * from dt_kota ORDER BY nm_kota ASC");
                    while ($tampil = mysqli_fetch_array($q)){
                      echo "<option value='$tampil[id]'>$tampil[nm_kota]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="nama_obyek">Tempat penelitian: <br />
                <input type="checkbox" name="bilasama" onClick="IsiSama(this.form)"> Tempat penelitian sama dengan instansi/lembaga tujuan surat. 
                </label>
                <input type="text" name="nama_obyek" class="form-control" id="nama_obyek" placeholder="Contoh: Fakultas Psikologi Universitas Islam Negeri Maulana Malik Ibrahim Malang, dll." required>
              </div>
              <div class="form-group">
                <label for="tujuan_surat">Maksud permohonan surat:</label>
                <input type="text" name="tujuan_surat" class="form-control" id="tujuan_surat" placeholder="Contoh:  Permohonan data mahasiswa aktif Fakultas Psikologi UIN Maulana Malik Ibrahim Malang angkatan 2019 sd. 2020, dll." required>
              </div>
              <div class="form-group">
                <label for="judul_tesis">Judul tesis:</label>
                <textarea name="judul_tesis" class="form-control" id="judul_tesis" required></textarea>
              </div>
              <div class="form-group">
                <label for="tgl_pengajuan">Tanggal pengajuan surat:</label>
                <input type="text" class="form-control" id="tgl_pengajuan" value="<?php echo date("d-m-Y");?>" disabled>
                <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
              </div>
              <div class="checkbox">
                <label>
                <input type="checkbox" id="checked" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar untuk digunakan sebagaimana mestinya.
                </label>
              </div>
          </div>
          <div class="panel-footer">
          <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
          <input type="text" name="kp2" class="sr-only" value="<?php echo $dkp2['id'];?>" required readonly>
          <input type="text" name="statusform" class="sr-only" value="1" required readonly>
          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
          </div>
          </form>
        </div>
      </div>
      <div class="row">
        <h3 class="text-center text-info">Rekap Permohonan Surat</h3>
        <div class="panel panel-info">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover table-condensed table-bordered custom" style="margin-bottom:0px;">
                <thead>
                  <tr>
                    <th class="text-center" width="3%">No.</th>
                    <th width="14%" class="text-center">Tgl. pengajuan</th>
                    <th width="58%">Instansi/lembaga tujuan surat</th>
                    <th width="16%">Status pengajuan</th>
                    <th width="9%" class="text-center">Opsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no = 0;
                    $qry = "select * from mag_sipt WHERE nim='$nim' ORDER BY id DESC";
                    $has = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                    while($data = mysqli_fetch_assoc( $has )) {
                    $no++;
                    $id = $data['id'];
                    $qrykota = "select * from dt_kota WHERE id='$data[kota_penelitian]'";
                    $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qrykota )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                    $dt = mysqli_fetch_assoc( $resp );						
                    ?>
                  <tr>
                    <td class="text-center"><?php echo $no;?></td>
                    <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                    <td><?php echo $data['lembaga_tujuan_surat'];?></td>
                    <td><?php if($data['statusform']==1) { echo "Belum diproses"; } else { echo "Telah diproses"; }?></td>
                    <td class="text-center">
                      <?php if($data['statusform']==1) { echo
                        "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                        </button>
                        <a class='btn btn-default' href='deleteSiptUser.php?id=".$id."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                        </a>";}
                        else { echo 
                        "<button class='btn btn-primary disabled' title='Telah diproses'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                        </button>
                        <button class='btn btn-primary disabled' title='Telah diproses'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                        </button>"
                        ;}?>
                    </td>
                  </tr>
                  <?php };?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Form Edit Permohonan Surat</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
    <script>
		$(document).ready(function () {
		  // Show the Modal on load
		  $("#myModal").modal("show");
		});

		function IsiSama(f) {
		  if (f.bilasama.checked == true) {
			f.nama_obyek.value = f.lembaga_tujuan_surat.value;
		  }
		  if (f.bilasama.checked == false) {
			f.nama_obyek.value = "";
		  }
		}

		function IsiSama2(f) {
		  if (f.bilasama2.checked == true) {
			f.nama_obyek.value = f.lembaga_tujuan_surat.value;
		  }
		  if (f.bilasama2.checked == false) {
			f.nama_obyek.value = "";
		  }
		}

		tinymce.init({
		  selector: "textarea#judul_tesis",
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
		$('#modalEdit').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget)
		  var recipient = button.data('whatever')
		  var modal = $(this);
		  var dataString = 'id=' + recipient;

		  $.ajax({
			type: "GET",
			url: "editSiptUser.php",
			data: dataString,
			cache: false,
			success: function (data) {
			  console.log(data);
			  modal.find('.isiModalEdit').html(data);
			},
			error: function (err) {
			  console.log(err);
			}
		  });
		});
    </script>
  </body>
</html>