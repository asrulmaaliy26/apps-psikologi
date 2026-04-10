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
      $qry = "SELECT COUNT(*) AS jumData FROM mag_periode_pengajuan_dospem";
      $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $jumlahData = $dataku['jumData'];
            
          include 'pagination.php';                 
          $reload = "rekapPptAdm.php?pagination=true";
          $sql =  "SELECT * FROM mag_periode_pengajuan_dospem ORDER BY start_datetime DESC";
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
        <h3 class="text-center text-warning">Dosen Pembimbing Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pengajuan Dosen Pembimbing Tesis per periode (semester).</li>
              <li>Periode Pengajuan Dosen Pembimbing Tesis yang <code>sedang aktif</code> bertanda <span class='label label-primary'>Sedang Aktif</span>.</li>
              <li><code>Perhatikan</code> rekap Periode Pengajuan Dosen Pembimbing Tesis yang ada. Jika input baru, pastikan Periode Pengajuan Dosen Pembimbing Tesis <code>tidak sama</code>.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
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
                        <th rowspan="3" class="text-center" width="3%">No.</th>
                        <th rowspan="3" class="text-center" width="23%">Periode Pengajuan</th>
                        <th colspan="2" rowspan="2" class="text-center">Durasi Pengajuan</th>
                        <th rowspan="3" class="text-center" width="4%">Syarat SKS</th>
                        <th rowspan="3" class="text-center" width="4%">Status</th>
                        <th rowspan="3" class="text-center" width="5%">Total Dospem</th>
                        <th rowspan="3" class="text-center" width="5%">Total Pengaju</th>
                        <th colspan="6" class="text-center">Verifikasi</th>
                        <th rowspan="3" class="text-center" width="8%">Opsi</th>
                      </tr>
                      <tr>
                        <th colspan="2" class="text-center">Dospem I</th>
                        <th colspan="2" class="text-center">Dospem II</th>
                        <th colspan="2" class="text-center">Judul</th>
                      </tr>
                      <tr>
                        <th class="text-center" width="12%">Awal Durasi</th>
                        <th class="text-center" width="12%">Akhir Durasi</th>
                        <th class="text-center" width="4%">Blm</th>
                        <th class="text-center" width="4%">Sdh</th>
                        <th class="text-center" width="4%">Blm</th>
                        <th class="text-center" width="4%">Sdh</th>
                        <th class="text-center" width="4%">Blm</th>
                        <th class="text-center" width="4%">Sdh</th>
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
                        
                        $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cek1='1'";
                        $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData1 = $dataku1['jumData'];
                        
                        $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cek1='2'";
                        $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData2 = $dataku2['jumData'];
                        
                        $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cek2='1'";
                        $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData3 = $dataku3['jumData'];
                        
                        $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cek2='2'";
                        $result4 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData4 = $dataku4['jumData'];
                        
                        $qry5 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cekjudul='1'";
                        $result5 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData5 = $dataku5['jumData'];
                        
                        $qry6 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cekjudul='2'";
                        $result6 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $jumlahData6 = $dataku6['jumData'];
                        
                        $qjumDospem = "SELECT COUNT(id_periode) AS jum FROM mag_dospem_tesis WHERE id_periode='$data[id]'";
                        $rjd = mysqli_query($GLOBALS["___mysqli_ston"], $qjumDospem);
                        $dJumDospem = mysqli_fetch_assoc($rjd);
                        
                        $qpengaju = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]'";
                        $row1 = mysqli_query($GLOBALS["___mysqli_ston"], $qpengaju);
                        $dpengaju = mysqli_num_rows($row1);
                        
                        $qjumPengaju = "SELECT COUNT(id_periode) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]'";
                        $rjp = mysqli_query($GLOBALS["___mysqli_ston"], $qjumPengaju);
                        $dJumPengaju = mysqli_fetch_assoc($rjp);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php if($data['status']==1) { echo 'Tahap '.$dtahap['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].' <span class="label label-primary">Sedang Aktif</span>';} else { echo 'Tahap '.$dtahap['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'];}?></td>
                        <td class="text-center"><?php echo $data['start_datetime'];?></td>
                        <td class="text-center"><?php echo $data['end_datetime'];?></td>
                        <td class="text-center"><?php echo $data['syarat_sks'];?></td>
                        <td class="text-center"><?php if($data['status']==1) { echo "<a class='btn btn-success btn-sm btn-block'><span class='glyphicon glyphicon-check'></span> ON</a>";} else { echo "<a class='btn btn-default btn-sm btn-block' title='Aktifkan!' href='updateStatusPeriodePpt.php?id=".$id."' onclick='return confirm(\"Yakin Periode ini diaktifkan?\")'><span class='glyphicon glyphicon-ban-circle'></span> OFF</a>";}?></td>
                        <td class="text-center"><a href='ptPerPeriode.php?id=<?php echo "$id";?>' class='btn btn-sm btn-block btn-info' title='Lihat, input dan edit'><?php echo $dJumDospem['jum'];?></a></td>
                        <td class="text-center"><a href='pengajuPtPerPeriode.php?id=<?php echo "$id";?>' class='btn btn-sm btn-block btn-info' title='Lihat dan edit'><?php echo $dJumPengaju['jum'];?></a></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalBelum1" data-whatever="<?php echo "$id";?>"><?php echo "$jumlahData1";?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalSudah1" data-whatever="<?php echo "$id";?>"><?php echo "$jumlahData2";?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalBelum2" data-whatever="<?php echo "$id";?>"><?php echo "$jumlahData3";?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalSudah2" data-whatever="<?php echo "$id";?>"><?php echo "$jumlahData4";?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalBelumJudul" data-whatever="<?php echo "$id";?>"><?php echo "$jumlahData5";?></button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm btn-block" title="Lihat data" data-toggle="modal" data-target="#modalSudahJudul" data-whatever="<?php echo "$id";?>"><?php echo "$jumlahData6";?></button></td>
                        <td class="text-center">
                          <button class="btn btn-warning" title="Edit periode" data-toggle="modal" data-target="#modalEdit" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                          <?php if(($dpengaju > 0)) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Sudah ada pengajuan' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";} else { echo "<a class='btn btn-default' href='deletePeriodePpt.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
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
                  <form action="sformInputPeriodePptAdm.php" method="post">
                    <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
                    <input type="text" name="kaprodi" class="sr-only" value="<?php echo $dkaprodi['id'];?>" required readonly>
                    <input type="text" name="ta" class="sr-only" value="<?php echo $dta['id'];?>" required readonly>
                    <div class="form-group">
                      <label for="tahap">Tahap</label>
                      <select id="tahap" name="tahap" class="form-control" required>
                        <option value="">-Pilih-</option>
                        <?php
                          $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_opsi_tahap_ujprop_ujtes ORDER BY tahap ASC");
                          while ($tampil = mysqli_fetch_array($q)){
                            echo "<option value='$tampil[id]'>$tampil[tahap]</option>";
                          }
                          ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="start_datetime">Waktu Mulai Pendaftaran</label>
                      <div class="input-group date" id="datetimepicker1">
                        <input type="text" id="start_datetime" name="start_datetime" class="form-control" required>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="end_datetime">Waktu Akhir Pendaftaran</label>
                      <div class="input-group date" id="datetimepicker2">
                        <input type="text" id="end_datetime" name="end_datetime" class="form-control" required>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="syarat_sks">Syarat SKS yang Harus Ditempuh</label>
                      <input type="number" min="1" max="100" id="syarat_sks" name="syarat_sks" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalBelum1" aria-labelledby="labelModalBelum1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalBelum1">Pengajuan Dosen Pembimbing I yang Belum Diverifikasi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalBelum1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalSudah1" aria-labelledby="labelModalSudah1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalSudah1">Pengajuan Dosen Pembimbing I yang Sudah Diverifikasi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalSudah1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalBelum2" aria-labelledby="labelModalBelum2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalBelum2">Pengajuan Dosen Pembimbing II yang Belum Diverifikasi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalBelum2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalSudah2" aria-labelledby="labelModalSudah2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalSudah2">Pengajuan Dosen Pembimbing II yang Sudah Diverifikasi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalSudah2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalBelumJudul" aria-labelledby="labelModalJudul" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalBelumJudul">Pengajuan Judul yang Belum Diverifikasi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalBelumJudul"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalSudahJudul" aria-labelledby="labelModalSudahJudul" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalSudahJudul">Pengajuan Judul yang Sudah Diverifikasi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalSudahJudul"></div>
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
              <h4 class="modal-title" id="modalEdit">Edit Periode Pengajuan Dosen Pembimbing Tesis</h4>
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
      
      $('#modalBelum1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPptSatuBelumVerifikasi.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalBelum1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalSudah1').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPptSatuSudahVerifikasi.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalSudah1').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalBelum2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPptDuaBelumVerifikasi.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalBelum2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalSudah2').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPptDuaSudahVerifikasi.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalSudah2').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalBelumJudul').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPjBelumVerifikasi.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalBelumJudul').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalSudahJudul').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewPjSudahVerifikasi.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalSudahJudul').html(data);
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
      url: "editPeriodePptAdm.php",
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