<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  		  
   $id_sempro = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id_sempro' ] );
   
   $qryperiod = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$id_sempro'";
   $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dperiod = mysqli_fetch_assoc($rperiod);
   $tahap = $dperiod['tahap'];
   $ta = $dperiod['ta'];
                         
   $qry_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$tahap'";
   $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_thp);
   $dthp = mysqli_fetch_assoc($hasil);
                         
   $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
   $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
   $dnta = mysqli_fetch_assoc($hasil);
                         
   $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
   $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
   $dsemester = mysqli_fetch_assoc($h);   
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPendAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}	
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}		 
           ?>
        <h3 class="text-center text-warning">Revisi Seminar Proposal Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Revisi Seminar Proposal Tesis <?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapRevisiProAdm.php">Periode Pendaftaran</a></li>
                  <li role="presentation" class="active"><a>Data <?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?></a></li>
                  <li role="presentation"><a href="rekapAllRevisiProAdm.php">Semua Data</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th rowspan="2" class="text-center" width="3%">No.</th>
                        <th rowspan="2" class="text-center" width="23%">Nama | NIM</th>
                        <th rowspan="2" class="text-center" width="44%">Judul Proposal Tesis</th>
                        <th colspan="2" class="text-center">File</th>
                        <th rowspan="2" class="text-center" width="8%">Opsi</th>
                        <th rowspan="2" class="text-center" width="12%">Validasi</th>
                      </tr>
                      <tr>
                        <th width="5%" class="text-center" style="font-size:10px;">Form</th>
                        <th width="5%" class="text-center" style="font-size:10px;">Proposal</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        $no=0;
                        $sql =  "SELECT * FROM mag_revisi_sempro WHERE id_sempro = '$id_sempro' ORDER BY id ASC";
                        $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                        while($data = mysqli_fetch_array($result)) {
                        $no++;
                        
						            $qnm =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim = '$data[nim]'";
                        $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnm);
                        $dnm = mysqli_fetch_assoc($r);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dnm['nama'].' | '.$dnm['nim'];?></td>
                        <td><?php echo $data['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_prop']);?></td>
                        <td class="text-center"><?php if(empty($data['file_form_revisi'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_form_revisi'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center"><?php if(empty($data['file_prop'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_prop'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center">
                        <button class="btn btn-primary" title="Lihat detail" data-toggle="modal" data-target="#modalDetail" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-folder-open"></span></button>
                        <?php
                        if($data['cek']==2 || $data['cek']==3) {
                        echo "
                        <a class='btn btn-default' title='Sudah diterima, tidak bisa dihapus!' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                        } else {
                          echo "
                          <a class='btn btn-default' href='deleteRevisiProPerPeriodeAdm.php?id=".$data['id']."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";
                        }
                        ?>                   
                        </td>
                        <td class="text-center" style="padding-bottom:2px; padding-top:2px;">
                          <label for="" class="sr-only">Validasi Nilai</label>
                          <form class="" style="margin-bottom:0px;" action="updateValidasiRevisiPro.php" method="post">
                            <input type="text" class="sr-only" name="id" value="<?php echo $data['id'];?>">
                            <input type="text" class="sr-only" name="id_sempro" value="<?php echo $id_sempro;?>">
                            <select name='cek' class='form-control input-sm' onchange='this.form.submit();' required>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_validasi_revisi ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $data['cek'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                            </select>
                          </form>
                        </td>
                      </tr>
						</td>
                      </tr>
                      <?php
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetail" aria-labelledby="labelModalDetail" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetail">Detail Data</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetail"></div>
            </div>
          </div>
        </div>
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

      $('#modalDetail').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient; 
      $.ajax({
      type: "GET",
      url: "detailRevisiProPerIndAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDetail').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });      
    </script>
  </body>
</html>