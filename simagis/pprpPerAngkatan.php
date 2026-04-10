<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  $angkatan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'angkatan' ] );
  
   $qta = "select * from mag_dt_ta WHERE status='1'";
   $rta = mysqli_query($GLOBALS["___mysqli_ston"], $qta)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dta = mysqli_fetch_assoc($rta);   
   
   $qwd1 = "select * from dt_pegawai WHERE jabatan_instansi = '2'";
   $rwd1 = mysqli_query($GLOBALS["___mysqli_ston"], $qwd1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dwd1 = mysqli_fetch_assoc($rwd1);   
   
   $qkaprodi = "select * from dt_pegawai WHERE jabatan_instansi = '36'";
   $rkaprodi = mysqli_query($GLOBALS["___mysqli_ston"], $qkaprodi)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dkaprodi = mysqli_fetch_assoc($rkaprodi); 
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPngjnAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';} 
            ?>
        <h3 class="text-center text-warning">Peminatan Rumpun Psikologi</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pengajuan Peminatan Rumpun Psikologi angkatan: <?php echo "$angkatan";?>.</li>
              <li>Silahkan tekan button Edit untuk merubah pengajuan.</li>
              <li>Silahkan Pilih Verifikasi untuk memverifikasi pengajuan.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPprpAdm.php">Rekap Pengajuan</a></li>
                  <li role="presentation" class="active"><a>Pengajuan pada Angkatan: <?php echo "$angkatan";?></a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped custom" style="margin-bottom:0px;">
                    <thead>
                      <tr>
                        <th class="text-center" width="4%">No.</th>
                        <th class="text-center" width="42%">Nama | NIM</th>
                        <th class="text-center" width="14%">Tgl. Pengajuan</th>
                        <th class="text-center" width="20%">Pilihan Rumpun</th>
                        <th class="text-center" width="14%">Verifikasi</th>
                        <th class="text-center" width="6%">Opsi</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        $no=0;
                        $sql =  "SELECT * FROM mag_pengelompokan_rumpun WHERE angkatan='$angkatan' ORDER BY id DESC";
                        $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                        while($data = mysqli_fetch_array($result)) {
                        $id=$data['id'];
                        $no++;
                        
                        $qnm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                        $res = mysqli_query($GLOBALS["___mysqli_ston"], $qnm);
                        $dnm =mysqli_fetch_assoc($res);
                        
                        $qrumpun = "SELECT * FROM mag_opsi_rumpun WHERE id='$data[rumpun]'";
                        $res = mysqli_query($GLOBALS["___mysqli_ston"], $qrumpun);
                        $drumpun = mysqli_fetch_assoc($res);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dnm['nama'].' | '.$dnm['nim'];?></td>
                        <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                        <td class="text-center"><?php echo $drumpun['nm'];?></td>
                        <td class="text-center">
                          <label for="" class="sr-only">Verifikasi</label>
                          <form class="" style="margin-bottom:0px;" action="updateVerifikasiPprp.php" method="post">
                            <input type="text" class="sr-only" name="id" value="<?php echo "$id";?>">
                            <input type="text" class="sr-only" name="angkatan" value="<?php echo "$angkatan";?>">
                            <select name='verifikasi' class='form-control input-sm' onchange='this.form.submit();' required>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_verifikasi ORDER BY nm ASC" );
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
                        <td class="text-center">
                          <?php if($data['cek']==2) {echo '<button class="btn btn-default" title="Telah diverifikasi" disabled><span class="glyphicon glyphicon-check"></span></button>';} else if($data['cek']==1) { echo'<button class="btn btn-warning" title="Edit pengajuan" data-toggle="modal" data-target="#modalEdit" data-whatever="'.$data['id'].'"><span class="glyphicon glyphicon-edit"></span></button>';}?>
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
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Edit Pengajuan Peminatan Rumpun Psikologi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
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
      
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "editPprpAdm.php",
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