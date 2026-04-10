<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  		  
   $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
   
   $qryperiod = "select * from mag_periode_pengajuan_ac WHERE id='$id'";
   $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dperiod = mysqli_fetch_assoc($rperiod);
   $ta = $dperiod['ta'];
   
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
    <?php include "navPngjnAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifSama') {
           echo '
          <div class="modal fade" id="myModal" role="dialog">
           <div class="modal-dialog">
           <div class="modal-content">
           <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">×</button>
           <h4 class="modal-title">Submit gagal</h4>
           </div>
           <div class="modal-body">
           <p>Submit gagal.</p>
           <p><strong>Note:</strong> Data yang diinput sudah ada, silahkan cek lagi!</p>
           </div>
           <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
           </div>
           </div>
           </div>';} 
          		  
           if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
           echo '<div class="alert alert-success custom-alert" role="alert">
           <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diinput</div>';}	
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}	
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}		 
           ?>
        <h3 class="text-center text-warning">Academic Coach</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Academic Coach <?php echo ' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPacAdm.php">Periode Pengajuan</a></li>
                  <li role="presentation" class="active"><a>Data Academic Coach</a></li>
                  <button role="presentation" class="btn btn-primary pull-right" title="Input Academic coach baru" data-toggle="modal" data-target="#modalInput"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Input Academic Coach Baru</button>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th rowspan="2" class="text-center" width="4%">No.</th>
                        <th rowspan="2" class="text-center" width="40%">Nama | NIP | NIPT</th>
                        <th rowspan="2" class="text-center" width="12%">Kuota Ac. Coach</th>
                        <th colspan="4" class="text-center">Progres Academic Coach</th>
                        <th rowspan="2" class="text-center" width="12%">Opsi</th>
                      </tr>
                      <tr>
                        <th class="text-center" width="8%">Pengaju</th>
                        <th class="text-center" width="8%">Proses</th>
                        <th class="text-center" width="8%">Selesai</th>
                        <th class="text-center" width="8%">Total</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        $no=0;
                        $sql =  "SELECT * FROM mag_dosen_wali WHERE id_periode = '$id' ORDER BY id ASC";
                        $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                        while($data = mysqli_fetch_array($result)) {
                        $no++;
                        $qnd =  "SELECT * FROM dt_pegawai WHERE id = '$data[nip]'";
                        $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnd);
                        $dnd = mysqli_fetch_assoc($r);
                        
                        $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[id]' AND id_periode='$data[id_periode]' AND (cek='1' OR cek='2') AND status='1'";
                        $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData1 = $dataku1['jumData'];
                        $sisa1 = $data['kuota'] - $jumlahData1;
                        
                        $qpengaju1 = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[id]' AND id_periode='$data[id_periode]'";
                        $row1 = mysqli_query($GLOBALS["___mysqli_ston"], $qpengaju1);
                        $dpengaju1 = mysqli_num_rows($row1);
                        
                        $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[id]' AND id_periode='$data[id_periode]' AND cek='1'";
                        $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData2 = $dataku2['jumData'];
                        
                        $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[id]' AND id_periode='$data[id_periode]' AND cek='2' AND status='1'";
                        $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData3 = $dataku3['jumData'];
                        
                        $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[id]' AND id_periode='$data[id_periode]' AND cek='2' AND status='2'";
                        $result4 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData4 = $dataku4['jumData'];
                        
                        $qry5 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[id]' AND id_periode='$data[id_periode]' AND cek='2'";
                        $result5 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData5 = $dataku5['jumData'];
                        ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dnd['nama'].' | '.$dnd['id'];?></td>
                        <td class="text-center"><?php if($data['kuota'] - $jumlahData1==0) { echo '<code>Penuh</code>';} else {echo $data['kuota'].' (tersisa '.$sisa1.')';}?></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalPengaju" data-whatever="<?php echo $data['id'];?>"><?php echo $jumlahData2?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalProses" data-whatever="<?php echo $data['id'];?>"><?php echo $jumlahData3?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalSelesai" data-whatever="<?php echo $data['id'];?>"><?php echo $jumlahData4?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalTotal" data-whatever="<?php echo $data['id'];?>"><?php echo $jumlahData5?></button></td>
                        <td class="text-center">
                          <button class='btn btn-primary' title='Lihat detail profil' data-toggle='modal' data-target='#modalDetailOpsi' data-whatever='<?php echo $data['id'];?>'><span class="glyphicon glyphicon-user"></span></button>
                          <button class='btn btn-warning' title='Edit kuota' data-toggle='modal' data-target='#modalEdit' data-whatever='<?php echo $data['id'];?>'><span class="glyphicon glyphicon-edit"></span></button>
                          <?php if($dpengaju1 > 0) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Sudah ada pengajuan' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";} else { echo "<a class='btn btn-default' href='deleteAc.php?id=".$data['id']."&id_periode=".$data['id_periode']."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";}?>                   
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
      <div id="modalInput" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="modalInput">Input Academic Coach Baru</h4>
            </div>
            <div class="modal-body">
              <div class="panel panel-default">
                <div class="panel-body">
                  <form action="sformInputAcPerPeriode.php" method="post">
                    <input type="text" name="id" class="sr-only" value="<?php echo "$id";?>" required readonly>
                    <div class="form-group">
                      <label for="nip">Dosen Academic Coach:</label>
                      <select name="nip" class="form-control" id="nip" required>
                        <option value="">-Pilih-</option>
                        <?php
                          $query = "SELECT * FROM dt_pegawai WHERE mengajar_pasca='2' ORDER BY nama_tg";
                                   $r = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                                   while($dt = mysqli_fetch_array($r)) {            
                            echo "<option value='$dt[id]'>$dt[nama_tg]</option>";
                                 }
                                 ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="kuota">Kuota untuk Menjadi Academic Coach:</label>
                      <input type="number" min="0" max="20" id="kuota" name="kuota" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalPengaju" aria-labelledby="labelModalPengaju" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalPengaju">Data yang Mengajukan Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalPengaju"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalProses" aria-labelledby="labelModalProses" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalProses">Data yang Sedang Proses Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalProses"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalSelesai" aria-labelledby="labelModalSelesai" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalSelesai">Data yang Telah Selesai Proses Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalSelesai"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalTotal" aria-labelledby="labelModalTotal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalTotal">Total Data Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalTotal"></div>
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
              <h4 class="modal-title" id="modalEdit">Edit Kuota Academic Coach</h4>
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
      
      $('#modalPengaju').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPengajuAcPerAcPerSmt.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalPengaju').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalProses').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewProsesAcPerAcPerSmt.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalProses').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalSelesai').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewSelesaiAcPerAcPerSmt.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalSelesai').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalTotal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewTotalAcPerAcPerSmt.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalTotal').html(data);
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
      
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "editKuotaAc.php",
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