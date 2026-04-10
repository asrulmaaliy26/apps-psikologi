<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 2;
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPngjnAdm.php";
      $qry = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$id'";
         $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $jumlahData = $dataku['jumData'];
            
          include 'pagination.php';                 
          $reload = "verifikasiPengajuanAc.php?id_periode=$id&pagination=true";
          $sql =  "SELECT * FROM mag_pengelompokan_dosen_wali WHERE id_periode='$id' ORDER BY id DESC";
          $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
           $rpp = 50;
           $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
           $tcount = mysqli_num_rows($result);
           $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
           $count = 0;
           $i = ($page-1)*$rpp;
           $no_urut = ($page-1)*$rpp;
      ?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                        echo '
                  <div class="modal fade" id="myModal" role="dialog">
                   <div class="modal-dialog">
                   <div class="modal-content">
                   <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">×</button>
                   <h4 class="modal-title">Update gagal</h4>
                   </div>
                   <div class="modal-body">
                   <p>Update gagal. Mahasiswa ini telah menyelesaikan proses Academic Coach</p>
                   </div>
                   <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   </div>
                   </div>
                   </div>
                   </div>';}
             
             if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalAc') {
                         echo '
                  <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog">
                  <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">×</button>
                  <h4 class="modal-title">Submit gagal</h4>
                  </div>
                  <div class="modal-body">
                  <p>Kuota Academic coach yang dipilih sudah penuh...</p>
                  <p><strong>Note:</strong> Silahkan pilih Academic coach yang belum penuh kuotanya...</p>
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                  </div>
                  </div>
                  </div>
                  ';}
            
                  if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                  echo '<div class="alert alert-success custom-alert" role="alert">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';} 
                    ?>
        <h3 class="text-center text-warning">Academic Coach</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pengajuan Academic Coach.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
              <li>Silahkan pilih Verifikasi & Edit untuk memverifikasi dan mengedit pengajuan.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPacAdm.php?page=<?php echo "$page";?>">Periode Pengajuan</a></li>
                  <li role="presentation" class="active"><a>Data Pengajuan Academic Coach</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped custom" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th class="text-center" width="3%">No.</th>
                        <th class="text-center" width="28%">Nama | NIM</th>
                        <th class="text-center" width="10%">Tgl. Pengajuan</th>
                        <th class="text-center" width="28%">Pilihan Academic Coach</th>
                        <th class="text-center" width="13%">Verifikasi</th>
                        <th class="text-center" width="18%">Opsi</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        
                        $qnm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                        $res = mysqli_query($GLOBALS["___mysqli_ston"], $qnm);
                        $dnm =mysqli_fetch_assoc($res);
                        
                        $qdw = "SELECT * FROM mag_dosen_wali WHERE id='$data[dosen_wali]'";
                        $res = mysqli_query($GLOBALS["___mysqli_ston"], $qdw);
                        $ddw = mysqli_fetch_assoc($res);
                        
                        $qndw = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
                        $res = mysqli_query($GLOBALS["___mysqli_ston"], $qndw);
                        $dndw = mysqli_fetch_assoc($res);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php echo $dnm['nama'].' | '.$dnm['nim'];?></td>
                        <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                        <td><?php echo $dndw['nama'];?></td>
                        <td class="text-center">
                          <label for="" class="sr-only">Verifikasi</label>
                          <form class="" style="margin-bottom:0px;" action="updateVerifikasiPac.php" method="post">
                            <input type="text" class="sr-only" name="id" value="<?php echo $data['id'];?>" required>
                            <input type="text" class="sr-only" name="id_periode" value="<?php echo $id;?>" required>
                            <input type="text" class="sr-only" name="page" value="<?php echo $page;?>">
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
                          <button class="btn btn-success btn-sm" title="Beri catatan" data-toggle="modal" data-target="#modalCatatan" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-edit"></span> Beri Catatan</button>
                          <?php if($data['status']==2) {echo '<button class="btn btn-default btn-sm" title="Telah selesai" disabled><span class="glyphicon glyphicon-check"></span> Selesai</button>';} else if($data['cek']==2) { echo'<button class="btn btn-default btn-sm" title="Telah diverifikasi" disabled><span class="glyphicon glyphicon-check"></span> Edit</button>';} else { echo'<button class="btn btn-warning btn-sm" title="Edit pengajuan" data-toggle="modal" data-target="#modalEdit" data-whatever="'.$data['id'].'"><span class="glyphicon glyphicon-edit"></span> Edit</button>';}?>
                        </td>
                      </tr>
                      <?php
                        $i++; 
                        $count++;
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="text-center"><?php echo paginate_one($reload, $page, $tpages); ?></div>
            </div>
            <div class="panel panel-danger">
              <div class="panel-heading text-center">
                <span class="lead">Opsi dan Profil Academic Coach</span>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-condensed table-striped custom" style="margin-bottom:0px;">
                    <thead>
                      <tr>
                        <th width="4%" class="text-center">No.</th>
                        <th width="36%">Nama</th>
                        <th width="18%">NIP</th>
                        <th width="20%">Kepakaran Mayor</th>
                        <th width="12%">Kuota</th>
                        <th width="12%" class="text-center">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $no=0;
                        $qdw = "SELECT * FROM mag_dosen_wali WHERE id_periode='$data[id_periode]'";
                                 $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                                 while($ddw = mysqli_fetch_assoc($rdw)) {
                        $no++;
                        
                        $qp = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
                                 $rp = mysqli_query($GLOBALS["___mysqli_ston"], $qp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                                 $dp = mysqli_fetch_assoc($rp);
                        
                        $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dp[kepakaran_mayor]'";
                                 $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                                 $dr = mysqli_fetch_assoc($rr);
                        
                        $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]' AND id_periode='$data[id_periode]' AND status='1'";
                        $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData0 = $dataku0['jumData'];
                        $sisa = $ddw['kuota'] - $jumlahData0;
                                 ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dp['nama'];?></td>
                        <td><?php echo $dp['id'];?></td>
                        <td><?php echo $dr['nm'];?></td>
                        <td><?php if($ddw['kuota'] - $jumlahData0==0) { echo '<code>Penuh</code>';} else {echo $ddw['kuota'].' (tersisa '.$sisa.')';}?></td>
                        <td class="text-center">
                          <button class="btn btn-sm btn-block btn-success" title="Lebih detail" data-toggle="modal" data-target="#modalDetailOpsi" data-whatever="<?php echo $ddw['id'];?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Detail
                          </button>
                        </td>
                      </tr>
                      <?php };?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalCatatan" aria-labelledby="labelModalCatatan" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalCatatan">Catatan Pengajuan Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalCatatan"></div>
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
              <h4 class="modal-title" id="modalEdit">Edit Pengajuan Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetailOpsi" aria-labelledby="labelModalDetailOpsi" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetailOpsi">Detail Profil Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetailOpsi"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanOpsi" aria-labelledby="labelModalListPengajuanOpsi" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanOpsi">Daftar yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanOpsi"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListProsesOpsi" aria-labelledby="labelModalListProsesOpsi" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProsesOpsi">Daftar yang Masih Proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProsesOpsi"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
      
      $('#modalCatatan').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget)
          var recipient = button.data('whatever')
          var modal = $(this);
          var dataString = 'id=' + recipient;
          $.ajax({
          type: "GET",
          url: "catatanPacAdm.php",
          data: dataString,
          cache: false,
          success: function (data) {
            console.log(data);
            modal.find('.isiModalCatatan').html(data);
          },
          error: function (err) {
            console.log(err);
          }
          });
        });
        $('#modalEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this);
        var dataString = 'id=' + recipient;
        $.ajax({
        type: "GET",
        url: "editPacAdm.php",
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
      
      $('#modalDetailOpsi').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this);
        var dataString = 'id=' + recipient;
        $.ajax({
        type: "GET",
        url: "detailOpsiAcAdm.php",
        data: dataString,
        cache: false,
        success: function (data) {
          console.log(data);
          modal.find('.isiModalDetailOpsi').html(data);
        },
        error: function (err) {
          console.log(err);
        }
        });
      });
      
      $('#modalListPengajuanOpsi').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this);
        var dataString = 'id=' + recipient;
        $.ajax({
        type: "GET",
        url: "viewListPacSamaAdm.php",
        data: dataString,
        cache: false,
        success: function (data) {
          console.log(data);
          modal.find('.isiModalListPengajuanOpsi').html(data);
        },
        error: function (err) {
          console.log(err);
        }
        });
      });
      
      $('#modalListProsesOpsi').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this);
        var dataString = 'id=' + recipient;
        $.ajax({
        type: "GET",
        url: "viewListPrsAcSamaAdm.php",
        data: dataString,
        cache: false,
        success: function (data) {
          console.log(data);
          modal.find('.isiModalListProsesOpsi').html(data);
        },
        error: function (err) {
          console.log(err);
        }
        });
      });        
    </script>
  </body>
</html>