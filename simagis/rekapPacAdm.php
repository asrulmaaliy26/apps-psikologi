<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username']; 
  
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
    <?php include "navPngjnAdm.php";
      $qry = "SELECT COUNT(*) AS jumData FROM mag_periode_pengajuan_ac";
         $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $jumlahData = $dataku['jumData'];
            
          include 'pagination.php';                 
          $reload = "rekapPacAdm.php?pagination=true";
          $sql =  "SELECT * FROM mag_periode_pengajuan_ac GROUP BY ta ORDER BY start_datetime DESC";
          $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
           $rpp = 10;
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
          if (!empty($_GET['message']) && $_GET['message'] == 'notifTa') {
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
           <p><strong>Note:</strong> Tidak ada Periode Tahun Akademik yang aktif, silahkan cek Periode Tahun Akademik!</p>
           </div>
           <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
           </div>
           </div>
           </div>';}  
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
              <li>Berikut adalah data Pengajuan Academic Coach per periode (semester).</li>
              <li>Periode Pengajuan Academic Coach yang <code>sedang aktif</code> bertanda <span class='label label-primary'>Sedang Aktif</span>.  Silahkan tekan <code>tombol ON/OFF</code> untuk mengaktifkan atau menonaktifkan.</li>
              <li><code>Perhatikan</code> rekap Periode Pengajuan Academic Coach yang ada. Jika input baru, pastikan Periode Pengajuan Academic Coach <code>tidak sama</code>.</li>
              <li>Silahkan tekan button yang diinginkan untuk melihat rincian, memverifikasi atau mengedit data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Periode Pengajuan</a></li>
                  <button role="presentation" class="btn btn-primary pull-right" title="Input periode baru" data-toggle="modal" data-target="#modalInput"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Input Periode Baru</button>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th rowspan="2" class="text-center" width="3%">No.</th>
                        <th rowspan="2" class="text-center" width="24%">Periode Pengajuan</th>
                        <th colspan="2" class="text-center">Durasi Pengajuan</th>
                        <th rowspan="2" class="text-center" width="6%">Status</th>
                        <th colspan="4" class="text-center">Progres Academic Coach</th>
                        <th rowspan="2" class="text-center" width="7%">Ac. Coach</th>
                        <th rowspan="2" class="text-center" width="8%">Opsi</th>
                      </tr>
                      <tr>
                        <th class="text-center" width="12%">Awal Durasi</th>
                        <th class="text-center" width="12%">Akhir Durasi</th>
                        <th class="text-center" width="7%">Pengaju</th>
                        <th class="text-center" width="7%">Proses</th>
                        <th class="text-center" width="7%">Selesai</th>
                        <th class="text-center" width="7%">Total</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        
                        $id = $data['id'];
                        $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$data[ta]'";
                        $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
                        $dnta = mysqli_fetch_assoc($hasil);
                        
                        $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                        $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
                        $dsemester = mysqli_fetch_assoc($h);
                        
                        $qjumAc = "SELECT COUNT(id_periode) AS jum FROM mag_dosen_wali WHERE id_periode='$data[id]'";
                        $rjAc = mysqli_query($GLOBALS["___mysqli_ston"], $qjumAc);
                        $dJumAc = mysqli_fetch_assoc($rjAc);
                        
                        $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$data[id]'";
                        $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData0 = $dataku0['jumData'];
                        
                        $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$data[id]' AND cek='1'";
                        $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData1 = $dataku1['jumData'];
                        
                        $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$data[id]' AND cek='2' AND status='1'";
                        $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData2 = $dataku2['jumData'];
                        
                        $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$data[id]' AND cek='2' AND status='2'";
                        $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData3 = $dataku3['jumData'];
                        
                        $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$data[id]' AND cek='2'";
                        $result4 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData4 = $dataku4['jumData'];
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php if($data['status']==1) { echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'].' <span class="label label-primary">Sedang Aktif</span>';} else { echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];}?></td>
                        <td class="text-center"><?php echo $data['start_datetime'];?></td>
                        <td class="text-center"><?php echo $data['end_datetime'];?></td>
                        <td class="text-center"><?php if($data['status']==1) { echo "<a class='btn btn-success btn-sm btn-block'><span class='glyphicon glyphicon-check'></span> ON</a>";} else { echo "<a class='btn btn-default btn-sm btn-block' title='Aktifkan!' href='updateStatusPeriodePac.php?id=".$id."' onclick='return confirm(\"Yakin Periode ini diaktifkan?\")'><span class='glyphicon glyphicon-ban-circle'></span> OFF</a>";}?></td>
                        <td class="text-center"><a href="verifikasiPengajuanAc.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>" class="btn btn-primary btn-sm btn-block" title="Lihat dan verifikasi"><?php echo "$jumlahData1";?></a></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalProses" data-whatever="<?php echo "$id";?>"><?php echo "$jumlahData2";?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalSelesai" data-whatever="<?php echo "$id";?>"><?php echo "$jumlahData3";?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalTotal" data-whatever="<?php echo "$id";?>"><?php echo 
                          "$jumlahData4";?></button></td>
                        <td class="text-center"><a href='acPerPeriode.php?id=<?php echo "$id";?>' class='btn btn-sm btn-block btn-info' title='Lihat, input dan edit'><?php echo $dJumAc['jum'];?></a></td>
                        <td class="text-center"><button class="btn btn-warning" title="Edit periode" data-toggle="modal" data-target="#modalEdit" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                          <?php if(($jumlahData0 > 0)) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Sudah ada pengajuan' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";} else { echo "<a class='btn btn-default' href='deletePeriodePac.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";}?>
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
                <div class="text-center"><?php echo paginate_one($reload, $page, $tpages); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalInput" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="modalInput">Input Periode Baru</h4>
            </div>
            <div class="modal-body">
              <div class="panel panel-default">
                <div class="panel-body">
                  <form action="sformInputPeriodePacAdm.php" method="post">
                    <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
                    <input type="text" name="kaprodi" class="sr-only" value="<?php echo $dkaprodi['id'];?>" required readonly>
                    <input type="text" name="ta" class="sr-only" value="<?php echo $dta['id'];?>" required readonly>
                    <div class="form-group">
                      <label for="start_datetime">Awal Durasi Pengajuan</label>
                      <div class="input-group date" id="datetimepicker1">
                        <input type="text" id="start_datetime" name="start_datetime" class="form-control" required>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="end_datetime">Akhir Durasi Pengajuan</label>
                      <div class="input-group date" id="datetimepicker2">
                        <input type="text" id="end_datetime" name="end_datetime" class="form-control" required>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                  </form>
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
              <h4 class="modal-title" id="modalEdit">Edit Periode Pengajuan Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
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
      
      $(document).ready(function() {
      $('#datetimepicker1')
      .datetimepicker({
      format: 'YYYY-MM-DD HH:mm:ss',
      });
      $('#datetimepicker1 input').click(function(event){
      $('#datetimepicker1 ').data("DateTimePicker").show();
      });
      }); 
         
      $(document).ready(function() {
      $('#datetimepicker2')
      .datetimepicker({
      format: 'YYYY-MM-DD HH:mm:ss',
      });
      $('#datetimepicker2 input').click(function(event){
      $('#datetimepicker2 ').data("DateTimePicker").show();
      });
      }); 
      
      $('#modalProses').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListPrssAcPerSmt.php",
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
      url: "viewListSlsAcPerSmt.php",
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
      url: "viewTotalAcPerSmt.php",
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
      
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "editPeriodePacAdm.php",
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