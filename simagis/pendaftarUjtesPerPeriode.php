<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
        
   $id_ujtes = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
   $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 2;
   $qryperiod = "select * from mag_periode_pendaftaran_ujtes WHERE id='$id_ujtes'";
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
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
              echo '
                    <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Submit gagal</h4>
                    </div>
                    <div class="modal-body">
                    <p>Salah satu atau semua file yang diupload bukan berbentuk PDF (berekstensi .pdf).</p>
                    <p><strong>Note:</strong> Konversikan file ke PDF terlebih dahulu...</p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                    </div>
                    </div>';} 
                
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
              echo '<div class="alert alert-success custom-alert" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';} 
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
              echo '<div class="alert alert-success custom-alert" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}     
                           ?>
        <h3 class="text-center text-warning">Ujian Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pendaftar Ujian Tesis <?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPendUjtesAdm.php">Periode Pendaftaran</a></li>
                  <li role="presentation" class="active"><a>Data Pendaftar</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class=" table table-condensed table-bordered table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th rowspan="2" class="text-center" width="3%">No.</th>
                        <th rowspan="2" class="text-center" width="22%">Nama | NIM | Hp | Tgl. Daftar</th>
                        <th rowspan="2" class="text-center" width="21%">Judul Tesis</th>
                        <th colspan="6" class="text-center">File</th>
                        <th rowspan="2" class="text-center" width="14%">Opsi</th>
                      </tr>
                      <tr>
                        <th width="5%" class="text-center">Tesis</th>
                        <th width="5%" class="text-center">Turnitin</th>
                        <th width="5%" class="text-center">Transkrip</th>
                        <th width="5%" class="text-center">Jurnal</th>
                        <th width="5%" class="text-center">T. Jurnal</th>
                        <th width="5%" class="text-center">Kwitansi</th>                        
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        $no=0;
                        $sql =  "SELECT * FROM mag_peserta_ujtes WHERE id_ujtes = '$id_ujtes' ORDER BY nim ASC";
                        $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                            while($data = mysqli_fetch_array($result)) {
                        $no++;
                        $qrymhssw = "select * from mag_dt_mhssw_pasca WHERE nim='$data[nim]' ORDER BY nim ASC";
                        $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qrymhssw )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dmhssw = mysqli_fetch_assoc( $resp );
                        
                        $qrynilai= "select * from mag_nilai_ujtes WHERE id_pendaftaran='$data[id]'";
                        $resnilai = mysqli_query($GLOBALS["___mysqli_ston"],  $qrynilai )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dnilai = mysqli_fetch_assoc( $resnilai );
                        ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dmhssw['nama'].' | '.$dmhssw['nim'].' | '.$dmhssw['kntk'].' | '.$data['tgl_pendaftaran'];?></td>
                        <td><?php echo $data['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_tesis']);?></td>
                        <td class="text-center"><?php if(empty($data['file_tesis'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_tesis'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center"><?php if(empty($data['file_turnitin'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_turnitin'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center"><?php if(empty($data['file_transkrip'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_transkrip'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center"><?php if(empty($data['file_jurnal'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_jurnal'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center"><?php if(empty($data['file_contoh_jurnal'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_contoh_jurnal'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center"><?php if(empty($data['file_kwitansi'])) { echo '<a class="btn btn-danger" title="Tidak ada file" disabled><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';} else { echo '<a class="btn btn-danger" title="Download" href="'.$data['file_kwitansi'].'" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';}?></td>
                        <td class="text-center">
                          <?php
                            if($dnilai['nilai_penguji1']>0 || $dnilai['nilai_penguji2']>0 || $dnilai['nilai_penguji3']>0 || $dnilai['nilai_penguji4']>0) { 
                            echo '
                            <button class="btn btn-default" title="Nilai dari dosen penguji telah diberikan" disabled><span class="glyphicon glyphicon-calendar"></span></button>';} else {
                            if($data['cek']==1) {echo '
                                              <button class="btn btn-primary" title="Buat jadwal ujian" data-toggle="modal" data-target="#modalCrtJad" data-whatever="'.$data['id'].'"><span class="glyphicon glyphicon-calendar"></span></button>';} else {
                                              echo '
                                              <button class="btn btn-success" title="Edit jadwal ujian" data-toggle="modal" data-target="#modalCrtJad" data-whatever="'.$data['id'].'"><span class="glyphicon glyphicon-calendar"></span></button>';}
                            }
                                              ?>
                          <button class='btn btn-warning' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='<?php echo $data['id'];?>'><span class="glyphicon glyphicon-edit"></span></button>
                          <a role="button" href="cetakPendUjtesAdm.php?id=<?php echo $data['id'];?>" class="btn btn-default" title="Cetak" target="_blank"><span class="glyphicon glyphicon-print"></span></a>
                          <?php if($dnilai['validasi']==2) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Nilai sudah divalidasi' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";} 
                          else { echo "<a class='btn btn-default' href='deletePendUjtesAdm.php?id=".$data['id']."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
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
      <div class="modal fade" tabindex="-1" role="dialog" id="modalCrtJad" aria-labelledby="labelModalCrtJad" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalCrtJad">
                <?php $sql =  "SELECT * FROM mag_peserta_ujtes WHERE id_ujtes = '$id_ujtes' ORDER BY nim ASC";
                  $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                  $data = mysqli_fetch_array($result); 
                  if($data['cek']==1) {echo "Input Jadwal";} else {echo "Edit Jadwal";}?>
              </h4>
            </div>
            <div class="modal-body">
              <div class="isiModalCrtJad"></div>
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
              <h4 class="modal-title" id="modalEdit">Edit Pendaftar Ujian Tesis</h4>
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
      
      $( '#modalCrtJad' ).on( 'show.bs.modal', function ( event ) {
          var button = $( event.relatedTarget )
          var recipient = button.data( 'whatever' )
          var modal = $( this );
          var dataString = 'id=' + recipient;
          $.ajax( {
            type: "GET",
            url: "includeInputJadUjtesPerPeriode.php",
            data: dataString,
            cache: false,
            success: function ( data ) {
              console.log( data );
              modal.find( '.isiModalCrtJad' ).html( data );
            },
            error: function ( err ) {
              console.log( err );
            }
          } );
         } );
      
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient; 
      $.ajax({
      type: "GET",
      url: "editPendUjtesAdm.php",
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