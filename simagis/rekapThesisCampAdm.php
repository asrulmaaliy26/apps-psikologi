<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
   $qta = "select * from mag_dt_ta WHERE status='1'";
   $rta = mysqli_query($GLOBALS["___mysqli_ston"], $qta)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dta = mysqli_fetch_assoc($rta);   
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPendAdm.php";
      $qry = "SELECT COUNT(*) AS jumData FROM mag_periode_thesis_camp";
         $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $jumlahData = $dataku['jumData'];
            
          include 'pagination.php';                 
          $reload = "rekapThesisCampAdm.php?pagination=true";
          $sql =  "SELECT * FROM mag_periode_thesis_camp ORDER BY start_datetime DESC";
          $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
           $rpp = 20;
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
        <h3 class="text-center text-warning">Thesis Camp</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pendaftaran Thesis Camp per periode.</li>
              <li>Periode Pendaftaran Thesis Camp yang <code>sedang aktif</code> bertanda <span class='label label-primary'>Sedang Aktif</span>. Silahkan tekan <code>tombol ON/OFF</code> untuk mengaktifkan atau menonaktifkan.</li>
              <li><code>Perhatikan</code> rekap Periode Pendaftaran Thesis Camp yang ada. Jika input baru, pastikan Periode Pendaftaran Thesis Camp <code>tidak sama</code>.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Periode Pendaftaran</a></li>
                  <button role="presentation" class="btn btn-primary pull-right" title="Input periode baru" data-toggle="modal" data-target="#modalInput"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Input Periode Baru</button>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table-condensed table table-bordered table-striped custom" style="margin-bottom:0px; font-size:12px;">
                    <thead>
                      <tr class="">
                        <th class="text-center" width="3%">No.</th>
                        <th class="text-center" width="25%">Periode Pendaftaran</th>
                        <th class="text-center" width="15%">Awal</th>
                        <th class="text-center" width="15%">Akhir</th>
                        <th class="text-center" width="10%">Status</th>
                        <th class="text-center" width="10%">Pendaftar</th>
                        <th class="text-center" width="22%">Opsi</th>
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
                        
                        $qjumpeserta = "SELECT COUNT(id) AS jum FROM mag_peserta_thesis_camp WHERE id_periode_thesis_camp='$id'";
                        $rjp = mysqli_query($GLOBALS["___mysqli_ston"], $qjumpeserta);
                        $dJumPeserta = mysqli_fetch_assoc($rjp);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php if($data['status']==1) { echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'].' <span class="label label-primary">Sedang Aktif</span>';} else { echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];}?></td>
                        <td class="text-center"><?php echo $data['start_datetime'];?></td>
                        <td class="text-center"><?php echo $data['end_datetime'];?></td>
                        <td class="text-center"><?php if($data['status']==1) { echo "<a class='btn btn-success btn-sm btn-block'><span class='glyphicon glyphicon-check'></span> ON</a>";} else { echo "<a class='btn btn-default btn-sm btn-block' title='Aktifkan!' href='updateStatusPeriodeThesisCamp.php?id=".$id."' onclick='return confirm(\"Yakin periode ini diaktifkan?\")'><span class='glyphicon glyphicon-ban-circle'></span> OFF</a>";}?></td>
                        <td class="text-center"><a href='pendaftarThesisCampPerPeriode.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>' class='btn btn-sm btn-block btn-info' title='Lihat dan edit'><?php echo $dJumPeserta['jum'];?></a></td>
                        <td class="text-center">
                          <button class="btn btn-warning" title="Edit periode" data-toggle="modal" data-target="#modalEdit" data-whatever="<?php echo $data['id'];?>&page=<?php echo "$page";?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>              
                          <?php if($dJumPeserta['jum'] > 0) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Sudah ada pendaftar' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";} 
                          else { echo "<a class='btn btn-danger' href='deletePeriodeThesisCamp.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Hapus</a>";}?>
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
                  <form action="sformInputPeriodeThesisCampAdm.php" method="post">
                    <input type="text" name="ta" class="sr-only" value="<?php echo $dta['id'];?>" required readonly>
                    <div class="form-group">
                      <label for="start_datetime">Awal Durasi Pendaftaran</label>
                      <div class="input-group date" id="datetimepicker1">
                        <input type="text" id="start_datetime" name="start_datetime" class="form-control" required>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="end_datetime">Akhir Durasi Pendaftaran</label>
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
              <h4 class="modal-title" id="modalEdit">Edit Periode Pendaftaran Thesis Camp</h4>
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
      url: "editPeriodeThesisCampAdm.php",
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
