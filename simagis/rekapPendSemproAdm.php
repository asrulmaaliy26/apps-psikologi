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
    <?php include "navPendAdm.php";
      $qry = "SELECT COUNT(*) AS jumData FROM mag_periode_pendaftaran_sempro";
         $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $jumlahData = $dataku['jumData'];
            
          include 'pagination.php';                 
          $reload = "rekapPendSemproAdm.php?pagination=true";
          $sql =  "SELECT * FROM mag_periode_pendaftaran_sempro ORDER BY start_datetime DESC";
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
          
          if (!empty($_GET['message']) && $_GET['message'] == 'notifSetengah') {
          echo '
          <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Update gagal</h4>
          </div>
          <div class="modal-body">
          <p>Update gagal. Ada tahap yang sama dalam satu Periode Tahun Akademik</p>
          <p><strong>Note:</strong> Waktu pendaftaran saja yang berhasil diupdate.</p>
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
        <h3 class="text-center text-warning">Seminar Proposal Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pendaftaran Seminar Proposal Tesis per periode.</li>
              <li>Periode Pendaftaran Seminar Proposal Tesis yang <code>sedang aktif</code> bertanda <span class='label label-primary'>Sedang Aktif</span>. Silahkan tekan <code>tombol ON/OFF</code> untuk mengaktifkan atau menonaktifkan.</li>
              <li><code>Perhatikan</code> rekap Periode Pendaftaran Seminar Proposal Tesis yang ada. Jika input baru, pastikan Periode Pendaftaran Seminar Proposal Tesis <code>tidak sama</code>.</li>
              <li>Keterangan singkatan Hasil Seminar: <code>L</code> = Lanjut. <code>LR</code> = Lanjut (Revisi). <code>SU</code> = Seminar Ulang.</li>
              <li>Lakukan <code>validasi nilai</code>.</li>
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
                        <th rowspan="2" class="text-center" width="3%">No.</th>
                        <th rowspan="2" class="text-center" width="25%">Periode Pendaftaran</th>
                        <th colspan="2" class="text-center">Durasi Pendaftaran</th>
                        <th rowspan="2" class="text-center" width="5%">Status</th>
                        <th rowspan="2" class="text-center" width="6%">Pendaftar</th>
                        <th colspan="2" class="text-center">Jadwal Seminar</th>
                        <th colspan="3" class="text-center">Hasil Seminar</th>
                        <th rowspan="2" class="text-center" width="4%">Penguji</th>
                        <th rowspan="2" class="text-center" width="16%">Opsi</th>
                      </tr>
                      <tr>
                        <th class="text-center" width="11%">Awal</th>
                        <th class="text-center" width="11%">Akhir</th>
                        <th class="text-center" width="5%">Belum</th>
                        <th class="text-center" width="5%">Sudah</th>
                        <th class="text-center" width="3%">L</th>
                        <th class="text-center" width="3%">LR</th>
                        <th class="text-center" width="3%">SU</th>
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
                        
                        $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$data[tahap]'";
                        $hsl = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
                        $dtahap = mysqli_fetch_assoc($hsl);
                        
                        $qpeserta = "SELECT * FROM mag_peserta_sempro WHERE id_sempro='$id'";
                        $row1 = mysqli_query($GLOBALS["___mysqli_ston"], $qpeserta);
                        $dpeserta = mysqli_num_rows($row1);
                        
                        $qjadwal = "SELECT * FROM mag_jadwal_sempro WHERE id_sempro='$id'";
                        $row2 = mysqli_query($GLOBALS["___mysqli_ston"], $qjadwal);
                        $djadwal = mysqli_num_rows($row2);
                        
                        $qjumpeserta = "SELECT COUNT(id_sempro) AS jum FROM mag_peserta_sempro WHERE id_sempro='$id'";
                        $rjp = mysqli_query($GLOBALS["___mysqli_ston"], $qjumpeserta);
                        $dJumPeserta = mysqli_fetch_assoc($rjp);
                        
                        $qry1 = "SELECT COUNT(*) AS jumData FROM mag_peserta_sempro WHERE id_sempro='$id' AND cek='1'";
                        $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData1 = $dataku1['jumData'];
                        
                        $qry2 = "SELECT COUNT(*) AS jumData FROM mag_peserta_sempro WHERE id_sempro='$id' AND cek='2'";
                        $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData2 = $dataku2['jumData'];
                        
                        $qrerata1 = "SELECT COUNT(id) AS rerata FROM mag_nilai_sempro WHERE (nilai_penguji1+nilai_penguji2+nilai_penguji3+nilai_penguji4)/4 BETWEEN 79 AND 101 AND id_sempro='$id' AND validasi='2'";
                        $rrerata1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qrerata1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $drerata1 = mysqli_fetch_assoc($rrerata1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $rerata1 = $drerata1['rerata'];
                        
                        $qrerata2 = "SELECT COUNT(id) AS rerata FROM mag_nilai_sempro WHERE (nilai_penguji1+nilai_penguji2+nilai_penguji3+nilai_penguji4)/4 BETWEEN 59 AND 79 AND id_sempro='$id' AND validasi='2'";
                        $rrerata2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qrerata2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $drerata2 = mysqli_fetch_assoc($rrerata2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $rerata2 = $drerata2['rerata'];
                        
                        $qrerata3 = "SELECT COUNT(id) AS rerata FROM mag_nilai_sempro WHERE (nilai_penguji1+nilai_penguji2+nilai_penguji3+nilai_penguji4)/4 BETWEEN 39 AND 59 AND id_sempro='$id' AND validasi='2'";
                        $rrerata3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qrerata3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $drerata3 = mysqli_fetch_assoc($rrerata3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $rerata3 = $drerata3['rerata'];           
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php if($data['status']==1) { echo 'Tahap '.$dtahap['tahap'].' Semester '.$dsemester['nama'].' '.$dnta['ta'].' <span class="label label-primary">Sedang Aktif</span>';} else { echo 'Tahap '.$dtahap['tahap'].' Semester '.$dsemester['nama'].' '.$dnta['ta'];}?></td>
                        <td class="text-center"><?php echo $data['start_datetime'];?></td>
                        <td class="text-center"><?php echo $data['end_datetime'];?></td>
                        <td class="text-center"><?php if($data['status']==1) { echo "<a class='btn btn-success btn-sm btn-block'><span class='glyphicon glyphicon-check'></span> ON</a>";} else { echo "<a class='btn btn-default btn-sm btn-block' title='Aktifkan!' href='updateStatusPeriodeSempro.php?id=".$id."' onclick='return confirm(\"Yakin periode ini diaktifkan?\")'><span class='glyphicon glyphicon-ban-circle'></span> OFF</a>";}?></td>
                        <td class="text-center"><a href='pendaftarSemproPerPeriode.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>' class='btn btn-sm btn-block btn-info' title='Lihat dan edit'><?php echo $dJumPeserta['jum'];?></a></td>
                        <td class="text-center"><button class="btn btn-sm btn-block btn-primary" title="Lihat detail" data-toggle="modal" data-target="#modalBelumJadwal" data-whatever="<?php echo $data['id'];?>"><?php echo $jumlahData1;?></button></td>
                        <td class="text-center"><a href='jadSemproPerPeriode.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>' class='btn btn-sm btn-block btn-primary' title='Lihat jadwal'><?php echo $jumlahData2;?></a></td>
                        <td class="text-center"><?php echo "$rerata1";?></td>
                        <td class="text-center"><?php echo "$rerata2";?></td>
                        <td class="text-center"><?php echo "$rerata3";?></td>
                        <td class="text-center"><button class="btn btn-block btn-primary" title="Lihat detail rekap" data-toggle="modal" data-target="#modalRekapPenguji" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></button></td>
                        <td class="text-center">
                          <a href='formPenilaianSemproPerPeriode.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>' class='btn btn-sm btn-success' title='Validasi nilai'>Validasi Nilai</a>
                          <button class="btn btn-warning" title="Edit periode" data-toggle="modal" data-target="#modalEdit" data-whatever="<?php echo $data['id'];?>&page=<?php echo "$page";?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>              
                          <?php if(($dpeserta > 0) || ($djadwal > 0)) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Sudah ada pendaftar' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";} else { echo "<a class='btn btn-default' href='deletePeriodePendSempro.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
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
                  <form action="sformInputPeriodePendSemproAdm.php" method="post">
                    <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
                    <input type="text" name="kaprodi" class="sr-only" value="<?php echo $dkaprodi['id'];?>" required readonly>
                    <input type="text" name="ta" class="sr-only" value="<?php echo $dta['id'];?>" required readonly>
                    <div class="form-group">
                      <label for="tahap">Tahap</label>
                      <select id="tahap" name="tahap" class="form-control" required>
                        <option value="">-Pilih-</option>
                        <?php
                          $q = mysqli_query($GLOBALS["___mysqli_ston"], "select * from mag_opsi_tahap_ujprop_ujtes ORDER BY tahap ASC");
                          while ($tampil = mysqli_fetch_array($q)){
                            echo "<option value='$tampil[id]'>$tampil[tahap]</option>";
                          }
                          ?>
                      </select>
                    </div>
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
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="lt">Grade Atas Lanjut</label>
                        <input type="number" max="100" step=".0001" name="lt" class="form-control" value="100" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="lb">Grade Bawah Lanjut</label>
                        <input type="number" step=".0001" name="lb" class="form-control" value="79.5001" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="lrt">Grade Atas Lanjut Revisi</label>
                        <input type="number" step=".0001" name="lrt" class="form-control" value="79.5000" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="lrb">Grade Bawah Lanjut Revisi</label>
                        <input type="number" step=".0001" name="lrb" class="form-control" value="59.5001" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="sut">Grade Atas Seminar Ulang</label>
                        <input type="number" step=".0001" name="sut" class="form-control" value="59.5000" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="sub">Grade Bawah Seminar Ulang</label>
                        <input type="number" step=".0001" name="sub" class="form-control" value="1" required>
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
      <div class="modal fade" tabindex="-1" role="dialog" id="modalBelumJadwal" aria-labelledby="labelModalBelumJadwal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalBelumJadwal">Pendaftar yang Belum Terjadwal</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalBelumJadwal"></div>
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
              <h4 class="modal-title" id="modalEdit">Edit Periode Pendaftaran Seminar Proposal Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalRekapPenguji" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalRekapPenguji">Rekap Dosen Penguji Seminar Proposal Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalRekapPenguji"></div>
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
      url: "editPeriodePendSemproAdm.php",
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
      
      $('#modalBelumJadwal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "pendaftarBelumTerjadwalAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalBelumJadwal').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalRekapPenguji').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "rekapPengujiSemproAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalRekapPenguji').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });   
    </script>
  </body>
</html>